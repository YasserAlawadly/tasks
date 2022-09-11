<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::where('count' , '>' , 0)->orderBy('count' , 'desc')->take(10)->get();

        //another solution if we don't need to create statistics table

//        $users = User::whereHas("roles", function($q){ $q->where("name", "user"); })
//            ->withCount('userTasks')
//            ->whereHas('userTasks')
//            ->orderBy('user_tasks_count', 'desc')
//            ->take(10)->get();

        return view('statistics.index' , compact('statistics'));
    }

}
