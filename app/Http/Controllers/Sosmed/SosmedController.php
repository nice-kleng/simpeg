<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\ReportTikTok;
use App\Models\ReportTimelineInstagram;
use App\Models\TimelineInstagram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SosmedController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Sosmed Kadiv Dashboard|View Sosmed Pegawai Dashboard', only: ['index'])
        ];
    }
    public function index()
    {
        if (Auth::user()->can('View Sosmed Kadiv Dashboard')) {
            $data['pegawai'] = User::role('Content Creator')
                ->whereDoesntHave('permissions', function ($query) {
                    $query->where('name', 'View Sosmed Kadiv Dashboard');
                })
                ->get();
            $data['tiktok_video'] = ReportTikTok::count();
            $data['feed_instagram'] = TimelineInstagram::where('jenis_project', 'FEED')->whereMonth('tanggal', now()->month)->count();
            $data['story_instagram'] = TimelineInstagram::where('jenis_project', 'STORY')->whereMonth('tanggal', now()->month)->count();
            $data['project_new'] = TimelineInstagram::where('status', 'Started')->whereMonth('tanggal', now()->month)->count();
            $data['project_ongoing'] = TimelineInstagram::where('status', 'On Going')->whereMonth('tanggal', now()->month)->count();
            $data['project_completed'] = TimelineInstagram::where('status', 'Upload')->whereMonth('tanggal', now()->month)->count();
            // $data['new_tiktok_follower'] = ReportTikTok::where('tanggal', '>=', now()->subDays(7))->whereMonth('tanggal', now()->month)->sum('pengikut_baru');
            $data['new_tiktok_follower'] = ReportTikTok::whereMonth('tanggal', now()->month)->sum('pengikut_baru');
            // $data['new_ig_follower'] = ReportTimelineInstagram::where('tanggal', '>=', now()->subDays(7))->whereMonth('tanggal', now()->month)->sum('pengikut');
            $data['new_ig_follower'] = ReportTimelineInstagram::whereHas('timelineInstagram', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut');
        } else {
            $data['tiktok_video'] = ReportTikTok::whereMonth('tanggal', now()->month)
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

            $data['project_new'] = TimelineInstagram::where('status', 'Started')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['project_ongoing'] = TimelineInstagram::where('status', 'On Going')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['project_completed'] = TimelineInstagram::where('status', 'Upload')->whereMonth('tanggal', now()->month)
                ->whereHas('pics', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();

            $data['new_tiktok_follower'] = ReportTikTok::whereMonth('tanggal', now()->month)->sum('pengikut_baru');
            $data['new_ig_follower'] = ReportTimelineInstagram::whereHas('timelineInstagram', function ($query) {
                $query->whereMonth('tanggal', now()->month);
            })->sum('pengikut');
        }
        return view('sosmed.dashboard', $data);
    }
}
