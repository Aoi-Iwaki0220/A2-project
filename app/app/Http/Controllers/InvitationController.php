<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invite;

class InvitationController extends Controller
{
    public function invitationForm() {
        return view('invitation');
    }

    public function invitationCode(Request $request) {  //招待コード入力
        $code = $request->invite_code;

        return redirect('parent_mypage');
    }
    public function createInvitation(Request $request) {  //招待コード作成
        $code = Str::upper(Str::random(8));
        
        $invite = new Invite;
        $invite->invite_code = $code;
        //$invite->child_id = $request->child_id;
        $invite->save();
        return response()->json(['invite_code' => $code]); 
    }
        
}
