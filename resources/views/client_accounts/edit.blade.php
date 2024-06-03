@extends('layouts.main')

@section('title')
    Editar Conta
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}"/>
@endsection

@section('content')
    <!-- start: page -->
    <section class="card card-featured card-dark card-featured-primary mb-4">
        <header class="card-header">
            <h2 class="card-title">Editar Conta</h2>
        </header>
        <div class="card-body">
            <form action="{{ route('client-accounts.update', $clientAccount->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="client_id">Cliente</label>
                    <select name="client_id" id="client_id" data-plugin-selectTwo class="form-control populate"
                            required>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id == $clientAccount->client_id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_amount">Valor Total</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control" step="1" value="{{ $clientAccount->total_amount }}" required>
                </div>
                <div class="form-group">
                    <label for="amount_paid">Valor Pago</label>
                    <input type="number" name="amount_paid" id="amount_paid" class="form-control" step="1" value="{{ $clientAccount->amount_paid }}">
                </div>
                <div class="form-group">
                    <label for="due_date">Data de Vencimento</label>
                    <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                        <input type="text" name="due_date" id="due_date" data-plugin-datepicker class="form-control" value="{{ $clientAccount->due_date }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control select2" required>
                        <option value="pending" {{ $clientAccount->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="partially_paid" {{ $clientAccount->status == 'partially_paid' ? 'selected' : '' }}>Parcialmente Pago</option>
                        <option value="paid" {{ $clientAccount->status == 'paid' ? 'selected' : '' }}>Pago</option>
                        <option value="overdue" {{ $clientAccount->status == 'overdue' ? 'selected' : '' }}>Vencido</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            </form>
        </div>
    </section>
    <!-- end: page -->
@endsection

@section('scripts')
    <script src="{{ asset('vendor/select2/js/select2.js') }}"></script>
@endsection
