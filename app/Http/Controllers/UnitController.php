<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::paginate((env('PAGINATION_COUNT')));

        return view('admin.units.units')->with(
            [
                'units' => $units,
                'showLinks'=>true,
            ]
        );
    }

    private function unitNameExists($unitName)
    {
        $unit = Unit::where(
            'unit_name', '=', $unitName
        )->first();
        if (!is_null($unit)) {
            Session::flash('message', 'Unit Name(' . $unitName . ') already exists');
            return false;


        }
        return true;
    }

    private function unitCodeExists($unitCode)
    {
        $unit = Unit::where(
            'unit_code', '=', $unitCode
        )->first();
        if (!is_null($unit)) {
            Session::flash('message', 'Unit Name(' . $unitCode . ') already exists');
            return false;
        }
        return true;
    }


    public function store(Request $request)
    {
        //TODO check if unit exist
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (! $this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }




        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit ' . $unit->unit_name . ' has been added');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'unit_code' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required'
        ]);

        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (! $this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }


        $unitID = intval($request->input('unit_id'));

        $unit = Unit::find($unitID);

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit ' . $unit->unit_name . ' has been updated');
        return redirect()->back();

    }

    public function search(Request $request)
    {
        $request->validate([
            'unit_search'=>'required'
        ]);

        $searchTerm=$request->input('unit_search');

        $units=Unit::where(
            'unit_name' , 'LIKE','%'.$searchTerm.'%'
        )->orwhere(
            'unit_code','LIKE','%'.$searchTerm.'%'
        )->get();

        if(count($units)>0){
            return view('admin.units.units')->with([
                'units'=>$units,
                'showLinks'=>false,
            ]);
        }
        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {


        if (is_null($request->input('unit_id')) || empty($request->input('unit_id'))) {
            Session::flush('message', 'Unit ID is required');
            return redirect()->back();
        }


        Unit::destroy($request->input('unit_id'));
        Session::flash('message', 'Unit  has been removed');
        return redirect()->back();
    }


}
