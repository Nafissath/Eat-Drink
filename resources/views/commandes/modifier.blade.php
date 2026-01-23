@extends('layouts.app')

@section('content')
@php
    $suiviUrl = URL::signedRoute('commandes.suivi', ['id' => $commande->id]);
    $updateUrl = URL::signedRoute('commandes.mettreAJour', ['id' => $commande->id]);
@endphp

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #7b1e3d 0%, #1d4ed8 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small opacity-75">Modifier ma commande</div>
                            <h4 class="mb-0 fw-bold">Commande #{{ $commande->id }}</h4>
                        </div>
                        <span class="badge bg-light text-dark">Statut: {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="alert alert-info">
                        <div class="fw-bold">Modification autorisée</div>
                        <div class="mb-0">Tu peux modifier uniquement tant que la commande est <strong>en attente</strong>.</div>
                    </div>

                    <form action="{{ $updateUrl }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if($commande->type_commande === 'sur_place')
                            <div class="p-4 rounded-4 border bg-light mb-4">
                                <div class="fw-bold mb-2"><i class="fas fa-hashtag text-primary me-2"></i>Table</div>
                                <label for="numero_table" class="form-label">Numéro de table <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-lg" id="numero_table" name="numero_table" min="1" value="{{ old('numero_table', $commande->numero_table) }}" required>
                                @error('numero_table')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if($commande->type_commande === 'livraison')
                            <div class="p-4 rounded-4 border mb-4" style="background: rgba(176, 42, 87, .05);">
                                <div class="fw-bold mb-2" style="color: #b02a57;"><i class="fas fa-map-marker-alt me-2"></i>Livraison</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-lg" id="adresse" name="adresse" rows="2" required>{{ old('adresse', $commande->adresse) }}</textarea>
                                        @error('adresse')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="ville" name="ville" value="{{ old('ville', $commande->ville) }}" required>
                                        @error('ville')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code_postal" class="form-label">Code postal <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="code_postal" name="code_postal" value="{{ old('code_postal', $commande->code_postal) }}" required>
                                        @error('code_postal')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="instructions" class="form-label">Instructions (optionnel)</label>
                            <textarea class="form-control" id="instructions" name="instructions" rows="3">{{ old('instructions', $commande->instructions) }}</textarea>
                            @error('instructions')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button type="submit" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #1d4ed8 0%, #7b1e3d 100%); border: 0;">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                            <a href="{{ $suiviUrl }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Retour au suivi
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
