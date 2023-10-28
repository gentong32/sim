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

    public function getSekolahbyNPSN($npsn)
    {
        $sql = "SELECT * FROM tb_sekolah WHERE npsn=:npsn:";

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

    public function get_rombel_sekolah($id_sekolah, $tahun, $kelas = null, $sub_kelas = null, $id_guru = null, $id_mapel = null)
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

    public function tambah_rombel_sekolah($id_sekolah, $kelas, $sub_kelas, $rombel, $tahun_mulai)
    {
        $sql = "INSERT INTO tb_rombel (id_sekolah,kelas,sub_kelas,nama_rombel,tahun_mulai) VALUES (:id_sekolah:, :kelas:, :sub_kelas:, :rombel:, :tahun_mulai:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'rombel' => $rombel,
            'tahun_mulai' => $tahun_mulai,
        ]);

        return $query;
    }

    public function update_rombel_sekolah($id_sekolah, $kelas, $sub_kelas,  $rombellama, $rombel, $tahun_mulai)
    {
        $sql = "UPDATE tb_rombel SET sub_kelas=:sub_kelas:, nama_rombel=:rombel: WHERE nama_rombel=:rombellama: AND id_sekolah=:id_sekolah: AND kelas=:kelas: AND tahun_mulai=:tahun_mulai:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'rombellama' => $rombellama,
            'rombel' => $rombel,
            'tahun_mulai' => $tahun_mulai,
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

    public function simpan_mapel($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $jenis = $data['jenis'];
        $sub_kelas = $data['sub_kelas'];
        $urutan = $data['urutan'];
        $nama_mapel = $data['nama_mapel'];

        $sql = "SELECT * FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND jenis=:jenis: AND sub_kelas=:sub_kelas: AND urutan=:urutan:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'jenis' => $jenis,
            'sub_kelas' => $sub_kelas,
            'urutan' => $urutan,
        ]);

        $hasil = $query->getRow();

        if ($hasil) {
            $sql2 = "UPDATE tb_mapel SET nama_mapel=:nama_mapel: WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND jenis=:jenis: AND sub_kelas=:sub_kelas: AND urutan=:urutan:";

            $query2 = $this->db->query($sql2, [
                'nama_mapel' => $nama_mapel,
                'id_sekolah' => $id_sekolah,
                'kelas' => $kelas,
                'jenis' => $jenis,
                'sub_kelas' => $sub_kelas,
                'urutan' => $urutan,
            ]);
        } else {
            $query2 = $this->db->table('tb_mapel')->insert($data);
        }

        return $query2;
    }

    public function hapus_mapel($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $jenis = $data['jenis'];
        $sub_kelas = $data['sub_kelas'];
        $urutan = $data['urutan'];

        $sql = "DELETE FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND jenis=:jenis: AND sub_kelas=:sub_kelas: AND urutan=:urutan:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'jenis' => $jenis,
            'sub_kelas' => $sub_kelas,
            'urutan' => $urutan,
        ]);

        return $query;
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
}
