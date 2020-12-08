@extends('main')

@section('content')
    
<main class="main">
  <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Kategori</li>
  </ol>
  <div class="container-fluid">
      <div class="animated fadeIn">
          <div class="row">
              <div class="col-md-4">
                  <div class="card">
                      <div class="card-header">
                          <h4 class="card-title">Kategori Baru</h4>
                      </div>
                      <div class="card-body">
                          <form action="{{ route('category.store') }}" method="post">
                              @csrf
                              <div class="form-group">
                                  <label for="name">Kategori</label>
                                  <input type="text" name="name" class="form-control" required>
                                  <p class="text-danger">{{ $errors->first('name') }}</p>
                              </div>
                              <div class="form-group">
                                  <label for="parent_id">Kategori</label>
                                  <select name="parent_id" class="form-control">
                                      <option value="">None</option>
                                      @foreach ($parent as $row)
                                      <option value="{{ $row->id }}">{{ $row->name }}</option>
                                      @endforeach
                                  </select>
                                  <p class="text-danger">{{ $errors->first('name') }}</p>
                              </div>
                              <div class="form-group">
                                  <button class="btn btn-outline-primary btn-sm mt-1"><i class="fa fa-plus"> | Tambah</i></button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-md-8">
                  <div class="card">
                      <div class="card-header">
                          <h4 class="card-title">List Kategori</h4>
                      </div>
                      <div class="card-body">
                          @if (session('success'))
                              <div class="alert alert-success">{{ session('success') }}</div>
                          @endif

                          @if (session('error'))
                              <div class="alert alert-danger">{{ session('error') }}</div>
                          @endif

                          <div class="table-responsive">
                              <table class="table table-hover table-bordered">
                                  <thead class="thead-dark">
                                      <tr>
                                          <th>No</th>
                                          <th>Kategori</th>
                                          {{-- <th>Parent</th> --}}
                                          <th>Created At</th>
                                          <th>Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $no = 1; ?>
                                      @forelse ($category as $val)
                                      <tr>
                                          <td>{{ $no++ }}</td>
                                          <td><strong>{{ $val->name }}</strong></td>
                                          {{-- <td>{{ $val->parent ? $val->parent->name:'-' }}</td> --}}
                                          <td>{{ $val->created_at->format('d-m-Y') }}</td>
                                          <td>
                                              <form action="{{ route('category.destroy', $val->id) }}" method="post">
                                                  @csrf
                                                  @method('DELETE')
                                                  <a href="{{ route('category.edit', $val->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"> | Edit</i></a>
                                                  <button class="btn btn-danger btn-sm"><i class="fa fa-trash"> | Hapus</i></button>
                                              </form>
                                          </td>
                                      </tr>
                                      @empty
                                      <tr>
                                          <td colspan="5" class="text-center">Tidak ada data</td>
                                      </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>
                          {!! $category->links() !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection