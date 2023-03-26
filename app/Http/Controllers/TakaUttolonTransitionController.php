<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Taka_uttolon_transition; 
use App\Models\sharepartner; 
use App\Models\cashtransition; 

use DataTables;
use Validator;
use DB;
use App\Models\balance_of_business;
class TakaUttolonTransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $Taka_uttolon_transition =  Taka_uttolon_transition::with('sharepartner')->latest()->get();
	//1-> touttolon
	  
	        if ($request->ajax()) {
					  $Taka_uttolon_transition =  Taka_uttolon_transition::with('sharepartner')->latest()->get();
        
            return Datatables::of($Taka_uttolon_transition)
                   ->addIndexColumn() 
				   

                    ->addColumn('action', function( Taka_uttolon_transition $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        
						
						
						return $button;
                    })  
    
                      ->addColumn('partner_name', function (Taka_uttolon_transition $Taka_uttolon_transition) {
                    return $Taka_uttolon_transition->sharepartner->name;
                })
				
				
				    ->addColumn('transitino_type', function (Taka_uttolon_transition $Taka_uttolon_transition) {
                    
					if ($Taka_uttolon_transition->transitiontype == 1)
					{
						$type= "টাকা উত্তোলন ";
					return $type;	
					}
					
					else
					{
						$type= "টাকা জমা  ";
					return $type;	
					}
					
					
                })				
				
				
				
				
				
				
				
				
					->editColumn('created_at', function(Taka_uttolon_transition $data) {
					
					 return date('d/m/y H:i A', strtotime($data->created_at) );
                    
                })
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
		

		return view('Taka_uttolon_transition.Taka_uttolon_transition', compact('Taka_uttolon_transition'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	 
	 
	 	    public function dropdown_list()
    {
		
		 $shopid = Auth()->user()->balance_of_business_id;
       $sharepartner = sharepartner::where('balance_of_business_id', $shopid )->where('softdelete','0' )->orderBy('name', 'ASC')->get(); 
	   

	        

            return response()->json(['sharepartner' => $sharepartner ]);
	 
 
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
                $rules = array(
            'partner_name'    =>  'required',
            'amount'     =>  'required',
			'comment',
           'transitiontype' =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

        $form_data = array(
            'sharepartner_id'        =>  $request->partner_name,
            'amount'         =>  $request->amount,
	       'comment'         =>  $request->comment,
 	  'transitiontype'         =>  $request->transitiontype,
	  'balance_of_business_id' => Auth()->user()->id,
        );
		
		
		  DB::beginTransaction();
		$partner = sharepartner::findOrFail($request->partner_name); 
		
		
		//////////////////////// jodi Taka uttolon hoy 	 
	   If ( $request->transitiontype == 1 )
	   {
	   $amount_of_current_uttholon = $partner->uttholon + $request->amount ; 
	          $form_data_for_update_uttolon_joma = array(
            
            'uttholon'        =>   $amount_of_current_uttholon,
            
        );
        sharepartner::whereId($request->partner_name)->update($form_data_for_update_uttolon_joma);

	  
	  
	  
	     /////////////update balance  
   $balance = balance_of_business::first();  
   $present_balance = $balance->balance - $request->amount ;	    
   balance_of_business::where('id', 1)
  ->update(['balance' =>$present_balance  ]);
	  
	  
	  
	  
	  }
	  //////////////////////// jodi Taka Joma hoy 
	   else{
	   $amount_of_current_joma = $partner->joma + $request->amount ; 
	          $form_data_for_update_uttolon_joma = array(
            
            'joma'        =>   $amount_of_current_joma,
            
        );
        sharepartner::whereId($request->partner_name)->update($form_data_for_update_uttolon_joma);
 
   
   
   
   /////////////update balance 
   $balance = balance_of_business::first();  
   $present_balance = $balance->balance + $request->amount ;	    
   balance_of_business::where('id', 1)
  ->update(['balance' =>$present_balance  ]);
	   
   
	   }

   
 
   
   
 $Taka_uttolon_transition =       Taka_uttolon_transition::create($form_data);
 
 
 	   If ( $request->transitiontype == 1 )
	   {
		  	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->sharepartner_id = $request->partner_name;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->Taka_uttolon_transition_id = $Taka_uttolon_transition->id;
$cashtransition->amount = $request->amount;
$cashtransition->withdrwal = $request->amount;	
$cashtransition->description = "Money Withdrwal from business by Business-Partner:"  .$partner->name ;	

$cashtransition->transtype = 5;
$cashtransition->type = 2;
$cashtransition->save(); 
		   
	   }
 else{
	 
		  	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->sharepartner_id = $request->partner_name;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->Taka_uttolon_transition_id = $Taka_uttolon_transition->id;
$cashtransition->amount = $request->amount;
$cashtransition->deposit = $request->amount;	
$cashtransition->description = "Money Deposit by Business-Partner:"  .$partner->name ;	
$cashtransition->transtype = 5;
$cashtransition->type = 1;
$cashtransition->save(); 	 
	 
 }
 
 
 
 
 
 
  DB::commit();
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
        $data = Taka_uttolon_transition::findOrFail($id);
		
		  DB::beginTransaction();
				$sharepartner = sharepartner::findOrFail($data->sharepartner_id );
			
				if ($data->transitiontype == 1)
				{
					/////////update personal balance of partner 
   $present_uttholon = $sharepartner->uttholon - $data->amount;
   sharepartner::where('id', $data->sharepartner_id)
  ->update(['uttholon' =>$present_uttholon  ]);
  ///////////////update comany balance 
    
   $balance = balance_of_business::first();  
   $present_balance = $balance->balance + $data->amount ;	    
   balance_of_business::where('id', 1)
  ->update(['balance' =>$present_balance  ]);
  
  
  
  
  
  
  
	}
  
  else {
	  
	  
	////////// update sharepartner balance			
  $present_joma = $sharepartner->joma - $data->amount;

   sharepartner::where('id', $data->sharepartner_id)
  ->update(['joma' =>$present_joma  ]);		
		

////////////////////// update company balance 

	    
   $balance = balance_of_business::first();  
   $present_balance = $balance->balance - $data->amount ;	    
   balance_of_business::where('id', 1)
  ->update(['balance' =>$present_balance  ]);

}
			 cashtransition::where('Taka_uttolon_transition_id', $id )->delete();
		
		
        $data->delete();
		DB::commit();
		
    }
}
