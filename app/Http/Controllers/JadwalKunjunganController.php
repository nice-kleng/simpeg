<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use App\Models\JawabanMitra;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Pertanyaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class JadwalKunjunganController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Jadwal Kunjungan', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JadwalKunjungan::query()
                ->with(['mitra', 'pic', 'pertanyaan']);

            // Filter for non-superadmin users
            if (!Auth::user()->hasRole('Super Admin')) {
                $data->whereHas('pic', function ($query) {
                    $query->where('pic_id', auth()->id());
                });
            }

            // Search functionality
            if ($request->search) {
                $searchTerm = $request->search;
                $data->where(function ($query) use ($searchTerm) {
                    $query->whereHas('mitra', function ($q) use ($searchTerm) {
                        $q->where('nama', 'like', "%{$searchTerm}%")
                            ->orWhere('kota_wilayah', 'like', "%{$searchTerm}%");
                    })
                        ->orWhereHas('pic', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereDate('tanggal', 'like', "%{$searchTerm}%")
                        ->orWhereRaw("DATE_FORMAT(tanggal, '%M') LIKE ?", ["%{$searchTerm}%"])
                        ->orWhereRaw("DATE_FORMAT(tanggal, '%m') LIKE ?", ["%{$searchTerm}%"]);
                });
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->format('d F Y');
                })
                ->addColumn('bulan', function ($row) {
                    return Carbon::parse($row->tanggal)->format('F');
                })
                ->addColumn('mitra', function ($row) {
                    return optional($row->mitra)->nama ?? '-';
                })
                ->addColumn('alamat', function ($row) {
                    return optional($row->mitra)->kota_wilayah ?? '-';
                })
                ->addColumn('pic', function ($row) {
                    return $row->pic->pluck('name')->implode(', ') ?: '-';
                })
                ->addColumn('status', function ($row) {
                    return ($row->pertanyaan && $row->pertanyaan()->count() > 0)
                        ? '<span class="badge badge-success">Sudah diisi</span>'
                        : '<span class="badge badge-danger">Belum diisi</span>';
                })
                ->addColumn('action', function ($row) {
                    return view('crm.jadwal.action-buttons', compact('row'))->render();
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('crm.jadwal.jadwal', [
            'mitras' => Mitra::orderBy('nama', 'asc')->get(),
            'pics' => User::role('crm')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required',
            'tanggal' => 'required',
            'pic' => 'required',
        ]);

        $jadwal = JadwalKunjungan::create([
            'mitra_id' => $request->mitra_id,
            'tanggal' => $request->tanggal,
        ]);

        $jadwal->pic()->attach($request->pic);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function edit($id)
    {
        $jadwal = JadwalKunjungan::with('pic')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $jadwal
        ]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);

        $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'tanggal' => 'required|date',
            'pic.*' => 'required|exists:users,id', // Fix validation for array of PICs
        ]);

        $jadwal->update([
            'mitra_id' => $request->mitra_id,
            'tanggal' => $request->tanggal,
        ]);

        // Sync the PICs from the array
        $jadwal->pic()->sync($request->pic);

        return response()->json(['success' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);
        $jadwal->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function jawabanMitra($id)
    {
        try {
            $jadwal = JadwalKunjungan::with(['mitra'])->findOrFail($id);

            if (request()->ajax()) {
                $pertanyaans = Pertanyaan::select('pertanyaans.*')
                    ->leftJoin('jawaban_mitras', function ($join) use ($id) {
                        $join->on('pertanyaans.id', '=', 'jawaban_mitras.pertanyaan_id')
                            ->where('jawaban_mitras.jadwal_kunjungan_id', '=', $id);
                    })
                    ->get();

                return DataTables::of($pertanyaans)
                    ->addIndexColumn()
                    ->addColumn('pertanyaan', function ($row) {
                        return $row->pertanyaan;
                    })
                    ->addColumn('jawaban', function ($row) use ($id) {
                        $jawaban = JawabanMitra::where('pertanyaan_id', $row->id)
                            ->where('jadwal_kunjungan_id', $id)
                            ->first();
                        return $jawaban ? $jawaban->jawaban : '-';
                    })
                    ->addColumn('action', function ($row) use ($jadwal, $id) {
                        $jawaban = JawabanMitra::where('pertanyaan_id', $row->id)
                            ->where('jadwal_kunjungan_id', $id)
                            ->first();

                        $btn = '<button type="button" class="btn btn-primary btn-sm edit-jawaban"
                            data-id="' . $row->id . '"
                            data-jadwal="' . $jadwal->id . '"
                            data-pertanyaan="' . $row->pertanyaan . '"
                            data-jawaban="' . ($jawaban ? $jawaban->jawaban : '') . '">';
                        $btn .= $jawaban ? 'Edit Jawaban' : 'Isi Jawaban';
                        $btn .= '</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('crm.jadwal.jawaban_mitra', compact('jadwal'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateJawaban(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_kunjungans,id',
            'pertanyaan_id' => 'required|exists:pertanyaans,id',
            'jawaban' => 'required|string'
        ]);

        JawabanMitra::updateOrCreate(
            [
                'jadwal_kunjungan_id' => $request->jadwal_id,
                'pertanyaan_id' => $request->pertanyaan_id,
            ],
            [
                'jawaban' => $request->jawaban,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan'
        ]);
    }
}
