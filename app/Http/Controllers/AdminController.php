<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contact;
use App\Title;
use App\Text;
use App\Project;
use App\Gallery;
use App\Category;
use App\Member;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function messages(){
        $messages = Contact::all();
        return view('admin.messages',compact('messages'));
    }

    public function team(){
        $team = Team::all();
        return view('admin.team', compact('team'));
    }

    public function teamPOST(Request $request){
        $img_path = '';

        if(Input::hasFile('image')){
            $img = Input::file('image');
            $img_path = str_replace(' ','',strtolower($request->input('name'))) . '.' . $img->getClientOriginalExtension();
            $img->move('assets/images/team', $img_path);
        }

        $img_path = 'assets/images/team/' . $img_path;

        $role = $request->input('role');

        switch ($role){
            case "kurucu":
                $teamRole = "Kurucu";
                break;
            case "baskan":
                $teamRole = "Başkan";
                break;
            case "baskanyrd":
                $teamRole = "Başkan Yrd.";
                break;
            case "sekbaskani":
                $teamRole = "Sosyal Etkinlikler Komitesi Başkanı";
                break;
            case "eykbaskani":
                $teamRole = "Eğlence ve Yarışma Komitesi Başkanı";
                break;
            case "ekbaskani":
                $teamRole = "Eğitim Komitesi Başkanı";
                break;
            case "sosyalmedya":
                $teamRole = "Sosyal Medya Yöneticisi";
                break;
            case "sekbaskanyrd":
                $teamRole = "Sosyal Etkinlikler Komitesi Başkan Yardımcısı";
                break;
            case "eykbaskanyrd":
                $teamRole = "Eğlence ve Yarışma Komitesi Başkan Yardımcısı";
                break;
            case "ekbaskanyrd":
                $teamRole = "Eğitim Komitesi Başkan Yardımcısı";
                break;
        }

        $isActive = $request->input('isactive') == "true" ? true : false;

        Team::create([
            'name' => $request->input('name'),
            'role' => $teamRole,
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'github' => $request->input('github'),
            'linkedin' => $request->input('linkedin'),
            'is_active' => $isActive,
            'image_path' => $img_path,
        ]);
    }

    public function deleteTeam(Request $request){
        return Team::destroy($request->input('person_id'));
    }

    public function deleteMessage(Request $request){
        return Contact::destroy($request->input('id'));
    }

    public function aboutUs(){
        $titles = Title::first();
        $about = Text::first()->about_us_body;
        return view('admin.about_us',compact('titles','about'));
    }

    public function aboutUsPOST(Request $request){
        $header = Title::first();
        $header->about_us = $request->input('about_us');
        $header->save();
        $content = Text::first();
        $content->about_us_body = $request->input('about_us_body');
        $content->save();
        return true;
    }

    public function projects(){
        $projects = Project::all();
        return view('admin.projects',compact('projects'));
    }

    public function projectsPOST(Request $request){
        $img_path = '';

        if(Input::hasFile('image')){
            $img = Input::file('image');
            $img_path = str_replace(' ','',strtolower($request->input('name'))) . '.' . $img->getClientOriginalExtension();
            $img->move('assets/images/projects', $img_path);
        }

        $img_path = 'assets/images/projects/' . $img_path;

        Project::create([
            'project_title' => $request->input('name'),
            'image_path' => $img_path,
            'icon' => $request->input('icon'),
            'category' => $request->input('category'),
            'date' => $request->input('date'),
            'state' => $request->input('state'),
            'short_description' => $request->input('short_desc'),
            'description' => $request->input('long_desc'),
        ]);


    }

    public function deleteProject(Request $request){
        return Project::destroy($request->input('project_id'));
    }

    public function activities(){
        $activities = Activity::all();
        return view('admin.activities',compact('activities'));
    }

    public function activitiesPOST(Request $request){
        $img_path = '';
        $before = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç');
        $after   = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c');

        if(Input::hasFile('image')){
            $img = Input::file('image');
            $img_path = str_replace(' ','',strtolower($request->input('name'))) . '.' . $img->getClientOriginalExtension();
            $img->move('assets/images/activities', $img_path);
            $img_path = 'assets/images/activities/' . $img_path;
        }
        else {
            $img_path = 'assets/images/activities/default.jpg';
        }
        $url = $request->input('name') . $request->input('date');
        $url = str_replace($before, $after, $url);
        $url = preg_replace('/[^a-zA-Z0-9 ]/', '', $url);
        $url = preg_replace('!\s+!', '-', $url);
        $url = strtolower(trim($url, '-'));
        
        Activity::create([
            'activity_title' => $request->input('name'),
            'url' => $url,
            'image_path' => $img_path,
            'location' => $request->input('location'),
            'category' => $request->input('category'),
            'date' => $request->input('date'),
            'short_description' => $request->input('short_desc'),
            'description' => $request->input('long_desc'),
        ]);
    }

    public function activityUpdate(Request $request){
        $activity = Activity::where('url', $request->input('url'))->get()[0];
        $activity->activity_title = $request->input('name');
        $activity->location = $request->input('location');
        $activity->category = $request->input('category');
        $activity->short_description = $request->input('short_desc');
        $activity->description = $request->input('long_desc');
        $activity->date = $request->input('date');
        $activity->save();
        return $activity;
    }

    public function deleteActivity(Request $request){
        return Activity::destroy($request->input('activity_id'));
    }

    public function gallery(){
        $gallery = Gallery::all();
        return view('admin.gallery',compact('gallery'));
    }

    public function galleryPOST(Request $request){
        $img_path = '';

        if(Input::hasFile('image')){
            $img = Input::file('image');
            $img_path = str_replace(' ','',strtolower($request->input('name'))) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(80, 80)->save('assets/images/gallery/thumb' .$img_path);
            $img->move('assets/images/gallery', $img_path);
        }

        $img_path = 'assets/images/gallery/' . $img_path;
        $img_thumb_path = 'assets/images/gallery/thumb';

        /*
        Gallery::create([
           'description' => $request->input('description'),
           'image_path' => $img_path,
           'thumb_path' =>
        ]);
        */
    }

    public function deletePhoto(Request $request){
        return $request;
    }

    public function members(){
        $members = Member::all();

        return view('admin.members',compact('members'));
    }

    public function categories(){
        $categories = Category::all();
        return view('admin.categories',compact('categories'));
    }
}
