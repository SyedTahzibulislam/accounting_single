<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Models\balance_of_business; 
use App\Models\User;
use App\Models\productorder;
use App\Models\Customer;
use App\Models\Bankname; 
use App\Models\sharepartner; 
use App\Models\Taka_uttolon_transition; 

use App\Models\cashtransition; 


use App\Models\Bankchalan;
use App\Models\Productcompany;
use App\Models\productcompanyorder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;

$jsonmessage=0;
$status=0;
class banktransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   	       public function index(Request $request)
    {
      $Bankchalan=  Bankchalan::with('Bankname','Productcompany','Customer','user')->latest()->get();
	  
	
	  
	        if ($request->ajax()) { 
            

			$Bankchalan=  Bankchalan::with('Bankname','Productcompany','Customer','user')->latest()->get();
            return Datatables::of($Bankchalan)
                   ->addIndexColumn()
                    ->addColumn('action', function( Bankchalan $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  
                              

	 ->addColumn('transtype', function (Bankchalan $Bankchalan) {
                   
    if($Bankchalan->type == 0)
	{
		return "Deposit";
	}


    if($Bankchalan->type == 1)
	{
		return "Withdrawl";
	}
				 
                }) 
					
					
					
					
	 ->addColumn('whom', function (Bankchalan $Bankchalan) {
                   
    if($Bankchalan->whom == 0)
	{
		return "From Business";
	}


    if($Bankchalan->whom == 1)
	{
		$customer = Customer::findOrFail($Bankchalan->customer_id)->name;
		return "customer:".$customer;
	}
	
	
	
    if($Bankchalan->whom == 2)
	{
		$company = Productcompany::findOrFail($Bankchalan->productcompany_id)->name;
			return "company:".$company;
	
	}
	
	
	
    if($Bankchalan->whom == 3)
	{
		$partner = sharepartner::findOrFail($Bankchalan->sharepartner_id)->name;
		return "Partner:".$partner;
	}
	
	
	
				 
                }) 	


	
					
					
					
					
					
					
					
					
					
->addColumn('entryby', function (Bankchalan $Bankchalan) {
                   
      $username = User::findOrFail($Bankchalan->User_id)->name;


				   return $username;
                }) 			
					
					
					
					
					
					
					
					
					
					
					
					

                 ->editColumn('created', function(Bankchalan $Bankchalan) {
					
					 return date('d/m/y h:i A', strtotime($Bankchalan->created_at) );
                    
                })
				
			
	             ->editColumn('pdf', function ($Bankchalan) {
                return '<a   target="_blank"      href="'.route('banktransition.pdf', $Bankchalan->id).'">Print</a>';
            })	

				

					
					
                    ->rawColumns(['action','created' ,'pdf'])

                    ->make(true);
					
					

        } 
      
        return view('bankchalan.bankchalan', compact('Bankchalan'));   

    }





public function printvoucher($id)
{
	
 $Bankchalan=  Bankchalan::with('Bankname','Productcompany','Customer','user')->findOrFail($id);

    if($Bankchalan->type == 0)
	{
		$type= "Deposit";
	}


    if($Bankchalan->type == 1)
	{
		$type= "Withdrawl";
	}
 
	
    if($Bankchalan->whom == 0)
	{
		$from= "From Business";
	}

 if($Bankchalan->whom == 1)
	{
		$customer = Customer::findOrFail($Bankchalan->customer_id)->name;
		$from= "customer:-".$customer;
	}
	
	
	
    if($Bankchalan->whom == 2)
	{
		$company = Productcompany::findOrFail($Bankchalan->productcompany_id)->name;
			$from= "company:-".$company;
	
	}
	
	
	
    if($Bankchalan->whom == 3)
	{
		$partner = sharepartner::findOrFail($Bankchalan->sharepartner_id)->name;
		$from= "Partner:-".$partner;
	}



$bankname = Bankname::findOrFail($Bankchalan->Bankname_id)->name; 
$username = user::findOrFail($Bankchalan->User_id)->name; 
	 $pdf = PDF::loadView('bankchalan.voucher', compact('from','type','Bankchalan','bankname','username' ),
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
	
	
	 return $pdf->stream('bankchalan.pdf');
	
	






}






	    public function  dropdownlist()
    {
		

	 $shopid = Auth()->user()->balance_of_business_id;
	   
	      $Bank = Bankname::where('balance_of_business_id', $shopid )->where('softdelete', 0)->orderBy('name')->get(); 
	   $Productcompany = Productcompany::where('balance_of_business_id', $shopid )->where('softdelete', 0)->orderBy('name')->get();
		 
		 $customer = Customer::where('balance_of_business_id', $shopid )->where('softdelete', 0)->orderBy('name')->get();
 $partner = sharepartner::where('balance_of_business_id', $shopid )->where('softdelete', 0)->orderBy('name')->get();
			
            return response()->json(['customer' => $customer , 'partner'=> $partner, 'Bank' => $Bank , 'Productcompany' => $Productcompany ]);

	   
	   
	   
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
        	$validated = $request->validate([
	
	 	'customer',
		
		'company',
		'transtype',
		'whom',
		'partner','Bank','grossamount',
		
		'transdate',

'comment',
		
		
    ]);
	
	

	if ( ($request->whom != 0   ) && ($request->customer == "") && ($request->company == "") && ($request->partner == "") )
	{
		
	global $status;			
$status=4;  // doya kore ke dicche theke ekta option check koren 
goto flag;	
	}



$bank = Bankname::findOrFail($request->Bank);

if ( $request->transtype == 1 )

{
	if ( $request->grossamount  >  $bank->currentbalance )
	{
		$status=5;  // Bank e jothesto taka nai  
goto flag;
		
	}
}





$Bankchalan = new Bankchalan();
$Bankchalan->Bankname_id = $request->Bank;
$Bankchalan->productcompany_id = $request->company;
$Bankchalan->customer_id = $request->customer;
$Bankchalan->sharepartner_id = $request->partner;
$Bankchalan->User_id = Auth()->User()->id;
$Bankchalan->amount = $request->grossamount;
$Bankchalan->description = $request->comment;

$Bankchalan->balance_of_business_id = Auth()->user()->balance_of_business_id;



if($request->transtype == 0) // 0 - joma
{ 	
$Bankchalan->type = $request->transtype;
$Bankchalan->debit = 0;
$Bankchalan->credit = $request->grossamount;

  
  

Bankname::where('id',$request->Bank)
 ->update(['currentbalance' =>( $bank->currentbalance + $request->grossamount  )  ]);

}




if($request->transtype == 1) // uttolon
{ 	
$Bankchalan->type = $request->transtype;
$Bankchalan->debit = $request->grossamount;
$Bankchalan->credit = 0;




Bankname::where('id',$request->Bank)
 ->update(['currentbalance' =>( $bank->currentbalance - $request->grossamount  )  ]);



}



$Bankchalan->transdate = $request->transdate ;

$Bankchalan->whom = $request->whom ;	
	
	



///////// bank chalaner kaj sheshh



if ($request->whom == 0 ) 
{
	
		 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);
	if($request->transtype == 1)
	{
   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance + $request->grossamount )  ]);




  
	}
	if($request->transtype == 0)
	{
   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance - $request->grossamount )  ]);	
  

  
	}	
	
	
}




