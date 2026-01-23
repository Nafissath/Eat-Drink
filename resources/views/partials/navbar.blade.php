<nav class="navbar navbar-expand-lg fixed-top luxury-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3" href="/accueil">
            <div class="luxury-brand-icon">
                <i class="fas fa-crown"></i>
            </div>
            <span class="luxury-brand-text">Eat&Drink <span class="gold-gradient-text">Premium</span></span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navLuxury">
            <span class="navbar-toggler-icon-luxury">
                <i class="fas fa-bars text-white"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navLuxury">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link-luxury {{ request()->is('accueil') ? 'active' : '' }}"
                        href="/accueil">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-luxury {{ request()->routeIs('exposants.*') ? 'active' : '' }}"
                        href="{{ route('exposants.index') }}">Exposants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-luxury {{ request()->routeIs('panier') ? 'active' : '' }}"
                        href="{{ route('panier') }}">
                        Panier
                        @if(session('panier') && count(session('panier')) > 0)
                            <span class="luxury-badge">{{ count(session('panier')) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link-luxury {{ request()->routeIs('commandes.index') ? 'active' : '' }}"
                            href="{{ route('commandes.index') }}">
                            Suivi & Commandes
                            @if($activeOrder = Auth::user()->getActiveOrder())
                                <span class="active-pulse-badge"></span>
                            @endif
                        </a>
                    @else
                        <a class="nav-link-luxury {{ request()->routeIs('commandes.rechercher') ? 'active' : '' }}"
                            href="{{ route('commandes.rechercher') }}">Suivre Commande</a>
                    @endauth
                </li>
            </ul>

            <div class="d-flex align-items-center gap-4">
                @guest
                    <a href="/login" class="luxury-btn-outline">S'identifier</a>
                    <a href="/inscription" class="luxury-btn-gold">Devenir Membre</a>
                @else
                    <div class="dropdown">
                        <button class="luxury-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->logo_url ?: 'https://ui-avatars.com/api/?name=' . Auth::user()->name . '&background=d4af37&color=0f172a' }}"
                                class="profile-img" alt="User">
                            <span
                                class="ms-2 d-none d-lg-inline">{{ Auth::user()->nom_entreprise ?: Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end luxury-dropdown animate__animated animate__fadeIn">
                            <li class="px-3 py-2 text-center border-bottom border-white border-opacity-10 mb-2">
                                <div class="small text-white-50 text-uppercase letter-spacing-2 mb-1"
                                    style="font-size: 0.6rem;">Mon Statut Elite</div>

                                @if(Auth::user()->statut_joueur === 'en_attente')
                                    <span class="badge rounded-pill px-3 py-1 fw-800 bg-secondary opacity-50">
                                        <i class="fas fa-clock me-1"></i> EN ATTENTE
                                    </span>
                                @else
                                    <span
                                        class="badge rounded-pill px-3 py-1 fw-800 {{ Auth::user()->rang === 'Or' ? 'bg-gold-luxury' : (Auth::user()->rang === 'Argent' ? 'bg-silver-luxury' : 'bg-bronze-luxury') }}">
                                        <i class="fas fa-crown me-1"></i> {{ Auth::user()->rang }}
                                    </span>
                                    <div class="mt-2 small text-gold fw-700">
                                        {{ Auth::user()->pepites }} Pépites
                                    </div>
                                @endif
                            </li>
                            <li><a class="dropdown-item" href="{{ route('client.club-prive') }}"><i
                                        class="fas fa-gem me-2"></i>Club Privé</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="fas fa-chart-line me-2"></i>Dashboard Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.joueurs.index') }}"><i
                                            class="fas fa-users-cog me-2"></i>Gestion des Joueurs</a></li>
                            @elseif(Auth::user()->role === 'entrepreneur_approuve')
                                <li><a class="dropdown-item" href="{{ route('entrepreneur.dashboard') }}"><i
                                            class="fas fa-tachometer-alt me-2"></i>Board Entrepreneur</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider opacity-10">
                            </li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i
                                            class="fas fa-sign-out-alt me-2"></i>Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<style>
    .luxury-navbar {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(212, 175, 55, 0.15);
        padding: 18px 0;
        transition: all 0.4s;
    }

    .luxury-brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
    }

    .luxury-brand-text {
        font-weight: 800;
        color: white;
        letter-spacing: -1px;
        font-size: 1.4rem;
    }

    .gold-gradient-text {
        background: linear-gradient(to right, #d4af37, #f3e5ab);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 0.9rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .nav-link-luxury {
        color: rgba(255, 255, 255, 0.6) !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1.5px;
        transition: all 0.3s;
        position: relative;
        padding: 10px 15px !important;
    }

    .nav-link-luxury:hover,
    .nav-link-luxury.active {
        color: var(--luxury-gold) !important;
    }

    .nav-link-luxury.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: var(--luxury-gold);
        border-radius: 2px;
        box-shadow: 0 0 10px var(--luxury-gold);
    }

    .active-pulse-badge {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-left: 5px;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.8);
        animation: pulseGreen 2s infinite;
        vertical-align: middle;
    }

    @keyframes pulseGreen {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.4);
            opacity: 0.5;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .luxury-badge {
        background: var(--luxury-gold);
        color: #0f172a;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 50%;
        font-weight: 800;
        margin-left: 5px;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .luxury-btn-outline {
        color: var(--luxury-gold);
        border: 1px solid rgba(212, 175, 55, 0.3);
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        font-size: 0.85rem;
    }

    .luxury-btn-outline:hover {
        background: rgba(212, 175, 55, 0.05);
        border-color: var(--luxury-gold);
        color: var(--luxury-gold);
    }

    .luxury-btn-gold {
        background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
        color: #0f172a;
        padding: 10px 28px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        transition: all 0.3s;
        font-size: 0.85rem;
    }

    .luxury-btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        color: #0f172a;
    }

    .luxury-profile-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 6px 15px 6px 6px;
        border-radius: 50px;
        color: white;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }

    .luxury-profile-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--luxury-gold);
    }

    .profile-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--luxury-gold);
    }

    .luxury-dropdown {
        background: #1e293b;
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 20px;
        padding: 10px;
        margin-top: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .luxury-dropdown .dropdown-item {
        color: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .luxury-dropdown .dropdown-item:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--luxury-gold);
    }

    .bg-gold-luxury {
        background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
        color: #0f172a;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
    }

    .bg-silver-luxury {
        background: linear-gradient(135deg, #9ca3af 0%, #4b5563 100%);
        color: white;
    }

    .bg-bronze-luxury {
        background: linear-gradient(135deg, #cd7f32 0%, #8b4513 100%);
        color: white;
    }

    .letter-spacing-2 {
        letter-spacing: 2px;
    }

    .fw-800 {
        font-weight: 800;
    }

    .text-gold {
        color: var(--luxury-gold) !important;
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: #1e293b;
            margin-top: 20px;
            padding: 25px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    }
</style>