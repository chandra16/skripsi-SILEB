<?php

namespace App\Http\Controllers;

use Auth;
use App\TahunAjaran;
use App\Kelas;
use App\Guru;
use App\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran = TahunAjaran::OrderBy('nama', 'asc')->get();
        return view('admin.tahunajaran.index', compact('tahunajaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    public function show($id)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('admin.tahunajaran.listkelas', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        TahunAjaran::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nama' => $request->nama,

            ]
        );

        return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function getClassByTahunAjaran($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('admin.tahunajaran.listkelas', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }


    public function getClassByTahunAjaranForUlangan($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('kepsek.listkelas-ulangan', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }


    public function getClassByTahunAjaranGuest($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('guest.siswa.listkelas', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }

    public function getClassByAngkatan($id){
        $tahunajaran=$id;
        return view('admin.kelas.kelasbytingkat', compact('tahunajaran'));
    }


    public function getClassByAngkatanLatest(){
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=$tahunajaran_latest->nama;
        return view('admin.kelas.kelasbytingkat', compact('tahunajaran'));
    }

     public function getClassByAngkatanForGuest(){
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=$tahunajaran_latest->nama;
        return view('guest.siswa.kelasbytingkat', compact('tahunajaran'));
    }

     public function listAngkatan(){
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=$tahunajaran_latest->nama;
        return view('kepsek.listAngkatan', compact('tahunajaran'));
    }

      public function listAngkatanForUlangan(){
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=$tahunajaran_latest->nama;
        return view('kepsek.listangkatan-ulangan', compact('tahunajaran'));
    }

        public function listAngkatanForRapot(){
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=$tahunajaran_latest->nama;
        return view('kepsek.listangkatan-rapot', compact('tahunajaran'));
    }

    public function getClassByTahunAjaranForEntry($id)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        return view('admin.nilaiulangan.daftarkelas', compact('kelas','guru','paket','tahunajaran'));
    }

     public function dataClassByTahunAjaran($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('kepsek.listclassbyangkatan', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }

    public function dataClassByTahunAjaranForUlangan($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('kepsek.listkelas-ulangan', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }


  public function dataClassByTahunAjaranForRapot($id,$angkatan)
    {
        $kelas = Kelas::where('tahun_ajaran', $id)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        $paket = Paket::all();
        $tahunajaran=$id;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('kepsek.listkelas-rapot', compact('kelas','guru','paket','tahunajaran','tahunajaran_latest','tingkat'));
    }


   
}
