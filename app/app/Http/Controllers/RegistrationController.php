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
        $spending->user_id = auth('child')->id();
        $spending->save();

        return redirect('child_mypage');
    }

    public function deleteSpend(int $id, Request $request) {  //支出論理削除
        $spending =  Spending::find($id);

        if($spending) {
            $spending->delete();
        }
        return redirect('calendar');
    }

    public function editSpendForm(int $id, Request $request) {
        $spending = new Spending;
        $type = 1;

        $spend_result = $spending->find($id);
        $types = Type::where('category_type', $type)->get();

        return view('detail_edit', [
            'id' => $id,
            'spend_result' => $spend_result,
            'types' => $types,
        ]);
    }

    public function editSpend(int $id, Request $request) {  //支出編集
        $spending = new Spending;
        $spend_record = $spending->find($id);

        $spend_record->amount = $request->amount;
        $spend_record->date = $request->date;
        $spend_record->type_id = $request->type_id;
        $spend_record->comment = $request->comment;

        $spend_record->save();

        return redirect('calendar');

    }

//-------------------↑↑ここまで支出↑↑------------------------------

//----------------収入---------------------------------------
    public function createIncomeForm() {
        $params = Type::where('category_type', '0')->get();
        return view('income', [
            'types' => $params,
        ]);
            
    }
    
    public function createIncome(Request $request) {  //収入追加
        $income = new Income;

        $income->date = $request->date;
        $income->amount = $request->amount;
        $income->type_id = $request->type_id;
        $income->comment = $request->comment;
        $income->save();

        return redirect('child_mypage');
    }

    public function deleteIncome(int $id, Request $request) {  //収入論理削除
        $income =  Income::find($id);

        if($income) {
            $income->delete();
        }
        return redirect('calendar');
    }

    public function editIncomeForm(int $id, Request $request) {
        $income = new Income;
        $subject1 = 'いくらもらった？';
        $type = 0;

        $income_result = $income->find($id);
        $types = Type::where('category_type', $type)->get();

        return view('detail_edit', [
            'id' => $id,
            'income_result' => $income_result,
            'types' => $types,
        ]);
    }

    public function editIncome(int $id, Request $request) {  //収入編集
        $income = new Income;
        $income_record = $income->find($id);

        $income_record->amount = $request->amount;
        $income_record->date = $request->date;
        $income_record->type_id = $request->type_id;
        $income_record->comment = $request->comment;

        $income_record->save();

        return redirect('calendar');

    }
}
