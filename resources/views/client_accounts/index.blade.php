@extends('layouts.main')

@section('title')
    Ver Contas dos Clientes
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
            <a href="{{ route('client-accounts.create') }}">
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-plus mx-3"></i> Criar Nova Conta
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

                    <h2 class="card-title">Administrar Contas dos Clientes</h2>
                </header>

                <div class="card-body">
                    <div id="datatable-wrapper">
                        <table class="table table-bordered table-striped mb-0" id="dataTable">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Cliente</th>
                                <th width="15%">Valor Total</th>
                                <th width="15%">Valor Pago</th>
                                <th width="20%">Data de Vencimento</th>
                                <th width="10%">Status</th>
                                <th width="10%">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- DataTables irá preencher o conteúdo aqui -->
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
                "ajax": "{{ route('client-accounts.datatables') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'client.name', name: 'client.name'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'amount_paid', name: 'amount_paid'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'status', name: 'status'},
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
