@extends('template_backend.home')

@section('heading')
Detail Soal Pilihan Berganda
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.detailModelSoal', Crypt::encrypt($modelsoal->id)) }}">Detail Soal</a></li>
<li class="breadcrumb-item active">{{ isset($soal) ? $soal->id : ''  }}</li>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('guru.ujianOnline.editSoalPilihanBerganda', Crypt::encrypt($soal->id)) }}" method="post">
      @csrf
      @method('put')

      <div class="row">
        <div class="col-md-12">
          <h3><b>PERTANYAAN</b></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="grade">Poin</label>
            <input type='number' id="grade" name='grade' class="form-control @error('grade') is-invalid @enderror" placeholder="1-100" value="{{ $soal->grade }}">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="question_text">Pertanyaan</label>
            <textarea id="question_text" name="question_text" class="textarea @error('question_text') is-invalid @enderror">
            {{ $soal->question_text }}
            </textarea>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="answer_explanation">Penjelasan</label>
            <textarea id="answer_explanation" name="answer_explanation" class="textarea @error('answer_explanation') is-invalid @enderror">
            {{ $soal->answer_explanation }}
            </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        &nbsp;
      </div>
      <div class="row">
        <div class="col-md-12" style="text-align: right;">
          <a href="{{ route('guru.ujianOnline.detailModelSoal', Crypt::encrypt($modelsoal->id)) }}" class="btn btn-default">
            <i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali
          </a>
          <button type="submit" name='btn-edit-soal' class="btn btn-success"><i class="nav-icon fas fa-save"></i> &nbsp; Edit</button>
        </div>
      </div>
    </form>

    <div class="row">
      &nbsp;
    </div>
    <div class="row">
      &nbsp;
    </div>

    <div class="row">
      <div class="col-md-12">
        <hr>
        <div class="row">
          <div class="col-md-6">
            <h3><b>OPSI PERTANYAAN</b></h3>
          </div>
          <div class="col-md-6" style="text-align: right;">
            @if (count($opsisoal) < 5)
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah-opsi">
              <i class="nav-icon fas fa-plus"></i> &nbsp; Tambah Opsi
            </button>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table id="example1" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>Nama Opsi</th>
              <th width="80px">Jawaban Yang Benar</th>
              <th width="80px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($opsisoal as $data)
            <tr>
              <td>{!! $data->option !!}</td>
              <td>{!! ($data->correct == 1) ? '<b>Ya</b>' : '-' !!}</td>
              <td>
                @if ($data->correct !== 1)
                <a href="{{ route('guru.ujianOnline.editOpsiJawaban', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm" style="width: 100%;">
                  <i class="nav-icon fas fa-star"></i> &nbsp; Set Jawaban
                </a>
                @endif

                <form action="{{ route('guru.ujianOnline.hapusOpsi', Crypt::encrypt($data->id)) }}" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger btn-sm" style="width: 100%;">
                    <i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Add Soal Pilihan Berganda -->
<div id="tambah-opsi" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('guru.ujianOnline.tambahOpsi') }}" method="post">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Tambah Opsi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type='hidden' id="question_id" name="question_id" value="{{ $soal->id }}">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="opsi">Opsi</label>
                <textarea id="opsi" name="opsi" class="textarea @error('opsi') is-invalid @enderror">
                </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
          <button type="submit" name='btn-tambah-opsi' class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Add Soal Pilihan Berganda -->
<!-- Modal -->
@endsection

@section('script')
<script>
  $("#SoalUjianOnlineGuru").addClass("active");
  $("#UjianOnlineGuru").addClass("active");
  $("#liUjianOnlineGuru").addClass("menu-open");
</script>
@endsection