<!DOCTYPE html>
<html lang="en">

@include('pharmacy.auth.partial.head',["title" =>"Login"])

<body>


    <div class="login-container">
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <h2>Login</h2>
        <form action="{{ route("login") }}" method="post">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope icon" style="color: #b7bdc8;"></i>
                {{-- <input type="email" id="email" placeholder="Enter your email" name="email" value="{{ old("email") }}"> --}}
                <x-text-input type="email" id="email" placeholder="Enter your email" name="email" :value="old('email')"/>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />



            <div class="input-group password-group">
                <i class="fas fa-lock icon" style="color: #b7bdc8;"></i>
                {{-- <input type="password" class="password-input" placeholder="Enter your password" name="password"> --}}
                <x-text-input type="password" class="password-input" placeholder="Enter your password" name="password"/>
                <i class="fas fa-eye password-toggle" style="color: #b7bdc8;"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />


            <div class="options">
                <x-input-label><input type="checkbox"> Remember password</x-input-label>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>


        <p class="or">or connect with</p>
        <a href="{{ route("login.google") }}" class="google-btn google-login">
             <img src="{{ asset("assets/images/google-logo.png") }}" alt="Google"> Log in with Google
        </a>



    </div>
@include('pharmacy.auth.partial.scripts')
</body>

</html>
