<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    public function cekLoginAdmin($email, $kode)
    {
        $sql = "SELECT * FROM tb_admin WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                if ($email == "antok2000@gmail.com")
                    $hasil = "ganteng";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_user;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;
        $kembalian['jenis_kelamin'] = "-";

        return $kembalian;
    }

    public function getDaftarAdmin()
    {

        $query = $this->db->table('tb_admin a')
            ->select('a.*, g.status_sekolah,a.nama as nama,g.nama as nama_sekolah')
            ->join('tb_sekolah g', 'a.id_sekolah = g.id_sekolah', 'left')
            ->where('a.email<>', 'antok2000@gmail.com')
            ->orderBy('a.id')
            ->get();

        return $query->getResultArray();
    }

    public function getAdmin($id_user)
    {
        $query = $this->db->table('tb_admin')
            ->select('nama, alamat, telp, email, id_sekolah, jenjang, no_rek, nama_bank')
            ->where('id_user', $id_user)
            ->get();

        return $query->getRowArray();
    }

    public function update_password($id_user, $token_baru)
    {
        $query = $this->db->table('tb_admin')
            ->where('id_user', $id_user)
            ->update(['token' => $token_baru]);
    }

    // FUNGSI UNTUK GURU =========================================================

    public function cekLoginGuru($email, $kode)
    {
        $sql = "SELECT g.id_guru as id_guru, g.*, gs.*
                FROM tb_guru g
                LEFT JOIN tb_guru_sekolah gs ON g.nuptk = gs.nuptk
                WHERE email = :email: 
                AND gs.tahun_ajaran = (
                    SELECT MAX(tahun_ajaran) 
                    FROM tb_guru_sekolah 
                    WHERE email = :email: 
                )
                ORDER BY id DESC LIMIT 1 ;";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";
        $jenis_kelamin = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_guru;
                $nama = $result->nama;
                $jenis_kelamin = $result->jenis_kelamin;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;
        $kembalian['jenis_kelamin'] = $jenis_kelamin;

        return $kembalian;
    }

    public function delete_daftar_guru($id_user)
    {
        $this->db->table('tb_guru')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_guru_sekolah($id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_guru_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran]);
    }

    public function simpan_daftar_guru_sekolah($data)
    {
        $this->db->table('tb_guru_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_guru($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_guru')->where('nuptk', $row['nuptk'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_guru')->insert($row);
            }
        }
    }

    public function tambah_guru($data)
    {
        $existingRow = $this->db->table('tb_guru')->where('nuptk', $data['nuptk'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_guru')->insert($data);
        } else {
        }
    }

    public function update_guru($data, $id_guru)
    {
        $this->db->table('tb_guru')->where('id_guru', $id_guru)->update($data);
    }

    public function tambah_guru_sekolah($data)
    {
        $this->db->table('tb_guru_sekolah')->insert($data);
    }

    public function getDaftarGuru($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_guru_sekolah gs
                LEFT JOIN tb_guru g ON g.nuptk = gs.nuptk
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        // $query = $this->db->table('tb_guru_sekolah gs')
        //     ->select('*')
        //     ->join('tb_guru g', 'g.nuptk = gs.nuptk', 'left')
        //     ->where('gs.id_sekolah', $id_sekolah)
        //     ->where('gs.tahun_ajaran', $tahun_ajaran)
        //     ->orderBy('gs.nama')
        //     ->get();

        return $query->getResultArray();
    }

    public function get_daftar_guru_mapel_old($id_sekolah)
    {
        $sql = "SELECT GROUP_CONCAT(nama_rombel ORDER BY nama_rombel ASC SEPARATOR ', ') AS nama_rombel, nama_mapel, nama, tr.kelas
                FROM tb_rombel tr
                LEFT JOIN tb_guru_mapel gm ON tr.id = gm.id_rombel
                LEFT JOIN tb_mapel tm ON tm.id = gm.id_mapel
                LEFT JOIN tb_guru_sekolah gs ON gs.id = gm.id_guru
                LEFT JOIN tb_guru tg ON tg.nuptk = gs.nuptk
                WHERE tr.id_sekolah = :id_sekolah: AND tahun_mulai = (SELECT MAX(tahun_mulai) FROM tb_rombel) 
                GROUP BY nama_mapel, nama, tr.kelas, tm.jenis, tm.sub_kelas
                ORDER BY tr.kelas, tm.nama_mapel, nama_rombel, tg.nama, tm.jenis, tm.sub_kelas";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getResultArray();
    }

    public function get_daftar_guru_mapel($id_sekolah)
    {
        $sql = "SELECT 
    GROUP_CONCAT(nama_rombel ORDER BY nama_rombel ASC SEPARATOR ', ') AS nama_rombel, 
    nama_mapel, 
    nama, 
    tr.kelas as kelas,
            1 as urutangrup
        FROM 
            tb_rombel tr
        LEFT JOIN 
            tb_guru_mapel gm ON tr.id = gm.id_rombel
        LEFT JOIN 
            tb_mapel tm ON tm.id = gm.id_mapel
        LEFT JOIN 
            tb_guru_sekolah gs ON gs.id = gm.id_guru
        LEFT JOIN 
            tb_guru tg ON tg.nuptk = gs.nuptk
        WHERE 
            tr.id_sekolah = :id_sekolah: AND tahun_mulai = (SELECT MAX(tahun_mulai) FROM tb_rombel) 
        GROUP BY 
            nama_mapel, nama, tr.kelas, tm.jenis, tm.sub_kelas
        
        UNION ALL
        
        SELECT 
            GROUP_CONCAT(nama_rombel ORDER BY nama_rombel ASC SEPARATOR ', ') AS nama_rombel,  
            (CASE 
                WHEN jenis_mapel='1' THEN 'BK' 
                WHEN jenis_mapel='2' THEN 'P5'
                ELSE NULL END) as nama_mapel, 
            nama, 
            tr.kelas as kelas,
            2 as urutangrup
        FROM 
            tb_rombel tr
        LEFT JOIN 
            tb_guru_lain gl ON tr.id = gl.id_rombel
        LEFT JOIN 
            tb_guru_sekolah gs ON gs.id = gl.id_guru
        LEFT JOIN 
            tb_guru tg ON tg.nuptk = gs.nuptk
        WHERE 
            tr.id_sekolah = :id_sekolah: AND tahun_mulai = (SELECT MAX(tahun_mulai) FROM tb_rombel) 
        GROUP BY 
            jenis_mapel, nama, tr.kelas

ORDER BY 
    kelas, urutangrup, nama_mapel, nama_rombel, nama
";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getResultArray();
    }

    public function duplikat_guru_tahun_lalu($id_sekolah, $tahun)
    {
        $sql = "INSERT INTO tb_guru_sekolah (nuptk, id_sekolah, tahun_ajaran)
                SELECT nuptk, id_sekolah, :tahun:
                FROM tb_guru_sekolah
                WHERE id_sekolah=:id_sekolah: AND tahun_ajaran = :tahun_lalu:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'tahun_lalu' => $tahun - 1,
        ]);
    }

    public function getDataGuru($id_guru)
    {
        $sql = "SELECT nuptk,nama,alamat,jenis_kelamin,telp,email 
                FROM tb_guru
                WHERE id_guru = :id_guru:";

        $query = $this->db->query($sql, [
            'id_guru' => $id_guru,
        ]);

        return $query->getRowArray();
    }

    public function cekkepsek($nuptk, $id_sekolah)
    {
        $sql = "SELECT *
                FROM tb_kepsek k 
                LEFT JOIN tb_guru_sekolah g ON g.id = k.id_kepsek 
                WHERE k.id_sekolah = :id_sekolah: AND nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nuptk' => $nuptk,
        ]);

        return $query->getRowArray();
    }

    public function cekwalikelas($nuptk, $id_sekolah)
    {
        $sql = "SELECT *
                FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND nuptk_wali_kelas = :nuptk:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nuptk' => $nuptk,
        ]);

        return $query->getResultArray();
    }

    public function cekajarkelas($nuptk, $id_sekolah)
    {
        $sql = "SELECT tgm.id as id_guru_mapel, tgm.*, ts.*, tm.*, tr.* FROM tb_guru_mapel tgm 
                LEFT JOIN tb_guru_sekolah ts ON tgm.id_guru = ts.id AND ts.id_sekolah = :id_sekolah:
                LEFT JOIN tb_mapel tm ON tgm.id_mapel = tm.id
                LEFT JOIN tb_rombel tr ON tgm.id_rombel = tr.id
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getResultArray();
    }

    public function cekajarlain($nuptk)
    {
        $sql = "SELECT tgl.id as id_guru_lain, tgl.*, ts.*, tr.* FROM tb_guru_lain tgl 
                LEFT JOIN tb_guru_sekolah ts ON tgl.id_guru = ts.id 
                LEFT JOIN tb_rombel tr ON tgl.id_rombel = tr.id
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
        ]);

        return $query->getResultArray();
    }

    public function cekwaliekskul($nuptk, $id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT te.id as id_ekskul, te.*, ts.* 
                FROM tb_ekskul te
                LEFT JOIN tb_guru_sekolah ts ON te.id_guru = ts.id AND te.tahun_ajaran = :tahun_ajaran: AND ts.id_sekolah = :id_sekolah: 
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function cek_nuptk($nuptk)
    {
        $sql = "SELECT * FROM tb_guru_sekolah 
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
        ]);

        return $query->getRow();
    }

    public function get_data_guru($id_user)
    {
        $sql = "SELECT * FROM tb_guru 
                WHERE id_guru = :id_user:";

        $query = $this->db->query($sql, [
            'id_user' => $id_user,
        ]);

        return $query->getRow();
    }

    public function hapus_guru_sekolah($nuptk, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_guru_sekolah')->where(['nuptk' => $nuptk, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }


    // FUNGSI UNTUK SISWA ==========================================================

    public function cekLoginSiswa($email, $kode)
    {
        $sql = "SELECT * FROM tb_siswa WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_siswa;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

        return $kembalian;
    }

    public function delete_daftar_siswa($id_user)
    {
        $this->db->table('tb_siswa')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_siswa_sekolah($id_sekolah, $tahun_ajaran, $daftar_kelas)
    {
        foreach ($daftar_kelas as $kelas) {
            $this->db->table('tb_siswa_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran, 'kelas' => $kelas]);
        }
    }

    public function simpan_daftar_siswa_sekolah($data)
    {
        $this->db->table('tb_siswa_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_siswa($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_siswa')->where('nisn', $row['nisn'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_siswa')->insert($row);
            }
        }
    }

    public function tambah_siswa($data)
    {
        $existingRow = $this->db->table('tb_siswa')->where('nisn', $data['nisn'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_siswa')->insert($data);
        } else {
        }
    }

    public function update_siswa($data, $id_siswa)
    {
        $this->db->table('tb_siswa')->where('id_siswa', $id_siswa)->update($data);
    }

    public function update_siswa_sekolah($data, $nisn, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_siswa_sekolah')->where(['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->update($data);
    }

    public function tambah_siswa_sekolah($data)
    {
        $this->db->table('tb_siswa_sekolah')->insert($data);
    }

    public function getDaftarsiswa($id_sekolah, $tahun_ajaran, $kelas = null, $rombel = null)
    {
        $wherekelas = "";
        if ($kelas != null) {
            $wherekelas = "AND kelas = :kelas:";
        }

        $whererombel = "";
        if ($rombel != null) {
            $whererombel = " AND nama_rombel = :rombel:";
        }

        $sql = "SELECT * FROM tb_siswa_sekolah gs
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn
                WHERE id_sekolah = :id_sekolah: " . $wherekelas . $whererombel . " AND tahun_ajaran = :tahun_ajaran:
                ORDER BY kelas, nis";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
        ]);

        return $query->getResultArray();
    }

    public function getDaftarpresensi($id_sekolah, $tahun_ajaran, $kelas, $rombel, $tanggalpresensi)
    {
        $wherekelas = "AND kelas = :kelas:";
        $whererombel = " AND nama_rombel = :rombel:";

        $sql = "SELECT * FROM tb_siswa_sekolah gs
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn
                LEFT JOIN tb_presensi p ON p.nisn = gs.nisn AND tanggal = :tanggalpresensi: 
                WHERE gs.id_sekolah = :id_sekolah: " . $wherekelas . $whererombel . " AND tahun_ajaran = :tahun_ajaran: 
                ORDER BY kelas, nis";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tanggalpresensi' => $tanggalpresensi,
        ]);

        return $query->getResultArray();
    }

    public function getnisnfromnis($id_sekolah, $nis)
    {
        $datasiswa = $this->db->table('tb_siswa_sekolah')->getWhere(['id_sekolah' => $id_sekolah, 'nis' => $nis])->getRowArray();

        return $datasiswa;
    }

    public function hapus_presensi($id_sekolah, $tanggal)
    {
        $this->db->table('tb_presensi')->where(['id_sekolah' => $id_sekolah, 'tanggal' => $tanggal])->delete();
    }

    public function simpan_presensi($data)
    {
        $this->db->table('tb_presensi')->insert($data);
    }

    public function getrekappresensi($id_sekolah, $tahun_ajaran, $kelas, $rombel, $batasawal, $batasakhir)
    {

        $batastanggal = "tanggal >='" . $batasawal . "' AND tanggal <='" . $batasakhir . "'";
        // echo $batastanggal;
        // die();
        $sql = "SELECT
                    gs.nis,
                    g.nama,
                    COALESCE(SUM(CASE WHEN p.status = 'I' THEN 1 ELSE 0 END), 0) as jml_ijin,
                    COALESCE(SUM(CASE WHEN p.status = 'S' THEN 1 ELSE 0 END), 0) as jml_sakit,
                    COALESCE(SUM(CASE WHEN p.status = 'A' THEN 1 ELSE 0 END), 0) as jml_alpha
                FROM tb_siswa_sekolah gs 
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn 
                LEFT JOIN tb_presensi p ON p.nisn = gs.nisn AND " . $batastanggal . " AND p.id_sekolah=:id_sekolah:
                WHERE gs.id_sekolah = :id_sekolah: AND kelas = :kelas: AND nama_rombel = :rombel: AND tahun_ajaran = :tahun_ajaran:  
                GROUP BY gs.nisn, g.nama 
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
        ]);


        return $query->getResultArray();
    }

    public function getDatasiswa($id_siswa, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_siswa ts
                LEFT JOIN tb_siswa_sekolah ss ON ts.nisn = ss.nisn
                WHERE id_siswa = :id_siswa: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_siswa' => $id_siswa,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getRowArray();
    }

    public function cek_nisn($nisn)
    {
        $sql = "SELECT * FROM tb_siswa_sekolah 
                WHERE nisn = :nisn:";

        $query = $this->db->query($sql, [
            'nisn' => $nisn,
        ]);

        return $query->getRow();
    }

    public function cek_nis($nis)
    {
        $sql = "SELECT * FROM tb_siswa_sekolah 
                WHERE nis = :nis:";

        $query = $this->db->query($sql, [
            'nis' => $nis,
        ]);

        return $query->getRow();
    }

    public function cek_email_admin($email)
    {
        $sql = "SELECT * FROM tb_admin 
                WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        return $query->getRow();
    }

    public function hapus_siswa_sekolah($nisn, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_siswa_sekolah')->where(['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }

    public function getDaftarNilaiP5($id_sekolah, $tahun_ajaran, $kelas, $rombel, $id_projek)
    {
        $sql = "SELECT nis, nama, jenis_kelamin, alamat, telp, COALESCE(p.nilai, 0) as nilai
                FROM tb_siswa_sekolah gs
                CROSS JOIN tb_dimensi_projek dp
                LEFT JOIN tb_siswa s ON s.nisn = gs.nisn 
                LEFT JOIN tb_nilai_p5 p ON p.nisn = gs.nisn AND p.id_dimensi_projek = dp.id
                WHERE gs.id_sekolah = :id_sekolah: 
                    AND kelas = :kelas: 
                    AND nama_rombel = :rombel: 
                    AND gs.tahun_ajaran = :tahun_ajaran:
                    AND dp.id_projek = :id_projek:
                ORDER BY gs.nisn, dp.id";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'id_projek' => $id_projek,
        ]);

        return $query->getResultArray();
    }

    public function getDaftarNilaiEks($id_sekolah, $tahun_ajaran, $kelas, $rombel, $id_ekskul)
    {
        $sql = "SELECT nis, nama, jenis_kelamin, alamat, telp, dp.tujuan_pembelajaran, COALESCE(p.nilai, 0) as nilai
                FROM tb_siswa_sekolah gs
                CROSS JOIN tb_tujuan_pembelajaran_ekskul dp
                LEFT JOIN tb_siswa s ON s.nisn = gs.nisn 
                LEFT JOIN tb_nilai_eks p ON p.nisn = gs.nisn AND p.id_tp_eks = dp.id
                WHERE gs.id_sekolah = :id_sekolah: 
                    AND gs.kelas = :kelas: 
                    AND nama_rombel = :rombel: 
                    AND gs.tahun_ajaran = :tahun_ajaran:
                    AND dp.id_ekskul = :id_ekskul: AND dp.kelas = :kelas:
                ORDER BY gs.nisn, dp.id";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'id_ekskul' => $id_ekskul,
        ]);

        return $query->getResultArray();
    }

    // FUNGSI UNTUK STAF =========================================================

    public function cekLoginStaf($email, $kode, $tahun = null)
    {
        $wheretahun = "";
        if ($tahun != null) {
            $wheretahun = "WHERE tahun_ajaran <= :tahun:";
        }

        $sql = "SELECT g.id_staf as id_staf, *
                FROM tb_staf g
                JOIN tb_staf_sekolah gs ON g.email = gs.email
                JOIN (
                    SELECT id_staf, MAX(tahun_ajaran) as max_tahun
                    FROM tb_staf_sekolah
                    " . $wheretahun . "
                    GROUP BY id_staf
                ) latest_gs ON gs.email = latest_gs.email AND gs.tahun_ajaran = latest_gs.max_tahun WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
            'tahun' => $tahun,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_staf;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

        return $kembalian;
    }

    public function delete_daftar_staf($id_user)
    {
        $this->db->table('tb_staf')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_staf_sekolah($id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_staf_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran]);
    }

    public function simpan_daftar_staf_sekolah($data)
    {
        $this->db->table('tb_staf_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_staf($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_staf')->where('email', $row['email'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_staf')->insert($row);
            }
        }
    }

    public function tambah_staf($data)
    {
        $existingRow = $this->db->table('tb_staf')->where('email', $data['email'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_staf')->insert($data);
        } else {
        }
    }

    public function update_staf($data, $id_staf)
    {
        $this->db->table('tb_staf')->where('id_staf', $id_staf)->update($data);
    }

    public function update_staf_sekolah($data, $email_lama)
    {
        $this->db->table('tb_staf_sekolah')->where('email', $email_lama)->update($data);
    }

    public function tambah_staf_sekolah($data)
    {
        $this->db->table('tb_staf_sekolah')->insert($data);
    }

    public function getDaftarStaf($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_staf_sekolah gs
                LEFT JOIN tb_staf g ON g.email = gs.email
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function getDataStaf($id_staf)
    {
        $sql = "SELECT *
                FROM tb_staf
                WHERE id_staf = :id_staf:";

        $query = $this->db->query($sql, [
            'id_staf' => $id_staf,
        ]);

        return $query->getRowArray();
    }

    public function cek_email($email)
    {
        $sql = "SELECT * FROM tb_staf_sekolah 
                WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        return $query->getRow();
    }

    public function hapus_staf_sekolah($email, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_staf_sekolah')->where(['email' => $email, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }

    public function getKepsek($id_sekolah)
    {
        $sql = "SELECT * FROM tb_kepsek tk
                LEFT JOIN tb_guru_sekolah tgs ON tk.id_kepsek = tgs.id
                LEFT JOIN tb_guru tg ON tgs.nuptk = tg.nuptk
                WHERE tk.id_sekolah = :id_sekolah:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getRow();
    }

    public function tambah_kepsek($id_sekolah, $id_kepsek)
    {
        $sql = "INSERT INTO tb_kepsek (id_sekolah, id_kepsek)
                VALUES (:id_sekolah:, :id_kepsek:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_kepsek' => $id_kepsek,
        ]);
    }

    public function update_kepsek($id_sekolah, $id_kepsek)
    {
        $sql = "UPDATE tb_kepsek SET id_kepsek=:id_kepsek: WHERE id_sekolah=:id_sekolah:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_kepsek' => $id_kepsek,
        ]);
    }

    public function tambahlog()
    {
        $data = ['id_user' => session()->get('id_user')];
        $this->db->table('log_login')->insert($data);
    }

    public function tambah_admin($data)
    {
        $this->db->table('tb_admin')->insert($data);
    }

    public function get_admin($id_admin)
    {
        $sql = "SELECT * FROM tb_admin 
                WHERE id_user = :id_admin:";

        $query = $this->db->query($sql, [
            'id_admin' => $id_admin,
        ]);

        return $query->getRowArray();
    }

    public function update_admin($data, $id_admin)
    {
        $this->db->table('tb_admin')->where('id_user', $id_admin)->update($data);
    }

    public function hapus_admin($id_admin)
    {
        $this->db->table('tb_admin')->delete(['id_user' => $id_admin]);
    }

    public function getDaftarnilai($id_sekolah, $tahun_ajaran, $kelas, $rombel, $id_tugas)
    {
        $sql = "SELECT gs.*, g.*, n.*, GROUP_CONCAT(COALESCE(t.status, 0) SEPARATOR ';') AS nilai_tp
                FROM tb_siswa_sekolah gs
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn
                LEFT JOIN tb_nilai_siswa n ON n.nisn = gs.nisn AND n.id_tugas = :id_tugas: 
                LEFT JOIN tb_nilai_tp t ON t.id_nilai_siswa = n.id
                WHERE gs.id_sekolah = :id_sekolah: 
                    AND gs.tahun_ajaran = :tahun_ajaran: 
                    AND kelas = :kelas: 
                    AND nama_rombel = :rombel: 
                GROUP BY n.id_tugas, g.nama
                ORDER BY kelas, nis";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'id_tugas' => $id_tugas,
        ]);

        return $query->getResultArray();
    }

    public function hapus_nilai_p5($id_sekolah, $nisn, $id_dimensi_projek)
    {
        $sql = "DELETE FROM tb_nilai_p5 
                WHERE id_sekolah = :id_sekolah: 
                AND nisn = :nisn: 
                AND id_dimensi_projek = :id_dimensi_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_dimensi_projek' => $id_dimensi_projek
        ]);
    }

    public function tambah_nilai_p5($id_sekolah, $nisn, $id_dimensi_projek, $nilai)
    {
        $sql = "INSERT INTO tb_nilai_p5 (id_sekolah, nisn, id_dimensi_projek, nilai) VALUES
                (:id_sekolah:, :nisn:, :id_dimensi_projek:, :nilai:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_dimensi_projek' => $id_dimensi_projek,
            'nilai' => $nilai,
        ]);
    }

    public function hapus_nilai_eks($id_sekolah, $nisn, $id_tp_eks)
    {
        $sql = "DELETE FROM tb_nilai_eks
                WHERE id_sekolah = :id_sekolah: 
                AND nisn = :nisn: 
                AND id_tp_eks = :id_tp_eks:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_tp_eks' => $id_tp_eks
        ]);
    }

    public function tambah_nilai_eks($id_sekolah, $nisn, $id_tp_eks, $nilai)
    {
        $sql = "INSERT INTO tb_nilai_eks (id_sekolah, nisn, id_tp_eks, nilai) VALUES
                (:id_sekolah:, :nisn:, :id_tp_eks:, :nilai:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_tp_eks' => $id_tp_eks,
            'nilai' => $nilai,
        ]);
    }

    public function rapor_nilai_mid($id_sekolah, $kelas, $sub_kelas, $nisn, $maks_kolom, $tahun_ajaran, $tglawal, $tglakhir)
    {
        $batasrapor = "AND tanggal_tugas > :tglawal: AND tanggal_tugas < :tglakhir: ";

        $kolomtugas = "";
        for ($a = 1; $a < $maks_kolom; $a++) {
            $kolomtugas = $kolomtugas . "MAX(CASE WHEN task_number = " . $a . " THEN nilai END) AS tugas_" . $a . ",";
        }
        $kolomtugas = $kolomtugas . "MAX(CASE WHEN task_number = " . $a . " THEN nilai END) AS tugas_" . $a;

        $sqlSetRowNumber = "SET @row_number = 0;";
        $this->db->query($sqlSetRowNumber);

        $sqlSetCurrentMapel = "SET @current_mapel = '';";
        $this->db->query($sqlSetCurrentMapel);

        $sqlMainQuery = "SELECT 
                    m.nama_mapel,m.jenis,
                    " . $kolomtugas . " 
                FROM (
                    SELECT 
                        ns.id_mapel,
                        ns.id_tugas,
                        ns.nilai,
                        @row_number := IF(@current_mapel = ns.id_mapel, @row_number + 1, 1) AS task_number,
                        @current_mapel := ns.id_mapel AS dummy
                    FROM tb_nilai_siswa ns
                    INNER JOIN tb_tugas t ON t.id = ns.id_tugas
                    WHERE ns.nisn = :nisn: AND ns.id_sekolah = :id_sekolah: AND t.tahun_ajaran = :tahun_ajaran: " . $batasrapor . " 
                    ORDER BY ns.id_mapel, ns.id_tugas
                ) AS tasks
                RIGHT JOIN tb_mapel m ON m.id = tasks.id_mapel
                WHERE m.kelas = :kelas: AND (m.sub_kelas = '-' OR m.sub_kelas = :sub_kelas:) AND m.id_sekolah = :id_sekolah:
                GROUP BY tasks.id_mapel, m.nama_mapel
                ORDER BY m.kelas, m.jenis, m.id";

        $query = $this->db->query($sqlMainQuery, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'tahun_ajaran' => $tahun_ajaran,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ]);

        return $query->getResultArray();
    }

    public function get_max_kolom_nilai_mid($id_sekolah, $kelas, $sub_kelas, $tahun_ajaran, $tglawal, $tglakhir)
    {
        $sql = "SELECT m.id_mapel, COUNT(s.id_tugas) AS jumlah_tugas 
                FROM tb_nilai_siswa s 
                LEFT JOIN tb_tugas t ON s.id_tugas = t.id 
                LEFT JOIN tb_guru_mapel m ON t.id_guru_mapel = m.id 
                LEFT JOIN tb_rombel r ON m.id_rombel = r.id 
                WHERE s.id_sekolah = :id_sekolah: 
                AND kelas = :kelas: AND sub_kelas = :sub_kelas: AND tahun_ajaran = :tahun_ajaran:  
                AND tanggal_tugas > :tglawal: AND tanggal_tugas < :tglakhir: 
                GROUP BY s.nisn, m.id_mapel 
                ORDER BY jumlah_tugas DESC 
                LIMIT 1";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'tahun_ajaran' => $tahun_ajaran,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ]);

        $hasil = $query->getRowArray();
        if ($hasil)
            return $hasil['jumlah_tugas'];
        else
            return 0;
    }

    public function get_absensi($id_sekolah, $nisn, $tglawal, $tglakhir)
    {
        $sql = "SELECT nisn,
                    SUM(CASE WHEN status = 'S' THEN 1 ELSE 0 END) AS Jumlah_S,
                    SUM(CASE WHEN status = 'I' THEN 1 ELSE 0 END) AS Jumlah_I,
                    SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) AS Jumlah_A
                FROM tb_presensi
                WHERE id_sekolah=:id_sekolah: AND tanggal> :tglawal: AND tanggal< :tglakhir: AND nisn = :nisn: 
                GROUP BY nisn";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ]);

        $hasil = $query->getRowArray();
        return $hasil;
    }

    public function get_pribadi($id_sekolah, $nisn, $tahun_ajaran)
    {
        $sql = "SELECT * 
                FROM tb_nilai_pribadi
                WHERE id_sekolah=:id_sekolah: AND tahun= :tahun_ajaran: AND nisn = :nisn: 
                GROUP BY nisn";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'tahun_ajaran' => $tahun_ajaran
        ]);

        $hasil = $query->getRowArray();
        return $hasil;
    }
}
