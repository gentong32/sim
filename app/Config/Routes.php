<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('/login/createpassword/(:any)', 'Login::createpassword/$1');
$routes->get('/login/cekpassword/(:any)/(:any)', 'Login::cekpassword/$1/$2');
$routes->get('/login/change_password', 'Login::change_password', ['filter' => 'ceknpsn']);

$routes->get('/home', 'Home::index');

$routes->get('/presensi', 'Presensi::index');
$routes->get('/presensi/get_data_presensi', 'Presensi::get_data_presensi');
$routes->get('/presensi_rekap', 'Presensi::rekap');
$routes->post('/presensi/simpan_presensi', 'Presensi::simpan_presensi');
$routes->get('/absensi/saya', 'Presensi::absensi_siswa');
$routes->get('/absensi/siswa', 'Presensi::absensi_siswa_nis');

$routes->get('/kepribadian', 'Kepribadian::index');
$routes->get('/kepribadian/get_data_kepribadian', 'Kepribadian::get_data_kepribadian');
$routes->get('/kepribadian_rekap', 'Kepribadian::rekap');
$routes->post('/kepribadian/simpan_kepribadian', 'Kepribadian::simpan_kepribadian');

$routes->get('/agenda', 'Agenda::index');
$routes->post('/agenda/simpan_agenda_kelas', 'Agenda::simpan_agenda_kelas');
$routes->post('/agenda/hapus_agenda_kelas', 'Agenda::hapus_agenda_kelas');
$routes->get('/agenda/list_agenda', 'Agenda::list_agenda');

$routes->get('/tujuan_pembelajaran', 'Tujuanpembelajaran::index');
$routes->post('/tujuan_pembelajaran/simpan_tj_pem', 'Tujuanpembelajaran::simpan_tj_pem');
$routes->post('/tujuan_pembelajaran/update_tj_pem', 'Tujuanpembelajaran::update_tj_pem');
$routes->post('/tujuan_pembelajaran/hapus_tj_pem', 'Tujuanpembelajaran::hapus_tj_pem');
$routes->post('/tujuan_pembelajaran/simpan_tj_pem_eks', 'Tujuanpembelajaran::simpan_tj_pem_eks');
$routes->post('/tujuan_pembelajaran/update_tj_pem_eks', 'Tujuanpembelajaran::update_tj_pem_eks');
$routes->post('/tujuan_pembelajaran/hapus_tj_pem_eks', 'Tujuanpembelajaran::hapus_tj_pem_eks');

$routes->get('/tugas', 'Tugas::index');
$routes->get('/tugas/get_tujuan_pembelajaran', 'Tugas::get_tujuan_pembelajaran');
$routes->post('/tugas/simpan_tugas', 'Tugas::simpan_tugas');
$routes->post('/tugas/hapus_tugas', 'Tugas::hapus_tugas');
$routes->get('/tugas/saya', 'Tugas::tugas_siswa');

$routes->get('/nilai', 'Nilai::index');
$routes->post('/nilai/simpan_nilai', 'Nilai::simpan_nilai');
$routes->post('/nilai/get_daftar_elemen_sekolah', 'Nilai::get_daftar_elemen_sekolah');
$routes->get('/nilai/get_daftar_nilai_p5', 'Nilai::get_daftar_nilai_p5');
$routes->post('/nilai/simpan_nilai_p5', 'Nilai::simpan_nilai_p5');
$routes->get('/nilai/get_rombel/(:any)', 'Nilai::get_rombel/$1');
$routes->get('/nilai/get_daftar_nilai_eks', 'Nilai::get_daftar_nilai_eks');
$routes->post('/nilai/simpan_nilai_eks', 'Nilai::simpan_nilai_eks');
$routes->get('/nilai/get_daftar_indikator_eks', 'Nilai::get_daftar_indikator_eks');
$routes->get('/nilai/rekap_nilai', 'Nilai::rekap_nilai');
$routes->post('/nilai/simpanrekap', 'Nilai::simpanrekap');

$routes->get('/nilai/saya', 'Nilai::nilai_siswa');

$routes->get('/peserta_ekskul', 'User::peserta_ekskul');

$routes->get('/ekskul_saya', 'User::ekskul_siswa');
$routes->post('/simpan_ekskul', 'User::simpan_ekskul_siswa');

$routes->get('/nilai/testabel', 'Nilai::testabel');

$routes->get('/buatrapor/raporPDF', 'Buatrapor::raporPDF');

