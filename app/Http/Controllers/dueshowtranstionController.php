<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\patient;
use App\Models\duetransition;
class dueshowtranstionController extends Controller
{
    public function showduecustomerpage()
	{	
	$patient = patient::where('softdelete', '0')->latest()->get();	
	
	 return view('showdueofpatient.patientlist', compact('patient'));  
		
	} 
	
	
	    public function showduetransition( Request $request )
	{	
	
	$duetransition = duetransition::where( 'patient_id', $request->patient)->get();	

	
	return view('showdueofpatient.duetable', compact('duetransition'));  
	  
		
	} 
	
	
	
	
	
}
