<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    public function index(){
        $units=Unit::paginate((env('PAGINATION_COUNT')));

        return view('admin.units.units')->with(
            ['units'=>$units]
        );
    }

    public function store(Request $request){
         dd($request);
        //TODO check if unit exist
        $request->validate([
            'unit_name'=>'required',
            'unit_code'=>'required'
        ]);
        $unit=new Unit();
        $unit->unit_name=$request->input('unit_name');
        $unit->unit_code=$request->input('unit_code');
        $unit->save();
        Session::flash('message','Unit '.$unit->unit_name .' has been added');
        return redirect()->back();
    }

    public function update(Request $request){
    $request->validate([
        'unit_code'=>'required',
        'unit_id'=>'required',
        'unit_name'=>'required'
    ]);
    $unitID=intval($request->input('unit_id'));

    $unit=Unit::find($unitID);

    $unit->unit_name=$request->input('unit_name');
    $unit->unit_code=$request->input('unit_code');
    $unit->save();
    Session::flush('message','Unit '.$unit->unit_name .' has been updated');
    return redirect()->back();

    }
    public function search(Request $request){

    }

    public function delete(Request $request){


        if(is_null($request->input('unit_id'))||empty($request->input('unit_id'))){
            Session::flush('message','Unit ID is required');
            return redirect()->back();
        }



        Unit::destroy($request->input('unit_id'));
        Session::flash('message','Unit  has been removed');
        return redirect()->back();
    }



}
