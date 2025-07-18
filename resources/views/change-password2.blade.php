<!-- <link rel="stylesheet" href="{{ asset('assets/css/vendors/login-css.css') }}" /> -->
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
            height: 65% !important;
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
        <div class="login-title">Reset Password</div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="password-container">
                <input id="new-password" type="password" class="input-field" placeholder="Enter New Password" name="password" required="">
                <span class="toggle-password" onclick="togglePassword('new-password', this.querySelector('i'))">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>
            <div class="password-container">
                <input id="confirm-password" type="password" class="input-field" placeholder="Confirm Password" name="password_confirmation" required="">
                <span class="toggle-password" onclick="togglePassword('confirm-password', this.querySelector('i'))">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>


            <button class="login-button" type="submit" name="submit">Reset Password</button>
        </form>

        <div class="footer-text">Recway's portal – A safer experience for all</div>
    </div>

    <scrip>
        <script>
            function togglePassword(fieldId, icon) {
                const passwordField = document.getElementById(fieldId);
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.add('fa-eye');
                    icon.classList.remove('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.add('fa-eye-slash');
                    icon.classList.remove('fa-eye');
                }
            }
        </script>
</body>

</html>
<!-- 
<body>
    <div class="container">
        <div class="login">
           <div class="login-container">
           <h1 style="text-align: center;">Change Your Password</h1>
           @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Enter Email Address" required="">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating mt-4">
                    <input type="password" class="form-control" id="floatingPassword1" name="password_confirmation" placeholder="Enter Email Address" required="">
                    <label for="floatingPassword">Confirm Password</label>
                </div>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="submit" >Change Password</button>
                </form>
           </div>
        </div>
        <div class="register">
            <div class="container">
              <img src="assets/images/password-protection.png" height="150" alt="">
              <h2>Update Your Password</h2>
              <p>Create a new password to update your account security.</p>
          </div>
        </div>      
      </div>
      <script>

      </script>
</body>
</html> -->