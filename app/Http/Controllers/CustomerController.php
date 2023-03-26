<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Areacode;

use DataTables;
use Validator;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	  public function index(Request $request)
    {
     // $medicine=  medicine::latest()->get();
	  
	
	  $Customer=  Customer::with('Areacode')->where('softdelete',0)
	    ->orderBy(Areacode::select('code')->whereColumn('areacodes.id','customers.Areacode_id' ))->get();
	
	  
	        if ($request->ajax()) {
					
					  $Customer=  Customer::with('Areacode')->where('softdelete',0)
	    ->orderBy(Areacode::select('code')->whereColumn('areacodes.id','customers.Areacode_id' ))->get();
	

		   //$medicine =  medicine::latest()->get();
            return Datatables::of($Customer)
                   ->addIndexColumn()
				   

                    ->addColumn('action', function( Customer $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  
                      ->addColumn('areacode', function (Customer $Customer) {
						  
						  $areacode = Areacode::findOrFail($Customer->Areacode_id)->code;
                    return $areacode;
					
					//return "c";
                })
					
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
		

		return view('customer.customer', compact('Customer'));   
	
	}






    public function areacode()
    {
		
		
	
     
       $data = Areacode::orderBy('code')->get(); 
	 

			
            return response()->json(['data' => $data]);

	   
	   
	   
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
        $rules = array(
            'name'    =>  'required',
            'areacode'     =>  'required',
            'customercode'         =>  'required',
			'mobile'   =>  'required',
				'address'   =>  'required',
			'duelimit'   =>  'required',
			'openingbalance'   =>  'required',

			
			
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       

        $form_data = array(
            'name'        =>  $request->name,
            'Areacode_id'         =>  $request->areacode,
           'customercode' =>$request->customercode,
		   'mobile' =>$request->mobile,
		   		   'address' =>$request->address,
				   		   'duelimit' =>$request->duelimit,
						   		   'openingbalance' =>$request->openingbalance,
								'presentduebalance' =>$request->openingbalance,   
											'balance_of_business_id' => Auth()->user()->balance_of_business_id,
								   
        );

        Customer::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	 
	    public function edit($id)
    {
        if(request()->ajax())
        {
			$shopid = Auth()->user()->id;

            $data = Customer::where('balance_of_business_id',$shopid)->findOrFail($id);
			$areacode = Areacode::where('balance_of_business_id',$shopid)->orderBy('code')->get(); 

            return response()->json(['data' => $data , 'areacode' => $areacode ]);
        }
    }

	 
	 
	 
	 
	 
    public function show($id)
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
      public function update(Request $request)
    {
  
        
        $rules = array(
            'name'    =>  'required',
            'areacode'     =>  'required',
            'customercode'         =>  'required',
			'mobile'   =>  'required',
				'address'   =>  'required',
			'duelimit'   =>  'required',
			'openingbalance'   =>  'required',
			
			
        );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
       

        $form_data = array(
            'name'        =>  $request->name,
            'Areacode_id'         =>  $request->areacode,
           'customercode' =>$request->customercode,
		   'mobile' =>$request->mobile,
		   		   'address' =>$request->address,
				   		   'duelimit' =>$request->duelimit,
						   		   'openingbalance' =>$request->openingbalance,
								'presentduebalance' =>$request->openingbalance,   
								   
        );
        Customer::whereId($request->hidden_id)->update($form_data);

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
              	   	Customer::whereId($id)
  ->update(['softdelete' => '1']);
    }
}
