<?php
namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Spending;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index() {
        $goal = new Goal;
        $today = Carbon::today();
        $all = Goal::whereDate('date', '>=', $today)->first();

        return view('home', [
            'goals' => $all
        ]);
    }

    public function Sindex() {
        $spending = new Spending;
        $spends = $spending->all();

        $spend_with_type = $spending->with('type')->first()->toArray();

        return view('spend', [
            'spends' => $spends
        ]);
    }

    public function Iindex() {
        $income = new Spending;
        $incomes = $income->all();

        $income_with_type = $income->with('type')->first()->toArray();

        return view('income', [
            'incomes' => $incomes
        ]);
    }
}
