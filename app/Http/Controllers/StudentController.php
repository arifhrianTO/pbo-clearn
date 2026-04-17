<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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
            'prodi' => 'required'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.'
        ]);

        $students = new Student();
        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;

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
        $validatedData = $request->validate([
            'nim' => [
                'required',
                'unique:students,nim,' . $request->old_nim . ',nim'
            ],
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.'
        ]);

        $student = Student::where('nim', $id)->first();
        $student->nim = $request->nim;
        $student->nama = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;

        if ($student->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil diedit !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal diedit !',
                'type' => 'error'
            ]);
        }
    }

    public function destroy(string $id)
    {
        $student = Student::where('nim', $id);
        
        if ($student->count() < 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        if ($student->first()->delete()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil dihapus !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal dihapus !',
                'type' => 'error'
            ]);
        }
    }
}