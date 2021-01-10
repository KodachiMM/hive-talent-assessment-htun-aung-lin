<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | Auto Verge</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <link href="https://getbootstrap.com/docs/5.0/examples/dashboard/dashboard.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/css/feather.min.css">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <link href="https://cdn.jsdelivr.net/npm/pc-bootstrap4-datetimepicker@4.17/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        a {
            text-decoration: none;
        }

        .notifications {
            margin-top: 5px;
            width: 400px;
        }

        .notification-content {
            font-size: 16px;
        }

        .nav-item-text {
            position: relative;
            top: 2px;
        }

        .pagination-disable {
			opacity: .6;
			pointer-events: none;
		}

        [v-cloak] > * {
			display:none;
		}

		[v-cloak]::before {
			content: "";
			color: blue;
		}
    </style>

    @yield('style')
</head>
<body>
    @include('admin.layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('admin.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="app" v-cloak>
                @yield('content')
                <notifications group="notification" width="400px" position="top right" />
            </main>
        </div>
    </div>

    <script src="/js/admin/manifest.js"></script>
    <script src="/js/admin/vendor.js"></script>
    <script src="/js/admin/app.js"></script>

    <script src="https://kit.fontawesome.com/706adec7e9.js" crossorigin="anonymous"></script>
</body>
</html>