if ($request->whom == 3 ) 
{
	$partner = sharepartner::findOrFail($request->partner); 
	 
	   	if($request->transtype == 1)
	{
	   sharepartner::where('id', $request->partner)
  ->update(['uttholon' =>(   $partner->uttholon	+  $request->grossamount )  ]);	
	
	
	$Taka_uttolon_transition = new Taka_uttolon_transition();
	$Taka_uttolon_transition->sharepartner_id = $request->partner; 
	$Taka_uttolon_transition->amount= $request->grossamount;
	$Taka_uttolon_transition->comment = "Money withdwal from Bank: " .$bank->name. "At: " .$request->transdate ; 
	$Taka_uttolon_transition->transitiontype= 1;
	
	
	$Taka_uttolon_transition->balance_of_business_id  =  Auth()->user()->balance_of_business_id;

	
	
	$Taka_uttolon_transition->save();
	}
	
	
	   	if($request->transtype == 0)
	{
	   sharepartner::where('id', $request->partner)
  ->update(['joma' =>(   $partner->joma	+  $request->grossamount )  ]);	
	
	
	$Taka_uttolon_transition = new Taka_uttolon_transition();
	$Taka_uttolon_transition->sharepartner_id = $request->partner; 
	$Taka_uttolon_transition->amount= $request->grossamount;
	$Taka_uttolon_transition->comment = "Money Deposit to the Bank: " .$bank->name. "At: " .$request->transdate ; 
	$Taka_uttolon_transition->transitiontype= 2;
		$Taka_uttolon_transition->balance_of_business_id  =  Auth()->user()->balance_of_business_id;

	$Taka_uttolon_transition->save();
	}	
$Bankchalan->Taka_uttolon_transition_id = $Taka_uttolon_transition->id;	
	
}








	
	if ($request->whom == 1 ) // customer hole 
	{		
$serialno = productorder::where('customer_id',$request->customer)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }
	
