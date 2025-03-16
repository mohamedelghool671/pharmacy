<!DOCTYPE html>
<html lang="en">

<head>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset("assets/css/all.min.css") }}">
        <!-- Normalize -->
        <link rel="stylesheet" href="{{ asset("assets/css/nomalize.css") }}">
        <!-- CSS File -->
        <link rel="stylesheet" href="{{ asset("assets/css/login.css") }}">
        <title>Forget-Password Page</title>
</head>

<body>

    <div class="login-container">
@include("pharmacy.auth.messages.message")
        <h2>Forgot Password</h2>
        <p>Please enter your email to reset your password.</p>

        <form id="email-form" action="{{ route("password.email") }}" method="post">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope icon" style="color: #b7bdc8;"></i>
                <x-text-input type="email" id="email" name="email" placeholder="Enter your email" required style="border: 2px solid var(--input-border); border-radius: 8px;"/>
            </div>
            <button type="submit" class="login-btn">Reset Password</button>
        </form>
    </div>


</body>

</html>
