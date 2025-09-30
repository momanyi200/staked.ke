<?php
// app/Http/Controllers/Messaging/MessageController.php
namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()->with('users')->get();
        return view('messaging.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        return view('messaging.conversation', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string']);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json($message->load('sender'));
    }

    public function fetch(Conversation $conversation)
    {
        $messages = $conversation->messages()
            ->with(['sender', 'readers'])
            ->latest()->take(50)->get()
            ->reverse()->values();

        // mark messages as read
        foreach ($messages as $message) {
            if ($message->user_id !== auth()->id()) {
                $message->readers()->syncWithoutDetaching([
                    auth()->id() => ['is_read' => true],
                ]);
            }
        }

        return response()->json($messages);
    }

    public function start(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $conversation = Conversation::create();
        $conversation->users()->attach([auth()->id(), $request->user_id]);

        return redirect()->route('messaging.show', $conversation);
    }

    public function typing(Conversation $conversation)
    {
        cache()->put("typing_{$conversation->id}_" . auth()->id(), true, now()->addSeconds(5));
        return response()->json(['status' => 'ok']);
    }

    public function typingStatus(Conversation $conversation)
    {
        $others = $conversation->users->where('id', '!=', auth()->id());
        $typingUsers = [];

        foreach ($others as $user) {
            if (cache()->has("typing_{$conversation->id}_{$user->id}")) {
                $typingUsers[] = $user->name;
            }
        }

        return response()->json($typingUsers);
    }

    public function unreadCount()
    {
        $count = auth()->user()->unreadMessagesCount();
        return response()->json(['count' => $count]);
    }

}
