<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientAccountRequest;
use App\Http\Requests\UpdateClientAccountRequest;
use App\Models\Client;
use App\Models\ClientAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientAccountController extends Controller
{
    public function index()
    {
        return view('client_accounts.index');
    }

    public function datatables()
    {
        $accounts = ClientAccount::query()->with(['client'])->get();
        return datatables()->of($accounts)
            ->addIndexColumn()
            ->editColumn('client_id', function ($account) {
                return $account->client ? $account->client->name : 'Sem cliente';
            })
            ->editColumn('total_amount', function ($account) {
                return number_format($account->total_amount, 0, ',', '.') . ' G$';
            })
            ->editColumn('amount_paid', function ($account) {
                return number_format($account->amount_paid, 0, ',', '.') . ' G$';
            })
            ->editColumn('due_date', function ($account) {
                return Carbon::parse($account->due_date)->format('d/m/Y');
            })
            ->editColumn('status', function ($account) {
                $statusLabels = [
                    'pending' => 'Pendente',
                    'partially_paid' => 'Parcialmente Pago',
                    'paid' => 'Pago',
                    'overdue' => 'Atrasado'
                ];
                return $statusLabels[$account->status];
            })
            ->addColumn('action', function ($account) {
                return "<a class='m-2' href='" . route('client-accounts.edit', $account->id) . "'><i class='fas fa-pen fa-2x'></i></a>
                    <a class='m-2 linkDelete' href='#' data-href='" . route('client-accounts.destroy', $account->id) . "' data-toggle='modal' data-target='#deleteModal'>
                        <i class='fas fa-trash fa-2x'></i>
                    </a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        $clients = Client::query()->get();
        return view('client_accounts.create', compact('clients'));
    }

    public function store(StoreClientAccountRequest $request)
    {
        $data = $request->validated();

        // Convertendo a data para o formato do banco de dados
        $data['due_date'] = Carbon::createFromFormat('d/m/Y', $data['due_date'])->format('Y-m-d');

        // Definindo amount_paid como 0 se estiver vazio
        if (empty($data['amount_paid'])) {
            $data['amount_paid'] = 0;
        }

        $account = ClientAccount::query()->create($data);
        $account->updateStatus();

        return redirect()->route('client-accounts.index')->with('success', 'Conta criada com sucesso!');
    }

    public function edit($id)
    {
        $clientAccount = ClientAccount::query()->findOrFail($id);
        $clientAccount->due_date = Carbon::parse($clientAccount->due_date)->format('d/m/Y'); // Convertendo para o formato desejado
        $clients = Client::all();
        return view('client_accounts.edit', compact('clientAccount', 'clients'));
    }

    public function update(UpdateClientAccountRequest $request, $id)
    {
        $data = $request->validated();

        // Convertendo a data para o formato do banco de dados
        $data['due_date'] = Carbon::createFromFormat('d/m/Y', $data['due_date'])->format('Y-m-d');

        // Definindo amount_paid como 0 se estiver vazio
        if (empty($data['amount_paid'])) {
            $data['amount_paid'] = 0;
        }

        $clientAccount = ClientAccount::query()->findOrFail($id);
        $clientAccount->update($data);
        $clientAccount->updateStatus();

        return redirect()->route('client-accounts.index')->with('success', 'Conta atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $account = ClientAccount::query()->findOrFail($id);
        $account->delete();
        return redirect()->route('client-accounts.index');
    }
}
