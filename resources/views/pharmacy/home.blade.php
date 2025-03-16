<!DOCTYPE html>
<html lang="en">
<head>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset("assets/css/all.min.css") }}">
        <!-- Normalize -->
        <link rel="stylesheet" href="{{ asset("assets/css/nomalize.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/css/home_style.css") }}" />
</head>

<body>
    <header>
        <h1>Welcome</h1>
    </header>

    <section class="user-selection">
        <a href="{{ route("register") }}" class="user-card"><img src="{{ asset("assets/images/buyer.png") }}" alt="buyer">
            <h2>Create Acount </h2>
        </a>
        <a href="{{ route("login") }}" class="user-card"><img src="{{ asset("assets/images/buyer.png") }}" alt="pharmacist">
            <p>Do you already have an account?</p>
            <h2>Log in </h2>
        </a>
    </section>


</body>

</html>
