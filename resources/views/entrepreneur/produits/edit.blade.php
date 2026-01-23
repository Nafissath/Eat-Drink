{{-- resources/views/entrepreneur/produits/edit.blade.php --}}
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
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.01);
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
            filter: brightness(1.1);
        }

        .current-image-lux {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            object-fit: cover;
            border: 2px solid var(--luxury-gold);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
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

        <div class="form-container-lux">
            <div class="text-center mb-5">
                <div class="mb-3">
                    @if($produit->photo)
                        <img src="{{ asset('storage/' . $produit->photo) }}" class="current-image-lux">
                    @else
                        <div class="current-image-lux d-inline-flex align-items-center justify-content-center bg-dark">
                            <i class="fas fa-image fa-2x opacity-10"></i>
                        </div>
                    @endif
                </div>
                <h1 class="display-6 fw-800" style="font-family: 'Playfair Display', serif;">Modifier la Création</h1>
                <p class="text-white-50">Perfectionnez les détails de votre plat.</p>
            </div>

            <form action="{{ route('entrepreneur.produits.update', $produit) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Nom du
                                Plat</label>
                            <input type="text" name="nom" class="form-control input-lux @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $produit->nom) }}" required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label
                                class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Description</label>
                            <textarea name="description"
                                class="form-control input-lux @error('description') is-invalid @enderror" rows="4"
                                required>{{ old('description', $produit->description) }}</textarea>
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
                                    style="border-left: none; border-radius: 0 15px 15px 0;"
                                    value="{{ old('prix', $produit->prix) }}" required>
                            </div>
                            @error('prix') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label
                                class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Disponibilité</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="est_disponible" id="est_disponible"
                                    value="1" {{ $produit->est_disponible ? 'checked' : '' }}>
                                <label class="form-check-label text-white-50 ms-2" for="est_disponible">Disponible à la
                                    vente</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label text-gold small fw-800 text-uppercase letter-spacing-1">Changer le Visuel
                            (Optionnel)</label>
                        <label class="upload-zone-lux d-block" for="photo">
                            <div id="upload-content">
                                <i class="fas fa-sync-alt fa-2x text-white-50 mb-3"></i>
                                <h6 class="fw-800">Cliquer pour remplacer la photo</h6>
                            </div>
                            <div id="image-preview" class="d-none">
                                <img src="" class="img-fluid rounded-4 shadow-lg"
                                    style="max-height: 200px; border: 2px solid var(--luxury-gold);">
                                <p class="mt-3 text-gold fw-800 small">NOUVELLE IMAGE SÉLECTIONNÉE</p>
                            </div>
                        </label>
                        <input type="file" name="photo" id="photo" class="d-none" onchange="previewImage(this)">
                        @error('photo') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-submit-lux">
                            <i class="fas fa-check-circle me-2"></i> ENREGISTRER LES MODIFICATIONS
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