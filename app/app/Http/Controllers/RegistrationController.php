<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class RegistrationController extends Controller
{
    public function createGoalForm() {
        return view('goal');
    }

    public function createGoal(Request $request) {
        $goal = new Goal;

        $goal->date = $request->date;
        $goal->amount = $request->amount;
        $goal->save();

        return redirect('/');
    }
}
