<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use Validator;
use App\Models\balance_of_business; 

class balanceofbusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	  public function index(Request $request)
    {
    
	  
	
	  $subdealer =  balance_of_business::where('softdelete',0)->orderBy('shopname')->get();
	
	  
	        if ($request->ajax()) {
					
	  $subdealer =  balance_of_business::where('softdelete',0)->orderBy('shopname')->get();

		 
            return Datatables::of($subdealer)
                   ->addIndexColumn()
				   

                    ->addColumn('action', function( balance_of_business $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  

					
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
		

		return view('business_and_sub_dealer.subdealer', compact('subdealer'));   
	
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
       $balance_of_business = new balance_of_business();
	   
	   $balance_of_business->shopname = $request->name;
	    $balance_of_business->mobile = $request->mobile;
		 $balance_of_business->address = $request->address;
		  $balance_of_business->openingbalance = $request->ob;
		    $balance_of_business->balance = $request->ob;
		  $balance_of_business->save(); 
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
                    $data = balance_of_business::findOrFail($id);
			

            return response()->json(['data' => $data  ]);
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
            'address'     =>  'required',
            'mobile'         =>  'required',
			'ob'   =>  'required',
			
			
			
        );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
       

        $form_data = array(
            'shopname'        =>  $request->name,
            'address'         =>  $request->address,
           'mobile' =>$request->mobile,
		  
		   		   'openingbalance' =>$request->ob,

								   
        );
        balance_of_business::whereId($request->hidden_id)->update($form_data);

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
                           	   	balance_of_business::whereId($id)
  ->update(['softdelete' => '1']);
    }
}
