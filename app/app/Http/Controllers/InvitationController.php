<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invite;
use Carbon\Carbon;

class InvitationController extends Controller
{
    public function invitationForm() {
        return view('invitation');
    }

    public function invitationCode(Request $request)
    {

        $parent = auth('parent')->user();
        $code = $request->input('invite_code');

        $invite = Invite::where('invite_code', $code)
                        ->where('used_flag', 0)
                        ->where(function($query){
                            $query->whereNull('used_at')
                                ->orWhere('used_at', '>', now());
                        })
                        ->first();

        if (!$invite) {
            return back()->withErrors(['invite_code' => '無効または使用期限切れの招待コードです。']);
        }

        // 招待コードを使用済みにして親IDをセット
        $invite->parent_id = $parent->id;
        $invite->used_flag = 1;
        $invite->used_at = now();
        $invite->save();

        // 子供テーブルのparent_id更新（紐づけ）
        $child = $invite->child;
        if ($child) {
            $child->parent_id = $parent->id;
            $child->save();
        }

        return redirect()->route('parent.mypage')->with('success', '子供との紐づけが完了しました。');
    }
    
    public function createInvitation(Request $request) {  //招待コード作成
        
        $child = auth('child')->user();
        if (!$child) {
        \Log::error('createInvitation: child user is null');
        return response()->json(['error' => '認証されていません。'], 401);
    }
        $using = Invite::where('child_id', $child->id)
                    ->where('used_flag', 0)
                    ->where(function($query){
                        $query->whereNull('used_at')
                              ->orWhere('used_at', '>', now());
                    })
                    ->first();

        if ($using) {
            return response()->json(['invite_code' => $using->invite_code]);
        }

        $code = Str::upper(Str::random(8));
        
        $invite = new Invite;
        $invite->invite_code = $code;
        $invite->child_id = $child->id;
        $invite->used_flag = 0;
        $invite->used_at = Carbon::now()->addHours(24);
        $invite->save();
        return response()->json(['invite_code' => $code]); 
    }
        

}
