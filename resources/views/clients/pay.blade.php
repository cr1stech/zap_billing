@extends('layouts.main')

@section('title')
    Pagar Contas do Cliente
@endsection

@section('styles')
    <style>
        .summary-card {
            font-size: 1.2em;
            font-weight: bold;
        }

        .summary-card h3,
        .payment-card h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .summary-card p {
            margin-bottom: 15px;
        }

        .amount-value {
            margin-left: 10px;
            color: black;
            font-size: 1.5em;
            font-weight: bold;
        }

        .remaining-amount {
            margin-left: 10px;
            color: red;
            font-size: 1.7em;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <!-- start: page -->
    <section class="card card-featured card-dark card-featured-danger mb-4">
        <header class="card-header">
            <h2 class="card-title">Pagar Contas do Cliente: {{ $client->name }}</h2>
        </header>
    </section>

    <div class="row">
        <div class="col-lg-6">
            <section class="card payment-card">
                <div class="card-body">
                    <h3>Formulário de Pagamento</h3>
                    <form action="{{ route('clients.processPayment', $client->id) }}" method="POST">
                        @csrf
                        <div class="form-group my-5">
                            <label for="amount">Valor do Pagamento</label>
                            <input type="number" class="form-control my-2" name="amount" id="amount" step="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Pagar</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </section>
        </div>

        <div class="col-lg-6">
            <section class="card summary-card">
                <div class="card-body">
                    <h3 class="mb-5">Resumo das Contas</h3>
                    <p>Valor Total das Contas: <span class="amount-value">{{ number_format($totalAccountValue, 0, ',', '.') }} G$</span></p>
                    <p>Valor Pago: <span class="amount-value">{{ number_format($totalPaid, 0, ',', '.') }} G$</span></p>
                    <p>Valor Restante: <span class="remaining-amount">{{ number_format($remainingAmount, 0, ',', '.') }} G$</span></p>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <section class="card">
                <div class="card-body">
                    <h3 class="my-4">Contas do Cliente</h3>
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Valor Total</th>
                            <th>Valor Pago</th>
                            <th>Data de Vencimento</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ number_format($account->total_amount, 0, ',', '.') }} G$</td>
                                <td>{{ number_format($account->amount_paid, 0, ',', '.') }} G$</td>
                                <td>{{ \Carbon\Carbon::parse($account->due_date)->format('d/m/Y') }}</td>
                                <td>
                                    @switch($account->status)
                                        @case('pending')
                                            Pendente
                                            @break
                                        @case('partially_paid')
                                            Parcialmente Pago
                                            @break
                                        @case('paid')
                                            Pago
                                            @break
                                        @case('overdue')
                                            Atrasado
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-lg-6">
            <section class="card">
                <div class="card-body">
                    <h3 class="my-4">Últimos Pagamentos</h3>
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Valor</th>
                            <th>Data de Pagamento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ number_format($payment->amount, 0, ',', '.') }} G$</td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