$routes->get('/pengumuman', 'Pengumuman::index');
$routes->get('/pengumuman/daftar', 'Pengumuman::daftar');
$routes->get('/pengumuman/baru', 'Pengumuman::pengumuman_baru');
$routes->get('/pengumuman/edit/(:any)', 'Pengumuman::pengumuman_edit/$1');
$routes->post('/pengumuman/simpanpengumuman', 'Pengumuman::simpanpengumuman');
$routes->post('/pengumuman/hapuspengumuman', 'Pengumuman::hapuspengumuman');

$routes->get('/admin/tes', 'Admin::tes');

$routes->get('/get_rombel_kelas/(:any)', 'User::get_rombel_kelas/$1');

$routes->post('/login/authenticate', 'Login::authenticate');
$routes->post('/login/cek_passlama', 'Login::cek_passlama');
$routes->post('/login/update_password', 'Login::update_password');
$routes->get('/login/logout', 'Login::logout');
$routes->get('/superadmin', 'Superadmin::index');
$routes->get('/superadmin/user', 'Superadmin::user');
$routes->get('/superadmin/tambah_admin', 'Superadmin::tambah_admin');
$routes->post('/superadmin/cek_email_admin', 'Superadmin::cek_email_admin');
$routes->post('/superadmin/simpan_admin', 'Superadmin::simpan_admin');
$routes->get('/superadmin/edit_admin/(:any)', 'Superadmin::edit_admin/$1');
$routes->post('/superadmin/update_admin', 'Superadmin::update_admin');
$routes->post('/superadmin/hapus_admin', 'Superadmin::hapus_admin');
$routes->get('/superadmin/reset_admin_pass/(:any)', 'Superadmin::reset_admin_pass/$1');
$routes->get('/superadmin/kalender', 'Superadmin::kalender');
$routes->post('/superadmin/simpan_kalender', 'Superadmin::simpan_kalender');
$routes->post('/superadmin/hapus_kalender', 'Superadmin::hapus_kalender');
$routes->get('/superadmin/list_kalender', 'Superadmin::list_kalender');
// $routes->get('upload', 'Modul::uploadForm');
// $routes->post('upload', 'Modul::uploadPdf');
$routes->get('/admin/input_sekolah', 'Admin::input_sekolah');
$routes->get('/admin/cek', 'Admin::cek');
$routes->post('/admin/cek_npsn', 'Admin::cek_npsn');
$routes->post('/admin/cek_email_sekolah', 'Admin::cek_email_sekolah');
$routes->post('/admin/simpan_sekolah', 'Admin::simpan_sekolah');
$routes->post('/admin/upload_data/(:any)', 'Admin::upload_data/$1');
$routes->post('/admin/cek_nuptk_sekolah', 'Admin::cek_nuptk_sekolah');
$routes->post('/admin/cek_nisn_sekolah', 'Admin::cek_nisn_sekolah');
$routes->post('/admin/cek_nis_sekolah', 'Admin::cek_nis_sekolah');
$routes->post('/admin/simpan_guru', 'Admin::simpan_guru');
$routes->post('/admin/update_guru', 'Admin::update_guru');
$routes->post('/admin/simpan_siswa', 'Admin::simpan_siswa');
$routes->post('/admin/update_siswa', 'Admin::update_siswa');
$routes->post('/admin/simpan_staf', 'Admin::simpan_staf');
$routes->post('/admin/update_staf', 'Admin::update_staf');
$routes->post('/admin/hapus_guru_sekolah', 'Admin::hapus_guru_sekolah');
$routes->post('/admin/hapus_siswa_sekolah', 'Admin::hapus_siswa_sekolah');
$routes->post('/admin/hapus_staf_sekolah', 'Admin::hapus_staf_sekolah');
$routes->post('/admin/reset_guru_pass', 'Admin::reset_guru_pass');
$routes->post('/admin/reset_siswa_pass', 'Admin::reset_siswa_pass');
$routes->post('/admin/reset_staf_pass', 'Admin::reset_staf_pass');
$routes->post('admin/simpan_kepsek', 'Admin::simpan_kepsek');
$routes->post('admin/upload_tdtgn', 'Admin::upload_tdtgn');
$routes->post('admin/simpan_mapel_pilihan_kelas', 'Admin::simpan_mapel_pilihan_kelas');
$routes->post('admin/simpan_rombel', 'Admin::simpan_rombel');
$routes->post('admin/update_rombel', 'Admin::update_rombel');
$routes->post('admin/hapus_rombel', 'Admin::hapus_rombel');
$routes->post('admin/get_rombel_mapel', 'Admin::get_rombel_mapel');
$routes->post('admin/simpan_guru_mapel', 'Admin::simpan_guru_mapel');
$routes->post('admin/hapus_mapel', 'Admin::hapus_mapel');
$routes->post('admin/simpan_mapel', 'Admin::simpan_mapel');
$routes->post('admin/simpan_siswa_pindah', 'Admin::simpan_siswa_pindah');
$routes->post('admin/simpan_projek', 'Admin::simpan_projek');
$routes->post('admin/update_projek', 'Admin::update_projek');
$routes->post('admin/hapus_projek', 'Admin::hapus_projek');
$routes->post('admin/simpan_penilaian/(:any)', 'Admin::simpan_penilaian/$1');
$routes->post('admin/simpan_ekskul', 'Admin::simpan_ekskul');
$routes->post('admin/update_ekskul', 'Admin::update_ekskul');
$routes->post('admin/hapus_ekskul', 'Admin::hapus_ekskul');
$routes->post('admin/simpan_agenda', 'Admin::simpan_agenda');
$routes->post('admin/hapus_agenda', 'Admin::hapus_agenda');
$routes->post('admin/simpanKopRapor', 'Admin::simpanKopRapor');
$routes->post('admin/simpan_mid', 'Admin::simpan_mid');
$routes->post('admin/simpan_bobot_nilai', 'Admin::simpan_bobot_nilai');
$routes->post('admin/simpan_jadwal_ujian', 'Admin::simpan_jadwal_ujian');

