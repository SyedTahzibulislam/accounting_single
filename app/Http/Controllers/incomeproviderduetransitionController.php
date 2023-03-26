<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\incomeproviderduetransition; 
use App\Models\externalincomeprovider; 
use App\Models\User; 
use App\Models\externalincometransition;

use App\Models\cashtransition;
use PDF;
use DateTime;
use DataTables;
use Validator;
use App\Models\balance_of_business; 
use DB;



class incomeproviderduetransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
    {
		
		$shopid = Auth()->user()->balance_of_business_id;
		
                  $incomeproviderduetransition =  incomeproviderduetransition::with('externalincomeprovider')->where('balance_of_business_id',   $shopid )
	
			  ->latest()->get();
	  
	
	  
	        if ($request->ajax()) {
				
                  $incomeproviderduetransition =  incomeproviderduetransition::with('externalincomeprovider')->where('balance_of_business_id',   $shopid )
	
			  ->latest()->get();
            
			
			
			
			return Datatables::of($incomeproviderduetransition)
                   ->addIndexColumn()
                    ->addColumn('action', function( incomeproviderduetransition $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    }) 
	
				
	 ->addColumn('incomeprovider', function (incomeproviderduetransition $incomeproviderduetransition) {


$incomeprovider  = externalincomeprovider::findOrFail($incomeproviderduetransition->externalincomeprovider_id)->name;
return $incomeprovider;

				 
                }) 
				
				
					 ->addColumn('entryby', function (incomeproviderduetransition $incomeproviderduetransition) {


$user = user::findOrFail($incomeproviderduetransition->user_id)->name;
return $user;

				 
                }) 
				



                 ->editColumn('created', function(incomeproviderduetransition $incomeproviderduetransition) {
					
					 return date('d/m/y h:i A', strtotime($incomeproviderduetransition->created_at) );
                    
                })









					
					
                    ->rawColumns(['action','created'])
                    ->make(true);
					
					

        }
      
        return view('incomeproviderduetransition.duetransition', compact('incomeproviderduetransition'));   

    }
	
	
	
	
		    public function  dropdownlist()
    {
		
		
	
		$shopid = Auth()->user()->balance_of_business_id;
	
                  $externalincomeprovider =  externalincomeprovider::where('balance_of_business_id',   $shopid )->where('softdelete', 0)
	
			  ->latest()->get();
	   
	  
		 
	
			
            return response()->json(['externalincomeprovider' => $externalincomeprovider ]);

	   
	   
	   
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
   public function store (Request $request)
    {
      
            $rules = array(
               
                'amount'     =>  'required',
				'supplier_id' => 'required',
				'comment',
				
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
         DB::beginTransaction();
	   $externalincomeprovider=  externalincomeprovider::findOrFail($request->supplier_id);
	  
//////////////////////// jodi dhar shod hoy 	  

	   $amount_of_current_due = $externalincomeprovider->ownererkachebaki - $request->amount ; 
	          $form_data = array(
            
            'ownererkachebaki'        =>   $amount_of_current_due,
            
        );
        externalincomeprovider::whereId($request->supplier_id)->update($form_data);

	  
	 	 			     /////////////update balance 
						 
	 $shopid = Auth()->user()->balance_of_business_id;					 
						 
						 
  
  $balance =  balance_of_business::findOrFail($shopid); 
   $present_balance = $balance->balance + $request->amount ;	    
     balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
		 
	/////////////////////////update complete    

 















		
		$incomeproviderduetransition = new incomeproviderduetransition();
		$incomeproviderduetransition->externalincomeprovider_id	= $request->supplier_id;
		$incomeproviderduetransition->balance_of_business_id	= Auth()->user()->balance_of_business_id;
		
		$incomeproviderduetransition->user_id	= Auth()->User()->id;
		$incomeproviderduetransition->amount	= $request->amount;
	
		$incomeproviderduetransition->comment	= $request->comment;
		$incomeproviderduetransition->save();
		
		
		
		
		  	$cashtransition = new  cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->description = "Due Payment from"  .$externalincomeprovider->name;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->incomeproviderduetransition_id = $incomeproviderduetransition->id;
$cashtransition->amount = $request->amount;
$cashtransition->deposit = $request->amount ;	
$cashtransition->type = 1;

$cashtransition->transtype = 13;

$cashtransition->save(); 	
		
		
		
		
		
		
		
		
       DB::commit();
        return response()->json(['success' => 'Data is successfully updated']);
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
	

$data = incomeproviderduetransition::findOrFail($id);

	 $shopid = Auth()->user()->balance_of_business_id;					 
	$externalincomeprovider = externalincomeprovider::findOrFail($data->externalincomeprovider_id);				 
						 

  $balance =  balance_of_business::findOrFail($shopid);   
   $present_balance = $balance->balance - $data->amount ;	    
  balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
  
 $presentdue = $externalincomeprovider->ownererkachebaki + $data->amount;


   externalincomeprovider::where('id',  $data->externalincomeprovider_id)
  ->update(['ownererkachebaki' =>$presentdue  ]);
  
  
  
  
  
  



cashtransition::where('incomeproviderduetransition_id', $id)->delete();
$data->delete();



return response()->json(['success' => 'Data Deleted successfully. ' ]);	

	
	
	
}
}
