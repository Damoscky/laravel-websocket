<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats');
    }

    public function fetchMessages()
    {
        $messages = Message::with('user')->get();
        return $messages;
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->message()->create([
            'message' => $request->message
        ]);
        broadcast(new MessageSent($message->load('user')))->toOthers();
        return ['status' => 'success'];
    }

    public function users()
    {
        return User::all();
    }
}
