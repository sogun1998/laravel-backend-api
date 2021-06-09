<?php

namespace App\Http\Controllers\ChatManage;

use App\Chatroom;
use App\Events\MessagePosted;
use App\Http\Controllers\Controller;
use App\Message;
use App\Phuhuynh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function index (Request $request) {
        $messages = Message::with(['sender', 'receiver'])
            ->where('room', $request->query('room', ''))
//            ->latest()
            ->paginate(50);
        return $messages;
//        return "hello";
    }
    public function store (Request $request) {
        $message = new Message();
        $message->sender = Auth::user()->id;
        $message->content = $request->input('content', '');
        $message->sender_role = $request->input('sender_role', '');
        if ($request->has('receiver') && $request->input('receiver')) {
            $receiver = (int) $request->input('receiver');
            $message->receiver = $receiver;
            $message->receiver_role = $request->input('receiver_role','');
            $message->room = "";
//            $message->room = $message->sender < $receiver ? $message->sender.'__'.$receiver : $receiver.'__'.$message->sender;
        } else {
            $message->room = $request->input('room');
        }

        $message->save();

//        broadcast(new MessagePosted($message->load(['sender', 'reactions.user'])))->toOthers(); // send to others EXCEPT user who sent this message
        broadcast(new MessagePosted($message->load('sender')))->toOthers();
        return response()->json(['message' => $message->load(['sender'])]);
    }
    public function makeRoom (Request $request) {
        $room = Chatroom::create([
//            'name', 'description','lophoc_id'
            'name'=>$request->name,
            'description'=>$request->description,
            'lophoc_id'=>$request->lophoc_id,
//            'grade'=>$request->grade,
//            'canBeKeyTeacher'=> true
        ]);
        return response()->json([
            'status_code' => 200,
            'message' => "Room created successfully.",
            'data' => [
//                "class"=>$request->teacher_id,
                "room"=> $room

            ],
        ]);
    }
    public function showRoom($id)
    {
        if (Chatroom::where('id', $id)->exists()) {
            $room = Chatroom::find($id);
            return $room;
        } else {
            return response()->json([
                "message" => "Room not found"
            ], 404);
        }
    }
    public function getKeyTeacher($id)
    {
        if (Phuhuynh::where('id', $id)->exists()) {
            $parent = Phuhuynh::find($id);
//            return $room;
            return  $parent->student->class->teacher;

        } else {
            return response()->json([
                "message" => "Parent not found"
            ], 404);
        }
    }


}
