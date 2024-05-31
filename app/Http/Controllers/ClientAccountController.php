<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAccount;
use Illuminate\Http\Request;

class ClientAccountController extends Controller
{
    public function index()
    {
        return view('client_accounts.index');
    }

    public function datatables()
    {
        $accounts = ClientAccount::with(['client'])->get();
        return datatables()->of($accounts)
            ->addIndexColumn()
            ->editColumn('client_id', function ($account) {
                return $account->client ? $account->client->name : 'Sem cliente';
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
        $clients = Client::all();
        return view('client_accounts.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,partially_paid,paid,overdue'
        ]);

        $account = ClientAccount::create($request->all());
        $account->updateStatus();
        return redirect()->route('client-accounts.index');
    }

    public function edit($id)
    {
        $account = ClientAccount::findOrFail($id);
        $clients = Client::all();
        return view('client_accounts.edit', compact('account', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'total_amount' => 'sometimes|required|numeric',
            'due_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:pending,partially_paid,paid,overdue'
        ]);

        $account = ClientAccount::findOrFail($id);
        $account->update($request->all());
        $account->updateStatus();
        return redirect()->route('client-accounts.index');
    }

    public function destroy($id)
    {
        $account = ClientAccount::findOrFail($id);
        $account->delete();
        return redirect()->route('client-accounts.index');
    }
}
