<?php

namespace App\Http\Controllers\Sosmed;

use App\Exports\ReportTikTokLiveExport;
use App\Http\Controllers\Controller;
use App\Models\ReportTikTokLive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;

class ReportTikTokLiveController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Report TikTok Live', only: ['index']),
            new Middleware('permission:Create Report TikTok Live', only: ['store']),
            new Middleware('permission:Edit Report TikTok Live', only: ['update']),
            new Middleware('permission:Delete Report TikTok Live', only: ['destroy']),
            new Middleware('permission:Export Report TikTok Live', only: ['export']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ReportTikTokLive::orderBy('tanggal', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('tanggal', function ($row) {
                    return date('d F Y', strtotime($row->tanggal));
                })
                ->addColumn('pics', function ($row) {
                    return $row->pics->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('reportTikTokLive.edit', $row->kd_report_tiktok_live) . '" class="edit btn btn-warning">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger" data-url="' . route('reportTikTokLive.destroy', $row->kd_report_tiktok_live) . '" onclick="deleteData(this)">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sosmed.timeline.tiktok.live.report_tiktok_live');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Content Creator')->orderBy('name', 'asc')->get();
        return view('sosmed.timeline.tiktok.live.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|string',
            'durasi' => 'required|string',
        ]);
        $request['kd_report_tiktok_live'] = 'RTTL-' . date('ymdhis') . str_pad(ReportTikTokLive::count() + 1, 4, '0', STR_PAD_LEFT);
        $reportTikTokLive = ReportTikTokLive::create($request->all());

        $pics = $request->input('pics', []);
        $reportTikTokLive->pics()->attach($pics);

        return redirect()->route('reportTikTokLive.index')->with('message', 'Data berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportTikTokLive $reportTikTokLive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportTikTokLive $reportTikTokLive)
    {
        $users = User::role('Content Creator')->orderBy('name', 'asc')->get();
        return view('sosmed.timeline.tiktok.live.edit', compact('reportTikTokLive', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportTikTokLive $reportTikTokLive)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|string',
            'durasi' => 'required|string',
        ]);

        $reportTikTokLive->update($request->all());

        $pics = $request->input('pics', []);
        $reportTikTokLive->pics()->sync($pics);

        return redirect()->route('reportTikTokLive.index')->with('message', 'Data berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportTikTokLive $reportTikTokLive)
    {
        $reportTikTokLive->pics()->detach();
        $reportTikTokLive->delete();

        return redirect()->route('reportTikTokLive.index')->with('message', 'Data berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function export(Request $request)
    {
        return Excel::download(new ReportTikTokLiveExport($request->start_date, $request->end_date), 'report-tiktok-live-' . date('d-m-Y') . '.xlsx');
    }
}
