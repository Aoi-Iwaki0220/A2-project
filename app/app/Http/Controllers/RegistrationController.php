<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class RegistrationController extends Controller
{
    public function createGoalForm() {
        return view('goal');
    }

    public function createGoal(Request $request) {  //目標追加
        $goal = new Goal;

        $goal->date = $request->date;
        $goal->amount = $request->amount;
        $goal->save();

        return redirect('/');
    }

    public function editGoalForm(int $id) {
        $goal = new Goal;
        $result = $goal->find($id);

        return view('goal_edit', [
            'id' => $id,
            'result' => $result,
        ]);
    }

    public function editGoal(int $id, Request $request) {
        $G_record = Goal::find($id);

        $G_record->date = $request->date;
        $G_record->amount = $request->amount;

        $G_record->save();
        return redirect('/');
    }
}
