<?php
namespace App\Http\Controllers;

use App\Models\Goal;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index() {
        $goal = new Goal;
        $all = Goal::withTrashed()->get()->toArray();

        return view('home', [
            'goals' => $all
        ]);
    }
}
