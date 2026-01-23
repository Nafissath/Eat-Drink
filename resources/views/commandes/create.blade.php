@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-emerald: #10b981;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        .luxury-checkout-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 100% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: white;
            padding-top: 4rem;
            padding-bottom: 6rem;
        }

        .luxury-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.4;
            background:
                radial-gradient(at 100% 0%, rgba(212, 175, 55, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.08) 0px, transparent 50%);
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .luxury-heading {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-style: italic;
            margin-bottom: 3rem;
            background: linear-gradient(to right, #fff, rgba(255, 255, 255, 0.5));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .luxury-form-card {
            background: var(--luxury-glass);
            backdrop-filter: blur(24px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 40px;
            padding: 50px;
            box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.6);
        }

        .section-label {
            color: var(--luxury-gold);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 800;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 25px;
        }

        .luxury-input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .luxury-input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 18px 25px;
            color: white;
            width: 100%;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .luxury-input:focus {
            outline: none;
            border-color: var(--luxury-gold);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }

        .luxury-type-card {
            cursor: pointer;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 25px;
            padding: 25px;
            transition: all 0.4s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-check:checked+.luxury-type-card {
            background: rgba(212, 175, 55, 0.05);
            border-color: var(--luxury-gold);
            transform: translateY(-5px);
        }

        .btn-check:checked+.luxury-type-card::after {
            content: '\f058';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 15px;
            right: 15px;
            color: var(--luxury-gold);
        }

        .luxury-icon-box {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .btn-check:checked+.luxury-type-card .luxury-icon-box {
            background: var(--luxury-gold);
            color: #0f172a;
        }

        .luxury-summary-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 40px;
            padding: 40px;
            position: sticky;
            top: 120px;
        }

        .luxury-btn-submit {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 22px;
            border-radius: 22px;
            border: none;
            width: 100%;
            transition: all 0.4s;
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.3);
            margin-top: 30px;
        }

        .luxury-btn-submit:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(212, 175, 55, 0.5);
        }

        #numeroTableGroup,
        #livraisonGroup {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gold-glow {
            text-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        }
    </style>

    <div class="luxury-checkout-wrapper">
        <div class="luxury-mesh"></div>

        <div class="container animate__animated animate__fadeIn">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <nav class="mb-4 opacity-50">
                        <span class="small fw-800 letter-spacing-2 text-uppercase">Expérience Gastronomique <i
                                class="fas fa-chevron-right mx-3"></i> Finalisation</span>
                    </nav>
                    <h1 class="luxury-heading d-inline-block">Réserver votre Dégustation</h1>
                </div>
            </div>

            <form action="{{ route('commandes.store') }}" method="POST" id="commandeForm">
                @csrf

                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="luxury-form-card">

                            @if (session('error') || $errors->any())
                                <div
                                    class="alert bg-danger bg-opacity-10 text-danger border-0 rounded-4 p-4 mb-5 animate__animated animate__shakeX">
                                    <h6 class="fw-800 mb-2"><i class="fas fa-exclamation-crown me-2"></i> Un détail requiert
                                        votre attention :</h6>
                                    <ul class="mb-0 small fw-500 opacity-75">
                                        @if(session('error'))
                                        <li>{{ session('error') }}</li> @endif
                                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Section 1: Mode -->
                            <div class="mb-5 pb-4 border-bottom border-white-10">
                                <span class="section-label">01. Mode de Réception</span>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <input class="btn-check" type="radio" name="type_commande" id="surPlace"
                                            value="sur_place" checked>
                                        <label class="luxury-type-card d-block" for="surPlace">
                                            <div class="luxury-icon-box">
                                                <i class="fas fa-chair fs-4"></i>
                                            </div>
                                            <h5 class="fw-800 mb-2">Expérience à Table</h5>
                                            <p class="text-white-50 small mb-0">Savourez vos créations directement chez
                                                l'exposant.</p>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="btn-check" type="radio" name="type_commande" id="livraison"
                                            value="livraison">
                                        <label class="luxury-type-card d-block" for="livraison">
                                            <div class="luxury-icon-box">
                                                <i class="fas fa-concierge-bell fs-4"></i>
                                            </div>
                                            <h5 class="fw-800 mb-2">Livraison Privée</h5>
                                            <p class="text-white-50 small mb-0">Dégustez nos mets exclusifs dans l'intimité
                                                de votre lieu.</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Personal -->
                            <div class="mb-5 pb-4 border-bottom border-white-10">
                                <span class="section-label">02. Identité du Gourmet</span>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="luxury-input-group">
                                            <label class="small fw-800 opacity-50 mb-3 d-block">NOM & PRÉNOM</label>
                                            <input type="text" class="luxury-input" name="nom_client"
                                                placeholder="Votre nom complet" required
                                                value="{{ auth()->user() ? auth()->user()->name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="luxury-input-group">
                                            <label class="small fw-800 opacity-50 mb-3 d-block">LIGNE DIRECTE</label>
                                            <input type="tel" class="luxury-input" name="telephone"
                                                placeholder="+229 00 00 00 00" required>
                                        </div>
                                    </div>
                                    @guest
                                        <div class="col-12">
                                            <div class="luxury-input-group">
                                                <label class="small fw-800 opacity-50 mb-3 d-block">CORRESPONDANCE
                                                    ÉLECTRONIQUE</label>
                                                <input type="email" class="luxury-input" name="email_client"
                                                    placeholder="votre@prestige.com" required>
                                                <div class="text-white-50 small mt-3 italic">* Pour le suivi exclusif de votre
                                                    commande</div>
                                            </div>
                                        </div>
                                    @endguest
                                </div>
                            </div>

                            <!-- Section 3: Details (Dynamic) -->
                            <div id="numeroTableGroup">
                                <span class="section-label">03. Emplacement Précis</span>
                                <div class="luxury-input-group">
                                    <label class="small fw-800 opacity-50 mb-3 d-block">NUMÉRO DE VOTRE TABLE</label>
                                    <input type="number" class="luxury-input" id="numero_table" name="numero_table"
                                        placeholder="Ex: Boutique Table n°5" min="1">
                                </div>
                            </div>

                            <div id="livraisonGroup" style="display: none;">
                                <span class="section-label">03. Destination de Livraison</span>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="luxury-input-group">
                                            <label class="small fw-800 opacity-50 mb-3 d-block">ADRESSE DÉTAILLÉE</label>
                                            <textarea class="luxury-input" id="adresse" name="adresse" rows="2"
                                                placeholder="Résidence, Quartier, Repères visuels..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="luxury-input-group">
                                            <label class="small fw-800 opacity-50 mb-3 d-block">CITÉ / VILLE</label>
                                            <input type="text" class="luxury-input" id="ville" name="ville"
                                                placeholder="Ex: Cotonou">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="luxury-input-group">
                                            <label class="small fw-800 opacity-50 mb-3 d-block">ZONE / QUARTIER</label>
                                            <input type="text" class="luxury-input" id="code_postal" name="code_postal"
                                                placeholder="Ex: Cadjehoun">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Extra -->
                            <div>
                                <span class="section-label">04. Instructions Particulières</span>
                                <textarea class="luxury-input" name="instructions" rows="3"
                                    placeholder="Une préférence culinaire ? Une consigne de discrétion ?"></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar Sidebar Summary -->
                    <div class="col-lg-4">
                        <div class="luxury-summary-card animate__animated animate__fadeInRight">
                            <h4 class="fw-800 mb-5 pb-3 border-bottom border-white-10">Votre Séance</h4>

                            <div class="mb-5">
                                @if(session('panier'))
                                    @foreach(session('panier') as $id => $item)
                                        <div class="d-flex justify-content-between mb-4 align-items-center">
                                            <div>
                                                <span class="text-gold fw-800 me-2">{{ $item['quantite'] }}x</span>
                                                <span class="text-white-50 small">{{ $item['nom'] }}</span>
                                            </div>
                                            <span
                                                class="fw-700 small">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }}
                                                <span class="opacity-20">XOF</span></span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="p-4 rounded-4 bg-black bg-opacity-20 mb-5">
                                <div class="d-flex justify-content-between mb-3 opacity-50 small">
                                    <span>Total des Créations</span>
                                    <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4 opacity-50 small">
                                    <span>Service & Logistique</span>
                                    <span class="text-emerald fw-bold">OFFERT</span>
                                </div>
                                <div
                                    class="pt-4 border-top border-white-10 d-flex justify-content-between align-items-center">
                                    <span class="fw-800 letter-spacing-1">TOTAL</span>
                                    <div class="text-end">
                                        <div class="fs-2 fw-800 text-gold lh-1">{{ number_format($total, 0, ',', ' ') }}
                                        </div>
                                        <div class="small fw-800 opacity-20 mt-1">FRANC CFA</div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="luxury-btn-submit">
                                CONFIRMER LA SÉANCE
                            </button>

                            <div class="mt-5 text-center">
                                <a href="{{ route('panier') }}"
                                    class="text-decoration-none text-white-50 small hover-gold transition-all">
                                    <i class="fas fa-shopping-bag me-2"></i>Ajuster ma sélection
                                </a>
                            </div>

                            <div class="mt-5 pt-4 text-center opacity-25 grayscale border-top border-white-10">
                                <img src="https://img.icons8.com/color/48/visa.png" width="30" class="mx-2" />
                                <img src="https://img.icons8.com/color/48/mastercard.png" width="30" class="mx-2" />
                                <p class="small mt-3 fw-500">PAIEMENT SÉCURISÉ & TRACÉ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const surPlace = document.getElementById('surPlace');
                    const livraison = document.getElementById('livraison');
                    const tableGroup = document.getElementById('numeroTableGroup');
                    const livraisonGroup = document.getElementById('livraisonGroup');

                    function toggleMode() {
                        if (surPlace.checked) {
                            tableGroup.style.display = 'block';
                            livraisonGroup.style.display = 'none';
                            document.getElementById('numero_table').required = true;
                            document.getElementById('adresse').required = false;
                            tableGroup.classList.add('animate__animated', 'animate__fadeIn');
                        } else {
                            tableGroup.style.display = 'none';
                            livraisonGroup.style.display = 'block';
                            document.getElementById('numero_table').required = false;
                            document.getElementById('adresse').required = true;
                            livraisonGroup.classList.add('animate__animated', 'animate__fadeIn');
                        }
                    }

                    surPlace.addEventListener('change', toggleMode);
                    livraison.addEventListener('change', toggleMode);
                    toggleMode();
                });
        </script>
    @endpush
@endsection
