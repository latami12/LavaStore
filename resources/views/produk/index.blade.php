@extends('main')

@section('title')
    <title>production</title>
@endsection

@section('content')
<table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Id</th>
        <th scope="col">User id</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Category</th>
        <th scope="col">Price</th>
        <th scope="col">Weight</th>
        <th scope="col">Stok</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php $no = 1;?>
        @foreach ($products as $produk)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $produk->id }}</td>
            <td>{{ $produk->user_id }}</td>
            <td><img src="{{ $produk->image }}" alt="..." class="img-thumbnail img-fluid" width="40px"></td>
            <td>{{ $produk->name }}</td>
            <td>{{ $produk->description }}</td>
            <td>{{ $produk->category->name }}</td>
            <td>{{ $produk->price }}</td>
            <td>{{ $produk->weight }}</td>
            <td>{{ $produk->status }}</td>
            
                <td>
                    <form action="{{ route('produk.destroy', $produk->id) }}" method="post" class="d-inline">
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
                                        <form action="{{ route('produk.update', $produk->id) }}" target="#" method="post">
                                            @csrf
                                            @method('patch')
                                            <div class="form-group">
                                                <label for="inputAddress">Name</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="Email..." value="{{$produk->name}}" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAddress">Description</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="Email..." value="{{$produk->description}}" name="email">
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity">Image</label>
                                                    <input type="text" class="form-control" id="inputCity" placeholder="Address..." value="{{$produk->image}}" name="alamat">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputState">Age</label>
                                                    <input type="number" class="form-control" value="{{$produk->price}}" name="umur">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity">Stok</label>
                                                    <input type="text" class="form-control" id="inputCity" placeholder="Address..." value="{{$produk->status}}" name="alamat">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputState">Weight</label>
                                                    <input type="number" class="form-control" value="{{$produk->weight}}" name="umur">
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
@endsection    