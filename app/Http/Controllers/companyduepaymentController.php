<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DataTables;
use Validator;
use App\Models\balance_of_business; 

use App\Models\cashtransition; 

use App\Models\Productcompany;
use App\Models\Product;  
use App\Models\productcompanyorder;
use App\Models\productcompanytransition;
use App\Models\User;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;

$status=0;
class companyduepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	       public function index(Request $request)
    {
     
	 $productcompanyorder=  productcompanyorder::with('productcompanytransition','Productcompany','user')->where('type',2)->OrWhere('type',4)->latest()->get();
	  
	
	  
	        if ($request->ajax()) {
              $productcompanyorder=  productcompanyorder::with('productcompanytransition','Productcompany','user')->where('type',2)->OrWhere('type',4)->latest()->get();
            return Datatables::of($productcompanyorder)
                   ->addIndexColumn()
                    ->addColumn('action', function( productcompanyorder $data){ 
   
  
                          $button = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
   

 
   
                    })  
                              


							  ->addColumn('companyname', function (productcompanyorder $productcompanyorder) {
                    return $productcompanyorder->Productcompany->name;
                })
				
									  ->addColumn('entryby', function (productcompanyorder $productcompanyorder) {
                    return $productcompanyorder->user->name;
                })
					

                 ->editColumn('created', function(productcompanyorder $data) {
					
					 return date('d/m/y h:i A', strtotime($data->created_at) );
                    
                })
				

				

					
					
                    ->rawColumns(['action','created' ])

                    ->make(true);
					
					

        }
      
        return view('companyduepayment.duepayment', compact('productcompanyorder'));   

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



	    public function  dropdownlist()
    {
		
		
	
     			 $shopid = Auth()->user()->balance_of_business_id;
     
	   $productdata = Product::where('balance_of_business_id',$shopid)->where('softdelete', 0)->orderBy('name')->get(); 
	   
	   
	  
		 
		 $Productcompany = Productcompany::where('balance_of_business_id',$shopid)->where('softdelete', 0)->orderBy('name')->get();

			
            return response()->json(['Productcompany' => $Productcompany , 'productdata' => $productdata]);

	   
	   
	   
    } 


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DB::transaction(function () use ($request) {
		
		
  
	$validated = $request->validate([
	
	 	'company_Id',
		'unit_price',
		'quantity',
		'stock',
		'vat',
		'vattk',
		'discount',
		'totaldiscount',
		'amount',
		'adjust',
		'percentofdicountontaotal',
		'grossamount',
		'discountatend',
		'paid',
		'due',
		'totalamount',
'statusvalue',
'medicine_name',
'type',
		
		
    ]);
		

	$company = Productcompany::findOrFail($request->company_Id);	

	 
		if ($request->type == 2)
		{
				
		$s = $company->due -  $request->grossamount;
		
		if ($s  < 0)
		{
			global $status; 
			$status=1;
			goto flag;
		
		
		}
		else{
		//////////////////////////////////////////////////// insert shuru ///////////////////////
		
		
		 $serialno = productcompanyorder::where('productcompany_id',$request->company_Id)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }		
		
		
		
		
		
	$productorder = new productcompanyorder(); 
		$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
	$productorder->productcompany_id  = $request->company_Id;
	$productorder->serialno  = $serial;
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = $request->discountatend; 
	$productorder->amountafterdiscount	  = $request->paid; 
	
	$productorder->balance_of_business_id = Auth()->user()->balance_of_business_id;
	
	$productorder->comment  =$request->comment; 
	$productorder->debit  = 0;
	$productorder->credit  = $request->grossamount;
	$productorder->balance  =   $company->due -  $request->grossamount;
	$productorder->type  = 2;
	
	
		

	
	
	
	$due = $request->due;
	$id= $request->company_Id;
	

	$dueamount = $company->due - $request->grossamount;


//// update company due 
Productcompany::where('id', $request->company_Id )
       ->update([
           'due' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance - $request->paid )  ]);	


	$productorder->save();
	
	
		
	$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->productcompany_id = $request->company_Id;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->productcompanyorder_id = $productorder->id;
$cashtransition->amount = $request->paid;
$cashtransition->withdrwal = $request->paid;	
$cashtransition->type = 2;
$cashtransition->transtype = 10;
$cashtransition->description = "Pay the due to the company: "  .$company->name ;
$cashtransition->save();		
		
		
		
		
		
		
		
		
		
		
		
		
		}
		
		
		
		
		
		}
if ($request->type == 4)
{
 
 
 $t=  $company->due +  $request->paid;

		if ($t  > 0)
		{
			global $status; 
			$status=2;
			goto flag;
		
		
		}
		else{ 
		//////////////////////////////////////////////////// insert shuru ///////////////////////
		
		
		 $serialno = productcompanyorder::where('productcompany_id',$request->company_Id)->orderBy('id', 'desc')->first();

 if ($serialno== '')
 {
	 $serial=1;
 }
 else{
$serial= $serialno->serialno+1;
 }		
		
		
		
		
		
		
		$productorder = new productcompanyorder(); 
		$productorder->user_id  = auth()->user()->id ; //$request->sellerid;
	$productorder->productcompany_id  = $request->company_Id;
	$productorder->serialno  = $serial;
	$productorder->amount  = $request->paid; 
		$productorder->balance_of_business_id = Auth()->user()->balance_of_business_id;
	
	$productorder->comment  =$request->comment; 
	$productorder->debit  = $request->paid;
	$productorder->credit  = 0;
	$productorder->balance  =   $company->due +  $request->paid;
	$productorder->type  = 4;
	
		

	
	
	
	$due = $request->due;
	$id= $request->company_Id;
	

	$dueamount = $company->due +  $request->paid;


//// update company due 
Productcompany::where('id', $request->company_Id )
       ->update([
           'due' => $dueamount
        ]);

/////////// update company balance 
  
			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance + $request->paid )  ]);	


	$productorder->save();
	
	
	
	
	
		$cashtransition = new cashtransition();
