<?php
namespace App\Http\Controllers;

use App\Models\Goal;
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
}
