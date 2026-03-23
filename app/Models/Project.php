<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   protected $fillable = [
    'title',
    'slug',
    'description',
    'video_url',
    'thumbnail_url',
    'github_url',
    'live_url',
    'tech_stack',
    'is_published',

   ];

   protected $casts = [
    'tech_stack' => 'array',
    'is_published' => 'boolean',
];
}
