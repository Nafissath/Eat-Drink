@extends('layouts.app')

@section('content')
    <div class="luxury-auth-page min-vh-100 d-flex align-items-center justify-content-center py-5">
        <!-- Mesh Gradient Background -->
        <div class="mesh-bg"></div>

        <div class="container" style="max-width: 450px; z-index: 10;">
            <div class="auth-card glass-card p-4 p-md-5">
                <div class="auth-header text-center mb-5">
                    <div class="auth-logo-wrapper mb-4">
                        <img src="https://img.icons8.com/color/96/lock-2.png" alt="Connect" class="auth-icon animate-float">
                    </div>
                    <h1 class="auth-title">Connexion <span class="text-gold">Eat&Drink</span></h1>
                    <p class="auth-subtitle">Accédez à votre espace premium</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-glass text-center mb-4">
                        <i class="fas fa-info-circle me-2 text-gold"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}" class="luxury-form">
                    @csrf
                    <div class="form-group-luxury mb-4">
                        <label for="email" class="form-label-luxury">Adresse email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email"
                                class="form-control-luxury @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="votre@email.com" required autofocus>
                        </div>
                        @error('email')
                            <span class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group-luxury mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="form-label-luxury">Mot de passe</label>
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                class="form-control-luxury @error('password') is-invalid @enderror" placeholder="••••••••"
                                required>
                        </div>
                        @error('password')
                            <span class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn-luxury">
                            <span class="btn-text">SE CONNECTER</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="auth-footer text-center mt-4">
                    <p class="text-white-50">Pas encore de compte ?</p>
                    <a href="{{ route('auth.inscription') }}" class="link-gold">
                        Devenir Partenaire <i class="fas fa-external-link-alt ms-1 small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .luxury-auth-page {
            position: relative;
            overflow: hidden;
            background: #0f172a;
            font-family: 'Outfit', sans-serif;
        }

        .mesh-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0f172a;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 30%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 30%, 1) 0, transparent 50%);
            opacity: 0.6;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: white;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .text-gold {
            background: linear-gradient(135deg, #d4af37 0%, #f1c40f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            font-weight: 300;
        }

        .auth-logo-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-icon {
            width: 48px;
            height: 48px;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .form-label-luxury {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            color: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .form-control-luxury {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 1rem;
            color: white;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-luxury:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #d4af37;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
            outline: none;
        }

        .form-control-luxury:focus+.input-icon {
            color: #d4af37;
        }

        .btn-luxury {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 1.2rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.15em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .btn-luxury:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .btn-luxury:active {
            transform: translateY(-1px);
        }

        .link-gold {
            color: #d4af37;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .link-gold:hover {
            color: #f1c40f;
            text-shadow: 0 0 15px rgba(241, 196, 15, 0.3);
        }

        .alert-glass {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: #d4af37;
            border-radius: 1rem;
            font-size: 0.9rem;
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: block;
        }
    </style>
@endsection