<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Models\balance_of_business; 
use App\Models\cashtransition; 

use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use PDF;
class balancesheetforCashtransform extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$balance_of_business = balance_of_business::where('softdelete',0)->get();

        return view('subdealerbalancesheet.subdealerbalancesheet', compact('balance_of_business'));   
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
		'business'=> 'required',
        ]);
		
		
		
		if ($validator->fails()) {
             return redirect()->back();
                       
        }
		
		
		
		
		        $start = date("Y-m-d",strtotime($request->input('startdate')));
        $end = date("Y-m-d",strtotime($request->input('enddate')));
 

        $endcom = date("Y-m-d",strtotime($request->input('enddate')."+1 day"));


 
	  $c = date("Y-m-d",strtotime($request->input('startdate')));
	  
		$datethatsentasenddatefromcust =  date("Y-m-d",strtotime($request->input('enddate')));
		
		
					$data = balance_of_business::findOrFail($request->business);
				$obtillfirstdate= $data->openingbalance;
				
			
		
		$firstdate  = date("Y-m-d",strtotime($data->created_at));
	
	
	
	$lastdatetofindoutopeningbalance =	$start;
	
		if ($firstdate < $start )
		{
		


$firstdate = date_create($firstdate);

$d = date_create($start);

$lastdatetofindoutopeningbalance =		date_sub($d,date_interval_create_from_date_string("1 days"));
		
	
		
		$business =	cashtransition::
		where('balance_of_business_id', $request->business )
				  ->whereBetween('created_at',[$firstdate,$lastdatetofindoutopeningbalance])->orderBy('created_at')->get();


		
		foreach ($business as $o)
		{
		if ($o->type == 1)
{
$obtillfirstdate = $obtillfirstdate+ $o->deposit;

}	

if ($o->type == 2)
{
$obtillfirstdate = $obtillfirstdate- $o->withdrwal;

}


		
		
		
		}
		
		
		
		}

		
	$order=	
	cashtransition::
		where('balance_of_business_id', $request->business )
		// ->whereBetween('created_at',[$start,$endcom])->orderBy('created_at')->get();
	->where('created_at',  '>=',  $start )	->where('created_at',  '<', $endcom )->orderBy('created_at')->get();
		
		
			 $pdf = PDF::loadView('subdealerbalancesheet.voucher', compact('data','c','lastdatetofindoutopeningbalance','end','start','order','obtillfirstdate' ),
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
