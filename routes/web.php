<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/clear-cache', function () {
  Artisan::call('config:clear');
  Artisan::call('cache:clear');
  Artisan::call('config:cache');
  return 'DONE';
});

Auth::routes();
Route::get('/welcome', 'WelcomeController@mainPage');
Route::get('/loginpage', 'WelcomeController@login');
Route::get('/login/cek_email/json', 'UserController@cek_email');
Route::get('/login/cek_password/json', 'UserController@cek_password');
Route::post('/cek-email', 'UserController@email')->name('cek-email')->middleware('guest');
Route::get('/reset/password/{id}', 'UserController@password')->name('reset.password')->middleware('guest');
Route::patch('/reset/password/update/{id}', 'UserController@update_password')->name('reset.password.update')->middleware('guest');
Route::get('/welcomepage', 'HomeController@welcome')->name('welcomepage');
Route::get('/buku-kerja', 'BukuKerjaController@indexGuest')->name('guest.bukukerja');
Route::get('/buku-kerja/{id}', 'BukuKerjaController@listBukuKerjaGuest')->name('guest.bukukerja.list');
Route::get('/bukukerja/download/{name}', 'BukuKerjaController@downloadDokumen')->name('bukukerja.download.');
Route::get('/jadwal-index', 'JadwalController@indexGuest')->name('guest.jadwal');
Route::get('/jadwal-data/{id}/{tahunajaran}', 'JadwalController@showJadwalForGuest')->name('guest.showjadwal');
Route::get('/guru-data', 'GuruController@indexGuest')->name('guest.showGuru');
Route::get('/guru-mapel/{id}', 'GuruController@mapelGuest')->name('guest.gurupermapel');
Route::get('/mapel-guest', 'GuruController@mapelGuestHome')->name('guest.mapel');
Route::get('/guru-data/profile/{id}', 'GuruController@showForGuest')->name('guest.guruprofile');
Route::get('/siswa/angkatan', 'TahunAjaranController@getClassByAngkatanForGuest')->name('guest.listkelas.latest');
Route::get('/kelas-data/{id}/{angkatan}', 'TahunAjaranController@getClassByTahunAjaranGuest')->name('guest.tahunajaran.listkelas');
Route::get('/data-siswa/{id}/{angkatan}/{tahunajaran}', 'SiswaController@siswakelasByAngkatanGuest')->name('guest.kelas.tahunajaran');
Route::get('/siswa-data/profile/{id}', 'SiswaController@showForGuest')->name('guest.siswaprofile');

