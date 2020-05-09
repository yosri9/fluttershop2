<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(){
        $tags=Tag::paginate(env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags'=>$tags
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'tag_name'=>'required'
        ]);
        $tagName=$request->input('tag_name');
        $tag=Tag::where('tag','=', $tagName)->get();
        if (count($tag)>0){
            Session::flash('message','tag'.$tagName.' already exists');
            return redirect()->back();
        }
        $newTag=new Tag();
        $newTag->tag=$tagName;
        $newTag->save();
        Session::flash('message','Tag '.$tagName.' has been added');
        return redirect()->back();

    }


}
