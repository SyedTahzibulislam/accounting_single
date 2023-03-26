<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\khorocer_khad;
use DataTables;
use Validator;

class Create_khorocer_khad_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
             $khorocer_khad =  khorocer_khad::where('softdelete', 0)->orderby('path')->get();
	  
	
	  
	        if ($request->ajax()) {
            $khorocer_khad =  khorocer_khad::where('softdelete', 0)->orderby('path')->get();
            return Datatables::of($khorocer_khad)
                   ->addIndexColumn()
                    ->addColumn('action', function( khorocer_khad $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  

					
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('khorocer_khad.khorocer_khad', compact('khorocer_khad'));   

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	 
	 
	 public function dropdownlist()
{
	
	$expenseslist =  khorocer_khad::OrderBy('name')->where('parent_id', null )->where('balance_of_business_id', Auth()->user()->balance_of_business_id )->get();
            return response()->json(['expenseslist' => $expenseslist ]);
	
	
	
}




public function dropdownlistforchild($id)
{
	
	$expenseslistchild =  khorocer_khad::OrderBy('name')->where('parent_id', $id )->where('balance_of_business_id', Auth()->user()->balance_of_business_id )->get();
            return response()->json(['expenseslistchild' => $expenseslistchild ]);
	
	
	
}
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	
	
	
	    public function store(Request $request)
    {
        
		
	$khorocer_khad = new khorocer_khad();
$khorocer_khad->name = $request->expensesname;

if ( $request->third != null )
{
	$khorocer_khad->parent_id = $request->third;	
$khorocer_khad->secondparent_id = $request->second;	
$khorocer_khad->thirdparent_id = $request->firstparentid;	


$first = khorocer_khad::findOrFail($request->firstparentid)->name;
$second = khorocer_khad::findOrFail($request->second)->name;
$third = khorocer_khad::findOrFail($request->third)->name;

$khorocer_khad->path = $first. "->" .$second. "->" .$third."->" .$request->expensesname ;






}

if ( ( $request->third == null ) and ( $request->second != null ))
{
	$khorocer_khad->parent_id = $request->second;	
$khorocer_khad->secondparent_id = $request->firstparentid;	





$first = khorocer_khad::findOrFail($request->firstparentid)->name;
$second = khorocer_khad::findOrFail($request->second)->name;


$khorocer_khad->path = $first. "->" .$second. "->"  .$request->expensesname ;








	
}

if (  ( $request->second == null )  and ( $request->firstparentid != null )   )
{
	$khorocer_khad->parent_id = $request->firstparentid;
	
$first = khorocer_khad::findOrFail($request->firstparentid)->name;


$khorocer_khad->path = $first. "->"  .$request->expensesname ;


	
}






if (  ( $request->firstparentid == null )  and ( $request->second == null )  and ( $request->third == null )  )
{



$khorocer_khad->path =   $request->expensesname ;


	
}







$khorocer_khad->balance_of_business_id = Auth()->user()->balance_of_business_id;	

$khorocer_khad->save();		
	
return response()->json(['success' => 'Data Added successfully.']);		
		
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = khorocer_khad::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request)
    {
  
        
            $rules = array(
                'name'    =>  'required',
               
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
       

        $form_data = array(
            'name'       =>   $request->name,
            
        );
       khorocer_khad::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        	   	khorocer_khad::whereId($id)
  ->update(['softdelete' => '1']);
    }
}
