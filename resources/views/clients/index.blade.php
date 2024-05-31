@extends('layouts.main')

@section('title')
    Ver Clientes
@endsection

@section('styles')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/dataTables.bootstrap5.css') }}" />
@endsection

@section('content')
    <!-- start: page -->
    <section class="card card-featured card-dark card-featured-danger mb-4">
        <header class="card-header">
            <a href="{{ route('clients.create') }}">
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-plus mx-3"></i> Criar Novo Cliente
                </button>
            </a>
        </header>
    </section>

    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <h2 class="card-title">Administrar Clientes</h2>
                </header>

                <div class="card-body">
                    <div id="datatable-wrapper">
                        <table class="table table-bordered table-striped mb-0" id="dataTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Conta Total</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('clients.datatables') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'total_account_value', name: 'total_account_value'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                language: {
                    url: "{{ asset('lang/pt-BR.json') }}"
                },
                "drawCallback": function (settings) {
                    $('#dataTable').on('click', '.linkDelete', function () {
                        let deleteLink = $(this).attr('data-href');
                        $('#deleteForm').attr('action', deleteLink);
                        $.magnificPopup.open({
                            items: {
                                src: '#deleteModal',
                                type: 'inline'
                            },
                            modal: true
                        });
                    });
                },
            });
        });
    </script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection
