<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\UserParent;
use App\Http\Controllers\DisplayController;

class AdminController extends Controller
{
    public function index(){
        return view('management'); 
    }

    public function searchUser(Request $request){
        $parentQuery = UserParent::with('child');
        $childQuery = Child::with('parent');

        if ($request->filled('name')) {//名前検索
            $parentQuery->where('name', 'like', '%' . $request->name . '%');
            $childQuery->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('start_date')) {//日付検索
            $parentQuery->whereDate('created_at', '>=', $request->start_date);
            $childQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $parentQuery->whereDate('created_at', '<=', $request->end_date);
            $childQuery->whereDate('created_at', '<=', $request->end_date);
        }

        $sort = $request->input('sort', 'desc'); // デフォルトは降順
        $parentQuery->orderBy('created_at', $sort);
        $childQuery->orderBy('created_at', $sort);

        $parents = $parentQuery->get();
        $children = $childQuery->get();
        $users = $parents->merge($children);

        if ($sort === 'asc') {
            $users = $users->sortBy('created_at');
        } else {
            $users = $users->sortByDesc('created_at');
        }

        return view('user_list', compact('users', 'request'));
    }
    //-------------------↑↑ここまでユーザー検索↑↑------------------------------

    public function searchUserHistory(Request $request)
{
    $userId = $request->input('user_id');
    $name = $request->input('name');
    $userType = $request->input('user_type'); // parent/child/admin などあれば
    $sort = $request->input('sort', 'desc'); 

    // 支出検索
    $spendsQuery = \DB::table('spendings')
        ->join('children', 'spendings.user_id', '=', 'children.id')
        ->select(
        'spendings.id',
        'spendings.user_id',
        \DB::raw("'child' as user_type"),
        \DB::raw("'支出作成' as action"),
        'spendings.amount',
        'spendings.created_at',
        'children.name as user_name'
    );

    // 収入検索
    $incomesQuery = \DB::table('incomes')
        ->join('children', 'incomes.user_id', '=', 'children.id')
        ->select(
        'incomes.id',
        'incomes.user_id',
        \DB::raw("'child' as user_type"),
        \DB::raw("'収入作成' as action"),
        'incomes.amount',
        'incomes.created_at',
        'children.name as user_name'
        
    );

    // 目標検索
    $goalsQuery = \DB::table('goals')
        ->join('children', 'goals.user_id', '=', 'children.id')
        ->select(
        'goals.id',
        'goals.user_id',
        \DB::raw("'child' as user_type"),
        \DB::raw("'目標設定' as action"),
        'goals.amount',
        'goals.created_at',
        'children.name as user_name'
    );

    if ($name) {        // 名前で絞り込み（部分一致）
        $spendsQuery->where('children.name', 'like', '%' . $name . '%');
        $incomesQuery->where('children.name', 'like', '%' . $name . '%');
        $goalsQuery->where('children.name', 'like', '%' . $name . '%');
    }
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    if ($startDate) {
        $spendsQuery->whereDate('spendings.created_at', '>=', $startDate);
        $incomesQuery->whereDate('incomes.created_at', '>=', $startDate);
        $goalsQuery->whereDate('goals.created_at', '>=', $startDate);
    }
    if ($endDate) {
        $spendsQuery->whereDate('spendings.created_at', '<=', $endDate);
        $incomesQuery->whereDate('incomes.created_at', '<=', $endDate);
        $goalsQuery->whereDate('goals.created_at', '<=', $endDate);
    }

    $unionQuery = $spendsQuery
        ->unionAll($incomesQuery)
        ->unionAll($goalsQuery);

    // 結果を取得
    $histories = \DB::table(\DB::raw("({$unionQuery->toSql()}) as histories"))
        ->mergeBindings($unionQuery)
        ->orderBy('created_at', $sort)
        ->paginate(10);

    return view('user_history', compact('histories', 'request'));
}
}