$routes->post('user/simpan_siswa_ekskul', 'User::simpan_siswa_ekskul');
$routes->post('user/hapus_siswa_ekskul', 'User::hapus_siswa_ekskul');

$routes->group('admin', ['filter' => 'ceknpsn'], function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('info_sekolah', 'Admin::info_sekolah');
    $routes->get('edit_sekolah', 'Admin::edit_sekolah');
    $routes->get('info_impor', 'Admin::info_impor');
    $routes->get('user', 'Admin::user');
    $routes->get('unduh_data_guru', 'Admin::unduh_data_guru');
    $routes->get('unduh_data_siswa', 'Admin::unduh_data_siswa');
    $routes->get('unduh_data_staf', 'Admin::unduh_data_staf');
    $routes->get('tambah_guru', 'Admin::tambah_guru');
    $routes->get('edit_guru/(:any)', 'Admin::edit_guru/$1');
    $routes->get('tambah_siswa', 'Admin::tambah_siswa');
    $routes->get('edit_siswa/(:any)', 'Admin::edit_siswa/$1');
    $routes->get('tambah_staf', 'Admin::tambah_staf');
    $routes->get('edit_staf/(:any)', 'Admin::edit_staf/$1');
    $routes->get('siswa_kelas', 'Admin::siswa_kelas');
    $routes->get('eksporDataGuru', 'Admin::eksporDataGuru');
    $routes->get('eksporDataSiswa', 'Admin::eksporDataSiswa');
    $routes->get('eksporDataStaf', 'Admin::eksporDataStaf');
    $routes->get('kepsek', 'Admin::kepsek');
    $routes->get('mapel', 'Admin::mapel');
    $routes->get('mapel_pilihan', 'Admin::mapel_pilihan');
    $routes->get('guru_mapel', 'Admin::guru_mapel');
    $routes->get('rombel', 'Admin::rombel');
    $routes->get('get_sub_kelas_mapel/(:any)', 'Admin::get_sub_kelas_mapel/$1');
    $routes->get('get_mapel/(:any)', 'Admin::get_mapel/$1');
    $routes->get('get_rombel_kelas/(:any)', 'Admin::get_rombel_kelas/$1');
    $routes->get('siswa_kelas/(:any)', 'Admin::siswa_kelas/$1');
    $routes->get('get_daftar_siswa', 'Admin::get_daftar_siswa');
    $routes->get('projek', 'Admin::projek');
    $routes->get('dimensi', 'Admin::dimensi');
    $routes->get('dimensi/(:any)', 'Admin::dimensi/$1');
    $routes->get('dimensi_penilaian/(:any)', 'Admin::dimensi_penilaian/$1');
    $routes->get('ekskul', 'Admin::ekskul');
    $routes->get('agenda', 'Admin::agenda');
    $routes->get('list_agenda', 'Admin::list_agenda');
    $routes->get('jadwal_ujian', 'Admin::jadwal_ujian');
    $routes->get('bobot_nilai', 'Admin::bobot_nilai');
    $routes->get('kop_rapor', 'Admin::kop_rapor');
    $routes->get('kalender_sekolah', 'Admin::kalender_sekolah');
    $routes->get('simpan_mid', 'Admin::simpan_mid');
    $routes->get('pengumuman', 'Admin::pengumuman');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
