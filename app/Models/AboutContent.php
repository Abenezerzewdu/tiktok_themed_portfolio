<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = ['key', 'content'];

    /**
     * Get the about me content
     */
    public static function getAboutMe(): ?string
    {
        return static::where('key', 'about_me')->value('content');
    }

    /**
     * Update the about me content
     */
    public static function setAboutMe(string $content): bool
    {
        return static::updateOrCreate(
            ['key' => 'about_me'],
            ['content' => $content]
        ) !== null;
    }
}
