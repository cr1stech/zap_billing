@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes da Conta</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $account->id }}</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td>{{ $account->client->name }}</td>
            </tr>
            <tr>
                <th>Compra</th>
                <td>{{ $account->purchase->purchase_date }}</td>
            </tr>
            <tr>
                <th>Valor</th>
                <td>{{ $account->amount }}</td>
            </tr>
            <tr>
                <th>Data de Vencimento</th>
                <td>{{ $account->due_date }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $account->status }}</td>
            </tr>
        </table>
        <a href="{{ route('client-accounts.index') }}" class="btn btn-primary">Voltar</a>
    </div>
@endsection
