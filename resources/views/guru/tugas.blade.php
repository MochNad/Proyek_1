@extends('guru.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Tugas Siswa</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          @foreach ($kelas2 as $m)
          <h3 class="card-title"><b>Kelas :</b> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$m->mapel}}</h3>
          @endforeach
        </div>
        <!-- ./card-header -->
        <div class="card-body p-0">
          <table class="table table-hover">
            <tbody>
              @foreach ($pertemuan as $p)
              <tr>
                <td class="border-0">{{$p->nama}}</td>
              </tr>
              
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 50%;">Tugas</th>
                        <th style="width: 15%;">Nilai</th>
                      </tr>
                      </thead>
                      <tbody>
                        @if ($data->count() > 0)
                          @foreach ($data as $i => $d)
                          <tr>
                            <td class="text-center">{{++$i}}</td>
                            <td>{{$d->nama}}</td>
                            <td><a href="{{asset('storage/'.$d->file)}}" target="_blank" rel="noopener noreferrer">{{$d->tugas}}</a></td>
                            <td class="d-flex justify-content-around">
                              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="">
                                <i class="fa-solid fa-circle-info"></i>
                              </button>
                            </td>
                          </tr>
                          @endforeach
                        @else
                          <tr><td colspan="6" class="text-center">No matching records found</td></tr>
                        @endif
                      </tbody>
                      {{-- <tfoot>
                      <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                      </tfoot> --}}
                    </table>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

{{-- <div class="modal fade" id="addPertemuanModal" tabindex="-1" role="dialog" aria-labelledby="addPertemuanModal-label" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPertemuanModal-label"><strong>Tambah Pertemuan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addPertemuan" method="POST" action="{{ url('/guru/pertemuan/'.$id) }}" enctype="multipart/form-data">
          @csrf
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                @error('nama')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addPertemuan"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div> --}}

@endsection