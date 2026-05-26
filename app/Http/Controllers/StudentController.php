<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        // Memanggil seluruh data dari table Student
        $students = Student::all();
        return view('student.index', ['students' => $students]);
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        //validasi data yang dikirimkan dari form
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',

            //new linex

            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',

            //new line
            'foto.required' => 'Foto wajib diupload.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Foto harus bertipe JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal 2 MB.'
        ]);

        // new line
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $foto = basename($foto);
        } else {
            $foto = null;
        }


        $students = new Student();
        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;

        //new line
        $students->foto = $foto ? 'foto/' . $foto : null;

        if ($students->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil disimpan !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal disimpan !',
                'type' => 'error'
            ]);
        }
    }

    public function edit(string $id)
    {
        $student = Student::where('nim', $id);
        if ($student->count() < 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }
        return view('student.edit', ['student' => $student->first()]);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $rules = [
            'nim' => 'required|unique:students,nim,' . $request->old_nim . ',nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
        ];

        if ($request->ganti_foto == 1) {
            $rules['foto'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        $request->validate($rules, [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto.required' => 'Foto wajib diupload.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus bertipe JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $old_foto = $student->foto;

        if ($request->ganti_foto == 1 && $request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $student->foto = $foto;

            if (!empty($old_foto) && Storage::disk('public')->exists($old_foto)) {
                Storage::disk('public')->delete($old_foto);
            }
        }

        $student->nim = $request->nim;
        $student->nama = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;

        if ($student->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil diedit !',
                'type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'notifikasi' => 'Data gagal diedit !',
            'type' => 'error'
        ]);
    }

    public function destroy(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $foto_siswa = $student->foto;

        if ($student->delete()) {

            if (!empty($foto_siswa) && Storage::disk('public')->exists($foto_siswa)) {
                Storage::disk('public')->delete($foto_siswa);
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data berhasil dihapus!',
                'type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'notifikasi' => 'Data gagal dihapus!',
            'type' => 'error'
        ]);
    }

    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);
        $file_name = 'foto-' . $student->nim . '.' . pathinfo($file_path, PATHINFO_EXTENSION);

        return response()->download($file_path, $file_name);
    }

    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);

        return response()->file($file_path);
    }
}
