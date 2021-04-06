<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search');
        if($search){
            // Do the query search
            $paginate = Mahasiswa::where('nama', 'LIKE', "%{$search}%")->paginate(3);
        } else {
            // Show the mhs lists
            $paginate = Mahasiswa::orderBy('nim','desc')->paginate(5); 
        }

        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim', 'asc')->paginate(5);
        return view('mahasiswa.index',['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);

        // return view('mahasiswa.index', compact('posts'));
        // with('i',(request()->input('page', 1) - 1) * 5);
    }

    public function cari(Request $request){
        // Menangkap pencarian 
        $cari = $request -> cari;

        // Mengambil data dari table mahasiswa sesuai pencarian data
        $mahasiswas = DB::table('mahasiswa')
        ->where('nama','like',"%".$cari."%")
        ->paginate();
        
        // Mengirim data mahasiswa ke view index
        return view('find',['mahasiswas' => $mahasiswa]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); // Mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas' => $kelas]);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Melakukan validasi data 
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        // Fungsi eloquent untuk menambah data 
        Mahasiswa::create($request->all());

        //Jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    

    /**S
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        // Menampilkan detail data dengan menemukan berdasarkan nim Mahasiswa untuk diedit 
        $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        // Melakukan validasi data 
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        // Funsgi eloquent untuk mengupdate data inputan kita 
        Mahasiswa::find($nim)->update($request->all());

        // Jika data berhasil diupdata, akan kembali ke halaman utama 
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
