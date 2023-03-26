<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\supplier; 
use App\Models\user; 
use App\Models\dhar_shod_othoba_advance_er_mal_buje_pawa; 
use DataTables;
use Validator;
use App\Models\balance_of_business;
use DB;
use App\Models\cashtransition;



 





class supplierduepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
    {
		
		$shopid = Auth()->user()->balance_of_business_id;
		
                  $dhar_shod_othoba_advance_er_mal_buje_pawa =  dhar_shod_othoba_advance_er_mal_buje_pawa::where('balance_of_business_id',   $shopid )
	
			  ->latest()->get();
	  
	
	  
	        if ($request->ajax()) {
				
            $dhar_shod_othoba_advance_er_mal_buje_pawa =  dhar_shod_othoba_advance_er_mal_buje_pawa::where('balance_of_business_id',   $shopid )

->latest()->get();
            
			
			
			
			return Datatables::of($dhar_shod_othoba_advance_er_mal_buje_pawa)
                   ->addIndexColumn()
                    ->addColumn('action', function( dhar_shod_othoba_advance_er_mal_buje_pawa $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    }) 
	
				
	 ->addColumn('supplier', function (dhar_shod_othoba_advance_er_mal_buje_pawa $dhar_shod_othoba_advance_er_mal_buje_pawa) {


$supplier = supplier::findOrFail($dhar_shod_othoba_advance_er_mal_buje_pawa->supplier_id)->name;
return $supplier;

				 
                }) 
				
				
					 ->addColumn('entryby', function (dhar_shod_othoba_advance_er_mal_buje_pawa $dhar_shod_othoba_advance_er_mal_buje_pawa) {


$user = user::findOrFail($dhar_shod_othoba_advance_er_mal_buje_pawa->user_id)->name;
return $user;

				 
                }) 
				



                 ->editColumn('created', function(dhar_shod_othoba_advance_er_mal_buje_pawa $dhar_shod_othoba_advance_er_mal_buje_pawa) {
					
					 return date('d/m/y h:i A', strtotime($dhar_shod_othoba_advance_er_mal_buje_pawa->created_at) );
                    
                })









					
					
                    ->rawColumns(['action','created'])
                    ->make(true);
					
					

        }
      
        return view('dhar_advance_shod.duepayment', compact('dhar_shod_othoba_advance_er_mal_buje_pawa'));   

    }
	
	
	
	
	
	    public function  dropdownlist()
    {
		
		
	
		$shopid = Auth()->user()->balance_of_business_id;
	
                  $supplier =  supplier::where('balance_of_business_id',   $shopid )->where('softdelete', 0)
	
			  ->latest()->get();
	   
	  
		 
	
			
            return response()->json(['supplier' => $supplier ]);

	   
	   
	   
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
				'transitiontype' => 'required',
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
         DB::beginTransaction();
	   $supplier=  supplier::findOrFail($request->supplier_id);
	  
//////////////////////// jodi dhar shod hoy 	  
	   If ( $request->transitiontype == 1 )
	   {
	   $amount_of_current_due = $supplier->due - $request->amount ; 
	          $form_data = array(
            
            'due'        =>   $amount_of_current_due,
            
        );
        supplier::whereId($request->supplier_id)->update($form_data);

	  
	 	 			     /////////////update balance 
						 
	 $shopid = Auth()->user()->balance_of_business_id;					 
						 
						 
  
  $balance =  balance_of_business::findOrFail($shopid); 
   $present_balance = $balance->balance - $request->amount ;	    
     balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
		 
	/////////////////////////update complete    

 











	 }
	  //////////////////////// jodi advance shod hoy 
	    If ( $request->transitiontype == 2 ){
		  $amount_of_current_advance = $supplier->advance - $request->amount ;   
	   	          $form_data = array(
            
            'advance'        =>   $amount_of_current_advance,
            
        );
        supplier::whereId($request->hidden_id)->update($form_data);
	   
 
	   }
	   	   If ( $request->transitiontype == 3 )
	   {
		  $amount_of_current_advance = $supplier->advance - $request->amount ;   
	   	          $form_data = array(
            
            'advance'        =>   $amount_of_current_advance,
            
        );
        supplier::whereId($request->supplier_id)->update($form_data);

	  
	 	 			     /////////////update balance 
	 $shopid = Auth()->user()->balance_of_business_id;					 
						 
						 
  
  $balance =  balance_of_business::findOrFail($shopid);   
   $present_balance = $balance->balance + $request->amount ;	    
  balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
		 
	/////////////////////////update complete    

	  }


		
		$dhar_shod_othoba_advance_er_mal_buje_pawa = new dhar_shod_othoba_advance_er_mal_buje_pawa();
		$dhar_shod_othoba_advance_er_mal_buje_pawa->supplier_id	= $request->supplier_id;
		$dhar_shod_othoba_advance_er_mal_buje_pawa->balance_of_business_id	= Auth()->user()->balance_of_business_id;
		
		$dhar_shod_othoba_advance_er_mal_buje_pawa->user_id	= Auth()->User()->id;
		$dhar_shod_othoba_advance_er_mal_buje_pawa->amount	= $request->amount;
		$dhar_shod_othoba_advance_er_mal_buje_pawa->transitiontype	= $request->transitiontype;
		$dhar_shod_othoba_advance_er_mal_buje_pawa->comment	= $request->comment;
		$dhar_shod_othoba_advance_er_mal_buje_pawa->save();
		
		
		
		
		  	$cashtransition = new  cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->description = "Due Payment to the supplier  "  .$supplier->name;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->dhar_shod_othoba_advance_er_mal_buje_pawa_id = $dhar_shod_othoba_advance_er_mal_buje_pawa->id;
$cashtransition->amount = $request->amount;
$cashtransition->withdrwal = $request->amount ;	
$cashtransition->type = 2;

$cashtransition->transtype = 3;

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
	

$data = dhar_shod_othoba_advance_er_mal_buje_pawa::findOrFail($id);

	 $shopid = Auth()->user()->balance_of_business_id;					 
	$supplier = supplier::findOrFail($data->supplier_id);				 
						 
  if ($data->transitiontype ==1 )
  {
  $balance =  balance_of_business::findOrFail($shopid);   
   $present_balance = $balance->balance + $data->amount ;	    
  balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
  
 $presentdue = $supplier->due + $data->amount;


   supplier::where('id',  $data->supplier_id)
  ->update(['due' =>$presentdue  ]);
  
  
  
  
  
  }



cashtransition::where('dhar_shod_othoba_advance_er_mal_buje_pawa_id', $id)->delete();
$data->delete();



return response()->json(['success' => 'Data Deleted successfully. ' ]);	

	
	
	
}




}
