<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $courses = Course::with('user')->withProgressFor($request->user())->latest()->get();

        return view('home', compact('courses'));
    }
}
