<?php

namespace App\Http\Controllers;

use Auth;
use App\Jadwal;
use App\Hari;
use App\Kelas;
use App\Guru;
use App\Siswa;
use App\Ruang;
use App\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use PDF;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $hari = Hari::all();
        $kelas = Kelas::where('tahun_ajaran',isset($tahunajaran) ? $tahunajaran->nama : '0' )->OrderBy('nama_kelas', 'asc')->get();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('admin.jadwal.index', compact('hari', 'kelas', 'guru', 'ruang','tahunajaran'));
    }

      public function indexGuest()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $hari = Hari::all();
        $kelas = Kelas::where('tahun_ajaran',isset($tahunajaran) ? $tahunajaran->nama : '0' )->OrderBy('nama_kelas', 'asc')->get();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('guest.jadwal.index', compact('hari', 'kelas', 'guru', 'ruang','tahunajaran'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'hari_id' => 'required',
            'nama_kelas' => 'required',
            'guru_id' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruang_id' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        $guru = Guru::findorfail($request->guru_id);
        Jadwal::updateOrCreate(
            [
                'id' => $request->jadwal_id
            ],
            [
                'hari_id' => $request->hari_id,
                'nama_kelas' => $request->nama_kelas,
                'mapel_id' => $guru->mapel_id,
                'guru_id' => $request->guru_id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruang_id' => $request->ruang_id,
                'tahun_ajaran' => $request->tahun_ajaran,
            ]
        );

        return redirect()->back()->with('success', 'Data jadwal berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$tahunajaran)
    {
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        $jadwal = Jadwal::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        return view('admin.jadwal.show', compact('jadwal', 'kelas'));
    }

      public function showJadwalForGuest($id,$tahunajaran)
    {
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        $jadwal = Jadwal::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        return view('guest.jadwal.show', compact('jadwal', 'kelas'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id, $tahunajaran)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::findorfail($id);
        $hari = Hari::all();
        $kelas = Kelas::all();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'hari', 'kelas', 'guru', 'ruang', 'tahunajaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findorfail($id);
        $jadwal->delete();

        return redirect()->back()->with('warning', 'Data jadwal berhasil dihapus! (Silahkan cek trash data jadwal)');
    }

    public function trash()
    {
        $jadwal = Jadwal::onlyTrashed()->get();
        return view('admin.jadwal.trash', compact('jadwal'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::withTrashed()->findorfail($id);
        $jadwal->restore();
        return redirect()->back()->with('info', 'Data jadwal berhasil direstore! (Silahkan cek data jadwal)');
    }

    public function kill($id)
    {
        $jadwal = Jadwal::withTrashed()->findorfail($id);
        $jadwal->forceDelete();
        return redirect()->back()->with('success', 'Data jadwal berhasil dihapus secara permanent');
    }

    public function view(Request $request)
    {
        $jadwal = Jadwal::where('nama_kelas', $request->nama_kelas)->where('tahun_ajaran', $request->tahun_ajaran)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'hari' => $val->hari->nama_hari,
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
            );
        }
        return response()->json($newForm);
    }

    public function jadwalSekarang(Request $request)
    {
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('nama_kelas')->where('hari_id', $request->hari)->where('jam_mulai', '<=', $request->jam)->where('jam_selesai', '>=', $request->jam)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
                'ket' => $val->absen($val->guru_id),
            );
        }
        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $jadwal = Jadwal::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('nama_kelas', $request->id)->get();
        $kelas = Kelas::findorfail($request->nama);
        $pdf = PDF::loadView('jadwal-pdf', ['jadwal' => $jadwal, 'kelas' => $kelas]);
        return $pdf->stream();
        // return $pdf->stream('jadwal-pdf.pdf');
    }

    public function guru()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $jadwal = Jadwal::orderBy('hari_id')->OrderBy('jam_mulai')->where('guru_id', $guru->id)->where('tahun_ajaran', $tahunajaran->nama)->get();
        return view('guru.jadwal', compact('jadwal', 'guru'));
    }



    public function siswa()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas',$siswa->kelas_id)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::orderBy('hari_id')->OrderBy('jam_mulai')->where('nama_kelas', $kelas->nama_kelas)->get();
        return view('siswa.jadwal', compact('jadwal', 'kelas', 'siswa'));
    }

    public function export_excel()
    {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_jadwal', $nama_file);
        Excel::import(new JadwalImport, public_path('/file_jadwal/' . $nama_file));
        return redirect()->back()->with('success', 'Data Siswa Berhasil Diimport!');
    }

    public function deleteAll()
    {
        $jadwal = Jadwal::all();
        if ($jadwal->count() >= 1) {
            Jadwal::whereNotNull('id')->delete();
            Jadwal::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }
    public function deleteJadwalById($id,$tahunajaran)
    {
        $jadwal = Jadwal::where('nama_kelas',$id)->where('tahun_ajaran',$tahunajaran)->get();
        if ($jadwal->count() >= 1) {
            Jadwal::whereNotNull('id')->delete();
            Jadwal::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }


 

     public function showJadwalPerMapel($id,$mapel,$angkatan)
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran->nama)->where('angkatan',$angkatan)->get();
        $jadwal = Jadwal::where('mapel_id', $mapel)->where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran->nama)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        return view('kepsek.daftarjadwal', compact('jadwal', 'kelas'));
    }
}