// customer banc er madhome taka joma korche 
$productorder = new productorder; 
$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
$productorder->customer_id  = $request->customer;
$productorder->serialno  = $serial;
$productorder->balance_of_business_id  =  Auth()->user()->balance_of_business_id;
	

if ($request->transtype == 0)
		
	{
		
		
$productorder->debit  = 0;
$productorder->credit  = $request->grossamount;
$productorder->comment  = "Due Payment through Bank: " .$bank->name. " at date:" .$request->transdate  ;
$productorder->amount  = $request->grossamount; 
$productorder->discount  = 0;
$productorder->amountafterdiscount	  = $request->grossamount; 
$productorder->	type  = 2;		
$productorder->balance  =   0; 


	
$productorder->save();	

// update customer balance 

$customerbalance= Customer::findOrFail($request->customer)->presentduebalance;
$currentbalance = $customerbalance - $request->grossamount;
customer::where('id', $request->customer )
       ->update([
           'presentduebalance' => $currentbalance
        ]);







	
	}


	if ($request->transtype == 1)
	{
			$productorder->debit  = $request->grossamount;
		$productorder->credit  = 0;
		$productorder->comment  = "Money back sell return through Bank: " .$bank->name. " at date:" .$request->transdate ;
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = 0;
	$productorder->amountafterdiscount	  = $request->grossamount;
	$productorder->type  = 4;
	$productorder->balance  = 0; 
	$productorder->save();
	
	
	// update customer balance 

$customerbalance= Customer::findOrFail($request->customer)->presentduebalance;
$currentbalance = $customerbalance + $request->grossamount;
customer::where('id', $request->customer )
       ->update([
           'presentduebalance' => $currentbalance
        ]);
	
	
	
	
	}

