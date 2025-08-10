<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Child;
use App\Models\UserParent;
use App\Models\Message;
use App\Models\MessageRead;

class MessageController extends Controller
{
    public function sendMessageForm() { //メッセージ表示
        $parent = Auth::guard('parent')->user();

        $child = $parent->child;

        $messages = Message::where('from_user_id', $parent->id)
                ->where('to_user_id', optional($child)->id)
                ->with('reads')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('message', compact('child', 'messages'));
    }
    public function sendMessage(Request $request) {  //メッセージ送信
        $parent = auth('parent')->user(); // 保護者ログイン中

        $message = new Message();
        $message->message = $request->message;
        $message->from_user_id = $parent->id;  
        $message->to_user_id = $request->to_user_id;
        $message->save();

        return redirect()->route('parent.mypage')->with('success', 'メッセージの送信が完了しました');
    }

    public function messageListForm() {  //受信メッセージ表示
        $child = auth('child')->user();
        $messages = Message::where('to_user_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->with(['fromUser', 'reads']) 
            ->get();

        return view('message_list', compact('messages'));
    }

    public function messageRead(int $id, Request $request) {
        $child = auth('child')->user();

        $exists = \App\Models\MessageRead::where('message_id', $id)
                ->where('user_id', $child->id)
                ->exists();

        if (!$exists) {
            \App\Models\MessageRead::create([
                'message_id' => $id,
                'user_id' => $child->id,
                'read_at' => now(),
            ]);
        }

        return redirect()->route('message.list');
    }
}
