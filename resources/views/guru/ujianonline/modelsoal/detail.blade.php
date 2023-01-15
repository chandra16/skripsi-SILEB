@extends('template_backend.home')

@section('heading')
Detail Ujian Online
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.detailModelSoal', Crypt::encrypt($modelsoal->id)) }}">Soal Ujian</a></li>
<li class="breadcrumb-item active">{{ isset($modelsoal) ? $modelsoal->nama_model_soal : ''  }}</li>
@endsection

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <table class="table table-bordered">
        <tr>
          <th width='30%'>Tipe</th>
          <td width='70%'>{{ $modelsoal->tipeUjian->nama }}</td>
        </tr>
        <tr>
          <th width='30%'>Nama Model Soal</th>
          <td width='70%'>{{ $modelsoal->nama_model_soal }}</td>
        </tr>
        <tr>
          <th width='30%'>Nama Mata Pelajaran</th>
          <td width='70%'>{{ $mapel->nama_mapel }}</td>
        </tr>
        <tr>
          <th width='30%'>Angkatan</th>
          <td width='70%'>{{ $mapel->angkatan }}</td>
        </tr>
      </table>
    </div>
    <div class="card-body">
      <div class="form-group">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".tambah-soal-pilihan-berganda">
          <i class="nav-icon fas fa-plus"></i> &nbsp; Tambah Soal Pilihan Berganda
        </button>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".tambah-soal-essay">
          <i class="nav-icon fas fa-plus"></i> &nbsp; Tambah Soal Essay
        </button>
      </div>
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tipe</th>
            <th>Soal</th>
            <th>Poin</th>
            <th>Status</th>
            <th width="80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($soal as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->type }}</td>
            <td>{!! $data->question_text !!}</td>
            <td>{{ $data->grade }}</td>
            <td>{!! ($data->deleted_at) ? '<b>Deleted</b>' : '<b>Active</b>' !!}</td>
            <td>
              @if ($data->type == 'Essay')
              <a href="{{ route('guru.ujianOnline.viewEditSoalEssay', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm" style="width: 100%;">
                <i class="nav-icon fas fa-eye"></i> &nbsp; Detail
              </a>
              @else
              <a href="{{ route('guru.ujianOnline.viewEditSoalPilihanBerganda', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm" style="width: 100%;">
                <i class="nav-icon fas fa-eye"></i> &nbsp; Detail
              </a>
              @endif

              @if ($data->deleted_at)
              <form action="{{ route('guru.ujianOnline.restore', Crypt::encrypt($data->id)) }}" method="post">
                @csrf
                <button class="btn btn-warning btn-sm" style="width: 100%;"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</button>
              </form>
              @else
              <form action="{{ route('guru.ujianOnline.softDelete', Crypt::encrypt($data->id)) }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm" style="width: 100%;"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Add Soal Pilihan Berganda -->
<div class="modal fade bd-example-modal-lg tambah-soal-pilihan-berganda" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('guru.ujianOnline.addSoalPilihanBerganda') }}" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Soal Pilihan Berganda</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type='hidden' id="question_model_id" name="question_model_id" value="{{ $modelsoal->id }}">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="grade">Poin</label>
                <input type='number' id="grade" name='grade' class="form-control @error('grade') is-invalid @enderror" placeholder="1-100">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="question_text">Pertanyaan</label>
                <textarea id="question_text" name="question_text" class="textarea @error('question_text') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="opsi1">Opsi #1</label>
                <textarea id="opsi1" name="opsi1" class="textarea @error('opsi1') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="opsi2">Opsi #2</label>
                <textarea id="opsi2" name="opsi2" class="textarea @error('opsi2') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="opsi3">Opsi #3</label>
                <textarea id="opsi3" name="opsi3" class="textarea @error('opsi3') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="opsi4">Opsi #4</label>
                <textarea id="opsi4" name="opsi4" class="textarea @error('opsi4') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="opsi5">Opsi #5</label>
                <textarea id="opsi5" name="opsi5" class="textarea @error('opsi5') is-invalid @enderror">
                </textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="question_answer">Jawaban</label>
                <select id="question_answer" name="question_answer" class="form-control @error('question_answer') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Jawaban Yang Benar --</option>
                  <option value="opsi1">Opsi #1</option>
                  <option value="opsi2">Opsi #2</option>
                  <option value="opsi3">Opsi #3</option>
                  <option value="opsi4">Opsi #4</option>
                  <option value="opsi5">Opsi #5</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="answer_explanation">Penjelasan</label>
                <textarea id="answer_explanation" name="answer_explanation" class="textarea @error('answer_explanation') is-invalid @enderror">
                </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
          <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Add Soal Pilihan Berganda -->
<!-- Add Soal Essay -->
<div class="modal fade bd-example-modal-lg tambah-soal-essay" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('guru.ujianOnline.addSoalEssay') }}" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Soal Essay</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type='hidden' id="question_model_id" name="question_model_id" value="{{ $modelsoal->id }}">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="grade">Poin</label>
                <input type='number' id="grade" name='grade' class="form-control @error('grade') is-invalid @enderror" placeholder="1-100">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="question_text">Pertanyaan</label>
                <textarea id="question_text" name="question_text" class="textarea @error('question_text') is-invalid @enderror">
                </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
          <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Add Soal Essay -->
<!-- Modal -->
@endsection

@section('script')
<script>
  $("#SoalUjianOnlineGuru").addClass("active");
  $("#UjianOnlineGuru").addClass("active");
  $("#liUjianOnlineGuru").addClass("menu-open");
</script>
@endsection