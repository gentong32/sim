<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

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

            // $start_date = new DateTime(tahun_ajaran() . '-07-10');
            // $end_date = new DateTime(tahun_ajaran() . '-07-18');
            // $interval = new DateInterval('P1D');
            // $period = new DatePeriod($start_date, $interval, $end_date);
            // $tglawalganjil = "";
            // foreach ($period as $date) {
            //     if ($date->format('N') == 1) {
            //         $tglawalganjil =  $date->format('Y/m/d');
            //         break;
            //     }
            // }

            $sqladmin = "SELECT * FROM tb_admin WHERE id_user=:id_user:";
            $queryadmin = $this->db->query($sqladmin, [
                'id_user' => session()->get('id_user')
            ]);
            $resultadmin = $queryadmin->getRowArray();
            $jenjang = $resultadmin['jenjang'];

            $sqlsekolah = "SELECT * FROM tb_sekolah WHERE id_sekolah=:id_sekolah:";
            $querysekolah = $this->db->query($sqlsekolah, [
                'id_sekolah' => $id_sekolah,
            ]);
            $resultsekolah = $querysekolah->getRowArray();

            if ($jenjang == "SMA") {
                $propkot = "PEMERINTAH " . strtoupper($resultsekolah['propinsi']);
            } else {
                $propkot = "PEMERINTAH " . strtoupper($resultsekolah['kota']);
            }
            $nama_sekolah = $resultsekolah['nama'];
            $alamat = $resultsekolah['alamat'] . ", " . $resultsekolah['kecamatan'];
            $telp = $resultsekolah['telp'];
            $email = $resultsekolah['email'];

            $kap_rapor_default = "<p>" . $propkot . "</p><p>DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
            <p>" . $nama_sekolah . "</p><p><span style='font-size:10px'>" . $alamat . "</span></p>
            <p><span style='font-size:10px'>Telp. " . $telp . " Email: " . $email . "</span></p>";

            $date = new DateTime(tahun_ajaran() . '-07-10');
            while ($date->format('N') > 1) {
                $date->modify('+1 day');
            }
            $tglawalganjil = $date->format('Y/m/d');

            $date = new DateTime((tahun_ajaran() + 1) . '-01-02');
            while ($date->format('N') > 3) {
                $date->modify('+1 day');
            }
            $tglawalgenap = $date->format('Y/m/d');

            $date = new DateTime(tahun_ajaran() . '-12-15');
            while ($date->format('N') < 6) {
                $date->modify('+1 day');
            }
            $tglraporganjil = $date->format('Y/m/d');

            $date = new DateTime((tahun_ajaran() + 1) . '-06-18');
            while ($date->format('N') < 6) {
                $date->modify('+1 day');
            }
            $tglraporgenap = $date->format('Y/m/d');

            $insertData = [
                'id_sekolah' => $id_sekolah,
                'tahun_ajaran' => $tahun,
                'tgl_awal_ganjil' => $tglawalganjil,
                'tgl_awal_genap' => $tglawalgenap,
                'tgl_mid_ganjil' => $tahun . "/10/01",
                'tgl_mid_genap' => ($tahun + 1) . "/03/01",
                'tgl_rapor_ganjil' => $tglraporganjil,
                'tgl_rapor_genap' => $tglraporgenap,
                'kop_rapor' => $kap_rapor_default

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
                LEFT JOIN tb_guru_sekolah ts ON tr.nuptk_wali_kelas = ts.nuptk AND ts.tahun_ajaran = :tahun: AND ts.id_sekolah = :id_sekolah:
                LEFT JOIN tb_guru tg ON tg.nuptk = ts.nuptk 
                WHERE tr.id_sekolah = :id_sekolah: " . $wherekelas . " AND tahun_mulai = :tahun: ORDER BY kelas, nama_rombel";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
        ]);

        return $query->getResult();
    }

    public function get_rombel_byid($id_rombel)
    {
        $rombel = $this->db->table('tb_rombel')->where(['id' => $id_rombel])->get()->getRowArray();
        return $rombel;
    }

    public function get_id_rombel($id_sekolah, $kelas, $nama_rombel)
    {
        $rombel = $this->db->table('tb_rombel')
            ->select('id, sub_kelas')
            ->where([
                'id_sekolah' => $id_sekolah,
                'kelas' => $kelas,
                'nama_rombel' => $nama_rombel
            ])
            ->orderBy('tahun_mulai', 'DESC')
            ->get()->getRowArray();
        return $rombel;
    }

    public function get_wali_rombel($id_sekolah, $nuptk)
    {
        $rombel = $this->db->table('tb_rombel')
            ->select('id, kelas, nama_rombel')
            ->where([
                'id_sekolah' => $id_sekolah,
                'nuptk_wali_kelas' => $nuptk,
            ])
            ->orderBy('tahun_mulai', 'DESC')
            ->get()->getRowArray();
        return $rombel;
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

        $jenis_mapel = 0;
        if ($id_mapel == "mpbk")
            $jenis_mapel = 1;
        else if ($id_mapel == "mpp5")
            $jenis_mapel = 2;

        $sql = "SELECT tr.*, tm.id as aktif FROM tb_rombel tr
                LEFT JOIN tb_guru_mapel tm ON tr.id = tm.id_rombel 
                WHERE id_sekolah = :id_sekolah: " . $wherekelas . $wheresubkelas . " AND tahun_mulai = :tahun: ORDER BY kelas, nama_rombel";

        if ($id_mapel != null) {

            if ($jenis_mapel == 0) {
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
                    $wheresubkelas 
                    AND kelas = :kelas:
                    AND tahun_mulai = :tahun: 
                ORDER BY 
                    kelas, nama_rombel";
            } else {
                $sql = "SELECT tr.*, CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM tb_guru_lain tl 
                            WHERE tr.id = tl.id_rombel AND jenis_mapel = :jenis_mapel: AND id_guru = :id_guru:
                        ) THEN 2
                        WHEN EXISTS (
                            SELECT 1 
                            FROM tb_guru_lain tl 
                            WHERE tr.id = tl.id_rombel AND jenis_mapel = :jenis_mapel: AND id_guru != :id_guru:
                        ) THEN 1
                        ELSE 0
                    END as aktif 
                FROM 
                    tb_rombel tr
                WHERE 
                    id_sekolah = :id_sekolah: 
                    $wheresubkelas 
                    AND kelas = :kelas:
                    AND tahun_mulai = :tahun:
                ORDER BY 
                    kelas, nama_rombel";
            }
        };

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
            'id_guru' => $id_guru,
            'id_mapel' => $id_mapel,
            'jenis_mapel' => $jenis_mapel,
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

    public function tambah_ekskul_sekolah($id_sekolah, $jenis, $tahun_ajaran, $ekskul, $id_guru)
    {
        $sql = "INSERT INTO tb_ekskul (id_sekolah,jenis,tahun_ajaran,nama_ekskul,id_guru) VALUES (:id_sekolah:, :jenis:, :tahun_ajaran:, :ekskul:, :id_guru:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'jenis' => $jenis,
            'tahun_ajaran' => $tahun_ajaran,
            'ekskul' => $ekskul,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function update_ekskul_sekolah($id_sekolah, $jenis, $tahun_ajaran, $ekskullama, $ekskul, $id_guru)
    {
        $sql = "UPDATE tb_ekskul SET nama_ekskul=:ekskul:, id_guru=:id_guru: WHERE nama_ekskul=:ekskullama: AND id_sekolah=:id_sekolah: AND jenis=:jenis: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'jenis' => $jenis,
            'tahun_ajaran' => $tahun_ajaran,
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

    public function get_daftar_siswa_ekskul($id_sekolah, $kelas, $nama_rombel, $tahun_ajaran, $id_ekskul)
    {

        $sql = "SELECT es.nisn,nis,kelas,nama,nama_rombel 
                FROM tb_ekskul_siswa es
                LEFT JOIN tb_siswa_sekolah ss ON ss.nisn = es.nisn
                LEFT JOIN tb_siswa ts ON ts.nisn = ss.nisn
                WHERE ss.id_sekolah = :id_sekolah: AND kelas = :kelas: AND tahun_ajaran = :tahun_ajaran: AND es.id_ekskul = :id_ekskul: ORDER BY kelas, nama_rombel,nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'nama_rombel' => $nama_rombel,
            'tahun_ajaran' => $tahun_ajaran,
            'id_ekskul' => $id_ekskul,
        ]);

        return $query->getResultArray();
    }

    public function get_daftar_mapel($id_sekolah, $tahun_ajaran, $kelas = null, $sub_kelas = null, $agama = null)
    {
        $andkelas = "";
        if ($kelas != null && $sub_kelas != null) {
            $andkelas = " AND kelas=:kelas: AND sub_kelas=:sub_kelas:";
        }
        $andagama = "";
        if ($agama != null) {
            $andagama = " AND ((jenis = 2 AND sub_kelas = :sub_kelas:) OR jenis = 1 OR (jenis = 0 AND nama_mapel LIKE '%" . $agama . "%'))";
        }
        $sql = "SELECT * FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND tahun_ajaran=:tahun_ajaran: " . $andkelas . $andagama . " ORDER BY kelas, jenis, sub_kelas, kd_mapel";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas,
        ]);

        return $query->getResultArray();
    }

    public function get_sub_kelas_mapel($id_sekolah, $tahun_ajaran, $kelas)
    {
        $sql = "SELECT sub_kelas FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND tahun_ajaran = :tahun_ajaran: AND kelas=:kelas: GROUP BY sub_kelas";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas
        ]);

        return $query->getResultArray();
    }

    public function get_daftar_mapel_pilihan($id_sekolah, $tahun_ajaran, $kelas, $sub_kelas)
    {
        $sql = "SELECT dm.*, tm.id FROM daf_mapel dm
        LEFT JOIN tb_mapel tm ON dm.kd_mapel = tm.kd_mapel AND tm.id_sekolah=:id_sekolah: AND tm.tahun_ajaran = :tahun_ajaran: AND tm.sub_kelas=:sub_kelas:
        WHERE dm.kelas=:kelas: AND dm.jenis=2";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'sub_kelas' => $sub_kelas
        ]);

        return $query->getResultArray();
    }

    public function cek_mapel($id_sekolah, $tahun_ajaran, $kelas)
    {
        $sql = "SELECT * FROM tb_mapel WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran: AND kelas = :kelas:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas
        ]);

        return $query->getResult();
    }

    public function cek_nilai_mapel($id_sekolah, $idmapel)
    {
        $sql = "SELECT * FROM tb_nilai_siswa WHERE id_sekolah = :id_sekolah: AND id_mapel = :idmapel:";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'idmapel' => $idmapel,
        ]);

        return $query->getResult();
    }

    public function impor_mapel($id_sekolah, $tahun_ajaran, $kelas)
    {
        $sql = "INSERT INTO tb_mapel (id_sekolah, kd_mapel, kelas, jenis, nama_mapel, tahun_ajaran)
                SELECT :id_sekolah:, kd_mapel, kelas, jenis, nama_mapel, :tahun_ajaran:
                FROM daf_mapel a
                WHERE kelas = :kelas: AND jenis<2 AND NOT EXISTS (
                SELECT 1
                FROM tb_mapel b
                WHERE b.kd_mapel = a.kd_mapel AND id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'tahun_ajaran' => $tahun_ajaran
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
        $tahun_ajaran = $data['tahun_ajaran'];

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
        $id_sekolah = session()->get('id_sekolah');
        $id = $data['id'];

        $sql = "DELETE FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND id=:id:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id' => $id,
        ]);

        return $query;
    }

    public function hapus_semuamapel($id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_mapel')
            ->where(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])
            ->delete();
    }

    public function hapus_mapelpilihan($id_sekolah, $tahun_ajaran, $kelas, $sub_kelas)
    {
        $this->db->table('tb_mapel')
            ->where(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran, 'kelas' => $kelas, 'sub_kelas' => $sub_kelas, 'jenis' => 2])->delete();
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

    public function hapus_dimensi_projek($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $id_projek = $data['id_projek'];

        $sql = "DELETE FROM tb_dimensi_projek WHERE id_sekolah=:id_sekolah: AND id_projek=:id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query;
    }

    public function hapus_mapel_pilihan($data, $tahun_ajaran)
    {
        $id_sekolah = $data['id_sekolah'];
        $kelas = $data['kelas'];
        $sub_kelas = $data['sub_kelas'];

        $sql = "DELETE FROM tb_mapel WHERE id_sekolah=:id_sekolah: AND tahun_ajaran=:tahun_ajaran: AND kelas=:kelas: AND jenis=2 AND sub_kelas=:sub_kelas:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
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

    public function get_projek_sekolah($id_sekolah, $tahun_ajaran, $kelas = null)
    {
        $wherekelas = "";
        if ($kelas != null) {
            $wherekelas = " AND kelas=:kelas:";
        }
        $sql = "SELECT * FROM tb_projek ts
                LEFT JOIN daf_tema dt ON ts.id_tema = dt.id
                WHERE id_sekolah=:id_sekolah: AND tahun_ajaran = :tahun_ajaran:" . $wherekelas;
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
        ]);
        return $query->getResultArray();
    }

    public function get_dimensi()
    {
        $sql = "SELECT * FROM daf_dimensi";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function get_dimensi_elemen_sekolah($id_projek)
    {
        $sql = "SELECT * 
                FROM tb_dimensi_projek dp
                LEFT JOIN daf_sub_elemen s ON dp.id_sub_elemen = s.id
                LEFT JOIN daf_dimensi d ON s.id_dimensi = d.id
                WHERE id_projek = :id_projek:";
        $query = $this->db->query($sql, [
            'id_projek' => $id_projek
        ]);
        return $query->getResultArray();
    }

    public function get_dimensi_sekolah($id_projek)
    {
        $sql = "SELECT id_dimensi, dimensi
                FROM tb_dimensi_projek dp
                LEFT JOIN daf_sub_elemen s ON dp.id_sub_elemen = s.id
                LEFT JOIN daf_dimensi d ON s.id_dimensi = d.id
                WHERE id_projek = :id_projek: 
                GROUP BY id_dimensi";
        $query = $this->db->query($sql, [
            'id_projek' => $id_projek
        ]);
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

    public function get_daftar_elemen_sekolah($id_projek, $id_sub_elemen)
    {
        $sql = "SELECT * 
                FROM tb_dimensi_projek dp
                LEFT JOIN daf_sub_elemen s ON dp.id_sub_elemen = s.id
                LEFT JOIN daf_dimensi d ON s.id_dimensi = d.id
                WHERE id_projek = :id_projek: AND id_sub_elemen = :id_sub_elemen:";
        $query = $this->db->query($sql, [
            'id_projek' => $id_projek,
            'id_sub_elemen' => $id_sub_elemen
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

    public function cek_rombel($id_sekolah, $tahun, $kelas, $namarombel)
    {
        $sql = "SELECT id FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND tahun_mulai = :tahun: 
                AND kelas = :kelas: 
                AND nama_rombel = :namarombel:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'namarombel' => $namarombel,
        ]);

        return $query->getRowArray();
    }

    public function hapus_guru_mapel($id_mapel, $id_guru, $kelas)
    {
        $sql = "DELETE m FROM tb_guru_mapel m
                LEFT JOIN tb_rombel r ON m.id_rombel = r.id 
                WHERE id_mapel = :id_mapel: AND id_guru = :id_guru: AND r.kelas = :kelas:";

        $query = $this->db->query($sql, [
            'id_mapel' => $id_mapel,
            'id_guru' => $id_guru,
            'kelas' => $kelas,
        ]);

        return $query;
    }

    public function hapus_guru_lain($jenis_mapel, $id_guru, $kelas)
    {
        $sql = "DELETE l FROM tb_guru_lain l
                LEFT JOIN tb_rombel r ON l.id_rombel = r.id 
                WHERE jenis_mapel = :jenis_mapel: AND id_guru = :id_guru: AND r.kelas = :kelas:";

        $query = $this->db->query($sql, [
            'jenis_mapel' => $jenis_mapel,
            'id_guru' => $id_guru,
            'kelas' => $kelas,
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

    public function insert_guru_bk_p5($id_rombel, $jenis_mapel, $id_guru)
    {
        $sql = "INSERT INTO tb_guru_lain (id_rombel, jenis_mapel, id_guru)
                VALUES (:id_rombel:, :jenis_mapel:, :id_guru:)";

        $query = $this->db->query($sql, [
            'id_rombel' => $id_rombel,
            'jenis_mapel' => $jenis_mapel,
            'id_guru' => $id_guru,
        ]);

        return $query;
    }

    public function get_daftar_ekskul($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT * FROM tb_ekskul te
        LEFT JOIN tb_guru_sekolah ts ON te.id_guru = ts.id 
        LEFT JOIN tb_guru tg ON tg.nuptk = ts.nuptk 
        WHERE te.id_sekolah=:id_sekolah: AND te.tahun_ajaran=:tahun_ajaran: AND soft_delete=0 ORDER BY jenis DESC";
        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
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

    public function getAgendaAll($id_sekolah, $id_uploader, $tahun = null)
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
                END AS type, 2 as jeniskal, id_uploader FROM tb_kalender_agenda WHERE id_sekolah=:id_sekolah: " . $wheretahun2 . " 
                UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    WHEN jenis = 3 THEN 'wali'
                    WHEN jenis = 4 THEN 'guru'
                    ELSE 'lain'
                END AS type, 2 as jeniskal, id_uploader FROM tb_kalender_agenda_kelas WHERE id_sekolah=:id_sekolah: " . $wheretahun2 . " AND id_uploader = :id_uploader: 
                ORDER BY date";

        $sql = "SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 0 THEN 'info'
                    WHEN jenis = 1 THEN 'tes'
                    WHEN jenis = 2 THEN 'libur'
                    WHEN jenis = 3 THEN 'wali'
                    WHEN jenis = 4 THEN 'guru'
                    ELSE 'lain'
                END AS type, 2 as jeniskal, id_uploader FROM tb_kalender_agenda_kelas WHERE id_sekolah=:id_sekolah: " . $wheretahun2 . " AND id_uploader = :id_uploader: 
                ORDER BY date";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_uploader' => $id_uploader,
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
        $id_user = session()->get('id_user');
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
            " UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 3 THEN 'wali'
                    WHEN jenis = 4 THEN 'guru'
                    ELSE 'lain'
                    END AS type, 3 as jeniskal, id_uploader FROM tb_kalender_agenda_kelas WHERE jenis!=5 AND  id_sekolah=:id_sekolah: AND id_rombel=:id_rombel: " . $wheretahun2 .
            " UNION SELECT tanggal as date, acara as title, jenis, CASE 
                    WHEN jenis = 5 THEN 'siswa'
                    ELSE 'lain'
                    END AS type, 4 as jeniskal, id_uploader FROM tb_kalender_agenda_kelas WHERE jenis=5 AND id_uploader=:id_user: AND id_sekolah=:id_sekolah: AND id_rombel=:id_rombel: " . $wheretahun2 . "
                ORDER BY date";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_rombel' => $id_rombel,
            'tahun' => $tahun,
            'id_user' => $id_user,
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
        $cari = $this->db->table('tb_sekolah')->where(['id_sekolah' => $id_sekolah]);
        $hasil = $cari->get()->getRowArray();
        if ($hasil) {
            $cek = $this->db->table('tb_sekolah')->where(['id_sekolah' => $id_sekolah])->update($data);
        } else {
            $cek = $this->db->table('tb_sekolah')->insert($data);
        }
    }

    public function update_admin($data, $id_admin)
    {
        $this->db->table('tb_admin')->where(['id_user' => $id_admin])->update($data);
    }

    public function getTP($id_user, $id_mapel, $kelas, $tahun_ajaran)
    {
        $getdata = $this->db->table('tb_tujuan_pembelajaran')->where(['id_guru' => $id_user, 'id_mapel' => $id_mapel, 'kelas' => $kelas, 'tahun_ajaran' => $tahun_ajaran])->get();
        return $getdata->getResult();
    }

    public function getTP_Ekskul($id_ekskul, $kelas, $semester)
    {
        $getdata = $this->db->table('tb_tujuan_pembelajaran_ekskul')->where(['id_ekskul' => $id_ekskul, 'kelas' => $kelas, 'semester' => $semester])->get();
        return $getdata->getResult();
    }

    public function tambah_tp($data)
    {
        $this->db->table('tb_tujuan_pembelajaran')->insert($data);
    }

    public function update_tp($data, $datawhere)
    {
        $this->db->table('tb_tujuan_pembelajaran')->where($datawhere)->update($data);
    }

    public function hapus_tp($datawhere)
    {
        $this->db->table('tb_tujuan_pembelajaran')->where($datawhere)->delete();
    }

    public function tambah_tp_eks($data)
    {
        $this->db->table('tb_tujuan_pembelajaran_ekskul')->insert($data);
    }

    public function update_tp_eks($data, $datawhere)
    {
        $this->db->table('tb_tujuan_pembelajaran_ekskul')->where($datawhere)->update($data);
    }

    public function hapus_tp_eks($datawhere)
    {
        $this->db->table('tb_tujuan_pembelajaran_ekskul')->where($datawhere)->delete();
    }
    public function get_tugas($id_guru_mapel, $tahun_ajaran)
    {
        $sql = "SELECT * FROM tb_tugas t
                WHERE id_guru_mapel = :id_guru_mapel: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_guru_mapel' => $id_guru_mapel,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function get_tugas_tp($id_tugas)
    {
        $sql = "SELECT t.id as id_tugas_tp, t.*, p.* FROM tb_tugas_tp t
                LEFT JOIN tb_tujuan_pembelajaran p ON t.id_tp = p.id
                WHERE id_tugas = :id_tugas:";

        $query = $this->db->query($sql, [
            'id_tugas' => $id_tugas,
        ]);

        return $query->getResultArray();
    }

    public function get_tptugas($id_guru_mapel, $tahun_ajaran)
    {
        $sql = "SELECT t.*, tp.id_tugas, p.tujuan_pembelajaran FROM tb_tugas t 
                LEFT JOIN tb_tugas_tp tp ON tp.id_tugas = t.id 
                LEFT JOIN tb_tujuan_pembelajaran p ON tp.id_tp = p.id   
                WHERE id_guru_mapel = :id_guru_mapel: AND t.tahun_ajaran = :tahun_ajaran: 
                ORDER BY t.tanggal_tugas";

        $query = $this->db->query($sql, [
            'id_guru_mapel' => $id_guru_mapel,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function insert_tugas($data)
    {
        $inserdata = $this->db->table('tb_tugas')->insert($data);
        $lastInsertedID = $this->db->insertID();
        return $lastInsertedID;
    }

    public function insert_tugas_tp($data)
    {
        $inserdata = $this->db->table('tb_tugas_tp')->insert($data);
    }

    public function hapus_tugas($data)
    {
        $deletedata = $this->db->table('tb_tugas')->where($data)->delete();
        return $deletedata;
    }

    public function cek_dimensi_projek($id_sekolah, $id_projek)
    {
        $sql = "SELECT * FROM tb_dimensi_projek 
                WHERE id_sekolah = :id_sekolah: AND id_projek = :id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query->getRow();
    }

    public function cek_nilai($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $nisn = $data['nisn'];
        $id_mapel = $data['id_mapel'];
        $id_tugas = $data['id_tugas'];
        $cek_data = $this->db->table('tb_nilai_siswa')->select('*')->where(['id_sekolah' => $id_sekolah, 'nisn' => $nisn, 'id_mapel' => $id_mapel, 'id_tugas' => $id_tugas])->get();
        return ($cek_data->getRow());
    }

    public function cek_nilai_semester($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $nisn = $data['nisn'];
        $id_mapel = $data['id_mapel'];
        $semester = $data['semester'];
        $cek_data = $this->db->table('tb_nilai_semester')->select('*')->where(['id_sekolah' => $id_sekolah, 'nisn' => $nisn, 'id_mapel' => $id_mapel, 'semester' => $semester])->get();
        return ($cek_data->getRow());
    }

    public function update_nilai($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $nisn = $data['nisn'];
        $id_mapel = $data['id_mapel'];
        $id_tugas = $data['id_tugas'];
        $nilai = $data['nilai'];
        $this->db->table('tb_nilai_siswa')->where([
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_mapel' => $id_mapel,
            'id_tugas' => $id_tugas
        ])->update(['nilai' => $nilai]);
    }

    public function update_nilai_semester($data)
    {
        $id_sekolah = $data['id_sekolah'];
        $nisn = $data['nisn'];
        $id_mapel = $data['id_mapel'];
        $semester = $data['semester'];
        $nilai = $data['nilai'];
        $status = $data['status'];
        $this->db->table('tb_nilai_semester')->where([
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'id_mapel' => $id_mapel,
            'semester' => $semester,
        ])->update(['nilai' => $nilai, 'status' => $status]);
    }

    public function insert_nilai($data)
    {
        $this->db->table('tb_nilai_siswa')->insert($data);
        $lastInsertedID = $this->db->insertID();
        return $lastInsertedID;
    }

    public function insert_nilai_semester($data)
    {
        $this->db->table('tb_nilai_semester')->insert($data);
        $lastInsertedID = $this->db->insertID();
        return $lastInsertedID;
    }

    public function update_nilai_tp($data)
    {
        $id_nilai_siswa = $data['id_nilai_siswa'];
        $id_tugas_tp = $data['id_tugas_tp'];
        $status = $data['status'];
        $this->db->table('tb_nilai_tp')->where(['id_nilai_siswa' => $id_nilai_siswa, 'id_tugas_tp' => $id_tugas_tp])->update(['status' => $status]);
    }

    public function insert_nilai_tp($data)
    {
        $this->db->table('tb_nilai_tp')->insert($data);
    }

    public function get_id_elemen($id_sekolah, $id_projek)
    {
        $sql = "SELECT id FROM tb_dimensi_projek 
                WHERE id_sekolah = :id_sekolah:  
                AND id_projek = :id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query->getResultArray();
    }

    public function get_daftar_kelas($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT kelas FROM tb_mapel 
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:
                GROUP BY kelas";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function simpanKopRapor($id_sekolah, $tahun_ajaran, $kop_rapor)
    {
        $sql = "UPDATE tb_info_sekolah SET kop_rapor = :kop_rapor: 
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kop_rapor' => $kop_rapor,
        ]);
    }

    public function simpanBobotNilai($id_sekolah, $tahun_ajaran, $bobot_nilai)
    {
        $sql = "UPDATE tb_info_sekolah SET bobot_tes = :bobot_nilai: 
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'bobot_nilai' => $bobot_nilai,
        ]);
    }

    public function simpanTglMid($id_sekolah, $tahun_ajaran, $idx_mid, $tgl_mid)
    {
        if ($idx_mid == 0) {
            $settglmid = "tgl_awal_ganjil = :tgl_mid: ";
        } else if ($idx_mid == 1) {
            $settglmid = "tgl_mid_ganjil = :tgl_mid: ";
        } else if ($idx_mid == 2) {
            $settglmid = "tgl_akhir_ganjil = :tgl_mid: ";
        } else if ($idx_mid == 3) {
            $settglmid = "tgl_awal_genap = :tgl_mid: ";
        } else if ($idx_mid == 4) {
            $settglmid = "tgl_mid_genap = :tgl_mid: ";
        } else if ($idx_mid == 5) {
            $settglmid = "tgl_akhir_genap = :tgl_mid: ";
        }

        $sql = "UPDATE tb_info_sekolah 
        SET " . $settglmid . "    
        WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'tgl_mid' => $tgl_mid,
        ]);
    }

    public function simpan_jadwal_ujian($id_sekolah, $data)
    {
        $id = $data['id'];
        $tgl = $data['jadwal_semester_ganjil_tgl'];
        $jam = $data['jadwal_semester_ganjil_jam'];
        $tgl2 = $data['jadwal_semester_genap_tgl'];
        $jam2 = $data['jadwal_semester_genap_jam'];

        $sql = "UPDATE tb_mapel SET jadwal_semester_ganjil_tgl = '" . $tgl . "', jadwal_semester_ganjil_jam = '" . $jam . "', jadwal_semester_genap_tgl = '" . $tgl2 . "', jadwal_semester_genap_jam = '" . $jam2 . "' WHERE id_sekolah = :id_sekolah: AND id = " . $id;

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);
    }

    public function daftar_projek($id_sekolah, $kelas, $tahun)
    {
        $sql = "SELECT * FROM tb_projek WHERE id_sekolah = :id_sekolah: AND kelas = :kelas: AND tahun_ajaran = :tahun:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function rekap_nilai($id_sekolah, $kelas, $rombel, $semester, $mulai, $akhir, $tahun, $sort)
    {
        if ($sort == "nama") {
            $sort = "nama, nisn";
        } else if ($sort == "nilai") {
            $sort = "total_nilai DESC, nisn, nama";
        } else {
            $sort = "nisn";
        }
        $sql = "SELECT ss.nisn, ss.nis, s.nama, r.id AS id_rombel, m.id AS id_mapel, gm.id AS id_guru_mapel, 
                t.id AS id_tugas, AVG(ns.nilai) AS nilai_rata_rata, nsm.nilai AS nilai_ujian, 
                (AVG(ns.nilai)*0.4 + nsm.nilai*0.6) AS nilai_akhir, SUM(AVG(ns.nilai)*0.4 + nsm.nilai*0.6) OVER (PARTITION BY ss.nisn) AS total_nilai, cn.catatan_ganjil,cn.catatan_genap,cn.status_naik  
                FROM tb_siswa_sekolah ss
                LEFT JOIN tb_siswa s ON ss.nisn=s.nisn
                LEFT JOIN tb_rombel r ON ss.id_sekolah=r.id_sekolah AND ss.kelas=r.kelas AND ss.nama_rombel=r.nama_rombel
                JOIN tb_mapel m ON ss.kelas=m.kelas AND m.id_sekolah =:id_sekolah: AND ss.tahun_ajaran=m.tahun_ajaran
                LEFT JOIN tb_guru_mapel gm ON r.id=gm.id_rombel AND m.id=gm.id_mapel
                LEFT JOIN tb_tugas t ON gm.id=t.id_guru_mapel AND tanggal_tugas>='" . $mulai . "' AND tanggal_tugas<='" . $akhir . "'
                LEFT JOIN tb_nilai_siswa ns ON ss.id_sekolah=ns.id_sekolah AND ss.nisn=ns.nisn AND t.id=ns.id_tugas 
                LEFT JOIN tb_nilai_semester nsm ON ss.id_sekolah=nsm.id_sekolah 
                AND ss.nisn=nsm.nisn AND m.id=nsm.id_mapel AND semester=:semester:
                LEFT JOIN tb_catatan_naik cn ON ss.id_sekolah=cn.id_sekolah 
                AND ss.nisn=cn.nisn AND tahun=:tahun: 
                WHERE ss.id_sekolah = :id_sekolah: 
                AND ss.tahun_ajaran=:tahun: and soft_delete=0 AND status_pindah=0 
                AND ss.kelas=:kelas: AND ss.nama_rombel = :rombel: 
                AND ((jenis = 2 AND m.sub_kelas = r.sub_kelas) OR jenis = 1 OR (jenis = 0 AND m.nama_mapel LIKE CONCAT('%', agama, '%')))
                GROUP BY
                    ss.nisn, 
                    r.id,
                    m.id,
                    gm.id
                ORDER BY " . $sort . ", id_mapel";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tahun' => $tahun,
            'semester' => $semester,
        ]);

        return $query->getResultArray();
    }

    public function daf_mapel_sekolah($id_sekolah, $kelas, $rombel, $tahun)
    {
        $sql = "SELECT sub_kelas FROM tb_rombel 
                WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND nama_rombel = :rombel: 
                ORDER BY tahun_mulai DESC";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tahun' => $tahun,
        ]);

        $subkelas = $query->getRow()->sub_kelas;

        $sql = "SELECT m.jenis,m.kd_mapel,m.nama_mapel FROM tb_mapel m
                WHERE id_sekolah=:id_sekolah: AND kelas=:kelas: AND tahun_ajaran=:tahun: AND ((jenis = 2 AND sub_kelas = '" . $subkelas . "') OR jenis = 1 OR (jenis = 0 AND m.nama_mapel LIKE CONCAT('%', 'Islam', '%')))";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tahun' => $tahun,
        ]);

        return $query->getResultArray();
    }

    public function simpan_catatannaik($id_sekolah, $nisn, $tahun, $semester, $catatan, $kenaikan)
    {
        $sql = "SELECT * FROM tb_catatan_naik 
                WHERE id_sekolah=:id_sekolah: AND nisn=:nisn: AND tahun=:tahun: ";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nisn' => $nisn,
            'tahun' => $tahun,
        ]);

        $cekrow = $query->getRow();

        if ($semester == 1)
            $suffiks = "_ganjil";
        else
            $suffiks = "_genap";

        if ($cekrow) {
            $sql2 = "UPDATE tb_catatan_naik SET catatan" . $suffiks . " = :catatan:, status_naik=:kenaikan: WHERE id_sekolah=:id_sekolah: AND nisn=:nisn: AND tahun=:tahun: ";
            $query2 = $this->db->query($sql2, [
                'catatan' => $catatan,
                'kenaikan' => $kenaikan,
                'id_sekolah' => $id_sekolah,
                'nisn' => $nisn,
                'tahun' => $tahun,
            ]);
        } else {
            $sql2 = "INSERT INTO tb_catatan_naik (id_sekolah, nisn, tahun, catatan" . $suffiks . ", status_naik) VALUES (:id_sekolah:, :nisn:, :tahun:, :catatan:, :kenaikan:)";

            $query2 = $this->db->query($sql2, [
                'id_sekolah' => $id_sekolah,
                'nisn' => $nisn,
                'tahun' => $tahun,
                'catatan' => $catatan,
                'kenaikan' => $kenaikan,
            ]);
        }
    }

    public function get_daftar_pengumuman($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT * FROM tb_pengumuman WHERE id_sekolah=:id_sekolah: AND tahun_ajaran=" . $tahun_ajaran;

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function get_pengumuman($id_sekolah, $tgl_sekarang)
    {
        $sql2 = "SELECT * FROM tb_pengumuman WHERE id_sekolah=:id_sekolah: AND tanggal_mulai<='" . $tgl_sekarang . "' AND tanggal_selesai>='" . $tgl_sekarang . "'";

        $query2 = $this->db->query($sql2, [
            'id_sekolah' => $id_sekolah,
            'tgl_sekarang' => $tgl_sekarang,
        ]);

        return $query2->getResultArray();
    }

    public function edit_pengumuman($id_sekolah, $id)
    {
        $sql2 = "SELECT * FROM tb_pengumuman WHERE id_sekolah=:id_sekolah: AND id=:id:";

        $query2 = $this->db->query($sql2, [
            'id_sekolah' => $id_sekolah,
            'id' => $id,
        ]);

        return $query2->getRowArray();
    }

    public function tambah_pengumuman($id_sekolah, $tgl_mulai, $tgl_selesai, $judul, $pengumuman, $tahun)
    {
        $sql2 = "INSERT INTO tb_pengumuman (id_sekolah, tanggal_mulai, tanggal_selesai, judul, pengumuman, tahun_ajaran) VALUES (:id_sekolah:, :tgl_mulai:, :tgl_selesai:, :judul:, :pengumuman:, :tahun:)";

        $query2 = $this->db->query($sql2, [
            'id_sekolah' => $id_sekolah,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'judul' => $judul,
            'pengumuman' => $pengumuman,
            'tahun' => $tahun
        ]);
    }

    public function update_pengumuman($id_pengumuman, $tgl_mulai, $tgl_selesai, $judul, $pengumuman)
    {
        $sql2 = "UPDATE tb_pengumuman SET tanggal_mulai=:tgl_mulai:, tanggal_selesai=:tgl_selesai:, judul=:judul:, pengumuman=:pengumuman: WHERE id=:id_pengumuman:";

        $query2 = $this->db->query($sql2, [
            'id_pengumuman' => $id_pengumuman,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'judul' => $judul,
            'pengumuman' => $pengumuman
        ]);
    }

    public function hapus_pengumuman($id_sekolah, $id_projek)
    {
        $sql = "DELETE FROM tb_pengumuman WHERE id_sekolah=:id_sekolah: AND id=:id_projek:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_projek' => $id_projek,
        ]);

        return $query;
    }

    public function cekSiswaWali($id_sekolah, $nis, $kelas, $rombel, $tahun_ajaran)
    {
        $sql = "SELECT nisn FROM tb_siswa_sekolah WHERE id_sekolah=:id_sekolah: AND nis=:nis: AND kelas=:kelas: AND nama_rombel=:rombel: AND tahun_ajaran=:tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nis' => $nis,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        $result = $query->getRowArray();

        return $result;
    }
}
