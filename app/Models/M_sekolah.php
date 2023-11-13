<?php

namespace App\Models;

use CodeIgniter\Model;

class M_sekolah extends Model
{
    public function getSekolah($id_sekolah)
    {

        $sql = "SELECT * FROM tb_sekolah WHERE id_sekolah=:id_sekolah:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getRowArray();
    }

    public function cek_npsn($npsn)
    {
        $sql = "SELECT * FROM tb_sekolah 
                WHERE npsn = :npsn:";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
        ]);

        return $query->getRow();
    }

    public function getSekolahbyNPSN($npsn)
    {
        $sql = "SELECT * FROM tb_sekolah WHERE npsn=:npsn:";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
        ]);

        return $query->getRowArray();
    }

    public function getdatasekolahbaru($npsn)
    {
        $sql = "SELECT npsn,nama_sekolah,alamat_sekolah,desa,kecamatan,nama_kota,nama_propinsi 
                FROM daf_sekolah ds 
                LEFT JOIN daf_kota dk ON dk.id_kota = ds.id_kota
                LEFT JOIN daf_propinsi dp ON dp.id_propinsi = dk.id_propinsi
                WHERE npsn=:npsn:";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
        ]);

        return $query->getRowArray();
    }

    public function getInfoSekolah($id_sekolah, $tahun)
    {
        $sql = "SELECT * FROM tb_info_sekolah WHERE id_sekolah=:id_sekolah: AND tahun_ajaran=:tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun
        ]);

        $result = $query->getRowArray();

        if (!$result) {
            $insertData = [
                'id_sekolah' => $id_sekolah,
                'tahun_ajaran' => $tahun,
            ];

            $this->db->table('tb_info_sekolah')->insert($insertData);

            $result = $this->getInfoSekolah($id_sekolah, $tahun);
        }

        return $result;
    }

    public function update_jumlah_guru($id_sekolah, $tahun_ajaran, $jumlah_user)
    {

        $sql = "UPDATE tb_info_sekolah 
                SET jumlah_guru = :jumlah_user:
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'jumlah_user' => $jumlah_user
        ]);
    }

    public function update_jumlah_siswa($id_sekolah, $tahun_ajaran, $jumlah_user)
    {

        $sql = "UPDATE tb_info_sekolah 
                SET jumlah_siswa = :jumlah_user:
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'jumlah_user' => $jumlah_user
        ]);
    }

    public function update_jumlah_staf($id_sekolah, $tahun_ajaran, $jumlah_user)
    {

        $sql = "UPDATE tb_info_sekolah 
                SET jumlah_staf = :jumlah_user:
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'jumlah_user' => $jumlah_user
        ]);
    }

    public function get_rombel_sekolah($id_sekolah, $tahun, $kelas = null)
    {
        $wherekelas = "";
        if ($kelas != null) {
            $wherekelas = " AND kelas = :kelas:";
        }

        $sql = "SELECT tr.*, tg.nama FROM tb_rombel tr
                LEFT JOIN tb_guru_sekolah ts ON tr.nuptk_wali_kelas = ts.nuptk AND ts.tahun_ajaran = :tahun: 
                LEFT JOIN tb_guru tg ON tg.nuptk = ts.nuptk 
                WHERE tr.id_sekolah = :id_sekolah: " . $wherekelas . " AND tahun_mulai = :tahun: ORDER BY kelas, nama_rombel";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
        ]);

        return $query->getResult();
    }

    public function get_rombel_mapel($id_sekolah, $tahun, $kelas = null, $sub_kelas = null, $id_guru = null, $id_mapel = null)
    {
        $wherekelas = "";
        if ($kelas != null) {
            $wherekelas = " AND kelas = :kelas:";
        }

        $wheresubkelas = "";
        if ($sub_kelas != null && $sub_kelas != "-") {
            $wheresubkelas = " AND sub_kelas = :sub_kelas:";
        }

        $sql = "SELECT tr.*, tm.id as aktif FROM tb_rombel tr
                LEFT JOIN tb_guru_mapel tm ON tr.id = tm.id_rombel 
                WHERE id_sekolah = :id_sekolah: " . $wherekelas . $wheresubkelas . " AND tahun_mulai = :tahun: ORDER BY kelas, nama_rombel";

        if ($id_mapel != null) {

            $sql = "SELECT tr.*, CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM tb_guru_mapel tm 
                            WHERE tr.id = tm.id_rombel AND id_mapel = :id_mapel: AND id_guru = :id_guru:
                        ) THEN 2
                        WHEN EXISTS (
                            SELECT 1 
                            FROM tb_guru_mapel tm 
                            WHERE tr.id = tm.id_rombel AND id_mapel = :id_mapel: AND id_guru != :id_guru:
                        ) THEN 1
                        ELSE 0
                    END as aktif 
                FROM 
                    tb_rombel tr
                WHERE 
                    id_sekolah = :id_sekolah:
                    AND sub_kelas = :sub_kelas: 
                    AND kelas = :kelas:
                    AND tahun_mulai = :tahun: 
                ORDER BY 
                    kelas, nama_rombel";
        };

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'id_guru' => $id_guru,
            'id_mapel' => $id_mapel,
        ]);

        return $query->getResult();
    }

    public function duplikat_rombel_tahun_lalu($id_sekolah, $tahun)
    {
        $sql = "INSERT INTO tb_rombel (id_sekolah, kelas, nama_rombel, tahun_mulai)
                SELECT id_sekolah, kelas, nama_rombel, :tahun:
                FROM tb_rombel
                WHERE id_sekolah=:id_sekolah: AND tahun_mulai = :tahun_lalu:;";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'tahun_lalu' => $tahun - 1,
        ]);
    }

    public function hapus_rombel_sekolah($id_sekolah, $tahun_mulai)
    {
        $sql = "DELETE FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND tahun_mulai = :tahun_mulai:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_mulai' => $tahun_mulai,
        ]);

        return $query;
    }

    public function hapus_rombel($id_sekolah, $kelas, $rombel, $tahun_mulai)
    {
        $sql = "DELETE FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND kelas=:kelas: AND nama_rombel=:rombel: AND tahun_mulai = :tahun_mulai:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tahun_mulai' => $tahun_mulai,
        ]);

        // return $query;
    }

    public function tambah_rombel_sekolah($id_sekolah, $kelas, $sub_kelas, $rombel, $nuptk_wali_kelas, $tahun_mulai)
    {
        $sql = "INSERT INTO tb_rombel (id_sekolah,kelas,sub_kelas,nama_rombel,nuptk_wali_kelas,tahun_mulai) VALUES (:id_sekolah:, :kelas:, :sub_kelas:, :rombel:, :nuptk_wali_kelas:, :tahun_mulai:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'rombel' => $rombel,
            'nuptk_wali_kelas' => $nuptk_wali_kelas,
            'tahun_mulai' => $tahun_mulai,
        ]);

        return $query;
    }

    public function update_rombel_sekolah($id_sekolah, $kelas, $sub_kelas,  $rombellama, $rombel, $nuptk_wali_kelas, $tahun_mulai)
    {
        $sql = "UPDATE tb_rombel SET sub_kelas=:sub_kelas:, nama_rombel=:rombel:, nuptk_wali_kelas=:nuptk_wali_kelas: WHERE nama_rombel=:rombellama: AND id_sekolah=:id_sekolah: AND kelas=:kelas: AND tahun_mulai=:tahun_mulai:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'rombellama' => $rombellama,
            'rombel' => $rombel,
            'nuptk_wali_kelas' => $nuptk_wali_kelas,
            'tahun_mulai' => $tahun_mulai,
        ]);

        return $query;
    }

    public function tambah_ekskul_sekolah($id_sekolah, $jenis, $ekskul, $id_guru)
    {
        $sql = "INSERT INTO tb_ekskul (id_sekolah,jenis,nama_ekskul,id_guru) VALUES (:id_sekolah:, :jenis:,  :ekskul:, :id_guru:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'jenis' => $jenis,
            'ekskul' => $ekskul,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function update_ekskul_sekolah($id_sekolah, $jenis, $ekskullama, $ekskul, $id_guru)
    {
        $sql = "UPDATE tb_ekskul SET nama_ekskul=:ekskul:, id_guru=:id_guru: WHERE nama_ekskul=:ekskullama: AND id_sekolah=:id_sekolah: AND jenis=:jenis:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'jenis' => $jenis,
            'ekskullama' => $ekskullama,
            'ekskul' => $ekskul,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function hapus_ekskul_sekolah($id_sekolah, $id)
    {
        $sql = "DELETE FROM tb_ekskul
                WHERE id_sekolah = :id_sekolah: AND id = :id:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id' => $id,
        ]);

        return $query;
    }

    public function get_daftar_siswa($id_sekolah, $kelas, $nama_rombel, $tahun_ajaran)
    {

        $sql = "SELECT sek.nisn,nis,kelas,nama,nama_rombel FROM tb_siswa_sekolah sek
                LEFT JOIN tb_siswa sis ON sek.nisn = sis.nisn
                WHERE id_sekolah = :id_sekolah: AND kelas = :kelas: AND nama_rombel = :nama_rombel: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'nama_rombel' => $nama_rombel,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResult();
    }

    public function hapus_daftar_siswa($id_sekolah, $kelas, $tahun_ajaran)
    {
        $sql = "DELETE FROM tb_siswa_sekolah WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query;
    }

    public function get_daftar_mapel($id_sekolah, $kelas = null, $sub_kelas = null)
    {
        $andkelas = "";
        if ($kelas != null && $sub_kelas != null) {
            $andkelas = " AND kelas=:kelas: AND sub_kelas=:sub_kelas:";
        }
        $sql = "SELECT * FROM tb_mapel WHERE id_sekolah=:id_sekolah:" . $andkelas;

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
        ]);

        return $query->getResultArray();
    }

    public function get_sub_kelas_mapel($id_sekolah, $kelas)
    {
        $sql = "SELECT sub_kelas FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: GROUP BY sub_kelas";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas
        ]);

        return $query->getResultArray();
    }

    public function get_daftar_mapel_pilihan($kelas)
    {
        $sql = "SELECT dm.*, tm.id FROM daf_mapel dm
        LEFT JOIN tb_mapel tm ON dm.kd_mapel = tm.kd_mapel
        WHERE dm.kelas=:kelas: AND dm.jenis=2";

        $query = $this->db->query($sql, [
            'kelas' => $kelas
        ]);

        return $query->getResultArray();
    }

    public function cek_mapel($id_sekolah, $kelas)
    {
        $sql = "SELECT * FROM tb_mapel WHERE id_sekolah = :id_sekolah: AND kelas = :kelas:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas
        ]);

        return $query->getResult();
    }

    public function impor_mapel($id_sekolah, $kelas)
    {
        $sql = "INSERT INTO tb_mapel (id_sekolah, kd_mapel, kelas, jenis, nama_mapel)
                SELECT :id_sekolah:, kd_mapel, kelas, jenis, nama_mapel
                FROM daf_mapel a
                WHERE kelas = :kelas: AND jenis<2 AND NOT EXISTS (
                SELECT 1
                FROM tb_mapel b
                WHERE b.kd_mapel = a.kd_mapel
            )";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas
        ]);

        return $query;
    }

    public function tambah_mapel($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $jenis = $data['jenis'];
        $sub_kelas = $data['sub_kelas'];
        $nama_mapel = $data['nama_mapel'];

        $query = $this->db->table('tb_mapel')->insert($data);

        if ($query) {
            $newID = $this->db->insertID();
            $sql2 = "UPDATE tb_mapel SET kd_mapel='mps" . $newID . "' WHERE id='" . $newID . "'";
            $query2 = $this->db->query($sql2);
            return $query2;
        } else
            return false;
    }

    public function update_mapel($data, $idedit)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $jenis = $data['jenis'];
        $sub_kelas = $data['sub_kelas'];
        $nama_mapel = $data['nama_mapel'];

        $sql = "UPDATE tb_mapel SET nama_mapel=:nama_mapel: WHERE id_sekolah=:id_sekolah: AND id=:idedit:";

        $query = $this->db->query($sql, [
            'nama_mapel' => $nama_mapel,
            'id_sekolah' => $id_sekolah,
            'idedit' => $idedit,
        ]);

        return $query;
    }

    public function hapus_mapel($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $jenis = $data['jenis'];
        $sub_kelas = $data['sub_kelas'];

        $sql = "DELETE FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND jenis=:jenis: AND sub_kelas=:sub_kelas:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'jenis' => $jenis,
            'sub_kelas' => $sub_kelas,
        ]);

        return $query;
    }

    public function hapus_semuamapel($id_sekolah)
    {
        $this->db->table('tb_mapel')->where('id_sekolah', $id_sekolah)->delete();
    }

    public function hapus_mapelpilihan($id_sekolah, $kelas, $sub_kelas)
    {
        $this->db->table('tb_mapel')->where(['id_sekolah' => $id_sekolah, 'kelas' => $kelas, 'sub_kelas' => $sub_kelas, 'jenis' => 2])->delete();
    }

    public function get_namamapel($kd_mapel)
    {
        $query = $this->db->table('daf_mapel')
            ->where('kd_mapel', $kd_mapel)
            ->get();

        return $query->getRowArray();
    }

    public function tambah_mapelpilihan($data)
    {
        $this->db->table('tb_mapel')->insert($data);
        $inserted_id = $this->db->insertID();
        // $kodemp = 'ms' . $inserted_id;
        // $this->db->table('tb_mapel')->where('id', $inserted_id)->update(['kd_mapel' => $kodemp]);
    }

    public function simpan_projek($data, $opsi)
    {
        $id_projek = $data['id_projek'];
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $id_tema = $data['id_tema'];
        $nama_projek = $data['nama_projek'];
        $deskripsi_projek = $data['deskripsi_projek'];

        if ($opsi == "update") {
            $sql2 = "UPDATE tb_projek SET id_tema=:id_tema:, nama_projek=:nama_projek:, deskripsi_projek=:deskripsi_projek: WHERE id_projek=:id_projek: AND id_sekolah=:id_sekolah:";

            $query2 = $this->db->query($sql2, [
                'id_tema' => $id_tema,
                'nama_projek' => $nama_projek,
                'deskripsi_projek' => $deskripsi_projek,
                'id_projek' => $id_projek,
                'id_sekolah' => $id_sekolah,
            ]);
        } else {
            $query2 = $this->db->table('tb_projek')->insert($data);
        }

        return $query2;
    }

    public function hapus_projek($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $id_projek = $data['id_projek'];

        $sql = "DELETE FROM tb_projek WHERE id_sekolah=:id_sekolah: AND id_projek=:id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query;
    }

    public function hapus_mapel_pilihan($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $sub_kelas = $data['sub_kelas'];

        $sql = "DELETE FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND jenis=2 AND sub_kelas=:sub_kelas:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
        ]);

        return $query;
    }

    public function get_tema()
    {
        $sql = "SELECT * FROM daf_tema";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_projek_sekolah($id_sekolah)
    {
        $sql = "SELECT * FROM tb_projek ts
                LEFT JOIN daf_tema dt ON ts.id_tema = dt.id
                WHERE id_sekolah=:id_sekolah:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);
        return $query->getResultArray();
    }

    public function get_projek($id_sekolah, $id_projek)
    {
        $sql = "SELECT * FROM tb_projek 
                WHERE id_sekolah = :id_sekolah: AND id_projek=:id_projek:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);
        return $query->getRowArray();
    }

    public function get_dimensi()
    {
        $sql = "SELECT * FROM daf_dimensi";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_daftar_elemen($id_projek, $id_dimensi)
    {
        $sql = "SELECT elemen, sub_elemen, se.id as id_sub_elemen, se.*, p.id_sub_elemen as id_sub_elemen_pilih
        FROM daf_sub_elemen se
        LEFT JOIN daf_elemen e ON e.id = se.id_elemen 
        LEFT JOIN tb_dimensi_projek p ON p.id_sub_elemen = se.id AND p.id_projek = :id_projek:
        WHERE e.id_dimensi = :id_dimensi:
        ORDER BY id_elemen, id_sub_elemen";
        $query = $this->db->query($sql, [
            'id_projek' => $id_projek,
            'id_dimensi' => $id_dimensi,
        ]);
        return $query->getResultArray();
    }

    public function get_dimensi_projek($id_sekolah, $kelas)
    {
        $sql = "SELECT p.id_projek, nama_projek, dimensi, e.* FROM tb_projek p
                LEFT JOIN tb_dimensi_projek dp  ON p.id_projek = dp.id_projek 
                LEFT JOIN daf_sub_elemen e ON dp.id_sub_elemen = e.id 
                LEFT JOIN daf_dimensi d ON e.id_dimensi = d.id 
                WHERE p.id_sekolah= :id_sekolah: AND kelas = :kelas:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
        ]);
        return $query->getResultArray();
    }

    public function get_elemen($id_dimensi)
    {
        $sql = "SELECT * FROM daf_elemen WHERE id_dimensi=:id_dimensi:";
        $query = $this->db->query($sql, [
            'id_dimensi' => $id_dimensi,
        ]);

        return $query->getResultArray();
    }

    public function hapus_penilaian($id_sekolah, $id_projek)
    {
        $sql = "DELETE FROM tb_dimensi_projek
                WHERE id_sekolah = :id_sekolah: AND id_projek = :id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query;
    }

    public function tambah_penilaian($id_sekolah, $id_projek, $id_sub_elemen)
    {
        $insertData = [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
            'id_sub_elemen' => $id_sub_elemen,
        ];

        $this->db->table('tb_dimensi_projek')->insert($insertData);
    }

    public function cek_rombel($id_sekolah, $tahun, $kelas, $subkelas, $namarombel)
    {
        $sql = "SELECT id FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND tahun_mulai = :tahun: 
                AND kelas = :kelas: 
                AND sub_kelas = :subkelas: 
                AND nama_rombel = :namarombel:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'subkelas' => $subkelas,
            'namarombel' => $namarombel,
        ]);

        return $query->getRowArray();
    }

    public function hapus_guru_mapel($id_mapel, $id_guru)
    {
        $sql = "DELETE FROM tb_guru_mapel
                WHERE id_mapel = :id_mapel: AND id_guru = :id_guru:";

        $query = $this->db->query($sql, [
            'id_mapel' => $id_mapel,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function insert_guru_mapel($id_rombel, $id_mapel, $id_guru)
    {
        $sql = "INSERT INTO tb_guru_mapel (id_rombel, id_mapel, id_guru)
                VALUES (:id_rombel:, :id_mapel:, :id_guru:)";

        $query = $this->db->query($sql, [
            'id_rombel' => $id_rombel,
            'id_mapel' => $id_mapel,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function get_daftar_ekskul($id_sekolah)
    {
        $sql = "SELECT * FROM tb_ekskul te
        LEFT JOIN tb_guru_sekolah ts ON te.id_guru = ts.id 
        LEFT JOIN tb_guru tg ON tg.nuptk = ts.nuptk 
        WHERE te.id_sekolah=:id_sekolah:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getResult();
    }

    public function getAgenda($id_sekolah, $tahun = null)
    {
        $wheretahun = "";
        $wheretahun2 = "";
        if ($tahun != null) {
            $wheretahun = "WHERE year(tanggal)=:tahun:";
            $wheretahun2 = "AND year(tanggal)=:tahun:";
        }
        $sql = "SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 2 THEN 'admin'
                    ELSE 'lain'
                END AS type, 1 as jeniskal, 'admin' as id_uploader FROM tb_kalender " . $wheretahun . "
                UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    WHEN jenis = 3 THEN 'wali'
                    WHEN jenis = 4 THEN 'guru'
                    ELSE 'lain'
                END AS type, 2 as jeniskal, id_uploader FROM tb_kalender_agenda WHERE id_sekolah=:id_sekolah: " . $wheretahun2 . " ORDER BY date";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function getAgendaSaja($id_sekolah, $tahun = null)
    {
        $wheretahun = "";
        if ($tahun != null) {
            $wheretahun = "AND year(tanggal)=:tahun:";
        }
        $sql = "SELECT * FROM tb_kalender_agenda WHERE id_sekolah=:id_sekolah: " . $wheretahun;

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function tambah_agenda($id_sekolah, $tanggalnya, $agenda, $jenis, $id_uploader)
    {
        $sql = "INSERT INTO tb_kalender_agenda (id_sekolah, tanggal, acara, jenis, id_uploader)
                VALUES (:id_sekolah:, :tanggal:, :acara:, :jenis:, :id_uploader:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tanggal' => $tanggalnya,
            'acara' => $agenda,
            'jenis' => $jenis,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function update_agenda($id_sekolah, $tanggalnya, $agenda, $jenis, $id_uploader)
    {
        $sql = "UPDATE tb_kalender_agenda SET acara=:agenda:, jenis=:jenis: WHERE tanggal=:tanggalnya: AND id_sekolah=:id_sekolah: AND id_uploader=:id_uploader:";

        $query = $this->db->query($sql, [
            'agenda' => $agenda,
            'jenis' => $jenis,
            'tanggalnya' => $tanggalnya,
            'id_sekolah' => $id_sekolah,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function hapus_agenda($id_sekolah, $tanggalnya, $id_uploader)
    {
        $sql = "DELETE FROM tb_kalender_agenda WHERE tanggal=:tanggalnya: AND id_sekolah=:id_sekolah: AND id_uploader=:id_uploader:";

        $query = $this->db->query($sql, [
            'tanggalnya' => $tanggalnya,
            'id_sekolah' => $id_sekolah,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function getAgendaKelas($id_sekolah, $id_rombel, $tahun = null)
    {
        $wheretahun = "";
        $wheretahun2 = "";
        if ($tahun != null) {
            $wheretahun = "WHERE year(tanggal)=:tahun:";
            $wheretahun2 = "AND year(tanggal)=:tahun:";
        }
        $sql = "SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 2 THEN 'admin'
                    ELSE 'lain'
                END AS type, 1 as jeniskal, 'admin' as id_uploader FROM tb_kalender " . $wheretahun . "UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    ELSE 'lain'
                END AS type, 2 as jeniskal, id_uploader FROM tb_kalender_agenda WHERE id_sekolah=:id_sekolah: " . $wheretahun2 .
            "UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 3 THEN 'wali'
                    WHEN jenis = 4 THEN 'guru'
                    ELSE 'lain'
                END AS type, 3 as jeniskal, id_uploader FROM tb_kalender_agenda_kelas WHERE id_sekolah=:id_sekolah: AND id_rombel=:id_rombel: " . $wheretahun2 . "
                ORDER BY date";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_rombel' => $id_rombel,
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function tambah_agenda_kelas($id_sekolah, $tanggalnya, $agenda, $jenis, $id_rombel, $id_uploader)
    {
        $sql = "INSERT INTO tb_kalender_agenda_kelas (id_sekolah, tanggal, acara, jenis, id_rombel, id_uploader)
                VALUES (:id_sekolah:, :tanggal:, :acara:, :jenis:, :id_rombel:, :id_uploader:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tanggal' => $tanggalnya,
            'acara' => $agenda,
            'jenis' => $jenis,
            'id_rombel' => $id_rombel,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function update_agenda_kelas($id_sekolah, $tanggalnya, $agenda, $jenis, $id_rombel,  $id_uploader)
    {
        $sql = "UPDATE tb_kalender_agenda_kelas SET acara=:agenda:, jenis=:jenis: WHERE tanggal=:tanggalnya: AND id_sekolah=:id_sekolah: AND id_rombel=:id_rombel: AND id_uploader=:id_uploader:";

        $query = $this->db->query($sql, [
            'agenda' => $agenda,
            'jenis' => $jenis,
            'tanggalnya' => $tanggalnya,
            'id_sekolah' => $id_sekolah,
            'id_rombel' => $id_rombel,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function hapus_agenda_kelas($id_sekolah, $tanggalnya, $id_rombel, $id_uploader)
    {
        $sql = "DELETE FROM tb_kalender_agenda_kelas WHERE tanggal=:tanggalnya: AND id_sekolah=:id_sekolah: AND id_rombel=:id_rombel: AND id_uploader=:id_uploader:";

        $query = $this->db->query($sql, [
            'tanggalnya' => $tanggalnya,
            'id_sekolah' => $id_sekolah,
            'id_rombel' => $id_rombel,
            'id_uploader' => $id_uploader
        ]);

        return $query;
    }

    public function getKalender()
    {
        $sql = "SELECT tanggal as date, acara as title, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    ELSE 'lain'
                END AS type, 1 as jeniskal FROM tb_kalender
                ORDER BY date";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function tambah_kalender($tanggalnya, $agenda, $jenis)
    {
        $sql = "INSERT INTO tb_kalender (tanggal, acara, jenis)
                VALUES (:tanggal:, :acara:, :jenis:)";

        $query = $this->db->query($sql, [
            'tanggal' => $tanggalnya,
            'acara' => $agenda,
            'jenis' => $jenis,
        ]);

        return $query;
    }

    public function update_kalender($tanggalnya, $agenda, $jenis)
    {
        $sql = "UPDATE tb_kalender SET acara=:agenda:, jenis=:jenis: WHERE tanggal=:tanggalnya:";

        $query = $this->db->query($sql, [
            'agenda' => $agenda,
            'jenis' => $jenis,
            'tanggalnya' => $tanggalnya,
        ]);

        return $query;
    }

    public function hapus_kalender($tanggalnya)
    {
        $sql = "DELETE FROM tb_kalender WHERE tanggal=:tanggalnya:";

        $query = $this->db->query($sql, [
            'tanggalnya' => $tanggalnya,
        ]);

        return $query;
    }

    public function getListKalender($tahun)
    {
        $sql = "SELECT tanggal as date, acara as title, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    ELSE 'lain'
                END AS type, 1 as jeniskal FROM tb_kalender WHERE year(tanggal)=:tahun:";

        $query = $this->db->query($sql, [
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function cek_pembayaran($npsn, $tahun_ajaran)
    {
        $sql = "SELECT * FROM tb_payment 
                WHERE npsn = :npsn: AND tahun_ajaran=:tahun_ajaran: AND status = 3";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        if ($query)
            return $query->getRow();
        else
            return "";
    }

    public function update_sekolah($data, $id_sekolah)
    {
        $this->db->table('tb_sekolah')->where(['id_sekolah' => $id_sekolah])->update($data);
    }

    public function update_admin($data, $id_admin)
    {
        $this->db->table('tb_admin')->where(['id_user' => $id_admin])->update($data);
    }
}
