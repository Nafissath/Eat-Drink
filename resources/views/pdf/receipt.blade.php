<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reçu de commande #{{ $commande->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { max-width: 150px; margin-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 10px 0; }
        .subtitle { font-size: 14px; margin-bottom: 20px; }
        .info-box { margin: 15px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .info-row { display: flex; margin-bottom: 5px; }
        .info-label { font-weight: bold; width: 120px; }
        .info-value { flex: 1; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background-color: #f5f5f5; text-align: left; padding: 8px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mt-20 { margin-top: 20px; }
        .qr-code { text-align: center; margin: 20px 0; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Eat&Drink</div>
        <div class="subtitle">Reçu de commande #{{ $commande->id }}</div>
        <div>Date: {{ $date }}</div>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Client:</div>
            <div class="info-value">{{ $commande->nom_client }}</div>
        </div>
        @if($commande->email_client)
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $commande->email_client }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Téléphone:</div>
            <div class="info-value">{{ $commande->telephone }}</div>
        </div>
        @if($commande->type_commande === 'sur_place' && $commande->numero_table)
        <div class="info-row">
            <div class="info-label">Table #:</div>
            <div class="info-value">{{ $commande->numero_table }}</div>
        </div>
        @endif
        @if($commande->type_commande === 'livraison' && $commande->adresse)
        <div class="info-row">
            <div class="info-label">Adresse:</div>
            <div class="info-value">
                {{ $commande->adresse }}<br>
                {{ $commande->code_postal }} {{ $commande->ville }}
            </div>
        </div>
        @endif
        @if($commande->instructions)
        <div class="info-row">
            <div class="info-label">Instructions:</div>
            <div class="info-value">{{ $commande->instructions }}</div>
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th class="text-right">Prix unitaire</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $produit)
            <tr>
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->pivot->quantite }}</td>
                <td class="text-right">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ number_format($produit->prix * $produit->pivot->quantite, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="qr-code">
        <div>Scannez ce code pour suivre votre commande:</div>
        <div style="margin-top: 10px;">
            <!-- Espace pour le QR Code généré par JavaScript -->
            <div id="qrcode"></div>
        </div>
    </div>

    <div class="footer">
        <div>Merci pour votre commande !</div>
        <div>Eat&Drink - Tél: +225 XX XX XX XX - Email: contact@eatdrink.ci</div>
        <div>Ceci est un reçu électronique valide sans signature.</div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            // Générer un QR Code avec la bibliothèque TCPDF intégrée
            $style = array(
                'border' => 0,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false,
                'module_width' => 1,
                'module_height' => 1
            );
            
            $pdf->write2DBarcode(
                $qrcode_url,
                'QRCODE,M',
                70, // x
                180, // y
                70, // width
                70, // height
                $style,
                'N'
            );
        }
    </script>
</body>
</html>
