<?php

namespace App\Http\Controllers;

use App\Models\agenttransactionController;
use Illuminate\Http\Request;

use App\Models\agentdetail;    
use App\Models\patient;   
use App\Models\agenttransaction;
use App\Models\balance_of_business;
use App\Models\cashtransition;

use DataTables;
use Validator;
use Carbon\Carbon;
use DB;
use PDF;
class AgenttransactionControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
		
		
        $employeesalarytransaction =  agenttransaction::with('agentdetail')->latest()->get();
	
	  
	        if ($request->ajax()) {
					  $employeesalarytransaction=  agenttransaction::with('agentdetail')->latest()->get();
            //$medicine =  medicine::latest()->get(); 
            return Datatables::of($employeesalarytransaction)
                   ->addIndexColumn() 
				   

                    ->addColumn('action', function( agenttransaction $data){ 
   /*
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';  */
                        $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                         $button .= '&nbsp;&nbsp;';
						 
					if ($data->paidorunpaid == 0)
					{ 
						$button .= '<button type="button" name="paid" id="'.$data->id.'" class="paid btn btn-info btn-sm">Paid</button>';
					}
						return $button;
                    })  
    
                      ->addColumn('employee_name', function (agenttransaction $employeesalarytransaction) {
                    return $employeesalarytransaction->agentdetail->name;
                })
				
				
				 ->addColumn('patient_name', function (agenttransaction $employeesalarytransaction) {
                    if ($employeesalarytransaction->patient_id )
					{
				return	$patient = patient::findOrFail($employeesalarytransaction->patient_id)->name;
					}
					else
					{
						return	$patient="Not Applicable";
					}
						
                })
				
				
								 ->addColumn('paid_staus', function (agenttransaction $employeesalarytransaction) {
                    
				if ($employeesalarytransaction->paidorunpaid == 0)
				{
					
					return $status="Unpaid";
					
				}
								if ($employeesalarytransaction->paidorunpaid == 1)
				{
					
					return $status="Paid";
					
				}	
						
                })

				
				    
					
					->addColumn('transitino_type', function (agenttransaction $employeesalarytransaction) {
                    

					
					
					return $type = "Commission";
					
					
				
                })
				
				
				
				
				
				
				
				
				
					->editColumn('created_at', function(agenttransaction $data) {
					
					 return date('d/m/y', strtotime($data->created_at) );
                    
                })
				

				             ->editColumn('pdf', function ($employeesalarytransaction) {
								 
								 if($employeesalarytransaction->paidorunpaid == 1)
								 {			 
                //return '<a   target="_blank"      href="'.route('agenttransaction.pdf', $employeesalarytransaction->id).'">Print</a>';
							
return "A";

							} else{
								return  'NA';	 
									 
								 }


		   })



				
                    ->rawColumns(['action','pdf'])
                    ->make(true);
        }
		

		return view('agenttransaction.agenttransaction', compact('employeesalarytransaction'));   
    }



   	public function printpdf($id)
{


		  $agenttransaction= agenttransaction::with('agentdetail','patient' )->findOrFail($id);
            
	$p = patient::find($agenttransaction->patient_id);
	
	if($p != null)
	{
	$p = $p->name;	
	}
	else
	{
	$p = "NA";		
	}

	
	
	
	
	   $pdf = PDF::loadView('agenttransaction.pdf', compact('agenttransaction','p' ),
   [], [
 'mode'                     => '',
	'format'                   => 'A5',
	'default_font_size'        => '7',
	'default_font'             => 'Times-New-Roman',
	'margin_left'              => 7,
	'margin_right'             => 7,
	'margin_top'               => 7,
	'margin_bottom'            => 7,
]
   
   
   );
	
	
	 return $pdf->stream('document.pdf');
	

	
}
















     public function agentfetch(Request $request)
    {
		
		
        $agentrans =  agenttransaction::with('agentdetail')->where('agentdetail_id', $request->agent  )->latest()->get();
	
	  
	   /*     if ($request->ajax()) {
					  $employeesalarytransaction=  agenttransaction::with('agentdetail')->where('agentdetail_id', $request->agent  )->latest()->get();
            //$medicine =  medicine::latest()->get(); 
            return Datatables::of($employeesalarytransaction)
                   ->addIndexColumn() 
				   

                    ->addColumn('action', function( agenttransaction $data){ 
   /*
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';  */
           /*             $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                         $button .= '&nbsp;&nbsp;';
						 
					if ($data->paidorunpaid == 0)
					{ 
						$button .= '<button type="button" name="paid" id="'.$data->id.'" class="paid btn btn-info btn-sm">Paid</button>';
					}
						return $button;
                    })  
    
                      ->addColumn('employee_name', function (agenttransaction $employeesalarytransaction) {
                    return $employeesalarytransaction->agentdetail->name;
                })
				
				
				 ->addColumn('patient_name', function (agenttransaction $employeesalarytransaction) {
                    if ($employeesalarytransaction->patient_id )
					{
				return	$patient = patient::findOrFail($employeesalarytransaction->patient_id)->name;
					}
					else
					{
						return	$patient="Not Applicable";
					}
						
                })
				
				
								 ->addColumn('paid_staus', function (agenttransaction $employeesalarytransaction) {
                    
				if ($employeesalarytransaction->paidorunpaid == 0)
				{
					
					return $status="Unpaid";
					
				}
								if ($employeesalarytransaction->paidorunpaid == 1)
				{
					
					return $status="Paid";
					
				}	
						
                })

				
				    
					
					->addColumn('transitino_type', function (agenttransaction $employeesalarytransaction) {
                    
					if ($employeesalarytransaction->transitiontype == 1)
					{
						$type= "Pathology Commission ";
					return $type;	
					}
					
					elseif ($employeesalarytransaction->transitiontype == 3)
					{
						$type= " Commission for surgery";
					return $type;	
					}
					elseif ($employeesalarytransaction->transitiontype == 4)
					{
						$type= " Commission for cabine fair";
					return $type;	
					}
					elseif ($employeesalarytransaction->transitiontype == 5)
					{
						$type= " Commission for the Patient relased";
					return $type;	
					}
					else
					{
						$type= " Not Applicable";
					return $type;	
					}
				
                })
				
				
				
				
				
				
				
				
				
					->editColumn('created_at', function(agenttransaction $data) {
					
					 return date('d/m/y', strtotime($data->created_at) );
                    
                })
					
                    ->rawColumns(['action'])
                    ->make(true);
        }  */
		

		return view('agenttransaction.agentfetch', compact('agentrans'));   
    }




















    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 	public function selectagent()
{
	
			$agentdetail = agentdetail::where('softdelete',0)->orderBy('name')->get();
		return view('agenttransaction.selectagent', compact('agentdetail'));   
	
	
} 
	 
	 
    public function create()
    {
        //
    }

		    public function dropdown_list()
    {
		

       $employeedetails = agentdetail::where('softdelete','0' )->orderBy('name')->get(); 
	   

	         

            return response()->json(['employeedetails' => $employeedetails ]);
	 
 
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
            'employeelist'    =>  'required',
            'salary'     =>  'required',
			'commissiontype'  =>  'required',
			'comment',
           
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

     DB::beginTransaction();      		
if ($request->commissiontype == 2  )
{
	
	$agenttransaction = new agenttransaction();
	
	$agenttransaction->agentdetail_id = $request->employeelist;
	
		$agenttransaction->paidamount = $request->salary;
		$agenttransaction->transitiontype = 1;
		$agenttransaction->comment = $request->comment;
		$agenttransaction->created_at = $request->Date_of_Transition;
	$agenttransaction->save();
	
	

		
}		

 if ($request->commissiontype == 1  )
{
	
	
	
		$agenttransaction = new agenttransaction();
	
	$agenttransaction->agentdetail_id = $request->employeelist;
	
		$agenttransaction->paidamount = $request->salary;
		$agenttransaction->paidorunpaid = 1;
		$agenttransaction->transitiontype = 6;
		$agenttransaction->comment = $request->comment;
		$agenttransaction->created_at = $request->Date_of_Transition;
	$agenttransaction->save();
	

		
}  
 
   
   

 $agent =   agentdetail::findOrFail($request->employeelist)->name;
      
		
		
		
 if ($request->commissiontype == 1  )		// nogode hole balance kmbe
 {		
 
 $businessid = Auth()->user()->balance_of_business_id;
 
			     /////////////update balance 	
   $balance =         balance_of_business::findOrFail($businessid);  
   $present_balance = $balance->balance - $request->salary ;	    
   balance_of_business::where('id', $businessid)
  ->update(['balance' =>$present_balance  ]);
	



		$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;

$cashtransition->User_id = Auth()->user()->id;
$cashtransition->agenttransaction_id = $agenttransaction->id;



$cashtransition->amount = $request->salary;
$cashtransition->withdrwal = $request->salary;	

$cashtransition->transtype = 11;

$cashtransition->description = "Paying Commission to the Agent :"  .$agent ;

$cashtransition->type = 2;
$cashtransition->save(); 













 }	
 
  if ($request->commissiontype == 2  )	// bakite hole hostipataler kache pawna barbe 	
 {
   $agent =  agentdetail::findOrFail($request->employeelist)->hospitaler_kache_pawna;
  $agentbalance =  $agent  + $request->salary ;
     agentdetail::findOrFail($request->employeelist)
  ->update(['hospitaler_kache_pawna' =>$agentbalance  ]);
  }
 
 
 
 
 
 
 
 
 
 
 
 
 
	  DB::commit();

        return response()->json(['success' => 'Data Added successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\agenttransactionController  $agenttransactionController
     * @return \Illuminate\Http\Response
     */
    public function show(agenttransactionController $agenttransactionController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\agenttransactionController  $agenttransactionController
     * @return \Illuminate\Http\Response
     */
	 
	

public function paidsenddata($id)
{
	  $data = agenttransaction::with('agentdetail')->findOrFail($id);

	 return response()->json(['data' => $data ]);
	
}


	
	 public function paid (Request $request){
		    if ($request->ajax()) {
			   
	  $agenttransition = agenttransaction::findOrFail($request->hidden_id);
 	
		   agenttransaction::where('id', $request->hidden_id)
  ->update(['paidorunpaid' => 1,

'created_at' => Carbon::today(),
'paidamount' =>$request->salary,

  ]);
  
  
  
  

  
 $businessid = Auth()->user()->balance_of_business_id;
 
			     /////////////update balance 	
   $balance =         balance_of_business::findOrFail($businessid);  
   $present_balance = $balance->balance - $request->salary ;	    
   balance_of_business::where('id', $businessid)
  ->update(['balance' =>$present_balance  ]);

  
  $agent =  agentdetail::findOrFail($agenttransition->agentdetail_id)->hospitaler_kache_pawna;
  $agentbalance =  $agent  - $agenttransition->paidamount    ;
     agentdetail::findOrFail($agenttransition->agentdetail_id)
  ->update(['hospitaler_kache_pawna' =>$agentbalance  ]); 
  
  	$agentname= agentdetail::findOrFail($agenttransition->agentdetail_id)->name;


	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;

$cashtransition->User_id = Auth()->user()->id;
$cashtransition->agenttransaction_id = $agenttransition->id;



$cashtransition->amount = $request->salary;
$cashtransition->withdrwal = $request->salary;	

$cashtransition->transtype = 11;

$cashtransition->description = "Paying Commission to the Agent :"  .$agentname ;

$cashtransition->type = 2;
$cashtransition->save(); 
  

  
  
  return response()->json(['success' => 'Amount Paid']); 
		 
	 }
	 }
	


	
     public function edit($id)
    {
                       if(request()->ajax())
        {
			//$data=  medicine::with('medicine_category')->findOrFail($id);
            $data = agenttransaction::with('agentdetail')->findOrFail($id);
			
			$employeedetails = agentdetail::where('softdelete','0' )->orderBy('name')->get(); 

			
			
			
			 
            return response()->json(['data' => $data , 'employeedetails' => $employeedetails  ]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\agenttransactionController  $agenttransactionController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
                  $rules = array(
            'employeelist'    =>  'required',
            'salary'     =>  'required',
           
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

        $form_data = array(
            'agentdetail_id'        =>  $request->employeelist,
            'paidamount'         =>  $request->salary,
	
 	 
        );
		
		

    
					    DB::beginTransaction();
   
       $data = agenttransaction::findOrFail($request->hidden_id);
		
			     /////////////update balance 	
   $balance = balance_of_business::first();  
   $present_balance = $balance->balance + $data->paidamount ;	    
  $present_balance = $present_balance - $request->salary ;
  balance_of_business::where('id', 1)
  ->update(['balance' =>$present_balance  ]);
		
		
		
    agenttransaction::whereId($request->hidden_id)->update($form_data);
	
       
		 DB::commit();
	 
	  return response()->json(['success' => 'Data is successfully updated']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\agenttransactionController  $agenttransactionController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
			    DB::beginTransaction();
   
       $data = agenttransaction::findOrFail($id);
	   
	   
  if ($data->paidorunpaid == 1 )  // taka deya hoye geche 
  {   	  

		
	
	 $businessid = Auth()->user()->balance_of_business_id;
 
			     /////////////update balance 	
   $balance =         balance_of_business::findOrFail($businessid);  
   $present_balance = $balance->balance + $data->paidamount ;	    
   balance_of_business::where('id', $businessid)
  ->update(['balance' =>$present_balance  ]);
	
	$cashtransition = cashtransition::where('agenttransaction_id', $data->id  )->first();

		$cashtransition->delete();
	
	
	
	
	
	
	
	
	
        $data->delete();
		
  }
  
 if ($data->paidorunpaid == 0 ) 
 {

   $agentdetail =  agentdetail::findOrFail($data->agentdetail_id)->hospitaler_kache_pawna;
  $agentdetailbalance =  $agentdetail  - $data->paidamount;
     agentdetail::findOrFail($data->agentdetail_id)
  ->update(['hospitaler_kache_pawna' =>$agentdetailbalance  ]);

 $data->delete();

 }	 
 	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
		
			     /////////////update balance 	

		 DB::commit();
    }
}
