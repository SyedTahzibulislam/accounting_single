<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use Validator;
use App\Models\balance_of_business; 
use App\Models\cashtransition; 


use App\Models\Customer;
use App\Models\Product;  
use App\Models\productorder;
use App\Models\producttransition;
use App\Models\User;


use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;

$jsonmessage=0;
$status=0;

class customerduetransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	       public function index(Request $request)
    {
      $productorder=  productorder::with('producttransition','Customer','user')->where('type',2)->OrWhere('type',4)->latest()->get();
	  
	
	  
	        if ($request->ajax()) { 
            

			$productorder=  productorder::with('producttransition','Customer','user')->where('type',2)->OrWhere('type',4)->latest()->get();
            return Datatables::of($productorder)
                   ->addIndexColumn()
                    ->addColumn('action', function( productorder $data){ 
   
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })  
                              


							  ->addColumn('customername', function (productorder $productorder) {
                    return $productorder->customer->name;
                })
				
									  ->addColumn('entryby', function (productorder $productorder) {
                    return $productorder->user->name;
                })
					
					->addColumn('type', function (productorder $productorder) {
                    if ($productorder->type == 2)
					{
						return "Payment ";
					}
					if ($productorder->type == 4)
					{
						return "Money back, sell return ";
					}
                })	
					

                 ->editColumn('created', function(productorder $data) {
					
					 return date('d/m/y h:i A', strtotime($data->created_at) );
                    
                })
				
             ->editColumn('pdf', function ($productorder) {
                return '<a   target="_blank"      href="'.route('customerduetransition.pdf', $productorder->id).'">Print</a>';
            })
				

					
					
                    ->rawColumns(['action','pdf','created' ])

                    ->make(true);
					
					

        } 
      
        return view('duetransition.duepayment', compact('productorder'));   

    }






	    public function  dropdownlist()
    {
		
		
	$shopid = Auth()->user()->balance_of_business_id;
     
      // $patientdata = patient::where('booking_status', 0)->orWhere('booking_status', 1)->get(); 
	   $productdata = Product::where('balance_of_business_id',$shopid )->where('softdelete', 0)->orderBy('name')->get(); 
	   
	   
	  
		 
		 $customer = Customer::where('balance_of_business_id',$shopid )->where('softdelete', 0)->orderBy('name')->get();

			
            return response()->json(['customer' => $customer , 'productdata' => $productdata]);

	   
	   
	   
    } 



	public function printvoucher($id)
{
	$order= productorder::findOrFail($id);
	
	
	$data= customer::findOrFail($order->customer_id);
	
	
	
	
	
	//	$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('medicinetransition.medicinebill', compact('data','order' ))->setPaper('a4', 'landscape')->setWarnings(false)->save('invoice.pdf');
   // return $pdf->stream('invoice.pdf');
	
	
	
	
	
	 $pdf = PDF::loadView('duetransition.voucher', compact('data','order' ),
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
	
	 	'customer_id',
		
		'percentofdicountontaotal',
		'grossamount',
		'discountatend',
		
		'totalamount',

'type',
		
		
    ]);
	$customer = customer::findOrFail($request->customer_id);
	
	$balance =  balance_of_business::first();
	
	
	if($request->type == 4) // check korche je pawna theke beshi taka decche kina 
	{
		$i = $customer->presentduebalance + $request->grossamount;
	
	if ( $i > 0  )	
	{
global $status;
$status=1;
	
goto flag;
	}

if ( $request->grossamount > $balance->balance   )	
	
	{
return response()->json(['success' => ' আপনার ব্যালেন্সে যথেষ্ট টাকা নাই ।  ']);	
	}	
	
	
	}
	
