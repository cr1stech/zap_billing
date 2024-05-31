@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pagamento para {{ $client->name }}</h1>

        <form action="{{ route('clients.processPayment', $client->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Valor a Pagar:</label>
                <input type="number" name="amount" id="amount" class="form-control" required min="1">
            </div>
            <button type="submit" class="btn btn-success">Pagar</button>
        </form>

        <h2>Contas Pendentes</h2>
        <ul>
            @foreach($accounts as $account)
                <li>Conta #{{ $account->id }} - Valor Total: {{ $account->total_amount }} - Valor Pago: {{ $account->amount_paid }} - Vencimento: {{ $account->due_date }}</li>
            @endforeach
        </ul>
    </div>
@endsection
