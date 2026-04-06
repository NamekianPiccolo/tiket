<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="styleguide.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
        :root {
        --search-shadow: 0px 4px 12px 0px rgba(0, 0, 0, 0.25);
        }
        @import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
        * {
        -webkit-font-smoothing: antialiased;
        box-sizing: border-box;
        }
        html,
        body {
        margin: 0px;
        height: 100%;
        }
        /* a blue color as a generic focus style */
        button:focus-visible,
        input:focus-visible {
        outline: 2px solid #4a90e2 !important;
        outline: -webkit-focus-ring-color auto 5px !important;
        }
        a {
        text-decoration: none;
        }

        /* Main container */
        .signup-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            position: relative;
            overflow: hidden;
        }

        /* Background image */
        .background-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Signup form container */
        .signup-form-container {
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        /* Left side (logo) */
        .signup-logo-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            max-width: 50%;
        }

        .signup-logo-side img {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }

        /* Right side (form) */
        .signup-form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            max-width: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            height: 100%;
        }

        /* Form elements */
        .signup-title {
            font-family: "Inter-Bold", Helvetica;
            font-weight: 700;
            color: #000000;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            position: relative;
            width: 100%;
            max-width: 350px;
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border-radius: 16px;
            border: 1px solid #d9d9d9;
            background-color: #f8f8f8;
            font-family: "Inter-Regular", Helvetica;
            font-size: 1rem;
            color: #000000;
        }

        .form-input::placeholder {
            color: #717171;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
        }

        .signup-btn {
            width: 100%;
            max-width: 350px;
            padding: 12px;
            background-color: black;
            border-radius: 10px;
            border: none;
            color: white;
            font-family: "Inter-Regular", Helvetica;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: opacity 0.3s;
        }

        .signup-btn:hover {
            opacity: 0.9;
        }

        .login-text {
            margin-top: 1.5rem;
            font-family: "Inter-Regular", Helvetica;
            font-weight: 400;
            color: #000000;
            font-size: 1rem;
        }

        .login-link {
            font-family: "Inter-ExtraBold", Helvetica;
            font-weight: 800;
            color: #640584;
            font-size: 1rem;
            cursor: pointer;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        /* Error message */
        .error-message {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffebee;
            color: #c62828;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: "Inter-Regular", Helvetica;
            z-index: 10;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .signup-form-container {
                flex-direction: column;
            }

            .signup-logo-side,
            .signup-form-side {
                max-width: 100%;
                padding: 1rem;
            }

            .signup-logo-side {
                height: 30%;
                align-items: flex-end;
            }

            .signup-form-side {
                height: 70%;
                justify-content: flex-start;
                padding-top: 2rem;
            }

            .signup-title {
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }

            .form-group {
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .signup-title {
                font-size: 1.8rem;
            }

            .form-input,
            .signup-btn {
                padding: 10px 35px 10px 12px;
                font-size: 0.9rem;
            }

            .input-icon {
                width: 18px;
                height: 18px;
            }
        }
    </style>
  </head>
  <body>
    <div class="signup-container">
        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <img class="background-image" src="{{ asset('storage/tikets/unsplash_yWF2LLan-_o.png')}}" />

        <div class="signup-form-container">
            <div class="signup-logo-side">
                <img src="{{ asset('storage/tikets/WhatsApp_Image_2025-05-11_at_19.20.40_d774a7d0-removebg-preview 1.png')}}" alt="Logo" />
            </div>

            <div class="signup-form-side">
                <form id="signupForm" action="{{ url('/register') }}" method="POST">
                    @csrf
                    <div class="signup-title">SIGN UP</div>

                    <!-- Name Input -->
                    <div class="form-group">
                        <input type="text" class="form-input" name="name" placeholder="Masukkan Nama" required>
                        <img class="input-icon" src="{{ asset('storage/tikets/Group 20.png')}}" alt="User icon" />
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <input type="email" class="form-input" name="email" placeholder="Masukkan Email" required>
                        <img class="input-icon" src="{{ asset('storage/tikets/email3.webp')}}" alt="Email icon" />
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <input type="password" class="form-input" name="password" placeholder="Masukkan Password" required>
                        <img class="input-icon" src="{{ asset('storage/tikets/Group 19.png')}}" alt="Password icon" />
                    </div>

                    <!-- Password Confirmation -->
                    <div class="form-group">
                        <input type="password" class="form-input" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        <img class="input-icon" src="{{ asset('storage/tikets/Group 19.png')}}" alt="Password icon" />
                    </div>

                    <!-- Signup Button -->
                    <button type="submit" class="signup-btn">DAFTAR</button>

                    <!-- Login Link -->
                    <div class="login-text">
                        Sudah punya akun? <a href="{{route('login')}}" class="login-link">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </body>
</html>
