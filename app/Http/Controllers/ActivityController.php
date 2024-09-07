<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Resources\ActivityResource;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index()
    {
        return ActivityResource::collection(Activity::all());
    }

    public function insert(Request $request){
        $activity = new Activity();
        $activity->title = $request->title;
        $activity->description = $request->description;        
        $activity->start_datetime = Carbon::parse($request->start_datetime)->format('Y-m-d H:i:s');
        $activity->location = $request->location;
        $activity->media = $request->media;
        if ($activity->media === "video" && $activity->media_url !== null && $activity->media_url !== "") {
            $videoId = substr($request->media_url, strpos($request->media_url, "=") + 1);
            $activity->media_url = "https://www.youtube.com/embed/" . $videoId;
        } else {
            $activity->media_url = $request->media_url;
        }
        $activity->save();
        return new ActivityResource($activity);
    }
}
