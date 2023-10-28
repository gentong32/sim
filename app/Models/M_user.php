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
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_admin;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

        return $kembalian;
    }

    // FUNGSI UNTUK GURU =========================================================

    public function cekLoginGuru($email, $kode, $tahun = null)
    {
        $wheretahun = "";
        if ($tahun != null) {
            $wheretahun = "WHERE tahun_ajaran <= :tahun:";
        }

        $sql = "SELECT g.id_guru as id_guru, *
                FROM tb_guru g
                JOIN tb_guru_sekolah gs ON g.nuptk = gs.nuptk
                JOIN (
                    SELECT id_guru, MAX(tahun_ajaran) as max_tahun
                    FROM tb_guru_sekolah
                    " . $wheretahun . "
                    GROUP BY id_guru
                ) latest_gs ON gs.nuptk = latest_gs.nuptk AND gs.tahun_ajaran = latest_gs.max_tahun WHERE email = :email:";

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
                $id_user = $result->id_guru;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

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

        return $query->getResultArray();
    }

    public function get_daftar_guru_mapel($id_sekolah)
    {
        $sql = "SELECT GROUP_CONCAT(nama_rombel ORDER BY nama_rombel ASC SEPARATOR ', ') AS nama_rombel, nama_mapel, nama, tr.kelas
                FROM tb_rombel tr
                LEFT JOIN tb_guru_mapel gm ON tr.id = gm.id_rombel
                LEFT JOIN tb_mapel tm ON tm.id = gm.id_mapel
                LEFT JOIN tb_guru_sekolah gs ON gs.id = gm.id_guru
                LEFT JOIN tb_guru tg ON tg.nuptk = gs.nuptk
                WHERE tr.id_sekolah = :id_sekolah: AND tahun_mulai = (SELECT MAX(tahun_mulai) FROM tb_rombel) 
                GROUP BY nama_mapel, nama, tr.kelas, tm.jenis, tm.sub_kelas, tm.urutan
                ORDER BY tr.kelas, tm.nama_mapel, nama_rombel, tg.nama, tm.jenis, tm.sub_kelas, urutan";

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
        $sql = "SELECT *
                FROM tb_guru
                WHERE id_guru = :id_guru:";

        $query = $this->db->query($sql, [
            'id_guru' => $id_guru,
        ]);

        return $query->getRowArray();
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

    public function hapus_siswa_sekolah($nisn, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_siswa_sekolah')->where(['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
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
}
