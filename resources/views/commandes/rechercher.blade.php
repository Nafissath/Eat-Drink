@extends('layouts.app')

@section('content')
    <div class="luxury-auth-container d-flex align-items-center justify-content-center py-5">
        <div class="glass-auth-card animate-fade-up">
            <div class="card-header-premium text-center mb-4">
                <div class="brand-spotlight mb-3">
                    <i class="fas fa-search-location text-gold fs-1"></i>
                </div>
                <h1 class="premium-title">Suivi de <span class="text-gold">Commande</span></h1>
                <p class="premium-subtitle">ENTREZ VOS IDENTIFIANTS DE RÉSERVATION</p>
            </div>

            @if(session('error'))
                <div class="luxury-alert danger mb-4 animate-shake">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('commandes.rechercher.process') }}" method="POST">
                @csrf

                <div class="luxury-input-group mb-4">
                    <label class="premium-label">NUMÉRO DE COMMANDE</label>
                    <div class="input-wrapper">
                        <i class="fas fa-hashtag"></i>
                        <input type="number" name="id" class="luxury-input" placeholder="Ex: 1245" required
                            value="{{ old('id') }}">
                    </div>
                    @error('id') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="luxury-input-group mb-5">
                    <label class="premium-label">NUMÉRO DE TÉLÉPHONE</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="telephone" class="luxury-input"
                            placeholder="Celui utilisé lors de la commande" required value="{{ old('telephone') }}">
                    </div>
                    @error('telephone') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-luxury-submit w-100">
                    <span class="btn-text">RECHERCHER MA COMMANDE</span>
                    <i class="fas fa-arrow-right ms-2 mt-1"></i>
                </button>
            </form>

            <div class="auth-footer text-center mt-5">
                <p class="text-white-50">En cas de difficulté, contactez notre service conciergerie.</p>
                <a href="{{ route('accueil') }}" class="btn-luxury-link mt-2">
                    <i class="fas fa-home me-2"></i> RETOUR À LA RÉSIDENCE
                </a>
            </div>
        </div>
    </div>

    <style>
        .luxury-auth-container {
            min-height: 80vh;
            background: radial-gradient(circle at center, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 1) 100%);
        }

        .glass-auth-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 30px;
            padding: 3.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .glass-auth-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .premium-title {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: white;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.25em;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .premium-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--luxury-gold);
            margin-bottom: 0.75rem;
            display: block;
            letter-spacing: 0.15em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .luxury-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1rem 1.25rem 1rem 3.5rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .luxury-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--luxury-gold);
            outline: none;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .luxury-input:focus+i {
            color: var(--luxury-gold);
        }

        .btn-luxury-submit {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            border: none;
            padding: 1.25rem;
            border-radius: 15px;
            color: #0f172a;
            font-weight: 800;
            letter-spacing: 0.1em;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-luxury-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
            filter: brightness(1.1);
        }

        .btn-luxury-link {
            color: var(--luxury-gold);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .btn-luxury-link:hover {
            color: white;
            transform: translateY(-1px);
        }

        .luxury-alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            border-left: 4px solid #ef4444;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
        }

        /* Animations */
        .animate-fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
@endsection