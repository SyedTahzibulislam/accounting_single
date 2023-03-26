<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use App\Models\khorocer_khad; 
use App\Models\supplier; 
use App\Models\User; 
use App\Models\khoroch_transition;  
use App\Models\employeesalarytransaction;
use App\Models\employeedetails;
use App\Models\agentdetail;  
use App\Models\surgerytransaction;
use App\Models\surgerylist; 
use App\Models\doctor; 
use App\Models\order;
use App\Models\medicinetransition; 
use App\Models\agenttransaction;
use App\Models\dhar_shod_othoba_advance_er_mal_buje_pawa;
use App\Models\doctorCommissionTransition; 
use App\Models\reporttransaction;  
 use App\Models\reportorder;   
 use App\Models\duetransition;
 use App\Models\cabinelist;
 use App\Models\cabinetransaction; 
 use App\Models\doctorappointmenttransaction;
use DataTables;
use App\Models\medicineCompanyTransition;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
class incomestatemnetController extends Controller
{
    Public function todaystatment()
	{
		//$todays_external_cost = khoroch_transition::whereDate('created_at', Carbon::today())->get();
		 
	
				
				
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', \DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', \DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', \DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id',\DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
				
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', \DB::raw( 'SUM(amount) as total_deya_commission'  ))

				
				->where(function ($query) {
    $query->where('transitiontype', 1)
        ->orWhere('transitiontype', 3)
		->orWhere('transitiontype', 4)
		->orWhere('transitiontype', 5)
		->orWhere('transitiontype', 6)
		->orWhere('transitiontype', 7);
})

				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', \DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('doctor_id')
                
                ->get();
				
				
				
				$medicineCompanyTransition = medicineCompanyTransition::with('medicine')
                ->select( 'medicine_id', \DB::raw( 'SUM(pay_in_cash) as pay_in_cash , SUM(Quantity) as Quantity, SUM(amount) as amount, SUM(due) as due'  ))
				->where('transitiontype', 1)
			     ->whereDate('created_at', Carbon::today())
                ->groupBy('medicine_id')
                
                ->get();




				

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', \DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::today())
                
				->groupBy('reportlist_id')
                
                ->get();	



                  $medicinetransition = medicinetransition::with('order')
                ->select( 'medicine_id', \DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(unit) as quantity ,   SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::today())
                
				->groupBy('medicine_id')
                
                ->get();
				
				

                  $surgerytransaction = surgerytransaction::with( 'surgerylist')
                ->select( 'surgerylist_id', \DB::raw('count(*) as total') , \DB::raw( 'SUM(total_cost_after_initial_vat_and_discount) as amount ,     SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::today())
                
				->groupBy( 'surgerylist_id')
                
                ->get();				
				
                 /* $cabinetransaction = cabinetransaction::with('cabinelist')
                ->select( 'cabinelist_id',  \DB::raw("DATE_FORMAT(ending, '%d-%m-%Y') as day"),      \DB::raw('count(*) as total') , \DB::raw( 'SUM(total_after_adjustment) as amount ,     SUM(discount) as discount'  ))
			     
				->whereDate('ending', Carbon::today())
                
				
                
				->groupBy('ending','cabinelist_id')
				
                ->get();								
*/


                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', \DB::raw( 'SUM(amount) as amount_of_due_paid , SUM(discountondue) as duediscount'  ))
			     
				->whereDate('created_at', Carbon::today())
                
				->groupBy('patient_id')
                
                ->get();
				


                  $income_from_doctor =doctorappointmenttransaction::whereDate('created_at', Carbon::today())->sum('nogod');


				
		 		// $total_due_cabine = cabinetransaction::whereDate('ending', Carbon::today())->sum('due');
		 $total_due_patho = reportorder::whereDate('created_at', Carbon::today())->sum('due');
		 $total_due_medicine = order::whereDate('created_at', Carbon::today())->sum('due');
		  $total_due_surgery = surgerytransaction::whereDate('created_at', Carbon::today())->sum('due');
		  $doctorcalldue = doctorappointmenttransaction::whereDate('created_at', Carbon::today())->sum('due');
		 return view ('incomestatement.incomestatementtoday')
		 ->with(compact('externalcost','medicineCompanyTransition','income_from_doctor','doctorcalldue','total_due_surgery','medicinetransition','surgerytransaction','total_due_medicine','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		 
	
	}

//////////////////////////////////////////////////////// yesterday

 	   Public function yesterdaystatment()
	{
		//$todays_external_cost = khoroch_transition::whereDate('created_at', Carbon::today())->get();yesterday()
		 
	
				
				
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', \DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', \DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', \DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id',\DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
				
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', \DB::raw( 'SUM(amount) as total_deya_commission'  ))

				
				->where(function ($query) {
    $query->where('transitiontype', 1)
        ->orWhere('transitiontype', 3)
		->orWhere('transitiontype', 4)
		->orWhere('transitiontype', 5)
		->orWhere('transitiontype', 6)
		->orWhere('transitiontype', 7);
})

				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', \DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
				->where('paidorunpaid', 1 )
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('doctor_id')
                
                ->get();
				
				
				
				$medicineCompanyTransition = medicineCompanyTransition::with('medicine')
                ->select( 'medicine_id', \DB::raw( 'SUM(pay_in_cash) as pay_in_cash , SUM(Quantity) as Quantity, SUM(amount) as amount, SUM(due) as due'  ))
				->where('transitiontype', 1)
			     ->whereDate('created_at', Carbon::yesterday())
                ->groupBy('medicine_id')
                
                ->get();




				

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', \DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::yesterday())
                
				->groupBy('reportlist_id')
                
                ->get();	



                  $medicinetransition = medicinetransition::with('order')
                ->select( 'medicine_id', \DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(unit) as quantity ,   SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::yesterday())
                
				->groupBy('medicine_id')
                
                ->get();
				
				

                  $surgerytransaction = surgerytransaction::with( 'surgerylist')
                ->select( 'surgerylist_id', \DB::raw('count(*) as total') , \DB::raw( 'SUM(total_cost_after_initial_vat_and_discount) as amount ,     SUM(totaldiscount) as discount'  ))
			     
				->whereDate('created_at', Carbon::yesterday())
                
				->groupBy( 'surgerylist_id')
                
                ->get();				
				
                 /* $cabinetransaction = cabinetransaction::with('cabinelist')
                ->select( 'cabinelist_id',  \DB::raw("DATE_FORMAT(ending, '%d-%m-%Y') as day"),      \DB::raw('count(*) as total') , \DB::raw( 'SUM(total_after_adjustment) as amount ,     SUM(discount) as discount'  ))
			     
				->whereDate('ending', Carbon::today())
                
				
                
				->groupBy('ending','cabinelist_id')
				
                ->get();								
*/


                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', \DB::raw( 'SUM(amount) as amount_of_due_paid , SUM(discountondue) as duediscount'  ))
			     
				->whereDate('created_at', Carbon::yesterday())
                
				->groupBy('patient_id')
                
                ->get();
				


                  $income_from_doctor =doctorappointmenttransaction::whereDate('created_at', Carbon::yesterday())->sum('nogod');


				
		 		// $total_due_cabine = cabinetransaction::whereDate('ending', Carbon::today())->sum('due');
		 $total_due_patho = reportorder::whereDate('created_at', Carbon::yesterday())->sum('due');
		 $total_due_medicine = order::whereDate('created_at', Carbon::yesterday())->sum('due');
		  $total_due_surgery = surgerytransaction::whereDate('created_at', Carbon::yesterday())->sum('due');
		  $doctorcalldue = doctorappointmenttransaction::whereDate('created_at', Carbon::yesterday())->sum('due');
		 return view ('incomestatement.yesterday')
		 ->with(compact('externalcost','medicineCompanyTransition','income_from_doctor','doctorcalldue','total_due_surgery','medicinetransition','surgerytransaction','total_due_medicine','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		 
	
	}
	


/////////////////////////////////////////////////////////////// month 
    Public function thismonthstatment()
	{
		//$todays_external_cost = khoroch_transition::whereDate('created_at', Carbon::today())->get();
		 
	
				
				
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			    ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			     ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
			     ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id', DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
			    ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as total_deya_commission'  ))
				->where('transitiontype', 1)
			    ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
			     ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('doctor_id')
                
                ->get();	

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				 ->whereMonth('created_at', Carbon::now()->month)
                
				->groupBy('reportlist_id')
                
                ->get();	





                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', DB::raw( 'SUM(amount) as amount_of_due_paid '  ))
			     
				 ->whereMonth('created_at', Carbon::now()->month)
                
				->groupBy('patient_id')
                
                ->get();	

				
		 
		 $total_due_patho = reportorder::whereMonth('created_at', Carbon::now()->month)->sum('due');
		
		 
		 return view ('incomestatement.month')
		 ->with(compact('externalcost','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		 
	
	}
	
	
	
	




/////////////////////////////////////////////// year 	
	
	
	
	
	    Public function thisyearstatment()
	{
		//$todays_external_cost = khoroch_transition::whereDate('created_at', Carbon::today())->get();
		 
	
				
				
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			     ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			    ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
			      ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id', DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
			    ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as total_deya_commission'  ))
				->where('transitiontype', 1)
			    ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
			     ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('doctor_id')
                
                ->get();	

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				  ->whereYear('created_at', Carbon::now()->year)
                
				->groupBy('reportlist_id')
                
                ->get();	





                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', DB::raw( 'SUM(amount) as amount_of_due_paid '  ))
			     
               ->whereYear('created_at', Carbon::now()->year)
                
				->groupBy('patient_id')
                
                ->get();	

				
		 
		 $total_due_patho = reportorder::whereYear('created_at', Carbon::now()->year)->sum('due');
		
		 
		 return view ('incomestatement.year')
		 ->with(compact('externalcost','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		 
	
	}
	
	
	
	
	
	
	
	
	
	/////////////////////////////////////////////// Lastmonth 	
	
	   Public function lastmonthstatment()
	{
		//$todays_external_cost = khoroch_transition::whereDate('created_at', Carbon::today())->get();
		 
	
				
				
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			     ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
			     ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id', DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
			    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as total_deya_commission'  ))
				->where('transitiontype', 1)
			    ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
			     ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->groupBy('doctor_id')
                
                ->get();	

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				 ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                
				->groupBy('reportlist_id')
                
                ->get();	





                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', DB::raw( 'SUM(amount) as amount_of_due_paid '  ))
			     
				 ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                
				->groupBy('patient_id')
                
                ->get();	

				
		 
		 $total_due_patho = reportorder::whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('due');
		
		 
		 return view ('incomestatement.lastmonth')
		 ->with(compact('externalcost','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		 
	
	}
	
	
	
	
	
	
	
	
	
	////////////////////////////////// fetch data  between two dates 
	
	
	
	public function recordbetweentwodate(Request $request){
		

		
		

        $validator = Validator::make($request->all(), [
            'startdate' => 'required|date|size:10',
        'enddate' => 'date|size:10',
        ]);
		
		
		
		if ($validator->fails()) {
            return redirect('picktwodate')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		        $start = date("Y-m-d",strtotime($request->input('startdate')));
        $end = date("Y-m-d",strtotime($request->input('enddate')."+1 day"));
      
		$datethatsentasenddatefromcust =  date("Y-m-d",strtotime($request->input('enddate')));
		
			
			    $externalcost = khoroch_transition::with('khorocer_khad')
                ->select( 'khorocer_khad_id', DB::raw( 'SUM(amount) as total_amount ,   SUM(due) as total_due , SUM(advance) as total_advance , SUM(unit) as total_unit'  ))
			    ->whereBetween('created_at',[$start,$end])
                ->groupBy('khorocer_khad_id')
                
                ->get();				
				
				
				
				
			    $employee_salary = employeesalarytransaction::with('employeedetails')
                ->select( 'employeedetails_id', DB::raw( 'SUM(totalsalary) as total_given_salary_of_a_employee'  ))
			     ->whereBetween('created_at',[$start,$end])
                ->groupBy('employeedetails_id')
                
                ->get();
		 
		 
		 

			    $agent_commision = agenttransaction::with('agentdetail')
                ->select( 'agentdetail_id', DB::raw( 'SUM(paidamount) as total_given_paidamount_of_a_agents'  ))
			     ->whereBetween('created_at',[$start,$end])
                ->groupBy('agentdetail_id')
                
                ->get();		 
				
				
			    $dharshod = dhar_shod_othoba_advance_er_mal_buje_pawa::with('supplier')
                ->select( 'supplier_id', DB::raw( 'SUM(amount) as total_baki_shod'  ))
				->where('transitiontype', 1)
			    ->whereBetween('created_at',[$start,$end])
                ->groupBy('supplier_id')
                
                ->get();	
				
				
			    $doctorcommission = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as total_deya_commission'  ))
				->where('transitiontype', 1)
			    ->whereBetween('created_at',[$start,$end])
                ->groupBy('doctor_id')
                
                ->get();	

                $doctor_er_sharer_taka = doctorCommissionTransition::with('doctor')
                ->select( 'doctor_id', DB::raw( 'SUM(amount) as deya_share'  ))
				->where('transitiontype', 2)
			     ->whereBetween('created_at',[$start,$end])
                ->groupBy('doctor_id')
                
                ->get();	

////////////////////// expenditure

                  $income_from_pathology_test = reporttransaction::with('reportlist')
                ->select( 'reportlist_id', DB::raw( 'SUM(adjust) as amount , SUM(totalvat) as vat , SUM(totaldiscount) as discount'  ))
			     
				 ->whereBetween('created_at',[$start,$end])
                
				->groupBy('reportlist_id')
                
                ->get();	





                  $income_from_due_payment = duetransition::with('patient')
                ->select( 'patient_id', DB::raw( 'SUM(amount) as amount_of_due_paid '  ))
			     
				 ->whereBetween('created_at',[$start,$end])
                
				->groupBy('patient_id')
                
                ->get();	

				
		 
		 $total_due_patho = reportorder::whereBetween('created_at',[$start,$end])->sum('due');
		
		 
		 return view ('incomestatement.databetweentwodata')
		 ->with(compact('externalcost','start','datethatsentasenddatefromcust','income_from_due_payment','total_due_patho','doctorcommission', 'doctor_er_sharer_taka', 'employee_salary','agent_commision', 'dharshod', 'income_from_pathology_test'));
		 
		
	

	}
	



}






/*
incomestatementthismonth
   ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)

'created_at', '=', Carbon::now()->subMonth()->month // last month




*/