<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class PDFController extends Controller
{
    public function generateReceipt($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);

        $data = [
            'commande' => $commande,
            'date' => now()->format('d/m/Y H:i'),
            'qrcode_url' => URL::signedRoute('commandes.suivi', ['id' => $commande->id])
        ];

        $pdf = Pdf::loadView('pdf.receipt', $data);

        return $pdf->download('recu-commande-' . $commande->id . '.pdf');
    }
}
