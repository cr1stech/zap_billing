<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function index()
    {
        return view('clients.index');
    }

    public function datatables()
    {
        $clients = Client::with('accounts')->get();

        return datatables()->of($clients)
            ->addIndexColumn()
            ->addColumn('total_account_value', function ($client) {
                $totalAmount = $client->accounts->sum('total_amount');
                $totalPaid = $client->accounts->sum('amount_paid');
                $remainingAmount = $totalAmount - $totalPaid;
                return number_format($remainingAmount, 0, ',', '.') . ' G$';
            })
            ->editColumn('status', function ($client) {
                return $client->status ? 'Ativo' : 'Inativo';
            })
            ->addColumn('action', function ($client) {
                return "
                    <a class='m-2' href='" . route('clients.edit', $client->id) . "'><i class='fas fa-pen fa-2x'></i></a>
                    <a class='m-2 linkDelete' href='#' data-href='" . route('clients.destroy', $client->id) . "' data-toggle='modal' data-target='#deleteModal'>
                        <i class='fas fa-trash fa-2x'></i>
                    </a>
                    <a class='m-2' href='" . route('clients.pay', $client->id) . "'><i class='fas fa-money-bill-wave fa-2x'></i></a>
                    <a class='m-2 btn-send-sms' href='#' data-client-id='{$client->id}'><i class='fab fa-whatsapp fa-2x'></i></a>
                ";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function formatPhoneNumber($phoneNumber)
    {
        // Remove todos os caracteres não numéricos
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Remove o zero inicial, se existir
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // Adiciona o código do país +595
        $phoneNumber = '+595' . $phoneNumber;

        return $phoneNumber;
    }

    public function sendSMS(Request $request)
    {
        $client = Client::find($request->client_id);

        if ($client) {
            $formattedPhoneNumber = $this->formatPhoneNumber($client->phone_number);

            // Obter contas vencidas
            $overdueAccounts = $client->accounts()->where('status', 'overdue')->get()->map(function ($account) {
                $account->due_date = Carbon::parse($account->due_date);
                return $account;
            });

            // Calcular totais para contas vencidas
            $totalOverdueAmount = $overdueAccounts->sum('total_amount');
            $totalOverduePaid = $overdueAccounts->sum('amount_paid');
            $totalOverdueRemaining = $totalOverdueAmount - $totalOverduePaid;

            // Dados para preencher o template
            $data = [
                'clientName' => $client->name,
                'totalAmount' => number_format($totalOverdueAmount, 0, ',', '.') . ' G$',
                'amountPaid' => number_format($totalOverduePaid, 0, ',', '.') . ' G$',
                'remainingAmount' => number_format($totalOverdueRemaining, 0, ',', '.') . ' G$',
                'overdueAccounts' => $overdueAccounts
            ];

            // Renderiza o template
            $message = view('messages.payment_reminder', $data)->render();

            try {
                $this->twilio->sendMessage($formattedPhoneNumber, $message);
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                \Log::error('Error sending WhatsApp message: ' . $e->getMessage());
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false], 404);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'status' => 'required|boolean'
        ]);

        Client::create($request->all());
        return redirect()->route('clients.index');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clients,email,' . $id,
            'status' => 'sometimes|required|boolean'
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());
        return redirect()->route('clients.index');
    }

    public function pay($id)
    {
        $client = Client::findOrFail($id);
        $accounts = $client->accounts()->orderBy('due_date')->get();
        $payments = $client->payments()->orderBy('payment_date', 'desc')->get();

        // Calcular o valor total da conta
        $totalAccountValue = $accounts->sum('total_amount');
        $totalPaid = $accounts->sum('amount_paid');
        $remainingAmount = $totalAccountValue - $totalPaid;

        return view('clients.pay', compact('client', 'accounts', 'payments', 'totalAccountValue', 'totalPaid', 'remainingAmount'));
    }

    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $client = Client::findOrFail($id);
        $amount = $request->input('amount');
        $affectedAccounts = [];

        // Obter todas as contas do cliente, ordenadas por data de vencimento, excluindo as que estão totalmente pagas
        $accounts = $client->accounts()->where('status', '!=', 'paid')->orderBy('due_date')->get();

        foreach ($accounts as $account) {
            if ($amount <= 0) {
                break;
            }

            $remaining = $account->total_amount - $account->amount_paid;
            if ($amount >= $remaining) {
                $paymentAmount = $remaining;
            } else {
                $paymentAmount = $amount;
            }

            // Registrar o valor pago em cada conta afetada
            $affectedAccounts[$account->id] = $paymentAmount;

            $amount -= $paymentAmount;
        }

        // Criar o pagamento
        Payment::create([
            'client_id' => $client->id,
            'affected_accounts' => $affectedAccounts, // Passar o array diretamente
            'amount' => $request->input('amount'),
            'payment_date' => now(),
        ]);

        return redirect()->route('clients.index')->with('success', 'Pagamento realizado com sucesso.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index');
    }
}
