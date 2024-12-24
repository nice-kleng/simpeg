<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;
use App\Exports\ExportReportTimelineInstagram;
use App\Models\Product;
use App\Models\ReportTimelineInstagram;
use App\Models\TimelineInstagram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;

class TimelineInstagramController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Timeline Instagram', only: ['index']),
            new Middleware('permission:Create Timeline Instagram', only: ['store']),
            new Middleware('permission:Edit Timeline Instagram', only: ['update']),
            new Middleware('permission:Delete Timeline Instagram', only: ['destroy']),
            new Middleware('permission:Create Report Timeline Instagram', only: ['storeReport']),
            new Middleware('permission:Edit Report Timeline Instagram', only: ['updateReport']),
            new Middleware('permission:Export Timeline Instagram', only: ['exportExcel']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Super Admin')) {
                $timelineInstagram = TimelineInstagram::orderBy('tanggal', 'desc')->get();
            } else {
                $timelineInstagram = TimelineInstagram::whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })->orderBy('tanggal', 'desc')->get();
            }
            return DataTables::of($timelineInstagram)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('pics', function ($row) {
                    return $row->pics->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('timelineInstagram.edit', $row->kd_timelineig) . '" class="edit btn btn-warning">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger" data-url="' . route('timelineInstagram.destroy', $row->kd_timelineig) . '" onclick="deleteData(this)">Delete</a>';
                    return $btn;
                })
                ->addColumn('report', function ($row) {
                    if ($row->report) {
                        return '<a href="' . route('timelineInstagram.editReport', $row->kd_timelineig) . '" class="btn btn-warning">Edit Report</a>';
                    } else {
                        return '<a href="' . route('timelineInstagram.report', $row->kd_timelineig) . '" class="btn btn-info">Report</a>';
                    }
                })
                ->rawColumns(['action', 'status', 'report'])
                ->make(true);
        }
        return view('sosmed.timeline.ig.timelineInstagram');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pics = User::role('Content Creator')->get();
        $products = Product::orderBy('nama_product', 'asc')->get();
        return view('sosmed.timeline.ig.create', compact('pics', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_project' => 'required|in:FEED,STORY',
            'status' => 'required',
            'format' => 'required',
            'jenis_konten' => 'required',
            'produk' => 'required|exists:products,nama_product',
            'head_term' => 'required',
            'core_topic' => 'required',
            'subtopic' => 'required',
            'copywriting' => 'required',
            'notes' => 'required',
            'refrensi' => 'required',
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id'
        ], [
            'pics.required' => 'Pics harus diisi',
            'pics.array' => 'Pics harus berupa array',
            'pics.*.exists' => 'Pics harus ada di tabel users',
            'produk.required' => 'Produk harus diisi',
            'produk.exists' => 'Produk harus ada di tabel products',
            'head_term.required' => 'Head term harus diisi',
            'core_topic.required' => 'Core topic harus diisi',
            'subtopic.required' => 'Subtopic harus diisi',
            'copywriting.required' => 'Copywriting harus diisi',
            'notes.required' => 'Notes harus diisi',
            'refrensi.required' => 'Refrensi harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Tanggal harus berupa tanggal',
            'jenis_project.required' => 'Jenis project harus diisi',
            'jenis_project.in' => 'Jenis project harus berupa FEED atau STORY',
            'status.required' => 'Status harus diisi',
            'format.required' => 'Format harus diisi',
            'jenis_konten.required' => 'Jenis konten harus diisi',
        ]);

        $pics = $request->pics ?? [];
        if (!Auth::user()->hasRole('Super Admin') || !Auth::user()->hasPermissionTo('View Sosmed Kadiv Dashboard')) {
            $pics[] = Auth::user()->id;
        }
        $pics = array_unique($pics);

        $timelineInstagram = new TimelineInstagram();
        $timelineInstagram->kd_timelineig = 'TIG-' . date('ymdhis');
        $timelineInstagram->tanggal = $request->tanggal;
        $timelineInstagram->jenis_project = $request->jenis_project;
        $timelineInstagram->status = $request->status;
        $timelineInstagram->format = $request->format;
        $timelineInstagram->jenis_konten = $request->jenis_konten;
        $timelineInstagram->produk = $request->produk;
        $timelineInstagram->head_term = $request->head_term;
        $timelineInstagram->core_topic = $request->core_topic;
        $timelineInstagram->subtopic = $request->subtopic;
        $timelineInstagram->copywriting = $request->copywriting;
        $timelineInstagram->notes = $request->notes;
        $timelineInstagram->refrensi = $request->refrensi;
        $timelineInstagram->save();

        $timelineInstagram->pics()->attach($pics);
        return redirect()->route('timelineInstagram.index')->with('message', 'Data berhasil ditambahkan')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimelineInstagram $timelineInstagram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimelineInstagram $timelineInstagram)
    {
        $pics = User::role('Content Creator')->get();
        $products = Product::orderBy('nama_product', 'asc')->get();
        return view('sosmed.timeline.ig.edit', compact('timelineInstagram', 'pics', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimelineInstagram $timelineInstagram)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_project' => 'required|in:FEED,STORY',
            'status' => 'required',
            'format' => 'required',
            'jenis_konten' => 'required',
            'produk' => 'required|exists:products,nama_product',
            'head_term' => 'required',
            'core_topic' => 'required',
            'subtopic' => 'required',
            'copywriting' => 'required',
            'notes' => 'required',
            'refrensi' => 'required',
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id'
        ], [
            'pics.required' => 'Pics harus diisi',
            'pics.array' => 'Pics harus berupa array',
            'produk.required' => 'Produk harus diisi',
            'produk.exists' => 'Produk harus ada di tabel products',
            'head_term.required' => 'Head term harus diisi',
            'core_topic.required' => 'Core topic harus diisi',
            'subtopic.required' => 'Subtopic harus diisi',
            'copywriting.required' => 'Copywriting harus diisi',
            'notes.required' => 'Notes harus diisi',
            'refrensi.required' => 'Refrensi harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Tanggal harus berupa tanggal',
            'jenis_project.required' => 'Jenis project harus diisi',
            'jenis_project.in' => 'Jenis project harus berupa FEED atau STORY',
            'status.required' => 'Status harus diisi',
            'format.required' => 'Format harus diisi',
            'jenis_konten.required' => 'Jenis konten harus diisi',
        ]);
        $timelineInstagram->tanggal = $request->tanggal;
        $timelineInstagram->jenis_project = $request->jenis_project;
        $timelineInstagram->status = $request->status;
        $timelineInstagram->format = $request->format;
        $timelineInstagram->jenis_konten = $request->jenis_konten;
        $timelineInstagram->produk = $request->produk;
        $timelineInstagram->head_term = $request->head_term;
        $timelineInstagram->core_topic = $request->core_topic;
        $timelineInstagram->subtopic = $request->subtopic;
        $timelineInstagram->copywriting = $request->copywriting;
        $timelineInstagram->notes = $request->notes;
        $timelineInstagram->refrensi = $request->refrensi;
        $timelineInstagram->save();
        $timelineInstagram->pics()->sync($request->pics);

        return redirect()->route('timelineInstagram.index')->with('message', 'Data berhasil diupdate')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimelineInstagram $timelineInstagram)
    {
        $timelineInstagram->pics()->detach();
        $timelineInstagram->delete();
        return redirect()->route('timelineInstagram.index')->with('message', 'Data berhasil dihapus')->with('title', 'Berhasil')->with('type', 'success');
    }

    public function report(String $timelineInstagram)
    {
        return view('sosmed.timeline.ig.report.report_instagram', compact('timelineInstagram'));
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'timeline_instagram_kd' => 'required|exists:timeline_instagrams,kd_timelineig',
            'link_konten' => 'url',
        ]);

        $report = new ReportTimelineInstagram();
        $report->timeline_instagram_kd = $request->timeline_instagram_kd;
        $report->jangkauan = $request->jangkauan;
        $report->interaksi = $request->interaksi;
        $report->aktivitas = $request->aktivitas;
        $report->impresi = $request->impresi;
        $report->like = $request->like;
        $report->comment = $request->comment;
        $report->share = $request->share;
        $report->save = $request->save;
        $report->pengikut = $request->pengikut;
        $report->bukan_pengikut = $request->bukan_pengikut;
        $report->profile = $request->profile;
        $report->beranda = $request->beranda;
        $report->jelajahi = $request->jelajahi;
        $report->lainnya = $request->lainnya;
        $report->tagar = $request->tagar;
        $report->jumlah_pemutaran = $request->jumlah_pemutaran;
        $report->waktu_tonton = $request->waktu_tonton;
        $report->rata = $request->rata;
        $report->link_konten = $request->link_konten;
        $report->save();

        return redirect()->route('timelineInstagram.index')->with('message', 'Data berhasil ditambahkan')->with('title', 'Berhasil')->with('type', 'success');
    }

    public function editReport(TimelineInstagram $timelineInstagram)
    {
        $report = $timelineInstagram->report;
        return view('sosmed.timeline.ig.report.edit_report_instagram', compact('timelineInstagram', 'report'));
    }

    public function updateReport(Request $request, TimelineInstagram $timelineInstagram)
    {
        $request->validate([
            'link_konten' => 'url',
        ]);
        $report = $timelineInstagram->report;
        $report->link_konten = $request->link_konten;
        $report->jangkauan = $request->jangkauan;
        $report->interaksi = $request->interaksi;
        $report->aktivitas = $request->aktivitas;
        $report->impresi = $request->impresi;
        $report->like = $request->like;
        $report->comment = $request->comment;
        $report->share = $request->share;
        $report->save = $request->save;
        $report->pengikut = $request->pengikut;
        $report->bukan_pengikut = $request->bukan_pengikut;
        $report->profile = $request->profile;
        $report->beranda = $request->beranda;
        $report->jelajahi = $request->jelajahi;
        $report->lainnya = $request->lainnya;
        $report->tagar = $request->tagar;
        $report->jumlah_pemutaran = $request->jumlah_pemutaran;
        $report->waktu_tonton = $request->waktu_tonton;
        $report->rata = $request->rata;
        $report->save();
        return redirect()->route('timelineInstagram.index')->with('message', 'Data berhasil diupdate')->with('title', 'Berhasil')->with('type', 'success');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ExportReportTimelineInstagram($request->start_date, $request->end_date, $request->jenis), 'report_timeline_instagram_' . date('Ymdhis') . '.xlsx');
    }
}
