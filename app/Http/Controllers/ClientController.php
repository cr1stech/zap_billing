<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index');
    }

    public function datatables()
    {
        $clients = Client::all();
        return datatables()->of($clients)
            ->addIndexColumn()
            ->editColumn('status', function ($client) {
                return $client->status ? 'Ativo' : 'Inativo';
            })
            ->addColumn('action', function ($client) {
                return "
                    <a class='m-2' href='" . route('clients.edit', $client->id) . "'><i class='fas fa-pen fa-2x'></i></a>
                    <a class='m-2' href='" . route('clients.pay', $client->id) . "'><i class='fas fa-cash-register fa-2x'></i></a>
                    <a class='m-2 linkDelete' href='#' data-href='" . route('clients.destroy', $client->id) . "' data-toggle='modal' data-target='#deleteModal'>
                        <i class='fas fa-trash fa-2x'></i>
                    </a>";
            })
            ->rawColumns(['action'])
            ->toJson();
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

    public function showPaymentForm(Client $client)
    {
        $accounts = $client->accounts()->where('status', '!=', 'paid')->orderBy('due_date')->get();
        return view('clients.pay', compact('client', 'accounts'));
    }

    public function processPayment(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $request->input('amount');
        $accounts = $client->accounts()->where('status', '!=', 'paid')->orderBy('due_date')->get();

        foreach ($accounts as $account) {
            if ($amount <= 0) break;

            $remaining = $account->total_amount - $account->amount_paid;

            if ($amount >= $remaining) {
                $account->amount_paid = $account->total_amount;
                $amount -= $remaining;
            } else {
                $account->amount_paid += $amount;
                $amount = 0;
            }

            $account->updateStatus();
        }

        return redirect()->route('clients.index')->with('success', 'Pagamento efetuado com sucesso.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index');
    }
}