$Bankchalan->productorder_id = $productorder->id;


	}

	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////jodi company hoy
	
	
	
	if ($request->whom == 2 ) // company hole 
	{		

	
	
	
	$company = Productcompany::findOrFail($request->company);	

	 
		if ($request->transtype == 1)
		{
				
		$s = $company->due -  $request->grossamount;
		
		if ($s  < 0)
		{
			global $status; 
			$status=1;   // company k pawna theke beshi diyechen
			goto flag;
		
		
		}
		else{
		//////////////////////////////////////////////////// insert shuru ///////////////////////
		
		
		
		
$serialno = productcompanyorder::where('productcompany_id',$request->company)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }		
		
		
		
	$productorder = new productcompanyorder(); 
		$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
	$productorder->productcompany_id  = $request->company;
	$productorder->serialno  = $serial;
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = 0; 
	$productorder->amountafterdiscount	  = $request->grossamount;

	$productorder->comment  = "Pay to Company through bank " .$bank->name. " at date:"  .$request->transdate; 
	$productorder->debit  = 0;
	$productorder->credit  = $request->grossamount;
	$productorder->balance  =   0;
	$productorder->type  = 2;
	$productorder->balance_of_business_id  =  Auth()->user()->balance_of_business_id;

	
		

	
	
	
	$due = $request->grossamount;
	
	

	$dueamount = $company->due - $request->grossamount;


//// update company due 
Productcompany::where('id', $request->company )
       ->update([
           'due' => $dueamount
        ]);



	$productorder->save();
	
	
		}

	}




if ($request->transtype == 0)
{
 	$company = Productcompany::findOrFail($request->company);	
 $t=  $company->due +  $request->grossamount;

		if ($t  > 0)
		{
			global $status; 
			$status=2;   // companyr kache apni rini . company keno taka dibe 
			goto flag;
		
		
		}
		else{
		//////////////////////////////////////////////////// insert shuru ///////////////////////
		
		
		 $serialno = productcompanyorder::where('productcompany_id',$request->company)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }		
		
		
		
		
		
		
		$productorder = new productcompanyorder(); 
		$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
	$productorder->productcompany_id  = $request->company;
	$productorder->serialno  = $serial;
	$productorder->amount  = $request->grossamount; 
	
	$productorder->comment  = "Money Return from Company through bank " .$bank->name. " at date:"  .$request->transdate; 
	$productorder->debit  = $request->grossamount;
	$productorder->credit  = 0;
	$productorder->balance  = 0; 
	$productorder->type  = 4;
	$productorder->balance_of_business_id  =  Auth()->user()->balance_of_business_id;

		

	
	
	
	$due = $request->grossamount;

	

	$dueamount = $company->due +  $request->grossamount;


//// update company due 
Productcompany::where('id', $request->company )
       ->update([
           'due' => $dueamount
        ]);

	$productorder->save();
		
		}
}


$Bankchalan->productcompanyorder_id = $productorder->id;

	}

 $Bankchalan->save();

 







