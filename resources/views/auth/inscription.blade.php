@extends('layouts.app')

@section('content')
    <div class="luxury-auth-page min-vh-100 d-flex align-items-center justify-content-center py-5">
        <!-- Mesh Gradient Background -->
        <div class="mesh-bg"></div>

        <div class="container" style="max-width: 600px; z-index: 10;">
            <div class="auth-card glass-card p-4 p-md-5">
                <div class="auth-header text-center mb-5">
                    <div class="auth-logo-wrapper mb-4">
                        <img src="https://img.icons8.com/color/96/chef-hat.png" alt="Join" class="auth-icon animate-float">
                    </div>
                    <h1 class="auth-title">Devenir <span class="text-gold">Partenaire</span></h1>
                    <p class="auth-subtitle">Rejoignez l'élite de la gastronomie locale</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-glass text-center mb-4">
                        <i class="fas fa-info-circle me-2 text-gold"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.inscription') }}" class="luxury-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-group-luxury">
                                <label for="nom_entreprise" class="form-label-luxury">Nom de l'établissement</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-store input-icon"></i>
                                    <input type="text" id="nom_entreprise" name="nom_entreprise"
                                        class="form-control-luxury @error('nom_entreprise') is-invalid @enderror"
                                        value="{{ old('nom_entreprise') }}" placeholder="Ex: Le Palais Gourmand" required
                                        autofocus>
                                </div>
                                @error('nom_entreprise')
                                    <span class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-group-luxury">
                                <label for="email" class="form-label-luxury">Adresse email professionnelle</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" id="email" name="email"
                                        class="form-control-luxury @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="contact@votre-resto.com" required>
                                </div>
                                @error('email')
                                    <span class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group-luxury">
                                <label for="password" class="form-label-luxury">Mot de passe</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" id="password" name="password"
                                        class="form-control-luxury @error('password') is-invalid @enderror"
                                        placeholder="••••••••" required>
                                </div>
                                @error('password')
                                    <span class="error-msg"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group-luxury">
                                <label for="password_confirmation" class="form-label-luxury">Confirmation</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-shield-alt input-icon"></i>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control-luxury" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4 mb-4">
                        <button type="submit" class="btn-luxury">
                            <span class="btn-text">SOUMETTRE MA CANDIDATURE</span>
                            <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="auth-footer text-center mt-4">
                    <p class="text-white-50">Déjà membre du réseau ?</p>
                    <a href="{{ route('login') }}" class="link-gold">
                        Connectez-vous <i class="fas fa-sign-in-alt ms-1 small"></i>
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
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.6rem;
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
            padding: 0.9rem 1rem 0.9rem 3rem;
            border-radius: 0.8rem;
            color: white;
            font-size: 0.95rem;
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
            padding: 1.1rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.15em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .btn-luxury:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
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
            font-size: 0.75rem;
            margin-top: 0.4rem;
            display: block;
        }
    </style>
@endsection