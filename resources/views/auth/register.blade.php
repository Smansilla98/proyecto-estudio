<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registro - {{ config('app.name', 'Escuela de Tambores') }}</title>

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
        .register-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
        }
        .register-left {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            padding: 60px 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .register-left i {
            font-size: 80px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .register-left h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .register-left p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .register-left .features {
            text-align: left;
            width: 100%;
        }
        .register-left .features div {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .register-left .features i {
            font-size: 18px;
            width: 20px;
        }
        .register-right {
            padding: 60px 50px;
        }
        .register-header {
            margin-bottom: 40px;
        }
        .register-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .register-header p {
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
        .btn-register {
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
        .btn-register:hover {
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
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }
        .login-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .login-link a:hover {
            color: #4f46e5;
        }
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            .register-left {
                padding: 40px 30px;
            }
            .register-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container" style="display: grid; grid-template-columns: 1fr 1fr;">
        <div class="register-left">
            <i class="fas fa-drum"></i>
            <h1>Únete a Nosotros</h1>
            <p>Crea tu cuenta y comienza tu viaje musical</p>
            <div class="features">
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Acceso a todos los ritmos</span>
                </div>
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Videos tutoriales exclusivos</span>
                </div>
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Partituras descargables</span>
                </div>
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Comunidad de músicos</span>
                </div>
            </div>
        </div>
        
        <div class="register-right">
            <div class="register-header">
                <h2>
                    <i class="fas fa-user-plus" style="color: #6366f1; margin-right: 10px;"></i>
                    Crear Cuenta
                </h2>
                <p>Completa el formulario para registrarte</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 25px; padding: 15px 20px; background: #fee2e2; color: #991b1b; border-radius: 8px; border-left: 4px solid #ef4444;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user" style="margin-right: 5px; color: #6366f1;"></i>
                        Nombre Completo
                    </label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        required 
                        class="form-control" 
                        placeholder="Juan Pérez"
                        value="{{ old('name') }}"
                        autofocus
                    >
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                    <small style="color: #6c757d; font-size: 12px; margin-top: 5px; display: block;">
                        Mínimo 8 caracteres
                    </small>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock" style="margin-right: 5px; color: #6366f1;"></i>
                        Confirmar Contraseña
                    </label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required 
                        class="form-control" 
                        placeholder="••••••••"
                    >
                    @error('password_confirmation')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Crear Cuenta
                </button>
            </form>

            <div class="login-link">
                <p style="color: #6c757d; font-size: 14px; margin: 0;">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i>
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

