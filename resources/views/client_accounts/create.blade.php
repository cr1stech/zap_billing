@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Criar Nova Conta</h1>
        <form action="{{ route('client-accounts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="client_id">Cliente</label>
                <select name="client_id" id="client_id" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="purchase_id">Compra</label>
                <select name="purchase_id" id="purchase_id" class="form-control">
                    @foreach ($purchases as $purchase)
                        <option value="{{ $purchase->id }}">{{ $purchase->purchase_date }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" name="amount" id="amount" class="form-control">
            </div>
            <div class="form-group">
                <label for="due_date">Data de Vencimento</label>
                <input type="date" name="due_date" id="due_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending">Pendente</option>
                    <option value="paid">Pago</option>
                    <option value="overdue">Atrasado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Criar Conta</button>
        </form>
    </div>
@endsection
