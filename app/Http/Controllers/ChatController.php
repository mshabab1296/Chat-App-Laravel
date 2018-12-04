<?php

namespace App\Http\Controllers;

use App\Events\NewMessageNotification;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;
use Response;

class ChatController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$user_id = Auth::user()->id;
    	$senders = User::where('id', '!=', Auth::user()->id)->get();
    	return view('user.chat')->with(compact('user_id', 'senders'));
    }

    public function sendMessage(Request $request)
    {
    	$message = new Message;
    	$message->from    = Auth::user()->id;
    	$message->to      = $request->to_id;
    	$message->message = $request->message;
    	$message->time    = time();
    	$message->save();
    	event(new NewMessageNotification($message));
    	return Response::json($message, 200);
    }
}
