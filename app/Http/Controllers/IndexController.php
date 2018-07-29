<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Title;
use App\Text;
use App\Team;
use App\Project;
use App\Activity;
use App\Gallery;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Array_;

class IndexController extends Controller
{
    public function index(){
        $titles = Title::first();
        $texts = Text::first();
        $team = Team::where('is_active', 1)->get();
        $gallery = Gallery::all();
        return view('index',compact('titles','texts', 'team', 'gallery'));
    }

    public function api(){
        $array = [];
        $titles = Title::first();
        $texts = Text::first();
        $activities = Activity::all();
        $projects = Project::all();
        array_push($array, $titles, $texts, $activities, $projects);
        return $array;
    }

    public function store(Request $request){
        return Contact::create([
           'name' => $request->input('name'),
           'surname' => $request->input('surname'),
           'email' => $request->input('email'),
           'subject' => $request->input('subject'),
           'message' => $request->input('message'),
        ]);
    }

    public function projects(){
        $projects = Project::all();
        return view('projects', compact('projects'));
    }

    public function activities(){
        $activities = Activity::all();
        return view('activities', compact('activities'));
    }

    public function ctf(){
        return view('ctf');
    }

    public function testpage(){
        /*$before = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç');
        $after   = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c');
        $url = str_replace($before, $after, $val);
        $url = preg_replace('/[^a-zA-Z0-9 ]/', '', $url);
        $url = preg_replace('!\s+!', '-', $url);
        $url = strtolower(trim($url, '-'));
        return $url;*/
    }
}
