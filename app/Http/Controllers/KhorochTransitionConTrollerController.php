<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\khorocer_khad; 
use App\Models\supplier; 
use App\Models\User; 
use App\Models\khoroch_transition;

use App\Models\cashtransition;
use PDF;
use DateTime;
use DataTables;
use Validator;
use App\Models\balance_of_business; 
use DB;
class KhorochTransitionConTrollerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
	   $shopid = Auth()->user()->balance_of_business_id;
	
	  $khoroch_transition=  khoroch_transition::with('khorocer_khad','supplier','User')->where('balance_of_business_id',   $shopid )->latest()->get();
	


	

	        if ($request->ajax()) {
					  $khoroch_transition=  khoroch_transition::with('khorocer_khad','supplier','User')->where('balance_of_business_id',   $shopid )->latest()->get();
           
            return Datatables::of($khoroch_transition)
                   ->addIndexColumn()
				   

                    ->addColumn('action', function( khoroch_transition $data){ 
   
                     
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm">Edit</button>';
                        return $button;
          
						
						
                        

					   return $button;
                    })


					
                   ->addColumn('khorocer_name', function (khoroch_transition $khoroch_transition) {
                    return $khoroch_transition->khorocer_khad->name;
                })
				  
                      ->addColumn('supplier_name', function (khoroch_transition $khoroch_transition) {
                    return $khoroch_transition->supplier->name;
                })
				  
				       ->addColumn('entryby', function (khoroch_transition $khoroch_transition) {
                    return $khoroch_transition->User->name;
                })
				
                 ->editColumn('created_at', function(khoroch_transition $data) {
					
					 return date('d/m/y', strtotime($data->created_at) );
                    
                })
				

					
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
		

		return view('khoroch_transition.khoroch_transition', compact('khoroch_transition'));   
	
	}











		    public function dropdown_list()
    {
		



 $shopid = Auth()->user()->balance_of_business_id;


       $khorocer_khad = khorocer_khad::where('balance_of_business_id',  $shopid  )->where('softdelete', '!', '1' )->get(); 
	   
 $supplier = supplier::where('balance_of_business_id',  $shopid  )->where('softdelete', '!', '1' )->get(); 
	         

            return response()->json(['khorocer_khad' => $khorocer_khad , 'supplier' => $supplier]);
	 
 
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
            'parentid'    =>  'required',
            'supplier'     =>  'required',
              
            'Date_of_Transition'=>  'required',
                'amount' =>  'required',  
            'due' ,  				
			'advance', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

   	DB::beginTransaction();    		

$khoroch_transition = new khoroch_transition();

$khoroch_transition->khorocer_khad_id = $request->parentid;
$khoroch_transition->supplier_id = $request->supplier;
$khoroch_transition->unit = 1;
$khoroch_transition->unit_price = $request->amount;
$khoroch_transition->amount = $request->amount;
$khoroch_transition->due = $request->due;
$khoroch_transition->advance = 0;
$khoroch_transition->balance_of_business_id = Auth()->User()->balance_of_business_id;
$khoroch_transition->user_id = Auth()->User()->id;
$khoroch_transition->created_at = $request->Date_of_Transition;
$khoroch_transition->save();

		

		
		$supplier = supplier::findOrFail($request->supplier );
		$present_due = $supplier->due + $request->due;
		$present_advance = $supplier->advance + $request->advance;
   
   
   supplier::where('id', $request->supplier)
  ->update(['due' =>$present_due , 'advance' => $present_advance ]);
   
     	 			     /////////////update balance use  	
  
  
 			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

 
   if ($request->advance == 0)
   {
   $present_balance = $balance->balance - ($request->amount - $request->due) ;
   }
      if ($request->advance > 0)
   {
   $present_balance = $balance->balance - $request->advance  ;
   }
    balance_of_business::where('id',  $shopid) 
  ->update(['balance' =>$present_balance  ]);
   
   
   
   $khorocname = khorocer_khad::findOrFail($request->parentid)->path;
   
   
  	$cashtransition = new  cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->description = "Paying for "  .$khorocname;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->khoroch_transition_id = $khoroch_transition->id;
$cashtransition->amount = $request->amount - $request->due;
$cashtransition->withdrwal = $request->amount - $request->due;	
$cashtransition->type = 2;
$cashtransition->created_at = $request->Date_of_Transition;
$cashtransition->transtype = 2;

$cashtransition->save(); 
   
   
   
   
   
   
   
   
   
      DB::commit(); 

   
   
       

        return response()->json(['success' => 'Data Added successfully.']);
    }


 public function selectkhoroch()
 {
	 $firstlevel = khorocer_khad::where('parent_id', null )->orderby('name')->get();
	  $secondlevel = khorocer_khad::where('secondparent_id', null )->where('parent_id', '!=', null )->orderby('name')->get();
	 	  $thirdlevel = khorocer_khad::where('thirdparent_id', null )->where('secondparent_id','!=', null )->where('parent_id', '!=', null )->orderby('name')->get();
		  	  $fourthlevel = khorocer_khad::where('thirdparent_id', '!=', null )->where('secondparent_id','!=', null )->where('parent_id', '!=', null )->orderby('name')->get();
	return view('khoroch_transition.khoroch', compact('firstlevel','secondlevel','thirdlevel','fourthlevel' ));    
 }
 
 
 
 
 public function secondlevel($id)
 {
	 $secondlevel = khorocer_khad::where('parent_id', $id )->orderby('name')->get(); 
	return response()->json(['secondlevel' => $secondlevel  ]); 
	 
 }





 public function thirdlevel($id)
 {
	 $thirdlevel = khorocer_khad::where('parent_id', $id )->orderby('name')->get(); 
	return response()->json(['thirdlevel' => $thirdlevel  ]); 
	 
 }




 public function fourthlevel($id)
 {
	 $fourthlevel = khorocer_khad::where('parent_id', $id )->orderby('name')->get(); 
	return response()->json(['fourthlevel' => $fourthlevel  ]); 
	 
 }






