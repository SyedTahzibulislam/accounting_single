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

use App\Models\productpriceaccunit;


use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;
use App\Models\unitcoversion;
class returnproductfromcustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 	       public function index(Request $request)
    {
      $productorder=  productorder::with('producttransition','Customer','user')->where('type',3)->latest()->get();
	  
	
	  
	        if ($request->ajax()) {
                $productorder=  productorder::with('producttransition','Customer','user')->where('type',3)->latest()->get();
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
					

                 ->editColumn('created', function(productorder $data) {
					
					 return date('d/m/y h:i A', strtotime($data->created_at) );
                    
                })
				
             ->editColumn('pdf', function ($productorder) {
                return '<a   target="_blank"      href="'.route('returnproduct.pdf', $productorder->id).'">Print</a>';
            })
				

					
					
                    ->rawColumns(['action','pdf','created' ])

                    ->make(true);
					
					

        }
      
        return view('returnproducttransition.returnproducttransition', compact('productorder'));   

    }







	    public function  dropdownlist()
    {
		
		
				 $shopid = Auth()->user()->balance_of_business_id;
     
      // $patientdata = patient::where('booking_status', 0)->orWhere('booking_status', 1)->get(); 
	   $productdata = Product::where('balance_of_business_id',$shopid)->where('softdelete', 0)->orderBy('name')->get(); 
	   
	   
	  
		 
		 $customer = Customer::where('balance_of_business_id',$shopid)->where('softdelete', 0)->orderBy('name')->get();
$unit = unitcoversion::where('softdelete', 0)->orderBy('name')->get();
			
            return response()->json(['customer' => $customer , 'unit'=>$unit, 'productdata' => $productdata]);

	   
	   
	   
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
		
			
	DB::transaction(function () use ($request) {
		
		
  
	$validated = $request->validate([
	
	 	'customer_id',
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
'unit',
		
		
    ]);
		

	$customer = customer::findOrFail($request->customer_id);	
	
	
		

		

		
		//////////////////////////////////////////////////// insert shuru ///////////////////////
		
	
///// transition serial 	
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
	$productorder->balance_of_business_id  = auth()->user()->balance_of_business_id ;
	$productorder->amount  = $request->grossamount; 
	$productorder->discount  = 0;
	$productorder->amountafterdiscount	  = $request->grossamount; ;
	$productorder->comment  =$request->comment; 
	$productorder->debit  = 0;
	$productorder->credit  = $request->grossamount;
	$productorder->balance  =   $customer->presentduebalance - $request->grossamount;
	$productorder->	type  = 3;
	
		

	
	
	
	$due = $request->due;
	$id= $request->customer_id;
	

	$dueamount = $customer->presentduebalance - $request->grossamount;


//// update patient due 
customer::where('id', $request->customer_id )
       ->update([
           'presentduebalance' => $dueamount
        ]);


	$productorder->save();
	
	


	
		

	
	
	
	
	
	
	
	

    $order_id = $productorder->id;

    for ($product_id = 0; $product_id < count($request->medicine_name); $product_id++ ) 

	{

		
		
		
		       
		
		
		
       $producttransition = new producttransition; 
	   $producttransition->	productorder_id = $order_id;
	    $producttransition->customer_id = $request->customer_id;
	 $producttransition->user_id =  auth()->user()->id ;
 $producttransition->balance_of_business_id  = auth()->user()->balance_of_business_id ;
	 
	   $producttransition->product_id = $request->medicine_name[$product_id]; // asole medicine_name[] er vetore id neya hoyeche. form bananor somoy name lekha hoyechecilo pore ar change kora hoy nai 
	    
  $producttransition->unirprice =  $request->unit_price[$product_id]; 
		$producttransition->quantity = $request->quantity[$product_id];
		
		
 $unitconverter= unitcoversion::findOrFail($request->unit[$product_id])->coversionamount;
  
  $quantity = $unitconverter * $request->quantity[$product_id];		
		
		// product::where('id',$request->medicine_name[$product_id] )->increment('stock', $quantity );
		
		
	$p =    productpriceaccunit::where('unitcoversion_id',  $request->unit[$product_id])->where('product_id',  $request->medicine_name[$product_id] )->first() ;

 $unitconverter= unitcoversion::findOrFail($p->unitcoversion_id)->coversionamount;
  

   productpriceaccunit::where('unitcoversion_id',  $request->unit[$product_id])->where('product_id',  $request->medicine_name[$product_id] )
  ->update(['stock' =>(   $p->stock + $request->quantity[$product_id] )  ]);	
	
		
		
		
		
		
		
		
		
		
		
		
		

		$unitname=unitcoversion::findOrFail($request->unit[$product_id])->name; 
		  $producttransition->unitname =  $unitname;
	 
 $producttransition->sellingunit = $request->unit[$product_id];	
	 $producttransition->unitcoversion_id = $request->unit[$product_id];
		 
		 $qun= $request->quantity[$product_id];
		 
$producttransition->type  = 3;
$producttransition->discountpercentage = 0;	
				 
		 $producttransition->discountpercentage = 0;
		 $producttransition->discount	 = 0;
		 $producttransition->amount = $request->adjust[$product_id];
		  $producttransition->finalamountafterdiscount	 = $request->adjust[$product_id];
			  $producttransition->quantityinbase = $request->quantity[$product_id] ;
		 

		  $producttransition->save(); 
		 
	


	}		
		
				
		

});	
     



return response()->json(['success' => 'Return entry Added successfully.']);




    }




	public function printvoucher($id)
{
	$order= productorder::findOrFail($id);
	
	
	$data= customer::findOrFail($order->customer_id);
	
	
	
	

	 $pdf = PDF::loadView('returnproducttransition.voucher', compact('data','order' ),
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
        //
    }
}
