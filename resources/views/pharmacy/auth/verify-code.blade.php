<!DOCTYPE html>
<html lang="en">

@include("pharmacy.auth.partial.head",["title" => "Verify-Code"])

<body>
    <div class="login-container">
        <h2>Verify Code</h2>
        <p class="email-info">We sent a reset link to <strong id="user-email">AliMOH1234$%@gmail.com</strong></p>

        <form id="code-form">
            <div class="code-inputs">
                <input type="text" maxlength="1" class="code-box" required>
                <input type="text" maxlength="1" class="code-box" required>
                <input type="text" maxlength="1" class="code-box" required>
                <input type="text" maxlength="1" class="code-box" required>
                <input type="text" maxlength="1" class="code-box" required>
                <input type="text" maxlength="1" class="code-box" required>
            </div>

            <p class="error-message" id="code-error">Invalid code, please try again.</p>
            <p class="success-message" id="code-success">✅ Code Verified Successfully!</p>

            <button type="submit" class="login-btn">Confirm</button>
        </form>

        <p class="resend-text">
            Haven’t got the email yet? <a href="#" id="resend-email">Resend email</a>
        </p>
    </div>

    <script>
        // نجيب الإيميل المحفوظ من Local Storage
        let savedEmail = localStorage.getItem("reset-email");

        if (savedEmail) {
            document.getElementById("user-email").textContent = savedEmail;
        } else {
            document.getElementById("user-email").textContent = "your email";
        }
        // التأكد من الكود
        const correctCode = "123456";

        document.getElementById("code-form").addEventListener("submit", function (e) {
            e.preventDefault();

            // تجميع الكود المدخل
            let enteredCode = "";
            document.querySelectorAll(".code-box").forEach(input => {
                enteredCode += input.value;
            });

            if (enteredCode === correctCode) {
                document.getElementById("code-error").style.display = "none";
                document.getElementById("code-success").style.display = "block";

                setTimeout(() => {
                    window.location.href = "reset-password.html";
                }, 1500);
            } else {
                document.getElementById("code-error").style.display = "block";
            }
        });

        // التنقل بين المربعات تلقائيًا عند إدخال رقم
        const inputs = document.querySelectorAll(".code-box");
        inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus(); // الانتقال للحقل التالي
                }
            });
        });

        // إعادة إرسال البريد عند الضغط على "Resend email"
        document.getElementById("resend-email").addEventListener("click", function (e) {
            e.preventDefault();
            alert("A new verification code has been sent to your email.");
        });

    </script>
</body>

</html>
