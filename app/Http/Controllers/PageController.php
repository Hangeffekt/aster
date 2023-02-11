<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class PageController extends Controller
{
    function pages(Request $request){
        if($request->id == null){
            $page = null;
        }
        else if($request->id == "new"){
            $page = "new";
        }
        else {
            $page = DB::table('pages')->where('id', $request->id)->first();
        }
        $pages = DB::table('pages')->get();

        return view("admin.page", ["data"=>$pages, "PageData"=>$page]);
    }

    function updatePage(Request $request){
        //validate $request

        $request->validate([
            "title"=>"required",
            "content"=>"required"
        ]);

        //if validate successfuly

        if($request->order == null){
            $order = 0;
        }
        else {
            $order = $request->order;
        }


        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->url == null){
            $url = $request->title;
        }
        else {
            $url = $request->url;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $url);
        $url = str_replace([" ", "_"], "-", $url);

        $affected = DB::table('pages')
              ->where('id', $request->id)
              ->update(['title' => $request->title, 'content' => $request->content, 'active' => $active, 'order' => $order, 'url' => $url]);

        return back()->with("success", "Successfuly update!");
    }

    function createPage(Request $request){
        //validate $request

        $request->validate([
            "title"=>"required",
            "content"=>"required"
        ]);

        //if validate successfuly

        if($request->order == null){
            $order = 0;
        }
        else {
            $order = $request->order;
        }


        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->url == null){
            $url = $request->title;
        }
        else {
            $url = $request->url;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $url);
        $url = str_replace([" ", "_"], "-", $url);

        $affected = DB::table('pages')->insert([
            'title' => $request->title,
            'active' => $active,
            'content' => $request->content,
            'order' => $order,
            'url' => $url
        ]);
        return back()->with("success", "New page created!");
    }

    function deletePage(Request $request){
        $query = DB::table('pages')->where('id', '=', $request->id)->delete();

        return redirect('page')->with("success", "Page successfuly deleted!");
    }
}
