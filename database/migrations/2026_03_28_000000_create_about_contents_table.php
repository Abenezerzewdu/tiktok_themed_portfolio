<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->default('about_me');
            $table->text('content');
            $table->timestamps();
        });

        // Insert default about text
        DB::table('about_contents')->insert([
            'key' => 'about_me',
            'content' => "In this chapter, I write of Abenezer — an Ethiopian web developer, shaped by curiosity and driven by the craft of building. With Laravel as a trusted tool and modern technologies as companions, I design and develop systems that are not only functional, but purposeful.\n\nMy work lives at the intersection of structure and creativity — from crafting seamless user interfaces to engineering the logic that powers them. Each project I take on is an opportunity to solve real problems, explore new ideas, and deliver experiences that feel both intuitive and refined.\n\nThough the path is ever unfolding, I move forward with intention — learning, building, and improving with every step. In this ongoing chronicle, my code becomes the ink, and each solution a mark of progress toward something greater.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
