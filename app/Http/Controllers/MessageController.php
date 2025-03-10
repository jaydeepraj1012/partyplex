<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the conversations.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all users the current user has exchanged messages with
        $conversations = User::whereIn('id', function ($query) use ($userId) {
                $query->select('sender_id')
                    ->from('messages')
                    ->where('receiver_id', $userId)
                    ->union(
                        DB::table('messages')
                            ->select('receiver_id')
                            ->where('sender_id', $userId)
                    );
            })
            ->withCount(['receivedMessages as unreadCount' => function ($query) use ($userId) {
                $query->where('sender_id', '!=', $userId)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false);
            }])
            ->get();
            
        // Get the last message for each conversation
        foreach ($conversations as $user) {
            $user->lastMessage = Message::where(function ($query) use ($userId, $user) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', $user->id);
                })
                ->orWhere(function ($query) use ($userId, $user) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $userId);
                })
                ->latest()
                ->first();
        }
        
        // Update current user's online status
        $currentUser = Auth::user();
        $currentUser->is_online = true;
        $currentUser->last_seen = now();
        $currentUser->save();
        
        return view('messages.index', compact('conversations'));
    }

    /**
     * Show the conversation with a specific user.
     */
    public function show(User $user)
    {
        $userId = Auth::id();
        $receiver = $user;
        
        // Check if there's a booking related to this conversation
        $bookingId = request('booking_id');
        $booking = null;
        if ($bookingId) {
            $booking = Booking::find($bookingId);
            
            // Make sure the booking belongs to either the current user or the receiver
            if ($booking && ($booking->user_id !== $userId && $booking->venue->user_id !== $userId)) {
                return redirect()->route('messages.index')->with('error', 'You are not authorized to view this booking.');
            }
        }
        
        // Get messages between the current user and the receiver
        $messages = Message::where(function ($query) use ($userId, $receiver) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($query) use ($userId, $receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
            
        // Mark messages as read
        Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Update current user's online status
        $currentUser = Auth::user();
        $currentUser->is_online = true;
        $currentUser->last_seen = now();
        $currentUser->save();
            
        return view('messages.show', compact('receiver', 'messages', 'booking'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required_without:attachment|string|nullable',
            'attachment' => 'nullable|file|max:5120', // 5MB max
            'booking_id' => 'nullable|exists:bookings,id',
        ]);
        
        $attachmentPath = null;
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }
        
        // Create the message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'booking_id' => $request->booking_id,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_read' => false
        ]);
        
        // Get the sender
        $sender = Auth::user();
        
        try {
            // Broadcast message sent event
            broadcast(new MessageSent($message, $sender))->toOthers();
            $broadcastSuccess = true;
        } catch (\Exception $e) {
            // Log broadcasting error but continue
            \Log::error('Broadcasting error: ' . $e->getMessage());
            $broadcastSuccess = false;
        }
        
        // Update current user's online status
        $sender->is_online = true;
        $sender->last_seen = now();
        $sender->save();
        
        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'broadcast_success' => $broadcastSuccess,
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'attachment' => $message->attachment,
                    'attachment_url' => $message->attachment ? asset('storage/' . $message->attachment) : null,
                    'created_at' => $message->created_at->format('M d, g:i A'),
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    /**
     * Get user online status
     */
    public function getUserStatus(User $user)
    {
        return response()->json([
            'is_online' => $user->is_online,
            'last_seen' => $user->last_seen ? $user->last_seen->diffForHumans() : null
        ]);
    }
    
    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
        ]);
        
        Message::where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }
}
