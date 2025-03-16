document.addEventListener("DOMContentLoaded", function () {
    // التعامل مع أيقونات إظهار/إخفاء الباسورد
    document.querySelectorAll(".password-toggle").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            let passwordInput = this.previousElementSibling;

            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // إظهار الباسورد
                this.classList.replace("fa-eye", "fa-eye-slash"); // تغيير الأيقونة
            } else {
                passwordInput.type = "password"; // إخفاء الباسورد
                this.classList.replace("fa-eye-slash", "fa-eye"); // إرجاع الأيقونة
            }
        });
    });
});
