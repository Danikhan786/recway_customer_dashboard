@include('includes.head')
<style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body Style */
    body {
        background: url('{{ asset("assets/login_bg.png") }}') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        color: #333;
        overflow: hidden;
    }

    /* Login Container */
    .login-container {
        background-color: #ffffff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        padding: 40px 30px;
        width: 100%;
        max-width: 380px;
        text-align: center;
        position: relative;
        animation: fadeIn 1s ease-in-out;
    }

    /* Logo */
    .logo {
        margin-bottom: 20px;
        width: 200px;
    }

    /* Title */
    .login-title {
        font-size: 1.5em;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    /* Input Fields */
    .input-field {
        width: 100%;
        padding: 12px;
        margin: 12px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1em;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .input-field:focus {
        border-color: #0078D4;
        box-shadow: 0 4px 8px rgba(0, 120, 212, 0.3);
        transform: scale(1.02);
    }

    /* Password Container */
    .password-container {
        position: relative;
    }

    /* Eye Icon */
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2em;
        color: #0078D4;
    }

    /* Login Button */
    .login-button {
        background-color: #0078D4;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 8px;
        width: 100%;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s;
        box-shadow: 0 4px 8px rgba(0, 120, 212, 0.3);
    }

    .login-button:hover {
        background-color: #005bb5;
    }

    /* Link */
    .forgot-password {
        margin-top: 20px;
        font-size: 0.9em;
    }

    .forgot-password a {
        color: #0078D4;
        text-decoration: none;
        transition: color 0.3s;
    }

    .forgot-password a:hover {
        color: #005bb5;
        text-decoration: underline;
    }

    /* Footer Text */
    .footer-text {
        font-size: 0.85em;
        color: #666;
        margin-top: 25px;
    }

    /* Animation for container */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        .login-container {
            padding: 30px 20px;
            width: 90%;
        }
    }
</style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('assets/recway.png') }}" alt="Recway Logo" class="logo">
        <div class="login-title">Verification</div>
        <p>
            We have sent a verification code to your email address
        </p>
        <form method="post" action="{{ route('verify.otp') }}">
            @csrf
            <input type="text" class="input-field" placeholder="Enter Code" name="otp"  maxlength="6" required="" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            @error('otp')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <button class="login-button" type="submit" name="submit">Verify</button>
        </form>

        <div class="footer-text">
            <p>Please enter the One-Time Password (OTP) <br> sent to your email to proceed.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>