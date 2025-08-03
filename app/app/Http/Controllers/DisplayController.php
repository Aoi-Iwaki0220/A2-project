<?php
namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Spending;
use App\Models\Income;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index() {//目標表示
        $today = Carbon::today();
        $goal = Goal::whereDate('date', '>=', $today)->first();
        $events = $this->getEventsColorOnly(); 

        return view('home', [
            'goal' => $goal,
            'events' => $events
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


    public function getEventsWithAmount()  //金額も表示→calendar.php
    {
        $events = [];

        $spendings = Spending::select('date', \DB::raw('SUM(amount) as total_amount'))
                    ->groupBy('date')
                    ->get();
        $incomes = Income::select('date', \DB::raw('SUM(amount) as total_amount'))
                         ->groupBy('date')
                         ->get();

        foreach ($spendings as $spend) {
            $events[] = [
                'id' => 'spend_'.$spend->id,
                'title' => 'つかった: ' . number_format($spend->total_amount) . ' 円',
                'start' => $spend->date,
                'color' => 'red',
            ];
        }

        foreach ($incomes as $income) {
            $events[] = [
                'id' => 'income_'.$income->id,
                'title' =>  'もらった: ' . number_format($income->total_amount) . '円',
                'start' => $income->date,
                'color' => 'blue',
            ];
        }

            return $events;
        }

    public function getEventsColorOnly()  //色のみ表示見見→home.php
    {
        $events = [];

        $spendings = Spending::select('date', \DB::raw('SUM(amount) as total_amount'))
                    ->groupBy('date')
                    ->get();
        $incomes = Income::select('date', \DB::raw('SUM(amount) as total_amount'))
                         ->groupBy('date')
                         ->get();

        foreach ($spendings as $spend) {
            $events[] = [
                'id' => 'spend_'.$spend->id,
                'title' => '' ,
                'start' => $spend->date,
                'color' => 'red',
            ];
        }

        foreach ($incomes as $income) {
            $events[] = [
                'id' => 'income_'.$income->id,
                'title' =>  '' ,
                'start' => $income->date,
                'color' => 'blue',
            ];
        }

            return $events;
        }

    public function calendarIndex()  //calendar.php
    {
        $events = $this->getEventsWithAmount();
        return view('calendar', compact('events'));
    }

    public function homeIndex()  //home.php
    {
        $events = $this->getEventsColorOnly();
        return view('home', compact('events'));
    }

    public function detailCalendar($date) {

        $spending = Spending::whereDate('date', $date)->with('type')->get();
        $income = Income::whereDate('date', $date)->with('type')->get();

        return view('detail',[
            'spend' => $spending,
            'income' => $income,
            'date' => $date
        ]);
    }

    //-------------------↑↑ここまでカレンダー↑↑------------------------------

    public function graph($year, $month) {

        $spendData = \App\Models\Spending::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->selectRaw('type_id, SUM(amount) as total')
        ->groupBy('type_id')
        ->with('type') 
        ->get();

        $totalAmount = $spendData->sum('total');
        $graphData = $spendData->map(function ($item)  {
            return [
                'label' => $item->type->name ?? '未分類',
                'value' => $item->total,
            ];
        });


        $top3Categories = $spendData->sortByDesc('total')->take(3)->map(function($item) {
            return [
                'name' => $item->type->name ?? '未分類',
                'amount' => $item->total,
        ];
        });

        return view('graph', compact('year', 'month', 'graphData', 'totalAmount', 'top3Categories'));
    }
}
