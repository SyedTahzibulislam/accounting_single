<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use Validator;
use App\Models\balance_of_business; 


use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;


use App\Models\expenseslist; 












class expensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
              $expenseslist=  expenseslist::OrderBy('name')->get();
	  
	  
	  
	  
	  	        if ($request->ajax()) {
               

 $expenseslist=  expenseslist::OrderBy('name')->get();
	  


		  return Datatables::of($expenseslist)
                   ->addIndexColumn()
                    ->addColumn('action', function( expenseslist $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  

					
                    ->rawColumns(['action' ])

                    ->make(true);
			

        }
  
        return view('expenses.expenses', compact('expenseslist'));   
	  
  
    }





public function dropdownlist()
{
	
	$expenseslist =  expenseslist::OrderBy('name')->where('parent_id', null )->get();
            return response()->json(['expenseslist' => $expenseslist ]);
	
	
	
}




public function dropdownlistforchild($id)
{
	
	$expenseslistchild =  expenseslist::OrderBy('name')->where('parent_id', $id )->get();
            return response()->json(['expenseslistchild' => $expenseslistchild ]);
	
	
	
}










    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        
		
	$expenseslist = new expenseslist();
$expenseslist->name = $request->expensesname;

if ( $request->third != null )
{
	$expenseslist->parent_id = $request->third;	
$expenseslist->secondparent_id = $request->second;	
$expenseslist->thirdparent_id = $request->firstparentid;	
}

if ( ( $request->third == null ) and ( $request->second != null ))
{
	$expenseslist->parent_id = $request->second;	
$expenseslist->secondparent_id = $request->firstparentid;	
	
}

if (  ( $request->second == null ))
{
	$expenseslist->parent_id = $request->firstparentid;
	
	
}



$expenseslist->balance_of_business_id = Auth()->user()->balance_of_business_id;	

$expenseslist->save();		
		
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
