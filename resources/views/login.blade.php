<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
  <title>Recway | Customer Portal</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Nunito Sans", sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      background-color: #f8f9fa;
      background-image: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .container {
      display: flex;
      width: 90%;
      max-width: 1400px;
      height: 90%;
      margin: auto;
      border-radius: 2vh;
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
      animation: fadeIn 1s ease-in-out;
    }

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

    .login-container {
      flex: 1;
      background-color: white;
      padding: 10vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
      animation: slideInLeft 1s ease-in-out;
      padding-top: 19vh;
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .login-container::before {
      content: "";
      position: absolute;
      top: -2vh;
      left: -2vh;
      width: 15vh;
      height: 15vh;
      border-radius: 50%;
      background-color: rgba(172, 2, 6, 0.05);
      z-index: 0;
    }

    .login-container::after {
      content: "";
      position: absolute;
      bottom: -15vh;
      right: -15vh;
      width: 43vh;
      height: 43vh;
      border-radius: 50%;
      background-color: rgba(172, 2, 6, 0.05);
      z-index: 0;
    }

    .login-content {
      position: relative;
      z-index: 1;
      max-width: 55vh;
      width: 100%;
      margin: 0 auto;
    }

    .logo {
      left: -1vh;
      position: relative;
      margin-bottom: 1vh;
      width: 35vh;
      filter: drop-shadow(0px 0.2vh 0.4vh rgba(0, 0, 0, 0.1));
      animation: zoomIn 1s ease-in-out;
    }

    @keyframes zoomIn {
      from {
        transform: scale(0.8);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .form-title {
      font-size: 3.5vh;
      margin-bottom: 1vh;
      color: #333;
      font-weight: 600;
    }

    .form-subtitle {
      font-size: 2vh;
      margin-bottom: 4vh;
      color: #666;
    }

    .login-form {
      width: 100%;
      height: 50vh;
    }

    .form-group {
      margin-bottom: 3vh;
    }

    .form-group label {
      display: block;
      margin-bottom: 1vh;
      font-weight: 500;
      color: #444;
      font-size: 2vh;
    }

    .input-wrapper {
      position: relative;
      display: flex;
    }

    .form-group input {
      width: 100%;
      padding: 1.4vh 6vh 1.4vh 6vh;
      /* Padding for icons */
      border: 0.4vh solid #e0e0e0;
      border-radius: 1vh;
      font-size: 2vh;
      transition: all 0.3s;
      background-color: #f9f9f9;
    }

    .form-group input:focus {
      outline: none;
      border-color: #ac0206;
      background-color: #fff;
      box-shadow: 0 0 0 0.5vh rgba(172, 2, 6, 0.15);
    }

    .input-wrapper i {
      position: absolute;
      left: 2vh;
      top: 2vh;
      /* transform: translateY(-50vh); */
      color: #777;
      font-size: 2vh;
    }

    .password-toggle {
      position: absolute;
      right: 6vh;
      /* top: 1vh; */
      /* transform: translateY(-50%); */
      color: #777;
      cursor: pointer;
      transition: color 0.3s;
      font-size: 2vh;
    }

    .password-toggle:hover {
      color: #ac0206;
    }

    .remember-me {
      display: flex;
      align-items: center;
      margin-bottom: 24px;
      font-size: 14px;
      color: #555;
    }

    .remember-me input {
      margin-right: 10px;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      width: 18px;
      height: 18px;
      border: 1.5px solid #ddd;
      border-radius: 4px;
      outline: none;
      transition: all 0.3s;
      position: relative;
      cursor: pointer;
    }

    .remember-me input:checked {
      background-color: #ac0206;
      border-color: #ac0206;
    }

    .remember-me input:checked::before {
      content: "✓";
      position: absolute;
      color: white;
      font-size: 12px;
      font-weight: bold;
      top: 0;
      left: 4px;
    }

    .login-btn {
      width: 100%;
      padding: 1.4vh;
      background: #ac0206;
      color: white;
      border: none;
      border-radius: 1vh;
      font-size: 2vh;
      margin-top: 4vh;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 0.4vh 1vh rgba(172, 2, 6, 0.3);
    }

    .login-btn:hover {
      background: #8a0205;
      transform: translateY(-0.5vh);
      box-shadow: 0 0.6vh 2vh rgba(172, 2, 6, 0.4);
    }

    .login-btn:active {
      transform: translateY(0.1vh);
      box-shadow: 0 0.2vh 1vh rgba(172, 2, 6, 0.4);
    }

    .forgot-password {
      margin-top: 2vh;
      text-align: center;
      font-size: 2vh;
    }

    .forgot-password a {
      color: #ac0206;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .forgot-password a:hover {
      color: #8a0205;
      text-decoration: underline;
    }

    .features-container {
      flex: 1;
      background: #ac0206;
      color: white;
      padding: 5vh;
      position: relative;
      overflow: hidden;
      animation: slideInRight 1s ease-in-out;
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .features-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .animated-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .circle {
      position: absolute;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 15s infinite ease-in-out;
    }

    .circle:nth-child(1) {
      width: 48vh;
      height: 48vh;
      top: -80px;
      right: -50px;
      animation-delay: 0s;
      background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    }

    .circle:nth-child(2) {
      width: 30vh;
      height: 30vh;
      bottom: 30%;
      right: 20%;
      animation-delay: 2s;
      background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    }

    .circle:nth-child(3) {
      width: 25vh;
      height: 25vh;
      bottom: 10%;
      left: 20%;
      animation-delay: 4s;
      background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    }

    .circle:nth-child(4) {
      width: 28vh;
      height: 28vh;
      top: 20%;
      left: 10%;
      animation-delay: 6s;
      background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0) translateX(0) scale(1);
      }

      25% {
        transform: translateY(-20px) translateX(20px) scale(1.05);
      }

      50% {
        transform: translateY(5px) translateX(30px) scale(0.95);
      }

      75% {
        transform: translateY(15px) translateX(15px) scale(1.02);
      }
    }

    .features-content {
      position: relative;
      z-index: 2;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .features-list {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 4vh;
    }

    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 3vh;
      transition: transform 0.3s;
      flex-direction: row;
      flex-wrap: nowrap;
    }

    .feature-item:hover {
      transform: translateX(5px);
    }

    .feature-icon {
      padding: 3vh;
      width: 6vh;
      height: 6vh;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 1vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 2vh;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(5px);
      font-size: 3vh
    }

    .feature-icon img {
      width: 2.4vh;
      height: 2.4vh;
      filter: brightness(0) invert(1);
      /* Make icons white */
    }

    .feature-text h3 {
      font-size: 2.2vh;
      margin-bottom: 1vh;
      font-weight: 600;
    }

    .feature-text p {
      font-size: 2vh;
      opacity: 0.9;
      line-height: 1.5;
    }

    @media (max-width: 576px) {
      .container {
        width: 90%;
        margin: 2vh auto;
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: center;
        height: fit-content;
      }

      .login-btn {
        margin-top: 0vh;
      }
    }

    /* Big screen adjustments */
    @media (min-width: 1600px) {
      .container {
        max-width: 90%;
      }
    }

    .custom_p {
      color: #bd0408;
      float: left;
    }
  </style>
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="container">
    <!-- Left side - Login form -->
    <div class="login-container">
      <div class="login-content">
        <img src="{{ asset('assets/recway.png') }}" alt="Recway Logo" class="logo">
        <h1 class="form-title">Log in to Recway's portal</h1>
        <p class="form-subtitle">Please enter your credentials to access your account</p>
        @error('email')
      <p class="custom_p"><i class="fa fa-info-circle"></i>
        {{ $message }}
      </p>
    @enderror
        @error('password')
      <p class="custom_p"><i class="fa fa-info-circle"></i>
        {{ $message }}
      </p>
    @enderror
        @if (session('error'))
      <p class="custom_p"><i class="fa fa-info-circle"></i>
        {{ session('error') }}
      </p>
    @endif
        @if (session('status'))
      <p class="text-success text-left"><i class="fa fa-info-circle"></i>
        {{ session('status') }}
      </p>
    @endif
        <form method="post" action="{{ route('login.submit') }}" class="login-form">
          @csrf
          <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i> <!-- Font Awesome for email -->
              <input type="email" id="email" placeholder="Enter your email" name="email" required>
            </div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <i class="fas fa-lock"></i> <!-- Font Awesome for password -->
              <input type="password" id="password" placeholder="Enter your password" name="password" required>
              <span class="password-toggle" id="password-toggle">
                <i class="fas fa-eye"></i> <!-- Font Awesome for eye -->
              </span>
            </div>
          </div>

          <!-- <div class="remember-me">
            <input type="checkbox" id="remember">
            <label for="remember">Remember me</label>
          </div> -->

          <button type="submit" class="login-btn">Sign In</button>

          <div class="forgot-password">
            <a href="{{ route('forgot-password') }}">Forgot your password?</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Right side - Features with red background -->
    <div class="features-container">
      <div class="animated-bg">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
      </div>
      <div class="features-overlay"></div>

      <div class="features-content">
        <div class="features-list">
          <!-- Security features with Font Awesome icons -->

          <div class="feature-item">
            <div class="feature-icon">
              <i class="fa-solid fa-shield-halved"></i> <!-- Font Awesome for Encryption -->
            </div>
            <div class="feature-text">
              <h3>GDPR</h3>
              <p>As a Swedish company within the EU, data protection and compliance with GDPR is a matter of course for
                us.</p>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-lock"></i> <!-- Font Awesome for Encryption -->
            </div>
            <div class="feature-text">
              <h3>Encryption of network traffic</h3>
              <p>All communication is encrypted with TLS 1.2 (or newer) encryption.</p>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-server"></i> <!-- Font Awesome for Server -->
            </div>
            <div class="feature-text">
              <h3>Data locality</h3>
              <p>Our servers are securely located in Sweden and operated within the country.</p>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-database"></i> <!-- Font Awesome for Database -->
            </div>
            <div class="feature-text">
              <h3>Data retention</h3>
              <p>The system has built-in functionality to remove customer data from systems and backups.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Password visibility toggle
    document.addEventListener('DOMContentLoaded', function () {
      const passwordField = document.getElementById('password');
      const passwordToggle = document.getElementById('password-toggle');

      passwordToggle.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle icon
        const icon = passwordToggle.querySelector('i');
        if (type === 'text') {
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });
  </script>
</body>
<script>
  document.addEventListener("contextmenu", function (e) {
    e.preventDefault();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "F12") {
      e.preventDefault();
    }
    if (e.ctrlKey && e.shiftKey && ["I", "J", "C"].includes(e.key.toUpperCase())) {
      e.preventDefault();
    }

    if (e.ctrlKey && e.key.toUpperCase() === "U") {
      e.preventDefault();
    }
  });
</script>
</html>