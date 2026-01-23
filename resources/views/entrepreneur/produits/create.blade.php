{{-- resources/views/entrepreneur/produits/create.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
        }

        .form-container-lux {
            max-width: 800px;
            margin: 4rem auto;
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 40px;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }

        .form-container-lux::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .input-lux {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 15px;
            padding: 12px 20px;
            color: white;
            transition: all 0.3s;
        }

        .input-lux:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--luxury-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
            color: white;
            outline: none;
        }

        .upload-zone-lux {
            border: 2px dashed var(--luxury-glass-border);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.01);
        }

        .upload-zone-lux:hover {
            border-color: var(--luxury-gold);
            background: rgba(212, 175, 55, 0.03);
        }

        .btn-submit-lux {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border-radius: 50px;
            padding: 15px 40px;
            font-weight: 800;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit-lux:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
            filter: brightness(1.1);
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* custom switch lux */
        .form-check-input:checked {
            background-color: var(--luxury-gold);
            border-color: var(--luxury-gold);
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ route('entrepreneur.produits.index') }}" class="text-white-50 text-decoration-none fw-700">
                <i class="fas fa-chevron-left me-2"></i> RETOUR AU CATALOGUE
            </a>
        </div>

        <div class="form-container-lux animate-fade-up">
            <div class="text-center mb-5">
                <h1 class="display-6 fw-800" style="font-family: 'Playfair Display', serif;">Nouvelle Création</h1>
                <p class="text-white-50">Ajoutez un nouveau plat d'exception à votre menu.</p>
            </div>

            <form action="{{ route('entrepreneur.produits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Nom du
                                Plat</label>
                            <input type="text" name="nom" class="form-control input-lux @error('nom') is-invalid @enderror"
                                placeholder="Ex: Risotto aux truffes blanches" value="{{ old('nom') }}" required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Description
                                Gastronomique</label>
                            <textarea name="description"
                                class="form-control input-lux @error('description') is-invalid @enderror" rows="4"
                                placeholder="Décrivez les saveurs, les textures et l'origine de vos ingrédients..."
                                required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Prix
                                (CFA)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-white-50"
                                    style="border: 1px solid var(--luxury-glass-border); border-radius: 15px 0 0 15px;"><i
                                        class="fas fa-tag"></i></span>
                                <input type="number" name="prix"
                                    class="form-control input-lux @error('prix') is-invalid @enderror"
                                    style="border-left: none; border-radius: 0 15px 15px 0;" placeholder="Ex: 5500"
                                    value="{{ old('prix') }}" required>
                            </div>
                            @error('prix') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label
                                class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Disponibilité</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="est_disponible" id="est_disponible"
                                    value="1" checked>
                                <label class="form-check-label text-white-50 ms-2" for="est_disponible">En ligne dès
                                    maintenant</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Visuel du
                            Produit</label>
                        <label class="upload-zone-lux d-block" for="photo">
                            <div id="upload-content">
                                <i class="fas fa-camera fa-3x text-white-50 mb-3"></i>
                                <h5 class="fw-800">Cliquez pour ajouter une photo</h5>
                                <p class="text-white-50 small mb-0">Format recommandé : Carré ou 4:3 (Max 2Mo)</p>
                            </div>
                            <div id="image-preview" class="d-none">
                                <img src="" class="img-fluid rounded-4 shadow-lg"
                                    style="max-height: 250px; border: 2px solid var(--luxury-gold);">
                                <p class="mt-3 text-gold fw-800 small">CHANGER LA PHOTO</p>
                            </div>
                        </label>
                        <input type="file" name="photo" id="photo" class="d-none" onchange="previewImage(this)">
                        @error('photo') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-submit-lux">
                            <i class="fas fa-save me-2"></i> AJOUTER AU MENU
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('upload-content').classList.add('d-none');
                    var preview = document.getElementById('image-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection