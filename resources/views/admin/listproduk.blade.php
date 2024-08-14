<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cssadmin/spur.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="dash">
       @include('admin.navbar')
        <div class="dash-app">
            <header class="dash-toolbar">
                <a href="#!" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </a>
            </header>
            <main class="dash-content">
                <div class="container-fluid">
                    <div class="alert alert-primary mb-3">Hanya produk yang Aktif yang akan tampil di halaman ecommerce</div>
                    <div class="alert alert-primary mb-3">Setiap ada produk yang di beli akan mengurangi stok produk otomatis</div>
                    <div class="alert alert-primary mb-3">Jika produk 0 maka produk tidak bisa di beli / disabled</div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Tambah Produk
                    </button>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Foto</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $produks)
                                    <tr>
                                        <td>{{ $produks->name }}</td>
                                        <td>
                                            @if($produks->foto)
                                             <img src="{{ asset('fotos/' . $produks->foto) }}" alt="{{ $produks->name }}" width="50">
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $produks->price }}</td>
                                        <td>{{ $produks->stock }}</td>
                                        <td>{{ $produks->status }}</td>
                                        <td>{{ $produks->category }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editproduk{{$produks->id}}">
                                                edit
                                            </button>
                                        </td>
                                        <td>
                                            <form action="{{ route('products.destroy', $produks->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editproduk{{$produks->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">edit Produk {{$produks->id}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('products.update', $produks->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nama Produk</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{ $produks->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="foto" class="form-label">Foto Produk</label>
                                                                <input type="file" class="form-control" id="foto" name="foto" value="{{ $produks->foto }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="price" class="form-label">Harga</label>
                                                                <input type="number" class="form-control" id="price" name="price" value="{{ $produks->price }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stock" class="form-label">Stok</label>
                                                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $produks->stock }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" id="status" name="status" required>
                                                                    <option value="{{ $produks->status }}">{{ $produks->status }}</option>
                                                                    <option value="aktif">Aktif</option>
                                                                    <option value="nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div> 
                                                            <div class="mb-3">
                                                                <label for="category" class="form-label">Kategori</label>
                                                                <input type="text" class="form-control" id="category" name="category" value="{{ $produks->category }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="name" name="name"  required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto Produk</label>
                                        <input type="file" class="form-control" id="foto" name="foto" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Nonaktif</option>
                                        </select>
                                    </div>                                    
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{ asset('jsadmin/spur.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>