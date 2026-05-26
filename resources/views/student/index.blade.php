<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students | Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    Data Siswa
                    <a href="/student/add" type="button" class="btn btn-primary float-right">Tambah</a>
                </div>
                <div class="card-body">
                    @if(session('notifikasi'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('notifikasi') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>No.</td>
                                    <td>NIM</td>
                                    <td>Nama</td>
                                    <td>Prodi</td>
                                    <td>Foto</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $data)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $data->nim }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->prodi }}</td>
                                    <td>
                                        <img class="img-fluid" src="{{ asset('storage/' .$data->foto) }}" alt="">
                                    </td>
                                    <td>
                                        <a href="/student/edit/{{ $data->nim }}" class="btn btn-sm btn-warning mr-1">Edit</a>
                                        <form method="POST" action="/student/delete/{{ $data->nim }}" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mr-1">Hapus</button>
                                        </form>
                                        <a href="/student/download/{{ $data->nim }}" class="btn btn-sm btn-primary mx-1 my-1">
                                            Download
                                        </a>

                                        <a href="/student/preview/{{ $data->nim }}" class="btn btn-sm btn-info mx-1 my-1">
                                            Preview
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan !</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>