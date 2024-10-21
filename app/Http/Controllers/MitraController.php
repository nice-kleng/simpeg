<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class MitraController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Mitra', only: ['index']),
            new Middleware('permission:Create Mitra', only: ['store']),
            new Middleware('permission:Edit Mitra', only: ['update']),
            new Middleware('permission:Delete Mitra', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mitra::all();
            return DataTables::of($data)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                })
                ->addColumn('upline', function ($row) {
                    return $row->upline ? $row->upline->nama : '-';
                })
                ->addColumn('downline', function ($row) {
                    return $row->downline->pluck('nama')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('mitra.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteData(this)" data-url="' . route('mitra.destroy', $row->id) . '" class="btn btn-danger btn-sm">Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('superadmin.mitra.mitra');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uplines = Mitra::orderBy('nama', 'asc')->get();
        return view('superadmin.mitra.create', compact('uplines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:mitras,kode',
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'status_mitra' => 'required|string|max:255',
            'kota_wilayah' => 'required|string|max:255',
            'fb' => 'nullable|string|max:255',
            'ig' => 'nullable|string|max:255',
            'marketplace' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:255',
            'upline' => 'nullable|exists:mitras,id',
            'bulan' => 'required|string|max:255',
            'note_1' => 'nullable|string|max:255',
            'note_2' => 'nullable|string|max:255',
        ], [
            'kode.required' => 'Kode Mitra harus diisi',
            'kode.string' => 'Kode Mitra harus berupa teks',
            'kode.max' => 'Kode Mitra maksimal 255 karakter',
            'kode.unique' => 'Kode Mitra sudah ada',
            'tanggal.required' => 'Tanggal Gabung harus diisi',
            'tanggal.date' => 'Tanggal Gabung harus berupa tanggal',
            'nama.required' => 'Nama Lengkap harus diisi',
            'nama.string' => 'Nama Lengkap harus berupa teks',
            'nama.max' => 'Nama Lengkap maksimal 255 karakter',
            'status_mitra.required' => 'Status Mitra harus diisi',
            'status_mitra.string' => 'Status Mitra harus berupa teks',
            'status_mitra.max' => 'Status Mitra maksimal 255 karakter',
            'kota_wilayah.required' => 'Kota/Wilayah harus diisi',
            'kota_wilayah.string' => 'Kota/Wilayah harus berupa teks',
            'kota_wilayah.max' => 'Kota/Wilayah maksimal 255 karakter',
            'fb.string' => 'Facebook harus berupa teks',
            'fb.max' => 'Facebook maksimal 255 karakter',
            'ig.string' => 'Instagram harus berupa teks',
            'ig.max' => 'Instagram maksimal 255 karakter',
            'marketplace.string' => 'Marketplace harus berupa teks',
            'marketplace.max' => 'Marketplace maksimal 255 karakter',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.string' => 'No HP harus berupa teks',
            'no_hp.max' => 'No HP maksimal 255 karakter',
            'upline.exists' => 'Upline tidak valid',
            'bulan.required' => 'Bulan harus diisi',
            'bulan.string' => 'Bulan harus berupa teks',
            'bulan.max' => 'Bulan maksimal 255 karakter',
            'note_1.string' => 'Note 1 harus berupa teks',
            'note_1.max' => 'Note 1 maksimal 255 karakter',
            'note_2.string' => 'Note 2 harus berupa teks',
            'note_2.max' => 'Note 2 maksimal 255 karakter',
        ]);

        Mitra::create($request->all());

        return redirect()->route('mitra.index')->with('message', 'Data berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mitra $mitra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mitra $mitra)
    {
        $uplines = Mitra::orderBy('nama', 'asc')->get();
        return view('superadmin.mitra.edit', compact('mitra', 'uplines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:mitras,kode,' . $mitra->id,
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'status_mitra' => 'required|string|max:255',
            'kota_wilayah' => 'required|string|max:255',
            'fb' => 'nullable|string|max:255',
            'ig' => 'nullable|string|max:255',
            'marketplace' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:255',
            'upline' => 'nullable|exists:mitras,id',
            'bulan' => 'required|string|max:255',
            'note_1' => 'nullable|string|max:255',
            'note_2' => 'nullable|string|max:255',
        ], [
            'kode.required' => 'Kode Mitra harus diisi',
            'kode.string' => 'Kode Mitra harus berupa teks',
            'kode.max' => 'Kode Mitra maksimal 255 karakter',
            'kode.unique' => 'Kode Mitra sudah ada',
            'tanggal.required' => 'Tanggal Gabung harus diisi',
            'tanggal.date' => 'Tanggal Gabung harus berupa tanggal',
            'nama.required' => 'Nama Lengkap harus diisi',
            'nama.string' => 'Nama Lengkap harus berupa teks',
            'nama.max' => 'Nama Lengkap maksimal 255 karakter',
            'status_mitra.required' => 'Status Mitra harus diisi',
            'status_mitra.string' => 'Status Mitra harus berupa teks',
            'status_mitra.max' => 'Status Mitra maksimal 255 karakter',
            'kota_wilayah.required' => 'Kota/Wilayah harus diisi',
            'kota_wilayah.string' => 'Kota/Wilayah harus berupa teks',
            'kota_wilayah.max' => 'Kota/Wilayah maksimal 255 karakter',
            'fb.string' => 'Facebook harus berupa teks',
            'fb.max' => 'Facebook maksimal 255 karakter',
            'ig.string' => 'Instagram harus berupa teks',
            'ig.max' => 'Instagram maksimal 255 karakter',
            'marketplace.string' => 'Marketplace harus berupa teks',
            'marketplace.max' => 'Marketplace maksimal 255 karakter',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.string' => 'No HP harus berupa teks',
            'no_hp.max' => 'No HP maksimal 255 karakter',
            'upline.exists' => 'Upline tidak valid',
            'bulan.required' => 'Bulan harus diisi',
            'bulan.string' => 'Bulan harus berupa teks',
            'bulan.max' => 'Bulan maksimal 255 karakter',
            'note_1.string' => 'Note 1 harus berupa teks',
            'note_1.max' => 'Note 1 maksimal 255 karakter',
            'note_2.string' => 'Note 2 harus berupa teks',
            'note_2.max' => 'Note 2 maksimal 255 karakter',
        ]);

        $mitra->update($request->all());

        return redirect()->route('mitra.index')->with('message', 'Data berhasil diupdate')->with('type', 'success')->with('title', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitra $mitra)
    {
        if ($mitra->downline()->count() > 0) {
            return redirect()->back()->with('message', 'Data tidak dapat dihapus karena memiliki downline')->with('title', 'Gagal')->with('type', 'error');
        }
        $mitra->delete();
        return redirect()->back()->with('message', 'Data berhasil dihapus')->with('title', 'Berhasil')->with('type', 'success');
    }
}
