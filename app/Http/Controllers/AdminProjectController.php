<?php

namespace App\Http\Controllers;
 use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
class AdminProjectController extends Controller
{
    public function index(){
      return Inertia::render('Admin');
    }


    public function store(Request $request){
    //validate
    //  dd([
    //     'hasFile' => $request->hasFile('video'),
    //     'file' => $request->file('video'),
    //     'all' => $request->all(),
    // ]);
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
// dd($request->file('video'));
// stores files less that 2mb since herd php.ini is not editable
    //redirect 
        return redirect('/admin');

    }

    public function message(){
    
    return  Inertia::render('Message');
    }



public function storeMessage(Request $request)
{
    // 1. Validate input
    $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // 2. Store in DB
    $message = Message::create($validated);

    // 3. Prepare safe values
    $name = $validated['name'] ?? 'Anonymous';
    $email = $validated['email'];
    $body = $validated['message'];

    // Escape text for Telegram HTML safety
    $name = e($name);
    $email = e($email);
    $body = e($body);

    // 4. Format message (clean + readable)
    $text = trim("
<b>📩 New Contact Message</b>

<b>👤 Name:</b> {$name}
<b>📧 Email:</b> {$email}

<b>💬 Message:</b>
{$body}
");

    // 5. Get config safely
    $token = config('services.telegram.bot_token');
    $chatId = config('services.telegram.chat_id');

    if (!$token || !$chatId) {
        Log::warning('Telegram not configured properly');
        return back()->with('success', 'Message sent successfully!');
    }

    // 6. Send (fast + controlled)
    try {
        Http::timeout(10) // faster fail
            ->retry(2, 200) // retry 2 times (200ms delay)
            ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
    } catch (\Throwable $e) {
        // Silent fail for user, log for you
        Log::error('Telegram send failed', [
            'error' => $e->getMessage(),
        ]);
    }

    // 7. Always respond fast to user
    return back()->with('success', 'Message sent successfully!');
}


    // just class hw
    // public function apis(Request $request) {
    // $request->validate([
    //         'message' => 'required|string',
    //         'data' => 'required|string'
    //         ]);
            
    // return response()->json([
    //     'message' => 'Product created',
    //     'data' => $request->all()
    // ]);}

}