$cashtransition->balance_of_business_id = Auth()->user()->balance_of_business_id;
$cashtransition->productcompany_id = $request->company_Id;
$cashtransition->User_id = Auth()->user()->id;
$cashtransition->productcompanyorder_id = $productorder->id;
$cashtransition->amount = $request->paid;
$cashtransition->deposit = $request->paid;	
$cashtransition->type = 1;
$cashtransition->description = "Money Back for producti Return from Company: "  .$company->name  ;

$cashtransition->transtype = 11;

$cashtransition->save();
	
	
	
	
	
	
	
	
	
	
	
	
		}














}	
	



flag:		

});	
global $status;
if ($status == 1)
{
 return response()->json(['success' => 'ভুল হচ্ছে। কোম্পানি কে আপনি আপনার বাকি থেকে বেশি টাকা দিয়ে ফেলেছেন  ']);	
}
elseif ($status == 2)
 
{

return response()->json(['success' => 'ভুল হচ্ছে। কোম্পানি আপনার কাছে বকেয়া টাকা পায়।  ']);	

}	
else{
	
return response()->json(['success' => ' Data Added successfully ']);	
	
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
                 $data = productcompanyorder::with('productcompanytransition','Productcompany','user')->findOrFail($id);

if ($data->type == 2)
{ 
	  $i = $data->productcompany_id;
$presentdue = Productcompany::findOrFail($data->productcompany_id)->due;

 Productcompany::where('id', $i )
  ->update(['due' =>(   $presentdue + $data->amount )  ]);	

/////////// update company balance 
  
  
  			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)

  ->update(['balance' =>(   $balance->balance + $data->amountafterdiscount	 )  ]);	

 cashtransition::where('productcompanyorder_id', $id )->delete();
	$data->delete();			 
	
}



if ($data->type == 4)
{
	  $i = $data->productcompany_id;
$presentdue = Productcompany::findOrFail($data->productcompany_id)->due;

 Productcompany::where('id', $i )
  ->update(['due' =>(   $presentdue - $data->debit )  ]);	

/////////// update company balance 
  
  			 $shopid = Auth()->user()->balance_of_business_id;
  
  $balance =  balance_of_business::findOrFail($shopid);

   balance_of_business::where('id',  $shopid)
  ->update(['balance' =>(   $balance->balance - $data->debit )  ]);	


 cashtransition::where('productcompanyorder_id', $id )->delete();
	$data->delete();			 
	
}







	 
		 

	   
	  return response()->json(['success' => 'Reverse entry added successfully .']);   
    }
}
