<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\User;
use App\Kelas;
use App\Siswa;
use App\Jadwal;
use App\Materi;
use App\Mapel;
use App\Soal;
use App\TahunAjaran;
use App\AbsensiMurid;
use App\Exports\SiswaExport;
use App\Exports\SiswaExportByClass;
use App\Imports\SiswaImport;
use App\Imports\SiswaImportByClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        return view('admin.siswa.index', compact('kelas'));
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
            'no_induk' => 'required|string|unique:siswa',
            'nama_siswa' => 'required',
            'jk' => 'required',
            'kelas_id' => 'required',
             'angkatan' => 'required'
        ]);

        if ($request->foto) {
            $foto = $request->foto;
            $new_foto = date('siHdmY') . "_" . $foto->getClientOriginalName();
            $foto->move('uploads/siswa/', $new_foto);
            $nameFoto = 'uploads/siswa/' . $new_foto;
        } else {
            if ($request->jk == 'L') {
                $nameFoto = 'uploads/siswa/52471919042020_male.jpg';
            } else {
                $nameFoto = 'uploads/siswa/50271431012020_female.jpg';
            }
        }

        Siswa::create([
            'no_induk' => $request->no_induk,
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'kelas_id' => $request->kelas_id,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'tahun_ajaran' => $request->tahun_ajaran,
            'angkatan' => $request->angkatan,
            'foto' => $nameFoto
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data siswa baru!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        return view('admin.siswa.details', compact('siswa'));
    }

     public function showForGuest($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        return view('guest.siswa.details', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
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
        $this->validate($request, [
            'nama_siswa' => 'required',
            'jk' => 'required',
            'kelas_id' => 'required',
            'tahun_ajaran' => 'required',
            'angkatan' => 'required'
        ]);

        $siswa = Siswa::findorfail($id);
        $user = User::where('no_induk', $siswa->no_induk)->first();
        if ($user) {
            $user_data = [
                'name' => $request->nama_siswa
            ];
            $user->update($user_data);
        } else {
        }
        $siswa_data = [
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'kelas_id' => $request->kelas_id,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'tahun_ajaran' => $request->tahun_ajaran,
            'angkatan' => $request->angkatan,
        ];
        $siswa->update($siswa_data);

      return redirect()->back()->with('info', 'Data siswa berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findorfail($id);
        $countUser = User::where('no_induk', $siswa->no_induk)->count();
        if ($countUser >= 1) {
            $user = User::where('no_induk', $siswa->no_induk)->first();
            $siswa->delete();
            $user->delete();
            return redirect()->back()->with('warning', 'Data siswa berhasil dihapus! (Silahkan cek trash data siswa)');
        } else {
            $siswa->delete();
            return redirect()->back()->with('warning', 'Data siswa berhasil dihapus! (Silahkan cek trash data siswa)');
        }
    }

    public function trash()
    {
        $siswa = Siswa::onlyTrashed()->get();
        return view('admin.siswa.trash', compact('siswa'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::withTrashed()->findorfail($id);
        $countUser = User::withTrashed()->where('no_induk', $siswa->no_induk)->count();
        if ($countUser >= 1) {
            $user = User::withTrashed()->where('no_induk', $siswa->no_induk)->first();
            $siswa->restore();
            $user->restore();
            return redirect()->back()->with('info', 'Data siswa berhasil direstore! (Silahkan cek data siswa)');
        } else {
            $siswa->restore();
            return redirect()->back()->with('info', 'Data siswa berhasil direstore! (Silahkan cek data siswa)');
        }
    }

    public function kill($id)
    {
        $siswa = Siswa::withTrashed()->findorfail($id);
        $countUser = User::withTrashed()->where('no_induk', $siswa->no_induk)->count();
        if ($countUser >= 1) {
            $user = User::withTrashed()->where('no_induk', $siswa->no_induk)->first();
            $siswa->forceDelete();
            $user->forceDelete();
            return redirect()->back()->with('success', 'Data siswa berhasil dihapus secara permanent');
        } else {
            $siswa->forceDelete();
            return redirect()->back()->with('success', 'Data siswa berhasil dihapus secara permanent');
        }
    }

    public function ubah_foto($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        return view('admin.siswa.ubah-foto', compact('siswa'));
    }

    public function update_foto(Request $request, $id)
    {
        $this->validate($request, [
            'foto' => 'required'
        ]);

        $siswa = Siswa::findorfail($id);
        $foto = $request->foto;
        $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
        $siswa_data = [
            'foto' => 'uploads/siswa/' . $new_foto,
        ];
        $foto->move('uploads/siswa/', $new_foto);
        $siswa->update($siswa_data);

        return redirect()->route('siswa.index')->with('success', 'Berhasil merubah foto!');
    }

    public function view(Request $request)
    {
        $siswa = Siswa::OrderBy('nama_siswa', 'asc')->where('kelas_id', $request->id)->get();

        foreach ($siswa as $val) {
            $newForm[] = array(
                'kelas' => $val->kelas->nama_kelas,
                'no_induk' => $val->no_induk,
                'nama_siswa' => $val->nama_siswa,
                'jk' => $val->jk,
                'foto' => $val->foto
            );
        }

        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $siswa = siswa::OrderBy('nama_siswa', 'asc')->where('kelas_id', $request->id)->get();
        $kelas = Kelas::findorfail($request->id);

        $pdf = PDF::loadView('siswa-pdf', ['siswa' => $siswa, 'kelas' => $kelas]);
        return $pdf->stream();
        // return $pdf->stream('jadwal-pdf.pdf');
    }

    public function kelas($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::where('kelas_id', $id)->OrderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::findorfail($id);
        return view('admin.siswa.show', compact('siswa', 'kelas'));
    }

    public function siswakelasByAngkatan($id,$angkatan,$tahunajaran)
    {

        $siswa = Siswa::where('kelas_id', $id)->where('tahun_ajaran',$tahunajaran)->where('angkatan',$angkatan)->OrderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran',$tahunajaran)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $tahun_ajaran=$tahunajaran;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('admin.siswa.show', compact('siswa', 'kelas','tahun_ajaran','tahunajaran_latest','tingkat'));
    }

     public function siswakelasByAngkatanGuest($id,$angkatan,$tahunajaran)
    {

        $siswa = Siswa::where('kelas_id', $id)->where('tahun_ajaran',$tahunajaran)->where('angkatan',$angkatan)->OrderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran',$tahunajaran)->where('angkatan',$angkatan)->OrderBy('nama_kelas', 'asc')->get();
        $tahun_ajaran=$tahunajaran;
        $tingkat=$angkatan;
        $tahunajaran_latest=TahunAjaran::latest()->first();
        return view('guest.siswa.siswakelas', compact('siswa', 'kelas','tahun_ajaran','tahunajaran_latest','tingkat'));
    }

    public function export_excel()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function exportExcelByClass($nama_kelas,$tahunajaran)
    {
        return Excel::download(new SiswaExportByClass($nama_kelas,$tahunajaran), 'siswa.xlsx');
    }


    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_siswa', $nama_file);
        Excel::import(new SiswaImport, public_path('/file_siswa/' . $nama_file));
        return redirect()->back()->with('success', 'Data Siswa Berhasil Diimport!');
    }

     public function import_excelByClass(Request $request,$nama_kelas,$tahunajaran,$angkatan)
        {
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            $file = $request->file('file');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('file_siswa', $nama_file);
            Excel::import(new SiswaImportByClass($nama_kelas,$tahunajaran,$angkatan), public_path('/file_siswa/' . $nama_file));
            return redirect()->back()->with('success', 'Data Siswa Berhasil Diimport!');
        }
    public function deleteAll()
    {
        $siswa = Siswa::all();
        if ($siswa->count() >= 1) {
            Siswa::whereNotNull('id')->delete();
            Siswa::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table siswa berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table siswa kosong!');
        }
    }

    public function deleteStudentByClass($id)
    {

        $siswa = Siswa::where('kelas_id', $id);
        if ($siswa->count() >= 1) {
            Siswa::whereNotNull('id')->delete();
            Siswa::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table siswa berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table siswa kosong!');
        }
    }

    public function mapelSiswa()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas',$siswa->kelas_id)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelas->nama_kelas)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('siswa.listmapel', compact('siswa', 'kelas', 'mapel'));
    }

    public function showMateri()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas',$siswa->kelas_id)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelas->nama_kelas)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel =Mapel::where('id', $jadwal[0]->mapel_id)->first();

        $materis=Materi::where('kelas',$siswa->kelas_id)->where('angkatan',$siswa->angkatan)->where('mapel',$mapel->nama_mapel)->get();


        $soal=Soal::where('kelas',$siswa->kelas_id)->where('angkatan',$siswa->angkatan)->where('mapel',$mapel->nama_mapel)->get();

        $jumlahSoal=Soal::where('kelas',$siswa->kelas_id)->where('angkatan',$siswa->angkatan)->where('mapel',$mapel->nama_mapel)->count();
        return view('siswa.materi', compact('materis','soal','jumlahSoal'));
    }

    public function showDetailMateri($id)
    {

        $singleMateri = Materi::findOrFail($id);

        return view('siswa.detailmateri', compact('singleMateri'));
    }


     public function exportPdf($id)
    {
        $singleMateri = Materi::findOrFail($id);

        $pdf = PDF::loadview('siswa.exportPdf', compact('singleMateri') );

        return $pdf->download('materi.pdf');
    }

    public function downloadMateri($name){
        return \Storage::download("/files/".$name);
    }

     public function downloadDokumenAbsensi($name){
        return \Storage::download("/files/".$name);
    }


      public function mapelSiswaForAbsen()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas',$siswa->kelas_id)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelas->nama_kelas)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('siswa.mapelabsen', compact('siswa', 'kelas', 'mapel'));
    }

    public function showJadwalPerMapel($idMapel){

        $tahunajaran=TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas',$siswa->kelas_id)->where('tahun_ajaran',$tahunajaran->nama)->first();
        // $jadwal = Jadwal::orderBy('hari_id')->OrderBy('jam_mulai')->where('nama_kelas', $kelas->nama_kelas)->where('mapel_id',$idMapel)->get();

         $jadwal = AbsensiMurid::where('nama_siswa',$siswa->nama_siswa)
                ->where('tahun_ajaran',$tahunajaran->nama)
                ->where('nama_kelas',$siswa->kelas_id)
                ->get();

        return view('siswa.showabsensi', compact('jadwal', 'kelas','siswa'));
    }

    public function showStudentAbsenDetail($idJadwal){
        $data=AbsensiMurid::where('jadwal_id',$idJadwal)->OrderBy('nama_siswa')->get();
        return view('siswa.detailabsen', compact('data'));
    }

    public function mapelByClass($kelasId)
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $kelas = Kelas::where('nama_kelas',$kelasId)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelasId)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('kepsek.listmapelbyclass', compact('kelas', 'mapel'));
    }
    public function mapelByClassForUlangan($kelasId)
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $tahunajaran_latest=$tahunajaran->nama;
        $namaKelas=$kelasId;
        $kelas = Kelas::where('nama_kelas',$kelasId)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelasId)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('kepsek.listmapelbyclass-ulangan', compact('kelas','mapel','tahunajaran_latest','namaKelas'));
    }

      public function mapelByClassForRapot($kelasId)
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $tahunajaran_latest=$tahunajaran->nama;
        $namaKelas=$kelasId;
        $kelas = Kelas::where('nama_kelas',$kelasId)->where('tahun_ajaran',$tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelasId)->where('tahun_ajaran',$tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('kepsek.listmapelbyclass-rapot', compact('kelas','mapel','tahunajaran_latest','namaKelas'));
    }

    public function showAbsesnsiPerMapel($idJadwal){

         $data = AbsensiMurid::where('jadwal_id',$idJadwal)->orderBy('nama_siswa')
                ->get();

        return view('kepsek.detailabsen', compact('data'));
    }

}