Route::middleware(['auth'])->group(function () {
  Route::get('/materi-data/download/{name}', 'SiswaController@downloadMateri')->name('materi.download');
  Route::get('/showulangan/{id}/{tahunajaran}/{mapel}', 'UlanganController@showNilaiUlangan')->name('kepsek.ulangan.show');
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/jadwal/sekarang', 'JadwalController@jadwalSekarang');
  Route::get('/profile', 'UserController@profile')->name('profile');
  Route::get('/pengaturan/profile', 'UserController@edit_profile')->name('pengaturan.profile');
  Route::post('/pengaturan/ubah-profile', 'UserController@ubah_profile')->name('pengaturan.ubah-profile');
  Route::get('/pengaturan/edit-foto', 'UserController@edit_foto')->name('pengaturan.edit-foto');
  Route::post('/pengaturan/ubah-foto', 'UserController@ubah_foto')->name('pengaturan.ubah-foto');
  Route::get('/pengaturan/email', 'UserController@edit_email')->name('pengaturan.email');
  Route::post('/pengaturan/ubah-email', 'UserController@ubah_email')->name('pengaturan.ubah-email');
  Route::get('/pengaturan/password', 'UserController@edit_password')->name('pengaturan.password');
  Route::post('/pengaturan/ubah-password', 'UserController@ubah_password')->name('pengaturan.ubah-password');
  Route::get('/listangkatan', 'TahunAjaranController@listangkatan')->name('kepsek.listangkatan');
  Route::get('/listangkatan-ulangan', 'TahunAjaranController@listangkatanForUlangan')->name('kepsek.listangkatan.ulangan');
  Route::get('/listangkatan-rapot', 'TahunAjaranController@listangkatanForRapot')->name('kepsek.listangkatan.rapot');
  Route::get('/datakelas/{id}/{angkatan}', 'TahunAjaranController@getClassByTahunAjaran')->name('kepsek.tahunajaran.listkelas');
  Route::get('/datakelas-ulangan/{id}/{angkatan}', 'TahunAjaranController@dataClassByTahunAjaranForUlangan')->name('kepsek.tahunajaran.listkelas-ulangan');

  Route::get('/datakelas-rapot/{id}/{angkatan}', 'TahunAjaranController@dataClassByTahunAjaranForRapot')->name('kepsek.tahunajaran.listkelas-rapot');
  Route::get('/mapel/{idKelas}', 'SiswaController@mapelByClass')->name('listmapelbyclass');
  Route::get('/mapel-ulangan/{idKelas}', 'SiswaController@mapelByClassForULangan')->name('listmapelbyclass-ulangan');
  Route::get('/mapel-rapot/show/{idKelas}/{mapelId}', 'RapotController@showRapot')->name('showrapot.mapel');
  Route::get('/mapel-rapot/{idKelas}', 'SiswaController@mapelByClassForRapot')->name('listmapelbyclass-rapot');
  Route::get('/datakelas/{id}/{angkatan}', 'TahunAjaranController@dataClassByTahunAjaran')->name('kepsek.tahunajaran.listkelas');
  Route::get('/jadwal', 'JadwalController@viewJadwal')->name('kepsek.listjadwal');
  Route::get('/jadwalujian', 'JadwalUjianController@viewJadwal')->name('kepsek.listjadwal');
  Route::get('/absensi/{id}/{mapel}/{angkatan}', 'JadwalController@showJadwalPerMapel');
  Route::get('/siswa/absensi/{idJadwal}', 'SiswaController@showAbsesnsiPerMapel')->name('kepsek.absesnsi.detail');
  Route::get('/dokumen/absensi/{name}', 'SiswaController@downloadDokumenAbsensi')->name('kepsek.download.absensi');
  Route::get('/guru/List/{mapelId}', 'GuruController@showGuruPerMapel')->name('kepsek.listguru');
  Route::get('/daftarkelas/update', 'TahunAjaranController@getClassByAngkatanLatest')->name('admin.listkelas.latest');

  Route::get('/profile/guru/{nip}', 'GuruController@detailGuru')->name('kepsek.detailguru');
  Route::get('/bukukerja', 'BukuKerjaController@index')->name('admin.bukukerja');
  Route::get('/bukukerja/{id}', 'BukuKerjaController@listBukuKerja')->name('admin.bukukerja.list');
  Route::post('/bukukerja/create', 'BukuKerjaController@create');
  Route::delete('/bukukerja/delete/{id}', 'BukuKerjaController@destroy')->name('bukukerja.destroy');

  Route::middleware(['siswa'])->group(function () {
    Route::get('/jadwal/siswa', 'JadwalController@siswa')->name('jadwal.siswa');
    Route::get('/ulangan/siswa', 'UlanganController@siswa')->name('ulangan.siswa');
    Route::get('/sikap/siswa', 'SikapController@siswa')->name('sikap.siswa');
    Route::get('/rapot/siswa', 'RapotController@siswa')->name('rapot.siswa');
    Route::get('/listmapel', 'SiswaController@mapelSiswa')->name('listmapel.siswa');
    Route::get('/siswa/abnsensi', 'SiswaController@mapelSiswaForAbsen')->name('absesnsi.siswa');
    Route::get('/mapel-siswa/materi', 'SiswaController@showMateri')->name('siswa.mapel.materi');
    Route::get('/mapel/materi/{id}', 'SiswaController@showDetailMateri')->name('siswa.mapel.materi.detail');
    Route::get('/materi/download/{name}', 'SiswaController@downloadMateri')->name('siswa.mapel.materi.download');
    Route::get('/siswa/absensi/{idmapel}', 'SiswaController@showJadwalPerMapel')->name('siswa.absesnsi.detail');
    Route::get('/siswa/absen/{idJadwal}', 'SiswaController@showStudentAbsenDetail')->name('siswa.absesnsi.data');
    Route::get('/materi/download/{name}', 'SiswaController@downloadMateri')->name('siswa.mapel.materi.download');
    Route::get('/jadwal/ujian', 'JadwalUjianController@viewJadwalUjianSiswa')->name('siswa.jadwal.ujian');
    Route::get('/siswa/ujian/{id}', 'UlanganController@mulaiUjian');
    Route::post('/siswa/ujian/submitJawaban', 'UlanganController@simpanUjianJawaban')->name('siswa.ujian.submit');
    Route::post('/siswa/ujian/selesai', 'UlanganController@selesaiUjian')->name('siswa.ujian.finish');
  });

  Route::middleware(['guru'])->group(function () {
    Route::get('/absen/harian', 'GuruController@absen')->name('absen.harian');
    Route::post('/absen/simpan', 'GuruController@simpan')->name('absen.simpan');
    Route::get('/jadwal/guru', 'JadwalController@guru')->name('jadwal.guru');
    Route::get('/guru/mapelList', 'GuruController@mapelByGuru')->name('guru.mapelByGuru');
    Route::resource('/nilai', 'NilaiController');
    Route::resource('/sikap', 'SikapController');
    Route::get('/rapot/predikat', 'RapotController@predikat');
    Route::resource('/rapot', 'RapotController');
    Route::resource('/guruulangan', 'UlanganController');
    Route::get('/guru/soal', 'GuruController@showPageCreateSoal')->name('guru.soal');
    Route::get('/guru/materi', 'GuruController@getListMateriByClass')->name('guru.listkelas');

    Route::get('/submitulangan/{id}/{tahunajaran}', 'UlanganController@addNilai')->name('guru.ulangan.addnilai');
    Route::get('/show-ulangan', 'UlanganController@showTahunAjaran')->name('guru.ulangan.showTahunAjaran');
    Route::get('/ulanganperclass', 'UlanganController@datakelas')->name('guru.ulangan.showkelas');
    Route::get('/ulanganperclass-kepsek', 'UlanganController@datakelas')->name('kepsek.ulangan.showkelas');
    Route::post('/materi/create', 'MateriController@createMateri');
    Route::post('/soal/create', 'MateriController@createSoal');
    Route::get('/materi/list', 'MateriController@showMateriList');
    Route::get('/soal/list', 'MateriController@showSoalList');
    Route::get('/materi/edit/{id}', 'MateriController@editMateri');
    Route::get('/soal/edit/{id}', 'MateriController@editSoal');
    Route::post('/ulangan/postNilai', 'UlanganController@postNilai')->name('guru.ulangan.post');
    Route::put('/materi/Update/{id}', 'MateriController@updateMateri');
    Route::put('/soal/Update/{id}', 'MateriController@updateSoal');
    // Delete Materi - Teacher
    Route::get('/materi/delete/{id}', 'MateriController@deleteMateri');
    Route::get('/soal/delete/{id}', 'MateriController@deleteSoal');
    Route::get('/absensi', 'GuruController@getListClassByGuruId');
    Route::get('/data-absensi/{id}/{tahunajaran}/{angkatan}', 'GuruController@showJadwalPerClass');
    Route::get('/absensi/input/{id}/{tahunajaran}/{angkatan}/{jadwalId}', 'GuruController@showSiswaForAbsen');
    Route::post('/absensi/inputdata', 'GuruController@inputAbsenSiswa')->name('guru.absensi.input');

    // Jadwal Ujian
    Route::get('/guru/ujianonline/jadwal', 'JadwalUjianController@showJadwalUjianPerGuruLogin')->name('guru.ujianOnline.jadwal');
    Route::get('/guru/ujianonline/jadwal/viewSetModelSoal/{id}', 'JadwalUjianController@viewSetModelSoal')->name('guru.ujianOnline.viewSetModelSoal');
    Route::post('/guru/ujianonline/jadwal/setModelSoal', 'JadwalUjianController@setModelSoal')->name('guru.ujianOnline.setModelSoal');

    // Model Soal
    Route::post('/guru/ujianonline/modelSoal/add', 'UlanganController@simpanModelSoal')->name('guru.ujianOnline.addModelSoal');
    Route::get('/guru/ujianonline/modelSoal/list', 'UlanganController@listModelSoal')->name('guru.ujianOnline.listModelSoal');
    Route::get('/guru/ujianonline/modelSoal/detail/{id}', 'UlanganController@detailModelSoal')->name('guru.ujianOnline.detailModelSoal');

    // Soal
    Route::post('/guru/ujianonline/soal/add/pilihanBerganda', 'UlanganController@simpanSoalPilihanBerganda')->name('guru.ujianOnline.addSoalPilihanBerganda');
    Route::post('/guru/ujianonline/soal/add/essay', 'UlanganController@simpanSoalEssay')->name('guru.ujianOnline.addSoalEssay');
    Route::delete('/guru/ujianonline/soal/softDelete/{id}', 'UlanganController@softDeleteSoal')->name('guru.ujianOnline.softDelete');
    Route::post('/guru/ujianonline/soal/restore/{id}', 'UlanganController@restoreSoal')->name('guru.ujianOnline.restore');
    Route::get('/guru/ujianonline/soal/edit/pilihanBerganda/view/{id}', 'UlanganController@viewEditSoalPilihanBerganda')->name('guru.ujianOnline.viewEditSoalPilihanBerganda');
    Route::put('/guru/ujianonline/soal/edit/pilihanBerganda/{id}', 'UlanganController@editSoalPilihanBerganda')->name('guru.ujianOnline.editSoalPilihanBerganda');
    Route::get('/guru/ujianonline/soal/edit/pilihanBerganda/opsiUpdate/{id}', 'UlanganController@udpateJawabanOpsi')->name('guru.ujianOnline.editOpsiJawaban');
    Route::delete('/guru/ujianonline/soal/edit/pilihanBerganda/hapusOpsi/{id}', 'UlanganController@hapusOpsi')->name('guru.ujianOnline.hapusOpsi');
    Route::post('/guru/ujianonline/soal/edit/pilihanBerganda/tambahOpsi', 'UlanganController@tambahOpsi')->name('guru.ujianOnline.tambahOpsi');
    Route::get('/guru/ujianonline/soal/edit/essay/view/{id}', 'UlanganController@viewEditSoalEssay')->name('guru.ujianOnline.viewEditSoalEssay');
    Route::put('/guru/ujianonline/soal/edit/essay/{id}', 'UlanganController@editSoalEssay')->name('guru.ujianOnline.editSoalEssay');

    // Koreksi
    Route::get('/guru/ujianonline/jadwal/{id}', 'UlanganController@koreksiViewList')->name('guru.ujianOnline.koreksi');
    Route::get('/guru/ujianonline/jadwal/kelas/{id}', 'UlanganController@koreksiViewDetail')->name('guru.ujianOnline.koreksi.detail');
    Route::post('/guru/ujianonline/koreksi/simpanNilai', 'UlanganController@simpanNilai')->name('guru.ujianOnline.koreksi.simpanNilai');

    // Laporan Ujian Online
    Route::get('/guru/ujianonline/laporan', 'NilaiController@viewLaporanUjianOnline')->name('guru.ujianOnline.viewLaporanUjianOnline');
    Route::get('/guru/ujianonline/laporan/search', 'NilaiController@searchLaporanUjianOnlineData')->name('guru.ujianOnline.searchLaporanUjianOnlineData');

  });

  Route::middleware(['trash'])->group(function () {
    Route::get('/jadwal/trash', 'JadwalController@trash')->name('jadwal.trash');
    Route::get('/jadwal/restore/{id}', 'JadwalController@restore')->name('jadwal.restore');
    Route::delete('/jadwal/kill/{id}', 'JadwalController@kill')->name('jadwal.kill');
    Route::get('/jadwaluijian/trash', 'JadwalUjianController@trash')->name('jadwalUjian.trash');
    Route::get('/jadwaluijian/restore/{id}', 'JadwalUjianController@restore')->name('jadwalUjian.restore');
    Route::delete('/jadwaluijian/kill/{id}', 'JadwalUjianController@kill')->name('jadwalUjian.kill');
    Route::get('/guru/trash', 'GuruController@trash')->name('guru.trash');
    Route::get('/guru/restore/{id}', 'GuruController@restore')->name('guru.restore');
    Route::delete('/guru/kill/{id}', 'GuruController@kill')->name('guru.kill');
    Route::get('/kelas/trash', 'KelasController@trash')->name('kelas.trash');
    Route::get('/kelas/restore/{id}', 'KelasController@restore')->name('kelas.restore');
    Route::delete('/kelas/kill/{id}', 'KelasController@kill')->name('kelas.kill');
    Route::get('/siswa/trash', 'SiswaController@trash')->name('siswa.trash');
    Route::get('/siswa/restore/{id}', 'SiswaController@restore')->name('siswa.restore');
    Route::delete('/siswa/kill/{id}', 'SiswaController@kill')->name('siswa.kill');
    Route::get('/mapel-admin/trash', 'MapelController@trash')->name('mapel-admin.trash');
    Route::get('/mapel/restore/{id}', 'MapelController@restore')->name('mapel.restore');
    Route::delete('/mapel/kill/{id}', 'MapelController@kill')->name('mapel.kill');
    Route::get('/user/trash', 'UserController@trash')->name('user.trash');
    Route::get('/user/restore/{id}', 'UserController@restore')->name('user.restore');
    Route::delete('/user/kill/{id}', 'UserController@kill')->name('user.kill');
  });

  Route::resource('/ulangan', 'UlanganController');
  Route::get('/admin/home', 'HomeController@admin')->name('admin.home');
  Route::get('/admin/pengumuman', 'PengumumanController@index')->name('admin.pengumuman');
  Route::resource('/tahunajaran', 'TahunAjaranController');
  Route::get('/kelas/{id}/{angkatan}', 'TahunAjaranController@getClassByTahunAjaran')->name('admin.tahunajaran.listkelas');
  Route::get('/daftarkelas/{id}/', 'TahunAjaranController@getClassByAngkatan')->name('admin.listkelas.angkatan');
  Route::get('/ulangan-kelas/{id}', 'TahunAjaranController@getClassByTahunAjaranForEntry')->name('admin.tahunajaran.daftarkelas');
  Route::post('/admin/pengumuman/simpan', 'PengumumanController@simpan')->name('admin.pengumuman.simpan');
  Route::get('/guru/absensi', 'GuruController@absensi')->name('guru.absensi');
  Route::get('/guru/kehadiran/{id}', 'GuruController@kehadiran')->name('guru.kehadiran');
  Route::get('/absen/json', 'GuruController@json');
  Route::get('/guru/mapel/{id}', 'GuruController@mapel')->name('guru.mapel');

  Route::get('/guru/ubah-foto/{id}', 'GuruController@ubah_foto')->name('guru.ubah-foto');
  Route::post('/guru/update-foto/{id}', 'GuruController@update_foto')->name('guru.update-foto');
  Route::post('/guru/upload', 'GuruController@upload')->name('guru.upload');
  Route::get('/guru/export_excel', 'GuruController@export_excel')->name('guru.export_excel');
  Route::post('/guru/import_excel', 'GuruController@import_excel')->name('guru.import_excel');
  Route::delete('/guru/deleteAll', 'GuruController@deleteAll')->name('guru.deleteAll');
  Route::resource('/guru', 'GuruController');
  Route::get('/kelas/edit/json', 'KelasController@getEdit');
  Route::resource('/kelas', 'KelasController');
  Route::get('/siswa/kelas/{id}', 'SiswaController@kelas')->name('siswa.kelas');
  Route::get('/datasiswa/{id}/{angkatan}/{tahunajaran}', 'SiswaController@siswakelasByAngkatan')->name('datasiswa.kelas.tahunajaran');
  Route::get('/siswa/view/json', 'SiswaController@view');
  Route::get('/listsiswapdf/{id}', 'SiswaController@cetak_pdf');
  Route::get('/siswa/ubah-foto/{id}', 'SiswaController@ubah_foto')->name('siswa.ubah-foto');
  Route::post('/siswa/update-foto/{id}', 'SiswaController@update_foto')->name('siswa.update-foto');
  Route::get('/siswa/export_excel', 'SiswaController@export_excel')->name('siswa.export_excel');
  Route::get('/siswa/exportExcelByClass/{id}/{tahunajaran}', 'SiswaController@exportExcelByClass')->name('siswa.exportExcelByClass');
  Route::post('/siswa/import_excel', 'SiswaController@import_excel')->name('siswa.import_excel');
  Route::post('/siswa/importdata/{id}/{tahunajaran}/{angkatan}', 'SiswaController@import_excelByClass')->name('siswa.import_excel_byclass');
  Route::delete('/siswa/deleteAll', 'SiswaController@deleteAll')->name('siswa.deleteAll');
  Route::delete('/siswa/deleteByClassId/{id}', 'SiswaController@deleteStudentByClass')->name('siswa.deleteStudentByClass');
  Route::resource('/siswa', 'SiswaController');
  Route::get('/mapel/getMapelJson', 'MapelController@getMapelJson');
  Route::resource('/mapel', 'MapelController');
  Route::get('/jadwal/view/json', 'JadwalController@view');
  Route::get('/jadwalkelaspdf/{id}', 'JadwalController@cetak_pdf');
  Route::get('/jadwal/export_excel', 'JadwalController@export_excel')->name('jadwal.export_excel');
  Route::post('/jadwal/import_excel', 'JadwalController@import_excel')->name('jadwal.import_excel');
  Route::delete('/jadwal/deleteAll', 'JadwalController@deleteAll')->name('jadwal.deleteAll');
  Route::delete('/delete/jadwal/{id}/{tahunajaran}', 'JadwalController@deleteJadwalById')->name('jadwal.deleteJadwalKelas');
  Route::get('/jadwal/{id}/{tahunajaran}', 'JadwalController@show')->name('jadwal.showjadwal');
  Route::resource('/jadwal', 'JadwalController');
  Route::get('/ulangan-kelas', 'UlanganController@create')->name('ulangan-kelas');
  Route::get('/ulangan-siswa/{id}', 'UlanganController@edit')->name('ulangan-siswa');
  Route::get('/ulangan-show/{id}', 'UlanganController@ulangan')->name('ulangan-show');
  Route::get('/sikap-kelas', 'SikapController@create')->name('sikap-kelas');
  Route::get('/sikap-siswa/{id}', 'SikapController@edit')->name('sikap-siswa');
  Route::get('/sikap-show/{id}', 'SikapController@sikap')->name('sikap-show');
  Route::get('/rapot-kelas', 'RapotController@create')->name('rapot-kelas');
  Route::get('/rapot-siswa/{id}', 'RapotController@edit')->name('rapot-siswa');
  Route::get('/rapot-show/{id}', 'RapotController@rapot')->name('rapot-show');
  Route::get('/predikat', 'NilaiController@create')->name('predikat');
  Route::resource('/user', 'UserController');

  // Jadwal Ujian
  Route::resource('/jadwalUjian', 'JadwalUjianController');
  Route::get('/jadwalUjian/{id}/{tahunajaran}', 'JadwalUjianController@show')->name('jadwalUjian.showJadwal');
  Route::get('/jadwalUjian/edit/{id}/{tahunajaran}', 'JadwalUjianController@edit')->name('jadwalUjian.showJadwalEdit');
});
