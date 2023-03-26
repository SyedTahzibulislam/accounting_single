<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\cashtransition; 
use App\Models\employeedetails;    
use App\Models\employeesalarytransaction;
use DataTables;
use Validator;
use Carbon\Carbon;
use App\Models\balance_of_business;
use DB;

use Illuminate\Support\Facades\Redirect;
use PDF;



class employeetransactioncontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employeesalarytransaction =  employeesalarytransaction::with('employeedetails')->latest()->get();
	
	  
	        if ($request->ajax()) {
					  $employeesalarytransaction=  employeesalarytransaction::with('employeedetails')->latest()->get();
            //$medicine =  medicine::latest()->get();
            return Datatables::of($employeesalarytransaction)
                   ->addIndexColumn() 
				   

                    ->addColumn('action', function( employeesalarytransaction $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  
    
                      ->addColumn('employee_name', function (employeesalarytransaction $employeesalarytransaction) {
                    return $employeesalarytransaction->employeedetails->name;
                })
				->editColumn('created_at', function(employeesalarytransaction $data) {
					
					 return date('d/m/y H:i A', strtotime($data->created_at) );
                    
                })	
					
                    ->rawColumns(['action'])
                    ->make(true);
        }
		
	return view('employeesalarytransaction.employeesalarytransaction', compact('employeesalarytransaction'));   
   

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
	
	
		    public function dropdown_list()
    {
		

       $employeedetails = employeedetails::where('softdelete','0' )->orderBy('name')->get(); 
	   

	         

            return response()->json(['employeedetails' => $employeedetails ]);
	 
 
    }



public function employeeshow()
{
	       $employeedetails = employeedetails::where('softdelete','0' )->orderBy('name')->get(); 
	
	return view('employeesalarytransaction.list', compact('employeedetails'));   
   

	
	
}




public function employeesalaryfetch(Request $request ) 

{
	
$employeesalarytransaction =  employeesalarytransaction::with('employeedetails')->where('employeedetails_id',$request->employee)->orderBy('starting')->get();	
$employeedetails = employeedetails::findOrFail($request->employee);




	   $pdf = PDF::loadView('employeesalarytransaction.reportbill', compact('employeesalarytransaction','employeedetails' ),
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
            'Startdate' =>  'required',       
			
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

        $form_data = array(
            'employeedetails_id'        =>  $request->employeelist,
            'totalsalary'         =>  $request->salary,
			
	 'starting' =>$request->Startdate,
	 'balance_of_business_id' => Auth()->user()->balance_of_business_id,
		 
 	 
        );
		
		

   
 
   
   
    DB::beginTransaction();
	
	
	
	
	
	
	
   	 			     /////////////update balance    	
  
	$shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);  
   $present_balance = $balance->balance - $request->salary ;	    
   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
	////////////////////////////////////banlce update complete 
 
   
   
     $k=   employeesalarytransaction::create($form_data);
		
	$employee_name = employeedetails::findOrFail($request->employeelist)->name;	
		
		
		
		
			$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;

$cashtransition->User_id = Auth()->user()->id;
$cashtransition->employeesalarytransaction_id = $k->id;
$cashtransition->amount = $request->salary;
$cashtransition->withdrwal = $request->salary;	

$cashtransition->description = "Expenditure for salary to the employee:- " .$employee_name;	
$cashtransition->created_at = $request->Startdate;
$cashtransition->transtype = 4;
$cashtransition->type = 2;
$cashtransition->save();	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
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
                       if(request()->ajax())
        {
			//$data=  medicine::with('medicine_category')->findOrFail($id);
            $data = employeesalarytransaction::with('employeedetails')->findOrFail($id);
			
			$employeedetails = employeedetails::where('softdelete','0' )->orderBy('name')->get(); 

			
			
			
			 
            return response()->json(['data' => $data , 'employeedetails' => $employeedetails  ]);
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
            'employeelist'    =>  'required',
            'salary'     =>  'required',
            'Startdate' =>  'required',       
	
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       		

        $form_data = array(
            'employeedetails_id'        =>  $request->employeelist,
            'totalsalary'         =>  $request->salary,
			
	 'starting' =>$request->Startdate,
		'balance_of_business_id' => Auth()->user()->balance_of_business_id,
		 
 	 
        );
		
		

    
	/// update balance 
	DB::beginTransaction();


 	$data = employeesalarytransaction::findOrFail($request->hidden_id);	
		
	$shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);  
   $present_balance = $balance->balance + $data->totalsalary ;
   $present_balance = $present_balance - $request->salary ;
   balance_of_business::where('id',  $shopid)
  ->update(['balance' => $present_balance  ]);
  
  
  
  
          $form_dataforcash = array(
            
				'balance_of_business_id' => Auth()->user()->balance_of_business_id,
	'amount' =>		$request->salary,
			'withdrwal' =>   $request->salary,
		 'created_at'=>$request->Startdate,
           
        );	
  
  
  
  
  
  
  
  
    
	 employeesalarytransaction::whereId($request->hidden_id)->update($form_data);
	  cashtransition::where( ['employeesalarytransaction_id' =>   $request->hidden_id,] )->update($form_dataforcash);

	DB::commit();
	 
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
DB::beginTransaction();
			   $data = employeesalarytransaction::findOrFail($id);
				
				
					 			     /////////////update balance    	
	$shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid); 
   $present_balance = $balance->balance + $data->totalsalary ;	    
   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>$present_balance  ]);
		/////// upade completee 
		
		////delete 
		 cashtransition::where('employeesalarytransaction_id',  $data->id )->delete();		
        $data->delete();
    
	DB::commit();
    }
}
