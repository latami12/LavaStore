@extends('main')

@section('title')
    <title>Akun Users</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <table class="table table-stripped">
            <form action="/search" method="get" target="#">
                <div class="input-group mt-2 mb-2">
                    <input type="text" class="form-control" placeholder="Users.." name="search" id="keyword" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-outline-dark" type="submit" id="cari"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">AGE</th>
                        <th scope="col">ADDRESS</th>
                        <th scope="col">NO. PHONE</th>
                        <th scope="col">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($user as $user)

                        <tr>
                            <th scope="row"> {{ $no++ }}</th>
                            <th scope="row"> {{ $user->id }}</th>
                            <td>{{ $user->name }} </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->umur }}</td>
                            <td>{{ $user->alamat }}</td>
                            <td>{{ $user->nomor_telepon }}</td>
                            <td>
                                <form action="{{ route('profile.destroy', $user->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <a href="{{ route('profile.update', $user->id) }} " class="btn btn-warning btn-sm"><i
                                            class="fa fa-pencil"> | Edit</i></a> --}}
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"> | Hapus</i></button>
                                </form>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#exampleModal"> 
                                        <i class="fa fa-pencil"> | Edit</i>
                                    </button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- edit akun --}}
                                                    {{-- @for($profile as $profile); --}}
                                                    <form action="{{ route('profile.update', $user->id) }}" target="#" method="post">
                                                        @csrf
                                                        @method('patch')
                                                        <div class="form-group">
                                                            <label for="inputAddress">Name</label>
                                                            <input type="text" class="form-control" id="inputAddress"
                                                                placeholder="Email..." value="{{$user->name}}" name="name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputAddress">Email</label>
                                                            <input type="text" class="form-control" id="inputAddress"
                                                                placeholder="Email..." value="{{$user->email}}" name="email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputAddress">No. Phone</label>
                                                            <input type="text" class="form-control" id="inputAddress"
                                                                placeholder="No. Phone..." value="{{$user->nomor_telepon}}" name="nomor_telepon">
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="inputCity">City</label>
                                                                <input type="text" class="form-control" id="inputCity" placeholder="Address..." value="{{$user->alamat}}" name="alamat">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="inputState">Age</label>
                                                                <input type="number" class="form-control" value="{{$user->umur}}" name="umur">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    </form>

                                            </div>
                                        </div>
                                    </div>
                                    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
