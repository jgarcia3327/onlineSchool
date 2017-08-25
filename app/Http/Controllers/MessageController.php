<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use View;
use App\Models\Message;

class MessageController extends Controller
{
    //

    public function index() {

        $messages = Message::select("message_to","message_from")->distinct()->where('message_to', Auth::user()->id)->orWhere('message_from', Auth::user()->id)->orderBy('create_date','desc')->get();
        return view("messages.index", compact('messages'));
    }
}
