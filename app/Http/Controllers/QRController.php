<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;

class QRController extends Controller
{
    public function makeQrCode($collection, $id){

        // Create a QR code
        $qrCode = new QrCode($collection.'/'.$id);
        $qrCode->setSize(300);
        $qrCode->setLogoPath(public_path().'/images/iconoFG-76.png');
        $qrCode->setLogoSize(60,60);

        $qrCode->writeFile(storage_path('app/public').'/qrcodes/qrcode.png');

        return view('qrcode', ['url'=>$qrCode->writeDataUri()]);
    }
}
