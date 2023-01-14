<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &middot; Konslutasi Pisokolog IMM</title>
    @stack('prepend-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ url('/admin/css/styles.css') }}" rel="stylesheet" />
    @stack('addon-style')
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous">
    </script>
    <style>
        /* body {
            margin-top: 20px;
        } */

        .timeline {
            border-left: 3px solid #727cf5;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            /* background: rgba(114, 124, 245, 0.09); */
            background: #fff;
            margin: 10px 2px 10px 30px;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            /* font-size: 1.03em; */
            padding: 50px;
            list-style: none;
            text-align: left;
            /* max-width: 40%; */
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        /*
        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        } */

        /* .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        } */

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -207px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #727cf5;
            box-shadow: 0 0 0 3px #727cf5;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }

        .sidenav-light .sidenav-menu .nav-link.active {
            color: #00ac69 !important
        }

        .sidenav-light .sidenav-menu .nav-link:hover {
            color: #00ac69 !important
        }

        .sidenav-light .sidenav-menu .nav-link.active .nav-link-icon {
            color: #00ac69 !important
        }

        /* a {
            color: #00ac69!important
        } */

        .nav-borders .nav-link.active {
            color: #00ac69 !important;
            border-bottom-color: #00ac69 !important
        }

        .card:not([class*=bg-]) .card-header {
            color: #00ac69 !important
        }

        table.dataTable td,
        table.dataTable th {
            vertical-align: middle !important;
        }

        .page-link,
        .dataTable-pagination a {
            color: #00ac69 !important
        }

        .page-item.active .page-link,
        .page-item.active .dataTable-pagination a,
        .dataTable-pagination .page-item.active a,
        .dataTable-pagination li.active .page-link,
        .dataTable-pagination li.active a {
            background-color: #00ac69 !important;
            border-color: #00ac69 !important;
            color: #fff !important;
        }
    </style>
</head>

<body class="nav-fixed">
    @include('includes.navbar-admin')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('includes.sidebar-admin')
        </div>
        <div id="layoutSidenav_content">
            @yield('container')
            @include('includes.footer-admin')
        </div>
    </div>
    @stack('prepend-script')
    <script src="{{ url('/admin/js/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ url('/admin/js/scripts.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ url('/admin/js/litepicker.js') }}"></script>
    @stack('addon-script')
    @yield('script')
</body>

</html>