// check shesh holo 	
		

	





	
		
				 $serialno = productorder::where('customer_id',$request->customer_id)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }
    
			$productorder = new productorder; 
		$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
	$productorder->customer_id  = $request->customer_id;
	$productorder->serialno  = $serial;
		$productorder->balance_of_business_id  = Auth()->user()->balance_of_business_id;
	

	
	
	if ($request->type == 2)
		
	{
		
		
			$productorder->debit  = 0;
		$productorder->credit  = $request->grossamount;
		$productorder->comment  = " Payment";
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = $request->discountatend;
	$productorder->amountafterdiscount	  = $request->totalamount;
	$productorder->	type  = 2;
	
	
	$productorder->balance  =   $customer->presentduebalance - $request->grossamount; 
	
	
	}


	if ($request->type == 4)
	{
			$productorder->debit  = $request->totalamount;
		$productorder->credit  = 0;
		$productorder->comment  = "Money back sell return ";
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = $request->discountatend;
	$productorder->amountafterdiscount	  = $request->grossamount;
	
	
	
	$productorder->	type  = 4;
	
	
	$productorder->balance  =   $customer->presentduebalance + $request->grossamount; 
	
	
	}

	
	
	
	
	$id= $request->customer_id;
	



	if ($request->type == 2)
		
	{
			$dueamount = $customer->presentduebalance - $request->grossamount;
//// update patient due 
customer::where('id', $request->customer_id )
       ->update([
           'presentduebalance' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>( $request->totalamount + $balance->balance)  ]);	
  

  
  
  
	}
	
	
	if ($request->type == 4)
		
	{
			$dueamount = $customer->presentduebalance + $request->grossamount;
//// update patient due 
customer::where('id', $request->customer_id )
       ->update([
           'presentduebalance' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance - $request->totalamount)  ]);	
	}

	

	$productorder->save();
	
	
	
	
	
	
	
		if ($request->type == 2)
		
	{
	
		$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->customer_id = $request->customer_id;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->productorder_id = $productorder->id;
$cashtransition->amount = $request->totalamount;
$cashtransition->deposit = $request->totalamount;	

$cashtransition->transtype = 8;

$cashtransition->description = "Due Payment by Customer:"  .$customer->name ;

$cashtransition->type = 1;
$cashtransition->save(); 
	
	}	
	
	
		if ($request->type == 4)
		
	{
	
		$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->customer_id = $request->customer_id;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->productorder_id = $productorder->id;
$cashtransition->amount = $request->totalamount;
$cashtransition->withdrwal = $request->totalamount;	
$cashtransition->type = 2;

$cashtransition->transtype = 8;

$cashtransition->description = "Money Back to the Customer:"  .$customer->name ;



$cashtransition->save(); 
	
	}		
	
	
	
	
	
	
	
	
	
	
	flag:
	global $status;
	if($status==1)
	{
	return response()->json(['success' => 'ট্রাঞ্জিশন সম্ভব না। কারণ আপনি কাস্টমার কে তার পাওনার চেয়ে বেশি দিয়ে ফেলেছেন। ']);		
	}
	if( $status == 2)
	{
	return response()->json(['success' => ' কোথাও ভুল হচ্ছে। কাস্টমার থেকে তার বাকি থেকে বেশি টাকা নেয়া হচ্ছে। পুণরায় ইনপুট দেন।  ']);	
	}
	else
	{
 return response()->json(['success' => 'Data Added successfully. ' .$status]);	
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
                    $data = productorder::findOrFail($id);
$customer = customer::findOrFail($data->customer_id) ;
	

if ($data->type == 2)
{
	$dueamount = $customer->presentduebalance + $data->amount;
//// update  due 
customer::where('id', $data->customer_id )
       ->update([
           'presentduebalance' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(  $balance->balance - $data->amountafterdiscount   )  ]);	


	


 
}





	if ($data->type == 4)
	{
		
		
				$dueamount = $customer->presentduebalance - $data->amount;
//// update patient due 
customer::where('id', $data->customer_id )
       ->update([
           'presentduebalance' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance + $data->amount)  ]);



	
	
	
	}

cashtransition::where('productorder_id', $id )->delete();

$data->delete();






    }
}
