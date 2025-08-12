<?php
namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Spending;
use App\Models\Income;
use App\Models\Type;
use App\Models\Child;
use App\Models\UserParent;
use App\Models\Message;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
    public function index() {
        $childId = auth('child')->id();
        $today = Carbon::today();
        $goal = Goal::where('user_id', $childId)->whereDate('date', '>=', $today)->first();//目標表示
        $events = $this->getEventsColorOnly(); 

        $unread = Message::whereNotIn('id', function ($query) use ($childId) {
            $query->select('message_id')
                ->from('message_reads')//未読メッセージカウント
                ->where('user_id', $childId);
        })
                ->where('to_user_id', $childId)
                ->count(); 

        $incomeSum = Income::where('user_id', $childId)->sum('amount');//収入合計
        $spendingSum = Spending::where('user_id', $childId)->sum('amount');//支出合計
        $nowAmount = $incomeSum - $spendingSum;//差額
        $remaining = $goal ? max($goal->amount - $nowAmount, 0) : 0;

        return view('home', [
            'goal' => $goal,
            'events' => $events,
            'unread' => $unread,
            'nowAmount' => $nowAmount,
            'remaining' => $remaining
        ]);
    }

    public function Sindex() {
        $childId = auth('child')->id();
        $spending = new Spending;
        $spends = Spending::where('user_id', $childId)->with('type')->get();


        return view('spend', [
            'spends' => $spends
        ]);
    }

    public function Iindex() {
        $childId = auth('child')->id();
        $income = new Spending;
        $incomes = Income::where('user_id', $childId)->with('type')->get();


        return view('income', [
            'incomes' => $incomes
        ]);
    }


    public function getEventsWithAmount()  //金額も表示→calendar.php
    {
        $childId = auth('child')->id();
        $events = [];

        $spendings = Spending::where('user_id', $childId)
                    ->select('date', \DB::raw('SUM(amount) as total_amount'))
                    ->groupBy('date')
                    ->get();
        $incomes = Income::where('user_id', $childId)
                    ->select('date', \DB::raw('SUM(amount) as total_amount'))
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
        $childId = auth('child')->id();
        $events = [];

        $spendings = Spending::where('user_id', $childId)
                        ->select('date', \DB::raw('SUM(amount) as total_amount'))
                        ->groupBy('date')
                        ->get();
        $incomes = Income::where('user_id', $childId)
                        ->select('date', \DB::raw('SUM(amount) as total_amount'))
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

    public function detailCalendar($date) {
        $childId = auth('child')->id();
        $spending = Spending::where('user_id', $childId)
                    ->whereDate('date', $date)
                    ->with('type')
                    ->get();
        $income = Income::where('user_id', $childId)
                    ->whereDate('date', $date)
                    ->with('type')
                    ->get();

        return view('detail',[
            'spend' => $spending,
            'income' => $income,
            'date' => $date
        ]);
    }


    //-------------------↑↑ここまでカレンダー↑↑------------------------------

    public function graph($year, $month) {  //グラフ表示
        $childId = auth('child')->id();
        $spendData = Spending::where('user_id', $childId)
                        ->whereYear('date', $year)
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

    public function previewGraph($year, $month) {  //グラフPDF
            $childId = auth('child')->id();
            $spendData = Spending::where('user_id', $childId)
                        ->whereYear('date', $year)
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

        return view('pdf', compact('year', 'month', 'graphData', 'totalAmount', 'top3Categories'));
    }
     //-------------------↑↑ここまでグラフ↑↑------------------------------

    //----------------マイページ---------------------------------------
    public function childMypage() {
        $child = auth('child')->user();
        $parent = $child ? $child->parent : null;
        return view('child_mypage', compact('parent', 'child'));
    }

    public function parentMypage() {
        $parent = auth('parent')->user();
        $child = $parent->child;

        if ($child) {
            $childId = $child->id;
            $incomeSum = Income::where('user_id', $childId)->sum('amount');//収入合計
            $spendingSum = Spending::where('user_id', $childId)->sum('amount');//支出合計
            $nowAmount = $incomeSum - $spendingSum;//差額
        }
    
        return view('parent_mypage', compact('parent', 'child', 'nowAmount'));
    }

    public function unlinkChild(){  //子供との紐づけ解除
        $parent = auth('parent')->user();
        $child = $parent->child; 


        if ($child) {
            $child->parent_id = null;
            $child->save();
        }

        return redirect()->route('parent.mypage')->with('success', 'こどもとの紐づけを解除しました');
    }

}
