<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;

class QRController extends Controller
{
    /**
     *  Genera un código QR a partir de la coleccion y el id pasado
     *
     * @param $collection
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
