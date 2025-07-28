<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\Spending;
use App\Models\Income;
use App\Models\Type;


class RegistrationController extends Controller
{//----------------目標---------------------------------------
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

    public function editGoal(int $id, Request $request) {  //目標編集
        $G_record = Goal::find($id);

        $G_record->date = $request->date;
        $G_record->amount = $request->amount;

        $G_record->save();
        return redirect('/');
    }

    public function deleteGoal(int $id, Request $request) {  //目標論理削除
        $goal =  Goal::find($id);

        if($goal) {
            $goal->delete();
        }
        return redirect('/');
    }
//-------------------↑↑ここまで目標↑↑------------------------------

//----------------支出---------------------------------------
    public function createSpendForm() {
        $params = Type::where('category_type', '1')->get();
        return view('spend', [
            'types' => $params,
        ]);
            
    }

    public function createSpend(Request $request) {  //支出追加
        $spending = new Spending;

        $spending->date = $request->date;
        $spending->amount = $request->amount;
        $spending->type_id = $request->type_id;
        $spending->comment = $request->comment;
        $spending->save();

        return redirect('/');
    }

//-------------------↑↑ここまで支出↑↑------------------------------

//----------------収入---------------------------------------
    public function createIncomeForm() {
        $params = Type::where('category_type', '0')->get();
        return view('income', [
            'types' => $params,
        ]);
            
    }
    
    public function createIncome(Request $request) {  //支出追加
        $income = new Income;

        $income->date = $request->date;
        $income->amount = $request->amount;
        $income->type_id = $request->type_id;
        $income->comment = $request->comment;
        $income->save();

        return redirect('/');
    }
}
