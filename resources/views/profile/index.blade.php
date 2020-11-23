@extends('main')

@section('title')
    <title>Akun Users</title>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <table class="table table-stripped">
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
                    @foreach ($user as $user )
                        
                    <tr>
                        <th scope="row"> {{ $no++ }}</th>
                        <th scope="row"> {{ $user->id }}</th>
                        <td>{{ $user->name }} </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->tanggal }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td>{{ $user->nomor_telepon }}</td>
                        <td>
                            <form action="{{ route('profile.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('profile.update', $user->id) }} " class="btn btn-warning btn-sm"><i class="fa fa-pencil"> | Edit</i></a>
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"> | Hapus</i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
