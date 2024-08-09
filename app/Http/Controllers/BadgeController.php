<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Eleve;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\RendererInterface;
use BaconQrCode\Renderer\ImageRendererInterface;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\ImageRendererConfig;
use BaconQrCode\Writer;

class BadgeController extends Controller
{
    //test
    public function index($eleveId){
        $eleve = Eleve::findOrFail($eleveId);
        // $qrCodePath = 'qrcodes/' . $elid . '.png';
        // $qrcode = QrCode::format('png')->size(200)->generate($elid, public_path($qrCodePath));
        // return view('qrcode', compact('qrcode'));

        // return view('qrcode', ['qrCodeImage' => $qrCodePath]);
        $qrCodes = QrCode::size(200)->generate($eleve());
        return response()->json(['qrCode' => (string) $qrCodes]);

    }
    //création du badge
    public function generateBadge(Request $request, $eleveId){
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $eleve = Eleve::findOrFail($eleveId);
        $qrCodePath = 'qrcodes/' . $eleve->id . '.png';

        QrCode::format('png')
              ->size(200)
              ->generate(route('badges.show', $eleve->id), public_path($qrCodePath));

        $badge = Badge::create([
            'eleve_id' => $eleve->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'qr_code' => $qrCodePath,
        ]);
        return response()->json($badge, 201);
    }
    //afficher la badge
    public function show($id)
    {
        $badge = Badge::findOrFail($id);
        return view('badge', compact('badge'));
    }
}
