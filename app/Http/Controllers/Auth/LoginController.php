<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Jadwal;
use App\Guru;
use App\Kehadiran;
use App\TahunAjaran;
use App\Kelas;
use App\Siswa;
use App\Mapel;
use App\User;
use App\Paket;
use App\Pengumuman;
use App\BukuKerja;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=isset($tahunajaran_latest) ? $tahunajaran_latest->nama : '';

        $hari = date('w');
        $jam = date('H:i');
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('nama_kelas')->where('hari_id', $hari)->where('jam_mulai', '<=', $jam)->where('jam_selesai', '>=', $jam)->get();
        $pengumuman = Pengumuman::first();
        $kehadiran = Kehadiran::all();

        $roster = Jadwal::where("tahun_ajaran",$tahunajaran)->count();
        $guru = Guru::count();
        $gurulk = Guru::where('jk', 'L')->count();
        $gurupr = Guru::where('jk', 'P')->count();
        $siswa = Siswa::where("tahun_ajaran",$tahunajaran)->count();
        $siswalk = Siswa::where('jk', 'L')->where("tahun_ajaran",$tahunajaran)->count();
        $siswapr = Siswa::where('jk', 'P')->where("tahun_ajaran",$tahunajaran)->count();
        $bukukerja = BukuKerja::where('tahun_ajaran', $tahunajaran)->count();
        $kelas = Kelas::where("tahun_ajaran",$tahunajaran)->count();
        $bkp = Kelas::where('paket_id', '1')->where("tahun_ajaran",$tahunajaran)->count();
        $dpib = Kelas::where('paket_id', '2')->where("tahun_ajaran",$tahunajaran)->count();
        $ei = Kelas::where('paket_id', '3')->where("tahun_ajaran",$tahunajaran)->count();
        $oi = Kelas::where('paket_id', '4')->where("tahun_ajaran",$tahunajaran)->count();
        $tbsm = Kelas::where('paket_id', '6')->where("tahun_ajaran",$tahunajaran)->count();
        $rpl = Kelas::where('paket_id', '7')->where("tahun_ajaran",$tahunajaran)->count();
        $tpm = Kelas::where('paket_id', '5')->where("tahun_ajaran",$tahunajaran)->count();
        $las = Kelas::where('paket_id', '8')->where("tahun_ajaran",$tahunajaran)->count();
        $mapel = Mapel::where("tahun_ajaran",$tahunajaran)->count();
        $user = User::count();
        $paket = Paket::all();
     
        $data_year = TahunAjaran::OrderBy('nama', 'asc')->get();
        $data_tahun=[];
        $datauser = [];
        foreach ($data_year as $key => $value) {
            $datauser[] = Siswa::where('tahun_ajaran',$value->nama)->count();
            $data_tahun[]=$value->nama;
        }

        $year=json_encode($data_tahun,JSON_NUMERIC_CHECK);
        $countsiswa=json_encode($datauser,JSON_NUMERIC_CHECK);

        $jumlahtahun=$data_year->count();


        return view('auth.login', compact('jadwal', 'pengumuman', 'kehadiran','roster',
            'guru',
            'gurulk',
            'gurupr',
            'siswalk',
            'siswapr',
            'siswa',
            'kelas',
            'bkp',
            'dpib',
            'ei',
            'oi',
            'tbsm',
            'rpl',
            'tpm',
            'las',
            'mapel',
            'user',
            'paket',
            'year',
            'countsiswa',
            'jumlahtahun',
            'bukukerja'));
    }
}
