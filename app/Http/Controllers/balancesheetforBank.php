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

use App\Models\Bankchalan;
use App\Models\Productcompany;
use App\Models\productcompanyorder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;

class balancesheetforBank extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$Bankname = Bankname::where('softdelete',0)->get();

        return view('bankbalancesheet.bankbalancesheet', compact('Bankname'));   
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
		
	
 $validator = Validator::make($request->all(), [
            'startdate' => 'required|date|size:10',
        'enddate' => 'date|size:10',
		'bankid'=> 'required',
        ]);
		
		
		
		if ($validator->fails()) {
             return redirect()->back();
                       
        }
		
		
		
		
		        $start = date("Y-m-d",strtotime($request->input('startdate')));
        $end = date("Y-m-d",strtotime($request->input('enddate')));
      
	  $c = date("Y-m-d",strtotime($request->input('startdate')));
	  
		$datethatsentasenddatefromcust =  date("Y-m-d",strtotime($request->input('enddate')));
		
		
					$data = Bankname::findOrFail($request->bankid);
				$obtillfirstdate= $data->openingbalance;
				
		
		
		$firstdate  = date("Y-m-d",strtotime($data->created_at));
	
	
	
	$lastdatetofindoutopeningbalance =	$start;
	
		if ($firstdate < $start )
		{
		


$firstdate = date_create($firstdate);

$d = date_create($start);

$lastdatetofindoutopeningbalance =		date_sub($d,date_interval_create_from_date_string("1 days"));
		
	
		
		$bankchalan =	Bankchalan::with('Bankname','Productcompany','Customer','user')
		->where('Bankname_id', $request->bankid )
				  ->whereBetween('transdate',[$firstdate,$lastdatetofindoutopeningbalance])->orderBy('transdate')->get();


		
		foreach ($bankchalan as $o)
		{
		if ($o->type == 0)
{
$obtillfirstdate = $obtillfirstdate+ $o->credit;

}	

if ($o->type == 1)
{
$obtillfirstdate = $obtillfirstdate- $o->debit;

}


		
		
		
		}
		
		
		
		}

		
	$order=	
	Bankchalan::with('Bankname','Productcompany','Customer','user')
		->where('Bankname_id', $request->bankid )	 
		 ->whereBetween('transdate',[$start,$end])->orderBy('transdate')->get();
	
		
		
			 $pdf = PDF::loadView('bankbalancesheet.voucher', compact('data','c','lastdatetofindoutopeningbalance','end','start','order','obtillfirstdate' ),
   [], [
 'mode'                     => '',
	'format'                   => 'A4',
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
