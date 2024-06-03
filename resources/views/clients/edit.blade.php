@extends('layouts.main')

@section('title')
    Editar Cliente
@endsection

@section('content')
    <!-- start: page -->
    <section class="card card-featured card-dark card-featured-primary mb-4">
        <header class="card-header">
            <h2 class="card-title">Editar Cliente</h2>
        </header>
        <div class="card-body">
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Telefone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $client->phone_number }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ $client->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Salvar</button>
            </form>
        </div>
    </section>
    <!-- end: page -->
@endsection
