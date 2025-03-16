<!DOCTYPE html>
<html lang="en">

@include("pharmacy.auth.partial.head",["title" => "Reset-Password"])

<body>
    <div class="login-container">
        <h2>Set a New Password</h2>
        <p class="password-info">Create a new password. Ensure it differs from previous ones for security.</p>
@include('pharmacy.auth.messages.message')
        <form id="reset-form" action="{{ route('password.store') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="input-group">
                <i class="fas fa-lock icon" style="color: #b7bdc8;"></i>
                <input type="email" id="email" placeholder="Email address" name="email" value="{{ $request->input('email')}}" readonly>
            </div>

            <div class="input-group">
                <i class="fas fa-lock icon" style="color: #b7bdc8;"></i>
                <input type="password" id="new-password" placeholder="New password" name="password" required>
                <i class="fas fa-eye password-toggle" id="toggleNewPassword" style="color: #b7bdc8;"></i>
            </div>

            <div class="input-group">
                <i class="fas fa-lock icon" style="color: #b7bdc8;"></i>
                <input type="password" id="confirm-password" placeholder="Confirm password" name="password_confirmation" required>
                <i class="fas fa-eye password-toggle" id="toggleConfirmPassword" style="color: #b7bdc8;"></i>
            </div>

            <button type="submit" class="login-btn">Update Password</button>
        </form>
    </div>

@include('pharmacy.auth.partial.scripts')
</body>

</html>
