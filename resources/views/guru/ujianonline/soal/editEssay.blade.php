@extends('template_backend.home')

@section('heading')
Detail Soal Essay
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.detailModelSoal', Crypt::encrypt($modelsoal->id)) }}">Detail Soal</a></li>
<li class="breadcrumb-item active">{{ isset($soal) ? $soal->id : ''  }}</li>
@endsection

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <form action="{{ route('guru.ujianOnline.editSoalEssay', Crypt::encrypt($soal->id)) }}" method="post">
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
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Modal -->
@endsection

@section('script')
<script>
  $("#SoalUjianOnlineGuru").addClass("active");
  $("#UjianOnlineGuru").addClass("active");
  $("#liUjianOnlineGuru").addClass("menu-open");
</script>
@endsection