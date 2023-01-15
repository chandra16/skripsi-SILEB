<?php

namespace App\Http\Controllers;

use App\BukuKerja;
use App\TahunAjaran;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuKerjaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.bukukerja.index');
    }

     public function indexGuest()
    {
        return view('guest.bukukerja.index');
    }


    public function listBukuKerja($id)
    {
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=isset($tahunajaran_latest) ? $tahunajaran_latest->nama : '';
        $data=BukuKerja::where('id_buku',$id)->where('tahun_ajaran',$tahunajaran)->get();
        $id_buku=$id;
        return view('admin.bukukerja.databukukerja',compact('data','id_buku'));
    }

    public function listBukuKerjaGuest($id)
    {
        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=isset($tahunajaran_latest) ? $tahunajaran_latest->nama : '';
        $data=BukuKerja::where('id_buku',$id)->where('tahun_ajaran',$tahunajaran)->get();
        $id_buku=$id;
        return view('guest.bukukerja.list',compact('data','id_buku'));
    }

    public function create(Request $request)
    {
        $this->validate($request,[ 
            'nama' => 'required',
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);


        $tahunajaran_latest=TahunAjaran::latest()->first();
        $tahunajaran=isset($tahunajaran_latest) ? $tahunajaran_latest->nama : '';
        $fileName = $request->file->getClientOriginalName();
        $filePath = \Storage::putFileAs('files', $request->file, $fileName);

        BukuKerja::create([
            'id_buku' => $request->id_buku,
            'nama' => $request->nama,
            'tahun_ajaran' => $tahunajaran,
            'file_name'=>$fileName,
            'file_path'=>$filePath,
        ]);

       return redirect()->back()->with('success', 'Berhasil menambahkan data guru baru!');
    }

     public function downloadDokumen($name){
        return \Storage::download("/files/".$name);
    }

    public function destroy($id)
    {
    $data = BukuKerja::where('id',$id)->first();
        DB::table('bukukerja')->where('id',$id)->first();
        $data->delete();
        return redirect()->back()->with('warning', 'Data  berhasil dihapus!');
    }

}
