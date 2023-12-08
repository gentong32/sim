<?php

namespace App\Libraries;

use TCPDF;

class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
        // Inisialisasi konfigurasi TCPDF di sini jika diperlukan
    }
}
