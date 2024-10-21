<?php

namespace App\Http\Controllers;

use App\Models\ReportTikTok;
use App\Models\ReportTikTokLive;
use App\Models\ReportTimelineInstagram;
use App\Models\TimelineInstagram;
use App\Models\TimelineTiktok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('permission:View Superadmin Dashboard|View Sosmed Kadiv Dashboard|View Sosmed Pegawai Dashboard', only: ['index'])];
    }

    public function index()
    {
        if (Auth::user()->can('View Sosmed Kadiv Dashboard') || Auth::user()->can('View Sosmed Kadiv Dashboard')) {
            $data['pegawai'] = User::role('Content Creator')
                ->whereDoesntHave('permissions', function ($query) {
                    $query->where('name', 'View Sosmed Kadiv Dashboard');
                })
                ->get();
            $data['tiktok_video'] = ReportTikTok::count();
            $data['feed_instagram'] = TimelineInstagram::where('jenis_project', 'FEED')->whereMonth('tanggal', now()->month)->count();
            $data['story_instagram'] = TimelineInstagram::where('jenis_project', 'STORY')->whereMonth('tanggal', now()->month)->count();
            $data['total_project_ig'] = TimelineInstagram::whereMonth('tanggal', now()->month)->count();
            $data['total_project_tiktok'] = TimelineTiktok::whereMonth('tanggal', now()->month)->count();
            $data['total_project_live'] = ReportTikTokLive::whereMonth('tanggal', now()->month)->count();
            $data['total_project_all'] = $data['total_project_ig'] + $data['total_project_tiktok'] + $data['total_project_live'];
            $data['project_ongoing'] = TimelineInstagram::where('status', '!=', 'Upload')->whereMonth('tanggal', now()->month)->count();
            $data['project_completed'] = TimelineInstagram::where('status', 'Upload')->whereMonth('tanggal', now()->month)->count();
            // $data['new_tiktok_follower'] = ReportTikTok::where('tanggal', '>=', now()->subDays(7))->whereMonth('tanggal', now()->month)->sum('pengikut_baru');
            $data['new_tiktok_follower'] = ReportTikTok::whereHas('timeline', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut_baru');
            // $data['new_ig_follower'] = ReportTimelineInstagram::where('tanggal', '>=', now()->subDays(7))->whereMonth('tanggal', now()->month)->sum('pengikut');
            $data['new_ig_follower'] = ReportTimelineInstagram::whereHas('timelineInstagram', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut');
        } else {
            $data['tiktok_video'] = TimelineTiktok::whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['feed_instagram'] = TimelineInstagram::where('jenis_project', 'FEED')
                ->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['story_instagram'] = TimelineInstagram::where('jenis_project', 'STORY')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['total_project_ig'] = TimelineInstagram::whereHas('pics', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->whereMonth('tanggal', now()->month)->count();
            $data['total_project_tiktok'] = TimelineTiktok::whereHas('pics', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->whereMonth('tanggal', now()->month)->count();
            $data['total_project_live'] = ReportTikTokLive::whereHas('pics', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->whereMonth('tanggal', now()->month)->count();
            $data['total_project_all'] = $data['total_project_ig'] + $data['total_project_tiktok'] + $data['total_project_live'];

            $data['project_ongoing'] = TimelineInstagram::where('status', '!=', 'Upload')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->count();

            $data['project_completed'] = TimelineInstagram::where('status', 'Upload')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->count();

            $data['new_tiktok_follower'] = ReportTikTok::whereHas('timeline', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut_baru');
            $data['new_ig_follower'] = ReportTimelineInstagram::whereHas('timelineInstagram', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut');
        }
        return view('dashboards.dashboard', $data);
    }

    public function detailProject(Request $request, string $user_id)
    {
        $data['user'] = User::find($user_id);

        if ($request->ajax()) {
            $table = $request->input('table');

            switch ($table) {
                case 'timeline_ig':
                    return $this->getTimelineIgDataTable($user_id);
                case 'timeline_tiktok':
                    return $this->getTimelineTiktokDataTable($user_id);
                case 'tiktok_live':
                    return $this->getTiktokLiveDataTable($user_id);
                default:
                    return response()->json(['error' => 'Invalid table specified'], 400);
            }
        }

        return view('sosmed.project_by_pegawai.detail_project', $data);
    }

    private function getTimelineIgDataTable($user_id)
    {
        $query = TimelineInstagram::whereHas('pics', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('tanggal', 'desc')->get();

        return DataTables::of($query)
            ->addIndexColumn('DT_RowIndex')
            ->addColumn('pics', function ($row) {
                return $row->pics->pluck('name')->implode(', ');
            })
            ->rawColumns(['pics'])
            ->toJson();
    }

    private function getTimelineTiktokDataTable($user_id)
    {
        $query = TimelineTiktok::whereHas('pics', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('tanggal', 'desc')->get();

        return DataTables::of($query)
            ->addIndexColumn('DT_RowIndex')
            ->addColumn('tanggal', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
            })
            ->addColumn('pics', function ($row) {
                return $row->pics->pluck('name')->implode(', ');
            })
            ->toJson();
    }

    private function getTiktokLiveDataTable($user_id)
    {
        $query = ReportTikTokLive::whereHas('pics', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('tanggal', 'desc')->get();

        return DataTables::of($query)
            ->addIndexColumn('DT_RowIndex')
            ->addColumn('tanggal', function ($row) {
                return date('d F Y', strtotime($row->tanggal));
            })
            ->addColumn('pics', function ($row) {
                return $row->pics->pluck('name')->implode(', ');
            })
            ->toJson();
    }
}
