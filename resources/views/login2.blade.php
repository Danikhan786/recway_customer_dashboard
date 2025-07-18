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
        flex-direction: column;
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

    .cards-portion {
        width: auto;
        animation: fadeIn 1s ease-in-out;
        display: flex;
        position: relative;
        bottom: -1rem;
    }

    .cards-portion .card {
        padding: 15px;
        width: 21rem;
        margin: 1rem;
        background-color: #ffffff;
        color: #4c5059;
        box-shadow: 0px 6px 10px 9px rgb(0 0 0 / 30%);
        display: flex;
        border-radius: 0.5rem;
        align-items: flex-start;
        

    } 


    /* .cards-portion {
        width: 100%;
        animation: fadeIn 1s ease-in-out;
        display: flex;
        background-color: #000000bf;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: baseline;
        margin-top: 2rem;
        bottom: -2.7rem;
        position: relative;
    }

    .cards-portion .card {
        padding: 15px;
        width: 25rem;
        margin: 0px;
        background-color: transparent;
        color: #e7e7e7;
        display: flex;
        align-items: flex-start;
        border-left: 2px solid white;
        border-radius: 0px;
        height: 7rem;

    } */

    .content h3 {
        margin: 0 0 5px;
        font-size: 16px;
        text-align: center
    }

    .content p {
        margin: 0;
        font-size: 13px;
        text-align: center
    }

    .icon {
        color: #0078d4;
        font-size: 22px;
        contain: size;
    }
</style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('assets/recway.png') }}" alt="Recway Logo" class="logo">
        <div class="login-title">Log in to <strong style="color:#ac0206">Recway's</strong> portal</div>
        <ul>
            @error('email')
                <li class="text-danger text-left"><i class="fa fa-info-circle"></i>
                    <strong>{{ $message }}</strong>
                </li>
            @enderror
            @error('password')
                <li class="text-danger text-left"><i class="fa fa-info-circle"></i>
                    <strong>{{ $message }}</strong>
                </li>
            @enderror
            @if (session('error'))
                <li class="text-danger text-left"><i class="fa fa-info-circle"></i>
                    <strong>{{ session('error') }}</strong>
                </li>
            @endif
            @if (session('status'))
                <li class="text-success text-left"><i class="fa fa-info-circle"></i>
                    <strong>{{ session('status') }}</strong>
                </li>
            @endif
        </ul>
        <form method="post" action="{{ route('login.submit') }}">
            @csrf
            <input type="text" class="input-field" placeholder="Username or Email" name="email" required="">

            <div class="password-container">
                <input type="password" class="input-field" id="password" placeholder="Password" name="password"
                    required="">
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>

            <button class="login-button" type="submit" name="submit">Log in</button>
        </form>
        <div class="forgot-password">
            <a href="{{ route('forgot-password') }}">Forgot password?</a>
        </div>

        <div class="footer-text">Recway's portal – A safer experience for all</div>
    </div>
    <div class="cards-portion">
        <div class="card" style="border-left:0px">
            <i class="fa-solid fa-shield icon"></i>
            <div class="content">
                <h3>GDPR</h3>
                <p>As a Swedish company within the EU, data protection and compliance with GDPR is a
                    matter of course for us.</p>
            </div>
        </div>
        <div class="card">
            <i class="fa-solid fa-lock icon"></i>
            <div class="content">
                <h3>Encryption of network traffic</h3>
                <p>All communication is encrypted with TLS 1.2 (or newer) encryption.</p>
            </div>
        </div>
        <div class="card">
            <i class="fa-solid fa-database icon"></i>
            <div class="content">
                <h3>Data locality</h3>
                <p>Our servers are securely located in Sweden and operated within the country.</p>
            </div>
        </div>
        <div class="card">
            <i class="fa-solid fa-trash icon"></i>
            <div class="content">
                <h3>Data retention</h3>
                <p>The system has built-in functionality to remove customer data from systems and
                    backups.</p>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>