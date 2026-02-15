<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar Sesión - {{ config('app.name', 'Escuela de Tambores') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', 'Nunito', sans-serif;
        }
        .login-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
        }
        .login-left {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            padding: 60px 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .login-left i {
            font-size: 80px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .login-left h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .login-left p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
        }
        .login-right {
            padding: 60px 50px;
        }
        .login-header {
            margin-bottom: 40px;
        }
        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .login-header p {
            color: #6c757d;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e293b;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }
        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-left {
                padding: 40px 30px;
            }
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container" style="display: grid; grid-template-columns: 1fr;">
        <div class="login-left">
            <i class="fas fa-drum"></i>
            <h1>Escuela de Tambores</h1>
            <p>Plataforma de aprendizaje para dominar el arte de la percusión</p>
        </div>
        
        <div class="login-right">
            <div class="login-header">
                <h2>
                    <i class="fas fa-sign-in-alt" style="color: #6366f1; margin-right: 10px;"></i>
                    Iniciar Sesión
                </h2>
                <p>Ingresa tus credenciales para acceder a tu cuenta</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 25px;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
            @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope" style="margin-right: 5px; color: #6366f1;"></i>
                        Correo Electrónico
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        class="form-control" 
                        placeholder="tu@email.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock" style="margin-right: 5px; color: #6366f1;"></i>
                        Contraseña
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        class="form-control" 
                        placeholder="••••••••"
                    >
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; color: #6c757d;">
                        <input type="checkbox" name="remember" style="cursor: pointer;">
                        <span>Recordarme</span>
                    </label>
                    <a href="#" style="color: #6366f1; text-decoration: none; font-size: 14px;">
                        ¿Olvidaste tu contraseña?
                    </a>
            </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </button>
            </form>

            <div style="text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #e0e0e0;">
                <p style="color: #6c757d; font-size: 14px; margin: 0;">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" style="color: #6366f1; text-decoration: none; font-weight: 500;">
                        <i class="fas fa-user-plus" style="margin-right: 5px;"></i>
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
