<footer class="luxury-footer-wrapper mt-auto border-top-luxury">
    <div class="luxury-footer-overlay"></div>
    <div class="container position-relative z-2 py-5 mt-4">
        <div class="row gy-5">
            <!-- Brand & Philosophy -->
            <div class="col-lg-4 text-center text-lg-start animate-fade-up">
                <div class="luxury-brand-footer mb-4">
                    <div class="luxury-brand-icon sm me-2">
                        <i class="fas fa-crown"></i>
                    </div>
                    <span class="luxury-brand-text">Eat&Drink <span class="gold-gradient-text">Premium</span></span>
                </div>
                <p class="premium-footer-text mb-4 opacity-75">
                    L'excellence gastronomique au creux de votre main. Plus qu'une plateforme, une signature culinaire
                    dédiée aux palais les plus exigeants de Cotonou.
                </p>
                <div class="premium-badge-group">
                    <span class="badge-luxury"><i class="fas fa-certificate me-1"></i> GASTRONOMIE ÉLITE</span>
                    <span class="badge-luxury"><i class="fas fa-bolt me-1"></i> LOGISTIQUE SIGNATURE</span>
                </div>
            </div>

            <!-- Navigation Privée -->
            <div class="col-lg-4 text-center animate-fade-up" style="animation-delay: 0.1s;">
                <h6 class="premium-label mb-4">Conciergerie Digitale</h6>
                <ul class="list-unstyled luxury-footer-links">
                    <li><a href="/accueil"><i class="fas fa-chevron-right me-3"></i>Accueil Résidence</a></li>
                    <li><a href="{{ route('exposants.index') }}"><i class="fas fa-chevron-right me-3"></i>Explorez les
                            Ambassadeurs</a></li>
                    <li><a href="{{ route('commandes.rechercher') }}"><i class="fas fa-search-location me-3"></i>Suivi
                            de Commande</a></li>
                    <li><a href="{{ route('panier') }}"><i class="fas fa-receipt me-3"></i>Sommaire de Réservation</a>
                    </li>
                </ul>
            </div>

            <!-- Contact & Héritage -->
            <div class="col-lg-4 text-center text-lg-end animate-fade-up" style="animation-delay: 0.2s;">
                <h6 class="premium-label mb-4">Service Relations Clients</h6>
                <div class="luxury-contact-info mb-4">
                    <p class="mb-2"><i class="fas fa-envelope text-gold me-2"></i> concierge@eatdrink-premium.com</p>
                    <p class="mb-0 fs-5 fw-bold text-white shadow-glow-text">+229 91 00 00 00</p>
                </div>
                <div class="d-flex justify-content-center justify-content-lg-end gap-4 mt-4 social-luxury">
                    <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom-luxury mt-5 pt-4 border-top border-white-05 text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <p class="mb-0 row-sub-text opacity-50">&copy; {{ date('Y') }} Eat&Drink Premium. Patrimoine
                        protégé.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 row-sub-text opacity-50">MANUFACTURED WITH <i
                            class="fas fa-heart text-gold mx-1"></i> BY ANTIGRAVITY IN COTONOU</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .luxury-footer-wrapper {
        background: #0f172a;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .luxury-footer-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 90% 80%, rgba(30, 41, 59, 1) 0%, transparent 50%);
        pointer-events: none;
    }

    .border-top-luxury {
        border-top: 1px solid rgba(212, 175, 55, 0.1) !important;
    }

    .border-white-05 {
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .premium-footer-text {
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.6);
    }

    .luxury-brand-icon.sm {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
    }

    .luxury-footer-links li {
        margin-bottom: 1.25rem;
    }

    .luxury-footer-links a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .luxury-footer-links a:hover {
        color: var(--luxury-gold);
        transform: translateX(8px);
    }

    .luxury-footer-links a i {
        font-size: 0.7rem;
        opacity: 0.5;
        transition: transform 0.3s;
    }

    .luxury-footer-links a:hover i {
        transform: scale(1.5);
        opacity: 1;
    }

    .social-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .social-icon:hover {
        background: var(--luxury-gold);
        color: #0f172a;
        transform: translateY(-8px) rotate(8deg);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        border-color: var(--luxury-gold);
    }

    .shadow-glow-text {
        text-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
    }

    .premium-badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    @media (max-width: 991px) {
        .premium-badge-group {
            justify-content: center;
        }

        .luxury-footer-links a:hover {
            transform: translateY(-3px);
        }
    }
</style>