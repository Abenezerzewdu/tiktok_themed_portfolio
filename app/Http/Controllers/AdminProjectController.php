<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class AdminProjectController extends Controller
{
    public function index(){
      return Inertia::render('Admin');
    }
    public function store(Request $request){
    //validate
    $request->validate([
            'title' => 'required|string',
            'video' => 'required|file|mimes:mp4,mov,avi|max:20000',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
        ]);

    //get video and store
    $videoPath=$request->file('video')->store('videos','public');

    //store the project
    Project::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->description,
            'video_url' => '/storage/' . $videoPath,
            'github_url' => $request->github_url,
            'live_url' => $request->live_url,
            'tech_stack' => explode(',', $request->tech_stack),
        ]);

    //redirect 
        return redirect('/admin');

    }
}
