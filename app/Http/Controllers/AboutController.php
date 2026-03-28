<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    /**
     * Display the about chronicle page
     */
    public function index()
    {
        $aboutText = AboutContent::getAboutMe() ?? "In this chapter, I write of Abenezer — an Ethiopian web developer, shaped by curiosity and driven by the craft of building. With Laravel as a trusted tool and modern technologies as companions, I design and develop systems that are not only functional, but purposeful.\n\nMy work lives at the intersection of structure and creativity — from crafting seamless user interfaces to engineering the logic that powers them. Each project I take on is an opportunity to solve real problems, explore new ideas, and deliver experiences that feel both intuitive and refined.\n\nThough the path is ever unfolding, I move forward with intention — learning, building, and improving with every step. In this ongoing chronicle, my code becomes the ink, and each solution a mark of progress toward something greater.";

        return Inertia::render('AboutChronicle', [
            'aboutText' => $aboutText,
        ]);
    }

    /**
     * Update the about content (admin only)
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
        ]);

        AboutContent::setAboutMe($request->content);

        return redirect()->back()->with('success', 'About content updated successfully.');
    }
}
