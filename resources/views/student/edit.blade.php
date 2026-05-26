<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Edit | Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    Edit Siswa
                    <a href="/student" type="button" class="btn btn-danger float-right">Kembali</a>
                </div>
                <form action="/student/edit/{{ $student->nim }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <input name="old_nim" hidden value="{{ $student->nim }}" />

                    <div class="card-body">
                        @if(session('notifikasi'))
                        <div class="form-group">
                            <div class="alert alert-{{ session('type') }}">
                                {{ session('notifikasi') }}
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="nim">NIM <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $student->nim) }}">
                            @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $student->nama) }}">
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-Mail <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- new line -->
                        <div class="form-group">
                            <label>Foto Lama <b class="text-danger">*</b></label>
                            <div class="form-group">
                                <img class="my-2 img-fluid"
                                    src="{{ asset('storage/' . $student->foto) }}">
                            </div>
                        </div>

                        <div class="form-group form-check">
                            <input type="hidden" name="ganti_foto" value="0">
                            <input type="checkbox" class="form-check-input" id="ganti_foto"
                                name="ganti_foto" value="1" onclick="check_ganti()"
                                @if( old('ganti_foto')==1 )
                                checked 
                                @endif />
                            <label for="ganti_foto" class="form-check-label">Ganti Foto</label>
                        </div>

                        <div class="form-group" id="ganti_foto_div" style="display:none">
                            <label for="foto">Foto Baru <b class="text-danger">*</b></label>
                            <input placeholder="Upload Foto" type="file" id="foto" name="foto"
                                accept="image/png, image/jpg, image/jpeg"
                                class="form-control @error('foto') is-invalid @enderror">

                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prodi">Prodi <b class="text-danger">*</b></label>
                            <select required id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror">
                                <option value="">- Pilih Prodi -</option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Informatika') {{ 'selected' }} @endif>Teknik Informatika</option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Rekayasa Keamanan Siber') {{ 'selected' }} @endif>Teknik Rekayasa Keamanan Siber</option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Rekayasa Perangkat Lunak') {{ 'selected' }} @endif>Teknik Rekayasa Perangkat Lunak</option>
                            </select>
                            @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/student" class="btn btn-danger">Batal</a>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            check_ganti();
        });

        function check_ganti() {
            let ganti = document.getElementById('ganti_foto');
            let divFoto = document.getElementById('ganti_foto_div');
            let foto = document.getElementById('foto');

            divFoto.style.display = ganti.checked ? 'block' : 'none';
            foto.required = ganti.checked;
        }
    </script>
</body>

</html>