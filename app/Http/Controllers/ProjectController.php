<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(){
      $projects=Project::where('is_published',true)->latest()->get();

      return Inertia::render('Home',[
      'projects'=>$projects
      ]);
    }

    
    public function show($slug)
{
    $project = Project::where('slug', $slug)->firstOrFail();

    return Inertia::render('ProjectDetail', [
        'project' => $project
    ]);
}
}
