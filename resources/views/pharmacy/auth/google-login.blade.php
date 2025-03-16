<!DOCTYPE html>
<html lang="en">
@include('pharmacy.auth.partial.head',["title" => "google-login"])
<body>

    <div class="google-container">
        <h2>Login with Google <img src="images/google-logo.png" alt="Google"></h2>
        <div class="title-container">
            <img src="../images/logo.png" alt="Sally Pharmacy Logo" class="logo">
            <div class="text">
                <p class="main-text">Choose an account</p><br>
                <p class="sub-text">to continue to <span class="app-name">Sally Pharmacy</span></p>
            </div>
        </div>

        <div class="account-list" id="account-list">
            <!-- الإيميلات هتظهر هنا ديناميكيًا -->
        </div>

        <div class="use-another-account">
            <i class="fas fa-user-plus icon"></i>
            <input type="text" value="Use another account" readonly>
        </div>

        <p class="policy">
            Before using this app, you can review Sally Pharmacy
            <a href="#">privacy policy</a> and <a href="#">terms of services</a>
        </p>
    </div>

    <script src="google-login.js"></script>
</body>
</html>
