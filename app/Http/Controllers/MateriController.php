<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Materi;
use App\Soal;
use App\Kelas;
use App\Mapel;
use App\Guru;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exercise;
use App\Question;
use Validator;

class MateriController extends Controller
{
    /*
     * This is For Show Teacher Dashboard
     *
     */
    public function index()
    {
        $user = Auth::user();
        return view('pages.teacher.home', compact('user', $user));
    }

    /*
     * This is For Middleware Role Teacher & Auth
     * role:teacher
     * auth
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    
    }

    public function show()
    {
        
    }
    
    
    public function showCreateMateri()
    {
        $user = Auth::user(); // Untuk Photo Profile
        $mapel = mataPelajaran::all(); // Untuk Show List Mapel - Select
        $kelas = Kelas::all(); // Untuk Show List Kelas - Select
        return view('pages.teacher.materi.createMateri', compact('user', 'mapel', 'kelas') );
    }

    /*
     * This is For Create Materi
     *
     */
    public function createMateri(Request $request)
    {
        $this->validate($request,[ 
            'judul' => 'required',
            'isi' => 'required',
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf,ppt,pptx,doc,docx|max:2048'
        ]);


        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $fileName = $request->file->getClientOriginalName();
        $filePath = \Storage::putFileAs('files', $request->file, $fileName);

        Materi::create([
            'mapel' => $request->mapel,
            //Assign the "mutated" kelas value to kelas column
            'kelas' => collect($request->kelas)->implode(', '),

            'judul' => $request->judul,
            'isi' => $request->isi,
            'kesimpulan' => $request->kesimpulan,
            'keterangan' => $request->keterangan,
            'user_id_teacher' => $guru->id_card,
            'angkatan' => $request->angkatan,
            'file_name'=>$fileName,
            'file_path'=>$filePath,
        ]);

       return redirect()->back()->with('success', 'Berhasil menambahkan materi!');
    }

