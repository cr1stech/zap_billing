<!doctype html>
<html class="fixed header-dark">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/jquery-ui/jquery-ui.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/jquery-ui/jquery-ui.theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-multiselect/css/bootstrap-multiselect.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/morris/morris.css') }}"/>

    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}"/>

    @yield('styles')

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('css/skins/default.css') }}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Head Libs -->
    <script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>

</head>
<body>
<section class="body">

    @include('partials.topbar')

    <div class="inner-wrapper">
        @include('partials.sidebar')

        <section role="main" class="content-body">
            <!-- start: page -->
            @yield('content')
            <!-- end: page -->
        </section>
    </div>
</section>

<!-- Modal Danger -->
<div id="deleteModal" class="modal-block modal-header-color modal-block-danger mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Excluir Registro</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">¿Realmente deseas eliminar este registro?</h4>
                    <p>Puede excluir todos los registros vinculados a este campo</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                        <button class="btn btn-warning modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>


<!-- Vendor -->
<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('vendor/popper/umd/popper.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('vendor/common/common.js') }}"></script>
<script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('js/examples/examples.modals.js') }}"></script>

@yield('scripts')

<!-- Specific Page Vendor -->
{{--<script src="{{ asset('vendor/jquery-ui/jquery-ui.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jquery-appear/jquery.appear.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jquery.easy-pie-chart/jquery.easypiechart.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/flot.tooltip/jquery.flot.tooltip.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/raphael/raphael.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/morris/morris.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/gauge/gauge.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/snap.svg/snap.svg.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/liquid-meter/liquid.meter.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/jquery.vmap.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/data/jquery.vmap.sampledata.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.africa.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.asia.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.australia.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.europe.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.north-america.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jqvmap/maps/continents/jquery.vmap.south-america.js') }}"></script>--}}

<!-- Theme Base, Components and Settings -->
<script src="{{ asset('js/theme.js') }}"></script>

<!-- Theme Custom -->
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{{ asset('js/theme.init.js') }}"></script>

<!-- Examples -->
{{--<script src="{{ asset('js/examples/examples.dashboard.js') }}"></script>--}}

</body>
</html>
