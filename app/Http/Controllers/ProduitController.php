<?php
namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::where('user_id', Auth::id())->get();
        return view('entrepreneur.produits.index', compact('produits'));
    }

    public function create()
    {
        return view('entrepreneur.produits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['est_disponible'] = $request->has('est_disponible');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('produits', 'public');
        }

        Produit::create($data);

        return redirect()->route('entrepreneur.produits.index')->with('success', 'Produit ajouté avec succès');
    }

    public function edit(Produit $produit)
    {
        $this->authorize('update', $produit);
        return view('entrepreneur.produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $this->authorize('update', $produit);

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'description', 'prix');
        $data['est_disponible'] = $request->has('est_disponible');

        if ($request->hasFile('photo')) {
            if ($produit->photo) {
                Storage::disk('public')->delete($produit->photo);
            }
            $data['photo'] = $request->file('photo')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('entrepreneur.produits.index')->with('success', 'Produit mis à jour');
    }

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        if ($produit->photo) {
            Storage::disk('public')->delete($produit->photo);
        }

        $produit->delete();

        return redirect()->route('entrepreneur.produits.index')->with('success', 'Produit supprimé');
    }

    public function toggleStatus(Produit $produit)
    {
        // On vérifie que le produit appartient bien à l'entrepreneur
        if ($produit->user_id !== Auth::id()) {
            abort(403);
        }

        $produit->update([
            'est_disponible' => !$produit->est_disponible
        ]);

        $message = $produit->est_disponible ? 'Produit marqué comme disponible' : 'Produit marqué comme épuisé';

        return redirect()->back()->with('success', $message);
    }
}
