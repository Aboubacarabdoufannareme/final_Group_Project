// Modern Login Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    if (!form) return console.error('Login form not found');

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    // Real-time validation
    emailInput?.addEventListener('blur', validateEmail);
    passwordInput?.addEventListener('blur', validatePassword);

    function validateEmail() {
        const value = emailInput.value.trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!value) return showError(emailInput, "Email is required");
        if (!regex.test(value)) return showError(emailInput, "Please enter a valid email address");
        clearError(emailInput);
        return true;
    }

    function validatePassword() {
        const value = passwordInput.value;
        if (!value) return showError(passwordInput, "Password is required");
        clearError(passwordInput);
        return true;
    }

    function showError(input, message) {
        const parent = input.parentElement;
        let errorDiv = parent.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            parent.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        input.classList.add('error');
        return false;
    }

    function clearError(input) {
        const parent = input.parentElement;
        const errorDiv = parent.querySelector('.error-message');
        if (errorDiv) errorDiv.remove();
        input.classList.remove('error');
    }

    // Form submission via AJAX
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        if (!isEmailValid || !isPasswordValid) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.textContent = 'Signing In...';

        const formData = new FormData();
        formData.append('email', emailInput.value.trim());
        formData.append('password', passwordInput.value);

        try {
            const response = await fetch('controllers/login_process.php', { method: 'POST', body: formData });
            const data = await response.json();

            const alertDiv = document.createElement('div');
            if (data.success) {
                alertDiv.className = 'alert alert-success';
                alertDiv.innerHTML = '✔ Login successful! Redirecting...';
                form.insertBefore(alertDiv, form.firstChild);
                setTimeout(() => window.location.href = 'Dashboard.php', 1000);
            } else {
                alertDiv.className = 'alert alert-error';
                alertDiv.textContent = '✗ ' + (data.message || 'Login failed');
                form.insertBefore(alertDiv, form.firstChild);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                setTimeout(() => alertDiv.remove(), 5000);
            }
        } catch (err) {
            console.error(err);
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-error';
            alertDiv.textContent = '✗ Network error: ' + err.message;
            form.insertBefore(alertDiv, form.firstChild);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
            setTimeout(() => alertDiv.remove(), 5000);
        }
    });
});

