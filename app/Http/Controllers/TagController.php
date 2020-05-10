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
            'tags'=>$tags,
            'showLinks'=>true,

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
    public function search(Request $request){
        $request->validate([
            'tag_search'=>'required'
        ]);

        $searchTerm=$request->input('tag_search');

        $tags=tag::where(
            'tag' , 'LIKE','%'.$searchTerm.'%'

        )->get();

        if(count($tags)>0){
            return view('admin.tags.tags')->with([
                'tags'=>$tags,
                'showLinks'=>false,
            ]);
        }
        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }

    public function delete(Request $request){
        $request->validate([
            'tag_id'=>'required'
        ]);
        $tagId=$request->input('tag_id');
        $tag=Tag::destroy($tagId);
        Session::flash('message','Tag has been deleted');
        return redirect()->back();
    }

    private function tagNameExists($tagName)
    {
        $tag = Tag::where(
            'tag', '=', $tagName
        )->first();
        if (!is_null($tag)) {
            Session::flash('message', 'Tag Name(' . $tagName . ') already exists');
            return false;


        }
        return true;
    }


    public function update(Request $request){
        $request->validate([
            'tag'=>'required',
            'tag_id'=>'required',
        ]);
        $tagName=$request->input('tag_name');
        $tagID=$request->input('tag_id');

        if (!$this->tagNameExists($tagName)){
            Session::flash('message','Tag name already exists');
        return redirect()->back();
        }
        $tag=Tag::find($tagID);
        $tag->tag=$tagName;
        $tag->save();
        Session::flash('message','Tag has been update.');
        return redirect()->back();
    }


}
