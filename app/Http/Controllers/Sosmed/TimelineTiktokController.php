<?php

namespace App\Http\Controllers\Sosmed;

use App\Exports\ReportTikTokKontenExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ReportTikTok;
use App\Models\TimelineTiktok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TimelineTiktokController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Timeline TikTok', only: ['index']),
            new Middleware('permission:Create Timeline TikTok', only: ['store']),
            new Middleware('permission:Edit Timeline TikTok', only: ['update']),
            new Middleware('permission:Delete Timeline TikTok', only: ['destroy']),
            new Middleware('permission:Delete Report TikTok', only: ['destroyReport']),
            new Middleware('permission:Edit Report TikTok', only: ['updateReport']),
            new Middleware('permission:Detail Report TikTok', only: ['detailReport']),
            new Middleware('permission:Create Report TikTok', only: ['reportCreate', 'reportStore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if (!Auth::user()->hasRole('Super Admin')) {
                $data = TimelineTiktok::whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })->orderBy('tanggal', 'desc')->get();
            } else {
                $data = TimelineTiktok::orderBy('tanggal', 'desc')->get();
            }

            return DataTables::of($data)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('tanggal', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                })
                ->addColumn('pics', function ($row) {
                    return $row->pics->pluck('name')->implode(', ');
                })
                ->addColumn('report', function ($row) {
                    if ($row->report) {
                        $btn = '<a href="' . route('timelineTikTok.editReport', $row->kd_timeline_tiktok) . '" class="btn btn-warning btn-sm">Edit Report</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="detailReport(\'' . $row->kd_timeline_tiktok . '\')">Detail Report</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteReport(\'' . $row->kd_timeline_tiktok . '\')">Delete Report</a>';
                        return $btn;
                    } else {
                        return '<a href="' . route('timelineTikTok.reportCreate', $row->kd_timeline_tiktok) . '" class="btn btn-info btn-sm">Report</a>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-warning btn-sm" onclick="editTimelineTikTok(\'' . $row->kd_timeline_tiktok . '\')">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteTimelineTikTok(\'' . $row->kd_timeline_tiktok . '\')">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'report'])
                ->make(true);
        }
        $products = Product::orderBy('nama_product', 'asc')->get();
        $users = User::role('Content Creator')->orderBy('name', 'asc')->get();
        return view('sosmed.timeline.tiktok.timeline_tiktok', compact('products', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'tipe_konten' => 'required',
            'jenis_konten' => 'required',
            'produk' => 'required',
            'hook_konten' => 'required',
            'copywriting' => 'required',
            'jam_upload' => 'required',
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tipe_konten.required' => 'Tipe Konten harus diisi',
            'jenis_konten.required' => 'Jenis Konten harus diisi',
            'produk.required' => 'Produk harus diisi',
            'hook_konten.required' => 'Hook Konten harus diisi',
            'copywriting.required' => 'Copywriting harus diisi',
            'jam_upload.required' => 'Jam Upload harus diisi',
            'pics.required' => 'Pics harus diisi',
            'pics.array' => 'Pics harus berupa array',
            'pics.*.exists' => 'Pics harus berupa User yang ada',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pics = $request->pics ?? [];
        if (!Auth::user()->hasRole('Super Admin')) {
            $pics[] = Auth::user()->id;
        }
        $pics = array_unique($pics);

        $timelineTiktok = new TimelineTiktok();
        $timelineTiktok->tanggal = $request->tanggal;
        $timelineTiktok->tipe_konten = $request->tipe_konten;
        $timelineTiktok->jenis_konten = $request->jenis_konten;
        $timelineTiktok->produk = $request->produk;
        $timelineTiktok->hook_konten = $request->hook_konten;
        $timelineTiktok->copywriting = $request->copywriting;
        $timelineTiktok->jam_upload = $request->jam_upload;
        $timelineTiktok->save();

        $timelineTiktok->pics()->attach($pics);

        return response()->json(['success' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimelineTiktok $timelineTiktok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimelineTiktok $timelineTiktok)
    {
        $timelineTiktok->load('pics');

        // Transform data untuk memudahkan penggunaan di frontend
        $formattedData = $timelineTiktok->toArray();
        $formattedData['pics'] = $timelineTiktok->pics->pluck('id')->toArray();

        return response()->json($formattedData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimelineTiktok $timelineTiktok)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'tipe_konten' => 'required',
            'jenis_konten' => 'required',
            'produk' => 'required',
            'hook_konten' => 'required',
            'copywriting' => 'required',
            'jam_upload' => 'required',
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tipe_konten.required' => 'Tipe Konten harus diisi',
            'jenis_konten.required' => 'Jenis Konten harus diisi',
            'produk.required' => 'Produk harus diisi',
            'hook_konten.required' => 'Hook Konten harus diisi',
            'copywriting.required' => 'Copywriting harus diisi',
            'jam_upload.required' => 'Jam Upload harus diisi',
            'pics.required' => 'Pics harus diisi',
            'pics.array' => 'Pics harus berupa array',
            'pics.*.exists' => 'Pics harus berupa User yang ada',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pics = $request->pics ?? [];
        if (!Auth::user()->hasRole('Super Admin')) {
            $pics[] = Auth::user()->id;
        }
        $pics = array_unique($pics);

        $timelineTiktok->tanggal = $request->tanggal;
        $timelineTiktok->tipe_konten = $request->tipe_konten;
        $timelineTiktok->jenis_konten = $request->jenis_konten;
        $timelineTiktok->produk = $request->produk;
        $timelineTiktok->hook_konten = $request->hook_konten;
        $timelineTiktok->copywriting = $request->copywriting;
        $timelineTiktok->jam_upload = $request->jam_upload;
        $timelineTiktok->save();

        $timelineTiktok->pics()->sync($pics);

        return response()->json(['success' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimelineTiktok $timelineTiktok)
    {
        $timelineTiktok->pics()->detach();
        $timelineTiktok->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function reportCreate(string $kd_timeline_tiktok)
    {
        return view('sosmed.timeline.tiktok.report.create', compact('kd_timeline_tiktok'));
    }

    public function reportStore(Request $request)
    {
        $request->validate([
            'link_konten' => 'required|url',
        ]);

        ReportTikTok::create($request->all());

        return redirect()->route('timelineTikTok.index')->with('message', 'Data berhasil ditambahkan')->with('title', 'Berhasil')->with('type', 'success');
    }

    public function editReport(TimelineTiktok $timelineTiktok)
    {
        return view('sosmed.timeline.tiktok.report.edit', compact('timelineTiktok'));
    }

    public function updateReport(Request $request, TimelineTiktok $timelineTiktok)
    {
        $request->validate([
            'link_konten' => 'required|url',
        ]);

        $timelineTiktok->report->update($request->all());

        return redirect()->route('timelineTikTok.index')->with('message', 'Data berhasil diubah')->with('title', 'Berhasil')->with('type', 'success');
    }

    public function detailReport(TimelineTiktok $timelineTiktok)
    {
        return response()->json($timelineTiktok->report);
    }

    public function destroyReport(TimelineTiktok $timelineTiktok)
    {
        $timelineTiktok->report->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function exportReport(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $tipe_konten = $request->tipe_konten;

        return Excel::download(new ReportTikTokKontenExport($tanggal_awal, $tanggal_akhir, $tipe_konten), 'Report TikTok ' . $tanggal_awal . ' - ' . $tanggal_akhir . ' ' . $tipe_konten . '.xlsx');
    }
}
