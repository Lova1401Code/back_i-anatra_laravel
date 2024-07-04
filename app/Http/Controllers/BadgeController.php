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
    public function index(){
        // $elid = 11;
        // $eleve = Eleve::findOrFail($elid);
        // $qrCodePath = 'qrcodes/' . $elid . '.png';
        // $qrcode = QrCode::format('png')->size(200)->generate($elid, public_path($qrCodePath));
        // return view('qrcode', compact('qrcode'));

        // return view('qrcode', ['qrCodeImage' => $qrCodePath]);
        $qrCodes = [];
        $qrCodes['simple'] = QrCode::size(120)->generate('https://www.binaryboxtuts.com/');
        $qrCodes['changeColor'] = QrCode::size(120)->color(255, 0, 0)->generate('https://www.binaryboxtuts.com/');
        $qrCodes['changeBgColor'] = QrCode::size(120)->backgroundColor(255, 0, 0)->generate('https://www.binaryboxtuts.com/');

        $qrCodes['styleDot'] = QrCode::size(120)->style('dot')->generate('https://www.binaryboxtuts.com/');
        $qrCodes['styleSquare'] = QrCode::size(120)->style('square')->generate('https://www.binaryboxtuts.com/');
        $qrCodes['styleRound'] = QrCode::size(120)->style('round')->generate('https://www.binaryboxtuts.com/');
        return view('qrcode', $qrCodes);

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