public function fetchkhoroch(Request $request)
{
	
	
	        $validator = Validator::make($request->all(), [
            'startdate' => 'required|date|size:10',
        'enddate' => 'date|size:10',
		'parentid',
	
        ]);
	
		        $start = date("Y-m-d",strtotime($request->input('startdate')));
        $end = date("Y-m-d",strtotime($request->input('enddate')));
		$datethatsentasenddatefromcust =  date("Y-m-d",strtotime($request->input('enddate')));
	
	 $shopid = Auth()->user()->balance_of_business_id;
	 
	 
	 if($request->fourthlevel != null )
	 {
		$t= $request->fourthlevel; 
		 
	 }
	 
	 if (($request->thirdlevel != null ) and  ($request->fourthlevel == null ) )
	 {
		$t= $request->thirdlevel;  
			
		 
	 }
	 if (($request->secondlevel != null ) and  ($request->thirdlevel == null ) )
		 
		 {
			$t= $request->secondlevel;   
		 }
 
		 if (($request->firstlevel != null ) and  ($request->secondlevel == null ) )
		 
		 {
			$t= $request->firstlevel;   
		 }	 
		 
		 
		 
		 
	 
	 		 $khoroch =  khoroch_transition::with('supplier','User','khorocer_khad','parentcat')					 
		  ->orderBy(khorocer_khad::select('path')->whereColumn('khorocer_khads.id','khoroch_transitions.khorocer_khad_id' ))
		 	->whereBetween('created_at',[$start,$end])    
			->where('balance_of_business_id',   $shopid )
		->get();
	
	$expensesname = khorocer_khad::findOrFail($t)->name;
	

		   $pdf = PDF::loadView('khoroch_transition.voucher', compact('khoroch','t','expensesname','datethatsentasenddatefromcust','start' ),
   [], [
 'mode'                     => '',
	'format'                   => 'A4',
	'default_font_size'        => '8',
	'default_font'             => 'Times-New-Roman',
	'margin_left'              => 7,
	'margin_right'             => 7,
	'margin_top'               => 7,
	'margin_bottom'            => 7,
]
   
   
   );


	 return $pdf->stream('document.pdf');
	

	
	
	
	
	
}












    /**
     * Display the specified resource.
     *
     * @param  \App\Models\khoroch_transition_conTroller  $khoroch_transition_conTroller
     * @return \Illuminate\Http\Response
     */
    public function show(khoroch_transition_conTroller $khoroch_transition_conTroller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\khoroch_transition_conTroller  $khoroch_transition_conTroller
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
	   
	   	   $shopid = Auth()->user()->balance_of_business_id;
	
	  $khoroch_transition=  khoroch_transition::with('khorocer_khad','supplier','User')->where('balance_of_business_id',   $shopid )->where('id', $id )->first();
	



       $khorocer_khad = khorocer_khad::where('balance_of_business_id',  $shopid  )->where('softdelete', '!', '1' )->get(); 
	   
 $supplier = supplier::where('balance_of_business_id',  $shopid  )->where('softdelete', '!', '1' )->get(); 
	         

            return response()->json(['khorocer_khad' => $khorocer_khad , 'supplier' => $supplier , 'khoroch_transition' => $khoroch_transition  ]);
	 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\khoroch_transition_conTroller  $khoroch_transition_conTroller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    

       $rules = array(
            'khorocer_khad'    =>  'required',
            'supplier'     =>  'required',
     'Date_of_Transition'=>  'required',
                'amount' =>  'required',  
            'due' ,  				
			'advance', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

        $form_data = array(
            'khorocer_khad_id' =>  $request->khorocer_khad,
			'supplier_id' => $request->supplier,
		
			'unit_price' =>  $request->amount,
			'amount' =>  $request->amount,
			'due' =>  $request->due,
			'created_at'  =>  $request->Date_of_Transition,
             'user_id' => Auth()->User()->id, 
			 'balance_of_business_id' => Auth()->user()->balance_of_business_id, 
			 
			 
			 
 	 
        );
		
		
		DB::beginTransaction();
		
	$k= khoroch_transition::findOrFail($request->hidden_id );
	 	$supplier = supplier::findOrFail($k->supplier_id );
		$present_due = $supplier->due - $k->due;
		$present_advance = $supplier->advance - $k->advance;
   
   
   supplier::where('id', $k->supplier_id)
  ->update(['due' =>$present_due , 'advance' => $present_advance ]);
   












	 
	

khoroch_transition::where('id', $request->hidden_id )->update($form_data);
	
		$supplier = supplier::findOrFail($request->supplier );
		$present_due = $supplier->due + $request->due;
		$present_advance = $supplier->advance + $request->advance;
   
   
   supplier::where('id', $request->supplier)
  ->update(['due' =>$present_due , 'advance' => $present_advance ]);
   
     	 			     /////////////update balance use  	
  
  
  
  
 			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);


    
   if ($request->advance == 0)
   {
   $present_balance = $balance->balance + ($k->amount - $k->due) - ($request->amount - $request->due) ;
   }
      if ($request->advance > 0)
   {
   $present_balance = $balance->balance - $request->advance  ;
   }
   balance_of_business::where('id',  $shopid) 
  ->update(['balance' =>$present_balance  ]);
   
   
   
   $khorocname = khorocer_khad::findOrFail($request->khorocer_khad)->name;
   
   
   
    cashtransition::where('khoroch_transition_id',  $request->hidden_id   ) 
  ->update([
  
  
'description' => "Paying for "  .$khorocname,

'User_id' => Auth()->user()->id,

'amount' => $request->amount - $request->due,
'withdrwal' => $request->amount - $request->due,	
'type' => 2,
'created_at'  =>  $request->Date_of_Transition,
'transtype' => 2,


  ]);  
   
   
   
   
   
   
   
      DB::commit(); 

   
   
       

        return response()->json(['success' => 'Data Added successfully.']);





















    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\khoroch_transition_conTroller  $khoroch_transition_conTroller
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $data = khoroch_transition::findOrFail($id);
		
		
				$supplier = supplier::findOrFail($data->supplier_id );
		$present_due = $supplier->due - $data->due;
		$present_advance = $supplier->advance - $data->advance;
   
   
   supplier::where('id', $data->supplier_id)
  ->update(['due' =>$present_due , 'advance' => $present_advance ]);
   

		/////////////update balance 
  DB::beginTransaction();
  
 			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid); 
 if ($data->advance == 0)
 {	 
   $present_balance = $balance->balance + ($data->amount - $data->due) ;    
		
 }	
 
  if ($data->advance > 0)
 {	 
   $present_balance = $balance->balance + $data->advance  ;    
		
 }
		
	   balance_of_business::where('id', $shopid)
  ->update(['balance' =>$present_balance  ]);	
		
	

cashtransition::where('khoroch_transition_id', $data->id  )->delete();



	
        $data->delete();
    
	 DB::commit();	
	
	}
}
