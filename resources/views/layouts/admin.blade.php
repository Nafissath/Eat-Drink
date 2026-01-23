<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eat&Drink Premium | Administration</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-emerald: #10b981;
            --luxury-dark: #0f172a;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--luxury-dark);
            color: #f8fafc;
            font-family: 'Outfit', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Mesh Background */
        .admin-mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(225, 39%, 20%, 1) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(339, 49%, 20%, 1) 0, transparent 50%);
            opacity: 0.5;
            z-index: -1;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--luxury-border);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 2.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--luxury-border);
        }

        .brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
        }

        .text-gold {
            background: linear-gradient(135deg, #d4af37 0%, #f1c40f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-section {
            padding: 1.5rem 1rem;
        }

        .nav-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 1rem;
            padding-left: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.65);
            padding: 0.85rem 1.25rem;
            margin: 0.25rem 0;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 28px;
            margin-right: 12px;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1) 0%, transparent 100%);
            color: var(--luxury-gold);
            border-left: 3px solid var(--luxury-gold);
            border-radius: 0 12px 12px 0;
        }

        .sidebar .nav-link.active i {
            color: var(--luxury-gold);
            opacity: 1;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1.5rem;
            border-top: 1px solid var(--luxury-border);
            background: rgba(0, 0, 0, 0.2);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--luxury-gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 700;
            color: var(--luxury-dark);
        }

        .user-email {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout-premium {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.6rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-logout-premium:hover {
            background: #ef4444;
            color: white;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background: var(--luxury-gold);
            border: none;
            color: var(--luxury-dark);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 999;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Global Gold Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--luxury-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--luxury-gold), #b8860b);
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="admin-mesh-bg"></div>

    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-text">Eat&Drink <span class="text-gold">PREMIUM</span></div>
            <div class="text-white-50 small mt-1" style="letter-spacing: 2px;">PANEL ADMIN</div>
        </div>

        <div class="nav-section">
            <div class="nav-label">Gestion Générale</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-user-check"></i>
                    Approbations Pro
                </a>
                <a class="nav-link {{ request()->routeIs('admin.joueurs.index') ? 'active' : '' }}"
                    href="{{ route('admin.joueurs.index') }}">
                    <i class="fas fa-trophy"></i>
                    Validation Joueurs
                </a>
                <a class="nav-link {{ request()->routeIs('admin.commandes-entrepreneurs') ? 'active' : '' }}"
                    href="{{ route('admin.commandes-entrepreneurs') }}">
                    <i class="fas fa-box-open"></i>
                    Flux Commandes
                </a>
            </nav>

            <div class="nav-label mt-4">Analyses & Données</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.statistiques') ? 'active' : '' }}"
                    href="{{ route('admin.statistiques') }}">
                    <i class="fas fa-chart-line"></i>
                    Performance
                </a>
                <a class="nav-link {{ request()->routeIs('admin.tendances') ? 'active' : '' }}"
                    href="{{ route('admin.tendances') }}">
                    <i class="fas fa-wave-square"></i>
                    Tendances
                </a>
            </nav>

            <div class="nav-label mt-4">Sécurité</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.restrictions*') ? 'active' : '' }}"
                    href="{{ route('admin.restrictions') }}">
                    <i class="fas fa-shield-alt"></i>
                    Restrictions
                </a>
                <a class="nav-link" href="{{ route('accueil') }}">
                    <i class="fas fa-external-link-alt"></i>
                    Voir le site
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                </div>
                <div class="user-details overflow-hidden">
                    <div class="fw-bold small text-white">Administrateur</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout-premium">
                    <i class="fas fa-sign-out-alt me-2"></i>DÉCONNEXION
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>

</html>