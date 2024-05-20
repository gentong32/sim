<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\M_sekolah;

class CekNPSN implements FilterInterface
{
    function __construct()
    {
        $this->M_sekolah = new M_sekolah();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!khususadmin()) {
            return redirect()->to("/");
        }

        $id_sekolah = session()->get('id_sekolah');
        $ceknpsn = $this->M_sekolah->getSekolah($id_sekolah);
        if (!$ceknpsn) {
            return redirect()->to("/admin/input_sekolah");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}
