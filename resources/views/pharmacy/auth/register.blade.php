<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset("assets/css/register_style.css") }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Register Page</title>
</head>
<body>
  <div class="login-container">
    <form class="login-form" action="{{ route("register.store") }}" method="post">
        @csrf
      <h2>Sign Up</h2>
      <div class="input-group">
        <x-text-input type="text" placeholder="Enter your FirstName" name="first_name" :value="old('first_name')"/>
        <x-input-error :messages="$errors->get('first_name')" class="error-message" />
    </div>
      <div class="input-group">
        <x-text-input type="text" placeholder="Enter your lastName" name="last_name" :value="old('last_name')"/>
        <x-input-error :messages="$errors->get('last_name')" class="error-message" />
    </div>
      <div class="input-group">
        <x-text-input type="email" placeholder="Enter your email" name="email" :value="old('email')"/>
        <x-input-error :messages="$errors->get('email')" class="error-message" />
    </div>
      <div class="input-group">
        <x-text-input type="tel" placeholder="Enter your phone number" name="phone" :value="old('phone')"/>
        <x-input-error :messages="$errors->get('phone')" class="error-message" />
    </div>
      <div class="input-group password-group">
        <x-text-input type="password" class="password-input" placeholder="Enter your password" name="password" />
        <i class="fas fa-eye password-toggle" style="color: #b7bdc8; cursor: pointer;"></i>
        <x-input-error :messages="$errors->get('password')" class="error-message" />
    </div>

    <div class="input-group password-group">

        <input type="password" class="password-input" placeholder="Confirm your password" name="password_confirmation">
        <i class="fas fa-eye password-toggle" style="color: #b7bdc8; cursor: pointer;"></i>
        <x-input-error :messages="$errors->get('password_confirmation')" class="error-message" />
    </div>



      <button type="submit" class="login-btn">Submit</button>
      <div class="divider">or connect with</div>
      <a href="{{ route("login.google") }}" type="button" class="google-login">
        <img src="{{ asset("assets/images/google-logo.png") }}" alt="Google" width="20">
        Google
      </a>


    </form>
  </div>
  @include("pharmacy.auth.partial.scripts")
</body>
</html>
