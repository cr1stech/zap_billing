@extends('layouts.main')

@section('title')
    Criar Cliente
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection

@section('content')
    <!-- start: page -->
    <section class="card card-featured card-dark card-featured-primary mb-4">
        <header class="card-header">
            <h2 class="card-title">Criar Novo Cliente</h2>
        </header>
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Telefone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
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
