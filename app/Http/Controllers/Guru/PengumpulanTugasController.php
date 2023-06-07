<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\PengumpulanTugas;
use App\Models\Pertemuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengumpulanTugasController extends Controller
{
    public function index($id_tgs, $id_kmg, $id_pertemuan)
    {
        $id_guru = Auth::user()->username;

        $userId = Guru::all()->where('username', $id_guru)->pluck('id');

        $user = User::join('guru', 'users.username', '=', 'guru.username')
                ->select('users.username', 'guru.*')
                ->where('users.id', Auth::user()->id)
                ->first();

        $mapel = DB::table('kelas_mapel_guru as a')
                ->join('mapel as b', 'a.id_mapel', '=', 'b.id')
                ->select('b.nama as nama','a.id_jurusanTingkatKelas as kelas', 'a.id_mapel as id_mapel', 'a.id as id')
                ->where('id_guru', $userId)
                ->get();

        $data = DB::table('pengumpulan_tugas as a')
                ->join('siswa as b', 'b.id', '=', 'a.id_siswa')
                ->select('b.name as nama', DB::raw("REPLACE(a.file, 'file/tugas/', '') as tugas"), 'a.file', 'a.nilai', 'a.id')
                ->where('a.id_tugas', $id_tgs)
                ->get();        

        $kelas = DB::table('kelas_mapel_guru as a')
                ->join('jurusan_tingkat_kelas as b', 'a.id_jurusanTingkatKelas', '=', 'b.id')
                ->join('kelas as c', 'b.id_kelas', '=', 'c.id')
                ->join('jurusan as d', 'b.id_jurusan', '=', 'd.id')
                ->join('tingkat as e', 'b.id_tingkat', '=', 'e.id')
                ->select('c.nama as kelas', 'd.name as jurusan', 'e.name as tingkat', 'b.id as id_kelas')
                ->where('id_guru', $userId)
                ->groupBy('c.nama', 'd.name', 'e.name', 'b.id')
                ->orderBy('c.nama')
                ->get();

        $kelas2 = DB::table('kelas_mapel_guru as a')
        ->join('jurusan_tingkat_kelas as b', 'b.id', '=', 'a.id_jurusanTingkatKelas')
        ->join('jurusan as c', 'c.id', '=', 'b.id_jurusan')
        ->join('tingkat as d', 'd.id', '=', 'b.id_tingkat')
        ->join('kelas as e', 'e.id', '=', 'b.id_kelas')
        ->join('mapel as f', 'f.id', '=', 'a.id_mapel')
        ->select('d.name as tingkat', 'c.name as jurusan', 'e.nama as kelas', 'f.nama as mapel')
        ->where('a.id', $id_kmg)
        ->get();

        $pertemuan = Pertemuan::all()->where('id',$id_pertemuan);

        //dd($data);

        return view('guru.tugas')
            ->with('data', $data)
            ->with('pertemuan', $pertemuan)
            ->with('kelas', $kelas)
            ->with('kelas2', $kelas2)
            ->with('mapel', $mapel)
            ->with('user', $user);
    }

    public function nilai(Request $request, $id)
        {
        $request->validate([
                'nilai' => ['required', 'integer'], // Menambahkan validasi agar nilai harus berupa integer
        ]);

        $nilai = PengumpulanTugas::find($id);

        $nilai->nilai = $request->input('nilai');
        $nilai->save();

        return redirect()->back();
        }
}
