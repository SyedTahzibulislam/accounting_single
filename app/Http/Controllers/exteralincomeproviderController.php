<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\externalincomeprovider; 

use DataTables;
use Validator;




class exteralincomeproviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
    {
		
			   $shopid = Auth()->user()->balance_of_business_id;
      $externalincomeprovider =  externalincomeprovider::where('balance_of_business_id',  $shopid  )->where('softdelete', 0)->latest()->get();
	  
	
	  
	        if ($request->ajax()) {
            $externalincomeprovider =  externalincomeprovider::where('balance_of_business_id',  $shopid  )->where('softdelete', 0)->latest()->get();
            return Datatables::of($externalincomeprovider)
                   ->addIndexColumn()
                    ->addColumn('action', function( externalincomeprovider $data){ 
   
                          $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                         $button .= '&nbsp;&nbsp;';
						 
						
						
						return $button;
                    })  
	
				

					
					
                    ->rawColumns(['action'])
                    ->make(true);
					
					

        }
      
        return view('externalincomeprovider.externalincomeprovider', compact('externalincomeprovider'));   

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
            'name'    =>  'required',
            'address'     =>  'required',
            'mobile'         =>  'required',
						
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       

        $form_data = array(
            'name'        =>  $request->name,
            'mobile'         =>  $request->mobile,
           'address' =>$request->address,
		 'balance_of_business_id' => Auth()->user()->balance_of_business_id, 
		 'ownererkachebaki' => $request->due,
        );

        externalincomeprovider::create($form_data);

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
            $data = externalincomeprovider::findOrFail($id);
            return response()->json(['data' => $data]);
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
                'name'    =>  'required',
                'mobile'     =>  'required',
				'address' => 'required',

            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
       

        $form_data = array(
            'name'       =>   $request->name,
            'mobile'        =>   $request->mobile,
            'address'            =>   $request->address,
			'ownererkachebaki' => $request->due,
			
        );
        externalincomeprovider::whereId($request->hidden_id)->update($form_data);

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
             	                 externalincomeprovider::whereId($id)
  ->update(['softdelete' => '1']);  //softdelete 
    }
}
