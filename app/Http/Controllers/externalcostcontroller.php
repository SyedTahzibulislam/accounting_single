<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\externalcost;

use App\Models\cashtransition;

use App\Models\balance_of_business;
use DataTables;
use Validator;

class externalcostcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
	
	
	
    {
		
		     $externalcost=  externalcost::latest()->get();
	  
	
	  
	        if ($request->ajax()) {
            $externalcost =  externalcost::latest()->get();
            return Datatables::of($externalcost)
                   ->addIndexColumn()
                    ->addColumn('action', function( externalcost $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  

			                 ->editColumn('created', function(externalcost $data) {
					
					 return date('d/m/y', strtotime($data->created_at) );
                    
                })		
					
                    ->rawColumns(['action','created',  ])
                    ->make(true);
        }
      
        return view('externalcost.externalcost', compact('externalcost')); 
		

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
			'amount' =>  'required',
			'Date_of_Transition'  =>  'required',					
			
           
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       
	   
	 $externalcost = new externalcost();
$externalcost->name = 	$request->name;
$externalcost->cost = 	$request->amount;
$externalcost->created_at = 	$request->Date_of_Transition;
$externalcost->balance_of_business_id = 	Auth()->user()->balance_of_business_id;
     $externalcost->save();
	   
	   
	   



	 
	 
	 
	 
	$shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>( $balance->balance    - $request->amount  )  ]);	 
		 
		 
		$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;

$cashtransition->User_id = Auth()->user()->id;
$cashtransition->externalcost_id = $externalcost->id;
$cashtransition->amount = $request->amount;
$cashtransition->withdrwal = $request->amount;	

$cashtransition->description = "Expenditure for" .$request->name;	
$cashtransition->created_at = $request->Date_of_Transition;
$cashtransition->transtype = 1;
$cashtransition->type = 2;
$cashtransition->save();	  
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 

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
            $data = externalcost::findOrFail($id);
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
			'amount' =>  'required',
				'Date_of_Transition'  =>  'required',	
           
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       

        $form_data = array(
            'name'        =>  $request->name,
			
'balance_of_business_id' => Auth()->user()->balance_of_business_id,
			'cost' =>   $request->amount,
		 'created_at' => 	$request->Date_of_Transition
           
        );
		
		
		
		
		$presentamount = externalcost::findOrFail($request->hidden_id)->cost;
		
		
		
		
			$shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid)->balance;


if($presentamount > $request->amount )
{
$sub = $presentamount - $request->amount;
$newbalance =   $balance + ( $presentamount - $request->amount ); 
}
else
{
$sub =   $request->amount - $presentamount;
$newbalance =   $balance - (   $request->amount - $presentamount);
	
	
}



   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>( $newbalance  )  ]);
		
		
		
		
		
		
		
		 externalcost::whereId($request->hidden_id)->update($form_data);
		 
        $form_dataforcash = array(
          'balance_of_business_id' => Auth()->user()->balance_of_business_id,  
		 'created_at' => 	$request->Date_of_Transition,	
	'amount' =>		$request->amount,
			'withdrwal' =>   $request->amount,
		 
           
        );		 
	









	
 cashtransition::where( ['externalcost_id' =>   $request->hidden_id,] )->update($form_dataforcash);
		 
		 
		 
		 
		 
		 

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
        
                $data = externalcost::findOrFail($id);
				
				
				 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>( $balance->balance    + $data->cost  )  ]);
				
				
				
				 cashtransition::where('externalcost_id',  $data->id )->delete();		
				
        $data->delete();
    }
}
