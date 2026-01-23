{{-- resources/views/commandes/beeper.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Outfit:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --status-color: #ffc107;
            /* Warning yellow (En préparation) */
            --success-color: #00C853;
            /* Ready green */
        }

        body {
            background-color: #1a1a1a;
            color: white;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
        }

        .status-bg {
            transition: background-color 0.5s ease;
        }

        /* Ticket Container */
        .ticket-container {
            max-width: 400px;
            margin: 2rem auto;
            background: white;
            color: #333;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        }

        /* Jagged edge effect top/bottom */
        .ticket-container::before,
        .ticket-container::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(135deg, transparent 66%, #1a1a1a 67%),
                linear-gradient(45deg, #1a1a1a 33%, transparent 34%);
            background-size: 20px 20px;
            background-position: 0 0;
            background-repeat: repeat-x;
            z-index: 10;
        }

        .ticket-container::before {
            top: -5px;
            transform: rotate(180deg);
        }

        .ticket-container::after {
            bottom: -5px;
        }

        .ticket-header {
            text-align: center;
            padding: 2rem 1rem 1rem;
            border-bottom: 2px dashed #ddd;
            position: relative;
        }

        .ticket-header::before,
        .ticket-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            width: 20px;
            height: 20px;
            background: #1a1a1a;
            border-radius: 50%;
        }

        .ticket-header::before {
            left: -10px;
        }

        .ticket-header::after {
            right: -10px;
        }

        .order-number {
            font-family: 'Orbitron', sans-serif;
            font-size: 5rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: 5px;
            color: #333;
        }

        .order-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            color: #777;
        }

        /* Beeper Pulse Animation */
        .beeper-status {
            text-align: center;
            padding: 2rem 1rem;
            margin-top: 2rem;
            margin-bottom: 4rem;
            position: relative;
        }

        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: var(--status-color);
            opacity: 0.2;
            animation: pulse 2s infinite;
            z-index: 0;
        }

        .pulse-ring:nth-child(2) {
            width: 300px;
            height: 300px;
            animation-delay: 0.5s;
        }

        .status-icon-wrapper {
            position: relative;
            z-index: 2;
            width: 120px;
            height: 120px;
            background: var(--status-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 0 30px var(--status-color);
            transition: all 0.5s ease;
        }

        .status-text {
            color: var(--status-color);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.5rem;
            transition: color 0.5s ease;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        /* Ready State */
        .status-ready {
            --status-color: #00C853;
        }

        .status-ready .status-text {
            animation: blink 1s infinite alternate;
        }

        @keyframes blink {
            from {
                opacity: 1;
            }

            to {
                opacity: 0.5;
            }
        }

        .table-badge {
            background: #333;
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">

        <!-- Ticket -->
        <div class="ticket-container animate__animated animate__slideInDown">
            <div class="ticket-header">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">{{ $commande->created_at->format('d/m/Y') }}</small>
                    <small class="text-muted">{{ $commande->created_at->format('H:i') }}</small>
                </div>
                <div class="order-label">Ticket de Commande</div>
                <div class="order-number">#{{ $commande->id }}</div>
                <div class="table-badge"><i class="bi bi-geo-alt-fill me-1"></i>Table {{ $commande->numero_table }}</div>
            </div>
            <div class="p-4 bg-light">
                <ul class="list-unstyled mb-0 small text-muted">
                    @foreach($commande->produits as $produit)
                        <li class="d-flex justify-content-between mb-1">
                            <span>{{ $produit->pivot->quantite }}x {{ $produit->nom }}</span>
                            <span>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 0, ',', ' ') }}</span>
                        </li>
                    @endforeach
                    <li class="border-top pt-2 mt-2 d-flex justify-content-between fw-bold text-dark">
                        <span>TOTAL</span>
                        <span>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Beeper Status -->
        <div id="beeper-area" class="beeper-status">
            <div class="pulse-ring"></div>
            <div class="pulse-ring"></div>

            <div class="status-icon-wrapper">
                <i id="status-icon" class="bi bi-hourglass-split text-white display-3"></i>
            </div>

            <h2 id="status-text" class="status-text animate__animated animate__pulse animate__infinite">
                En Cuisine...
            </h2>
            <p class="text-white-50 mt-2">Nous préparons votre commande</p>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('accueil') }}" class="btn btn-outline-light rounded-pill px-4 text-white-50 btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
            </a>
        </div>

    </div>

    <!-- Audio for notification -->
    <audio id="notify-sound" preload="auto">
        <source src="https://assets.mixkit.co/sfx/preview/mixkit-positive-notification-951.mp3" type="audio/mpeg">
    </audio>

    @push('scripts')
        <script>
            const commandeId = {{ $commande->id }};
            const statusUrl = "{{ URL::signedRoute('commandes.suivi.status', ['id' => $commande->id]) }}";
            const beeperArea = document.getElementById('beeper-area');
            const statusText = document.getElementById('status-text');
            const statusIcon = document.getElementById('status-icon');
            const notifySound = document.getElementById('notify-sound');

            let currentStatus = "{{ $commande->statut }}";

            function updateStatus(statut) {
                if (statut === 'terminee' || statut === 'prete') { // Adjust based on your actual statuses
                    beeperArea.classList.add('status-ready');
                    statusText.textContent = "COMMANDE PRÊTE !";
                    statusIcon.className = "bi bi-check-lg text-white display-3";

                    // Play sound if status just changed
                    if (currentStatus !== statut) {
                        try {
                            notifySound.play().catch(e => console.log('Audio autoplay prevented'));
                            navigator.vibrate([200, 100, 200]); // Vibrate phone
                        } catch (e) { }
                    }
                }
            }

            // Initial check
            updateStatus(currentStatus);

            // Poll every 5 seconds
            setInterval(() => {
                fetch(statusUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.statut !== currentStatus) {
                            currentStatus = data.statut;
                            updateStatus(currentStatus);
                        }
                    });
            }, 5000);
        </script>
    @endpush
@endsection