    public function createSoal(Request $request)
    {
        $this->validate($request,[ 
            'judul' => 'required',
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf,ppt,pptx,doc,docx|max:2048'
        ]);


        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $fileName = $request->file->getClientOriginalName();
        $filePath = \Storage::putFileAs('files', $request->file, $fileName);

        Soal::create([
            'mapel' => $request->mapel,
            //Assign the "mutated" kelas value to kelas column
            'kelas' => collect($request->kelas)->implode(', '),

            'judul' => $request->judul,
            'user_id_teacher' => $guru->id_card,
            'angkatan' => $request->angkatan,
            'file_name'=>$fileName,
            'file_path'=>$filePath,
        ]);

       return redirect()->back()->with('success', 'Berhasil menambahkan soal!');
    }
    /*
     * This is For Show Materi List
     *
     */
    public function showMateriList(Request $request)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $materis = Materi::where( 'user_id_teacher', Auth::user()->id_card )->get(); // Show, atau Get All "Materi"
        return view('guru.materi.list', compact('materis', 'user') );
    }

     public function showSoalList(Request $request)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $materis = Soal::where( 'user_id_teacher', Auth::user()->id_card )->get(); // Show, atau Get All "Materi"
        return view('guru.soal.list', compact('materis', 'user') );
    }


    /*
     * This is For Show Search Materi
     *
     */
    public function searchMateri(Request $request)
	{
        $user = Auth::user(); // Untuk Photo Profile

		// menangkap data pencarian
		$search = $request->table_search;

    		// mengambil data dari table materi sesuai pencarian data
        $search = Materi::where('mapel','like',"%".$search."%")
                            ->orWhere('kelas','like',"%".$search."%")
                            ->orWhere('judul','like',"%".$search."%")
                            ->orWhere('keterangan','like',"%".$search."%")
                            ->get();

    		// mengirim data materi ke view index
		return view('pages.teacher.materi.showMateriFiltered', compact('search', 'user') );

    }

    /*
     * This is For Show Update Materi
     *
     */
    public function editMateri($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $mapel = Mapel::all(); // Untuk Show List Mapel - Select
        $kelas = Kelas::all(); // Untuk Show List Kelas - Select
        $materi = Materi::findOrFail($id);
        return view('guru.materi.edit', compact('user', 'materi', 'mapel', 'kelas'));
    }

        public function editSoal($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $mapel = Mapel::all(); // Untuk Show List Mapel - Select
        $kelas = Kelas::all(); // Untuk Show List Kelas - Select
        $materi = Soal::findOrFail($id);
        return view('guru.soal.edit', compact('user', 'materi', 'mapel', 'kelas'));
    }

    /*
     * This is For Update Materi
     *
     */
    public function updateMateri(Request $request, $id)
    {

        $this->validate($request,[
            'mapel' => 'required',
            'kelas' => 'required',
            'judul' => 'required',
            'isi' => 'required'
        ]);

        $materi = Materi::findOrFail($id);
        if($request->file) {
            $fileName = $request->file->getClientOriginalName();
    
            $materi->file_name = $request->file->getClientOriginalName();
            $materi->file_path = \Storage::putFileAs('files', $request->file, $fileName);
        }
        
        $materi->mapel = $request->mapel;
        $materi->kelas = collect($request->kelas)->implode(', ');
        $materi->judul = $request->judul;
        $materi->isi = $request->isi;
        $materi->kesimpulan = $request->kesimpulan;
        $materi->angkatan = $request->angkatan;
        $materi->save();

       return redirect()->back()->with('success', 'Berhasil memperbaharui Materi!');
    }

    public function updateSoal(Request $request, $id)
        {

            $this->validate($request,[
                'mapel' => 'required',
                'kelas' => 'required',
                'judul' => 'required'
            ]);

            $materi = Soal::findOrFail($id);
            if($request->file) {
                $fileName = $request->file->getClientOriginalName();
        
                $materi->file_name = $request->file->getClientOriginalName();
                $materi->file_path = \Storage::putFileAs('files', $request->file, $fileName);
            }
            
            $materi->mapel = $request->mapel;
            $materi->kelas = collect($request->kelas)->implode(', ');
            $materi->judul = $request->judul;
            $materi->angkatan = $request->angkatan;
            $materi->save();

           return redirect()->back()->with('success', 'Berhasil memperbaharui Soal!');
        }

    /*
     * This is For Delete Materi
     *
     */
    public function deleteMateri($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $materi = Materi::findOrFail($id);
        $materi->delete();
        return redirect()->back()->with('success', 'Materi Berhasil diHapus.');
    }

 public function deleteSoal($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $materi = Soal::findOrFail($id);
        $materi->delete();
        return redirect()->back()->with('success', 'Soal Berhasil diHapus.');
    }
    /* ------------------------------------ END OF MATERI SECTION ---------------------------------------- */



    /* -------------------------------------------- EXERCISE SECTION ---------------------------------------- */
    /*
     * This is For Show Create Questions
     *
     */
    public function showCreateExercise()
    {
        $user = Auth::user(); // Untuk Photo Profile
        $mapel = mataPelajaran::all(); // Untuk Show List Mapel - Select
        $kelas = Kelas::all(); // Untuk Show List Kelas - Select
        return view('pages.teacher.exercise.createExercise', compact('user', 'mapel', 'kelas') );
    }

    /*
     * This is For Create Exercise
     *
     */
    public function createExercise(Request $request)
    {
        $this->validate($request,[
            'mapel' => 'required',
            'kelas' => 'required',
            'nama_exercise' => 'required',
            'deskripsi' => 'required',
        ]);

        Exercise::create([
            'mapel' => $request->mapel,

            //Assign the "mutated" kelas value to kelas column
            'kelas' => collect($request->kelas)->implode(', '),

            'nama_exercise' => $request->nama_exercise,
            'deskripsi' => $request->deskripsi,
            'user_id_teacher' => Auth::user()->id,
        ]);

        return back()->with('success','Exercise Berhasil dibuat.');
    }


    /*
     * This is For Show Exercise
     *
     */
    public function showExerciseList()
    {
        $user = Auth::user(); // Untuk Photo Profile
        $exercises = Exercise::where( 'user_id_teacher', Auth::user()->id )->get();
        return view('pages.teacher.exercise.showExerciseList', compact('user', 'exercises') );
    }

    /*
     * This is For Show Search Materi
     *
     */
    public function searchExercise(Request $request)
	{
        $user = Auth::user(); // Untuk Photo Profile

		// menangkap data pencarian
		$search = $request->table_search;

    		// mengambil data dari table materi sesuai pencarian data
        $search = Exercise::where('mapel','like',"%".$search."%")
                            ->orWhere('kelas','like',"%".$search."%")
                            ->orWhere('nama_exercise','like',"%".$search."%")
                            ->orWhere('deskripsi','like',"%".$search."%")
                            ->get();

    		// mengirim data materi ke view index
		return view('pages.teacher.exercise.showExerciseFiltered', compact('search', 'user') );

    }

    /*
     * This is For Show Update Materi
     *
     */
    public function editExercise($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $mapel = mataPelajaran::all(); // Untuk Show List Mapel - Select
        $kelas = Kelas::all(); // Untuk Show List Kelas - Select
        $exercise = Exercise::findOrFail($id);
        return view('pages.teacher.exercise.editExercise', compact('user', 'exercise', 'mapel', 'kelas'));
    }

    /*
     * This is For Update Materi
     *
     */
    public function updateExercise(Request $request, $id)
    {
        $this->validate($request,[
            'mapel' => 'required',
            'kelas' => 'required',
            'nama_exercise' => 'required',
            'deskripsi' => 'required',
        ]);

        $exercise = Exercise::findOrFail($id);
        $exercise->mapel = $request->mapel;
        $exercise->kelas = collect($request->kelas)->implode(', ');
        $exercise->nama_exercise = $request->nama_exercise;
        $exercise->deskripsi = $request->deskripsi;
        $exercise->user_id_teacher = Auth::user()->id;
        $exercise->save();

        return back()->with('success','Exercise Berhasil diUpdate/diEdit.');
    }

    /*
     * This is For Delete Exercise
     *
     */
    public function deleteExercise($id)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();
        return redirect()->back()->with('success', 'Exercise Berhasil diHapus.');
    }

    /*
     * This is For Show Create Questions
     *
     */
    public function showEditQuestion($id, Request $request)
    {
        $user = Auth::user(); // Untuk Photo Profile
        $exercise = Exercise::where('id', $id)->get();
        return view('pages.teacher.exercise.question.createQuestion', compact('user', 'exercise', ) );
    }

    /*
     * This is For Create Question
     *
     */
    public function createQuestion(Request $request)
    {
        $this->validate($request,[
            'exercise'  => 'required',
            'question'  => 'required',
            'opt1'  => 'required',
            'opt2'  => 'required',
            'opt3'  => 'required',
            'opt4'  => 'required',
        ]);

        return dd( $request->input('question.*') );


    }
}
