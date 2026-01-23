<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Inscription
    public function inscriptionPost(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nom_entreprise' => $request->nom_entreprise,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'entrepreneur_en_attente',
        ]);

        return redirect()->route('login')->with('status', 'Inscription réussie !');
    }

    // Inscription spécifique au Défi Elite Gold
    public function inscriptionDefiPost(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nom_entreprise' => $request->nom_entreprise,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client', // Rôle par défaut
            'statut_joueur' => 'en_attente',
            'pepites' => 0,
            'rang' => 'Bronze',
        ]);

        return redirect()->route('login')->with('status', 'Votre demande de participation au Défi Elite Gold a été enregistrée. Elle est en attente de validation par l\'administration.');
    }

    // Connexion
    // Connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('status', 'Bienvenue administrateur !');

            } elseif ($user->role === 'entrepreneur_approuve') {
                return redirect()->route('entrepreneur.dashboard')->with('status', 'Bienvenue sur votre tableau de bord !');
            } elseif ($user->role === 'entrepreneur_en_attente') {
                return redirect()->route('auth.statut');
            } else {
                // Pour les clients / joueurs
                return redirect()->route('accueil');
            }
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides.',
        ])->onlyInput('email');
    }


    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Déconnecté avec succès.');
    }
}
