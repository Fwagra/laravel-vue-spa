<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::orderBy('id', 'desc')->take(10)->get();
        $messages = $messages->reverse();
        $messages = $this->formatMessages($messages);

        return response()->json(compact('messages'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'text'  => 'required|max:200'
        ];

        $this->validate($request, $rules);
        $user = $request->user();

        $request->merge([
            'user_id' => $user->id,
            'chatroom' => 1
        ]);
        $message = Message::create($request->input());

        $message = $this->formatMessage($message);

        event(new MessagePosted($message));

        return response()->json(compact('message'));
    }

    /**
     * Format one message, leaving only the Vue's needed values
     * @param $message
     * @return array
     */
    public function formatMessage($message)
    {
        return [
            'text' => $message->text,
            'author' => $message->user->name
        ];
    }

    /**
     * Format many messages, leaving only the Vue's needed values
     * @param $messages
     * @return array
     */
    public function formatMessages($messages)
    {
        $formattedMessages = [];
        foreach ($messages as $message) {
            $formattedMessages[] = $this->formatMessage($message);
        }

        return  $formattedMessages;
    }

}