if ($request->whom == 0 ) 
{
	
	
  
 
	if($request->transtype == 1)
	{


  	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->Bankname_id = $request->Bank;
$cashtransition->User_id = Auth()->user()->id;

$cashtransition->amount = $request->grossamount;
$cashtransition->deposit = $request->grossamount;	
$cashtransition->type = 1;
$cashtransition->transtype = 6;
$cashtransition->description = "Deposit to the Business and withdrawl from  the Bank:" .$bank->name  ;


$cashtransition->bankchalan_id = $Bankchalan->id;

$cashtransition->created_at = $request->transdate;


$cashtransition->save();


  
	}
	if($request->transtype == 0)
	{

  
  
  
  	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->Bankname_id = $request->Bank;
$cashtransition->User_id = Auth()->user()->id;

$cashtransition->amount = $request->grossamount;
$cashtransition->withdrwal = $request->grossamount;	
$cashtransition->type = 2;
$cashtransition->transtype = 6;
$cashtransition->created_at = $request->transdate;
$cashtransition->description = "Withdrawl money from Business and Deposit to Bank:" .$bank->name  ;
$cashtransition->bankchalan_id = $Bankchalan->id;
$cashtransition->save();
  
  
  
  
  
  
  
	}	
	
	
}















 

	
	flag:
	global $status;
	if($status==1)
	{
	return response()->json(['success' => 'ট্রাঞ্জিশন সম্ভব না। কারণ আপনি কাস্টমার কে তার পাওনার চেয়ে বেশি দিয়ে ফেলেছেন। ']);		
	}
	if( $status == 2)
	{
	return response()->json(['success' => ' কোথাও ভুল হচ্ছে। কোম্পানি আপনার কাছে টাকা পায়। সে কেন টাকা জমা দিবে ?  ']);	
	}
	else
	{
 return response()->json(['success' => 'Data Added successfully. ' ]);	
	}
	
	
	
	
	
	
	
	
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
        $data= Bankchalan::findOrFail($id);
		
		
		if($data->type == 0)
		{
			$bank = Bankname::findOrFail($data->Bankname_id);
			Bankname::where('id',$data->Bankname_id)
 ->update(['currentbalance' =>( $bank->currentbalance - $data->amount  )  ]);

			
			
			
		}
		
		
				if($data->type == 1)
		{
			$bank = Bankname::findOrFail($data->Bankname_id);
			
			Bankname::where('id',$data->Bankname_id)
 ->update(['currentbalance' =>( $bank->currentbalance + $data->amount  )  ]);

			
			
			
		}
		
		
		
		if ($data->whom == 1)
		{
		
	$productorder= productorder::find($data->productorder_id);


	$customer = Customer::findOrFail($data->customer_id);		
if ($productorder)
{
$productorder->delete();	
}
	
if($data->type == 0)
{

$presentdue = $data->amount + $customer->presentduebalance;	
Customer::where('id', $data->customer_id )
       ->update([
           'presentduebalance' => $presentdue
        ]);

}
	
	if($data->type == 1)
{

$presentdue =   $customer->presentduebalance - $data->amount ;	
Customer::where('id', $data->customer_id )
       ->update([
           'presentduebalance' => $presentdue
        ]);

}
			
		}
		





		if ($data->whom == 2)
		{
		
	$productcompanyorder= productcompanyorder::find($data->productcompanyorder_id);
	$Productcompany = Productcompany::findOrFail($data->productcompany_id);		
if ($productcompanyorder)
{
$productcompanyorder->delete();	
}
	
if($data->type == 0)
{

$presentdue =   $Productcompany->due - $data->amount;	
Productcompany::where('id', $data->productcompany_id )
       ->update([
           'due' => $presentdue
        ]);

}
	
	if($data->type == 1)
{

$presentdue =   $Productcompany->due + $data->amount;	
Productcompany::where('id', $data->productcompany_id )
       ->update([
           'due' => $presentdue
        ]);

}
			
		}






		if ($data->whom == 3 )
		{   
		
		
		
		$partner = sharepartner::findOrFail($data->sharepartner_id); 
	 $Taka_uttolon_transition= 	Taka_uttolon_transition::find($data->Taka_uttolon_transition_id);
	 
if ($Taka_uttolon_transition)
{
$Taka_uttolon_transition->delete();	
}
	
if($data->type == 0)
{	

$joma =   $partner->joma - $data->amount;	
sharepartner::where('id', $data->sharepartner_id )
       ->update([
           'joma' => $joma
        ]);

}
	
	if($data->type == 1)
{

$uttholon =   $partner->uttholon - $data->amount;	
sharepartner::where('id', $data->sharepartner_id )
       ->update([
           'uttholon' => $uttholon
        ]);
}
			
		}



		if ($data->whom == 0 )
		{
		
	$balance = balance_of_business::findOrFail(1);
	if($data->type == 1)
	{
   balance_of_business::where('id', 1)
  ->update(['balance' =>(   $balance->balance - $data->amount )  ]);	
  
  cashtransition::where('bankchalan_id', $id )->delete(); 
  
	}
	if($data->type == 0)
	{
   balance_of_business::where('id', 1)
  ->update(['balance' =>(   $balance->balance + $data->amount )  ]);	
  
    cashtransition::where('bankchalan_id', $id )->delete(); 
  
	}
			
		}







$data->delete();


return response()->json(['success' => 'Data Deleted successfully. ' ]);	


		
		
    }
}
