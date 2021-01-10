<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Auto Verge - Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <link href="https://getbootstrap.com/docs/5.0/examples/sign-in/signin.css" rel="stylesheet">

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
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="/admin/login" method="post" autocomplete="off">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            @if ($errors->has('errors'))
            <div class="alert alert-danger">
                <strong>{{ $errors->first('errors') }}</strong>
            </div>
            @endif

            <label for="email" class="visually-hidden">Email address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>

            <label for="password" class="visually-hidden">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </main>
</body>
</html>