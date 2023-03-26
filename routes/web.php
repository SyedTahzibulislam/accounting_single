<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admincontroller;    
use App\Http\Controllers\UserController;  
use App\Http\Controllers\patientcontroller;            
use App\Http\Controllers\medicine_categorycontroller;
use App\Http\Controllers\medicinecontroller;                    
use App\Http\Controllers\categorylist;     
use App\Http\Controllers\medicinetransactionController; 
use App\Http\Controllers\ReturnmedicinetransactionController; 
use App\Http\Controllers\cabinetransactioncontroller;   
use App\Http\Controllers\employeedetailscontroller;
use App\Http\Controllers\cabinelistController;   
use App\Http\Controllers\employeetransactioncontroller; 
use App\Http\Controllers\reportcontroller;              
use App\Http\Controllers\reporttransactionController;       

use App\Http\Controllers\AccountController;        
use App\Http\Controllers\phermacyController;  
 use App\Http\Controllers\employeerolecangecontroller;      
use App\Http\Controllers\deletedusercontroller;  
use App\Http\Controllers\relesepatient;  
use App\Http\Controllers\doctorcontroller;        
use App\Http\Controllers\doctorappointmenttransactionController;   
use Dompdf\Dompdf; 
use App\Http\Controllers\makepathologyreport;        
use App\Http\Controllers\surgeryaddlistcontroller;    
use App\Http\Controllers\indexController;        
use App\Http\Controllers\surgerytransitionController;  
use App\Http\Controllers\finalreporttransitionController;   
use App\Http\Controllers\Create_khorocer_khad_Controller;                
use App\Http\Controllers\CreaterSupplierController;      
use App\Http\Controllers\KhorochTransitionConTrollerController; 

use App\Http\Controllers\incomestatemnetController;  

use App\Http\Controllers\outdoordoctortranstion;  

use App\Http\Controllers\dhar_shod_advance_get_Controller;
use App\Http\Controllers\DoctorCommissionController; 
use App\Http\Controllers\medicineCompanyController;                                
use App\Http\Controllers\TakaUttolonTransitionController;  
use App\Http\Controllers\CreatePartnerController; 
use App\Http\Controllers\joma_uttolon_report_statement_Controller; 
use App\Http\Controllers\Pathology_test_Component_Controller;  
use App\Http\Controllers\medicine_comapny_transition_Controller; 
use App\Http\Controllers\medicineComapnyrDenaPawnaShodController; 
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\show_booking_patient_and_release; 
use App\Http\Controllers\servicelisthospitalController;  
use App\Http\Controllers\prescriptionController;  
use App\Http\Controllers\servicetranstionController;  
use App\Http\Controllers\dueshowtranstionController;



















use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProductCompanyController;
use App\Http\Controllers\productCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\producttransitionController;
use App\Http\Controllers\customerduetransitionController;
use App\Http\Controllers\balancesheetforCustomer;
use App\Http\Controllers\productcompanytransitionController;
use App\Http\Controllers\companyduepaymentController;
use App\Http\Controllers\returnproductfromcustomerController;
use App\Http\Controllers\compnanybalncecontroller;
use App\Http\Controllers\unitconvertercontroller;
use App\Http\Controllers\BanaknameController;
use App\Http\Controllers\balancesheetforBank;
use App\Http\Controllers\supplierduepaymentController;
use App\Http\Controllers\incomeproviderduetransitionController;


use App\Http\Controllers\incometranstaionController;






use App\Http\Controllers\balanceofbusinessController;


use App\Http\Controllers\balancesheetforCashtransform;


use App\Http\Controllers\expensesController;



 use App\Http\Controllers\agentdetailcontroller;   
use App\Http\Controllers\AgenttransactionControllerController;
use App\Http\Controllers\externalcostcontroller; 
use App\Http\Controllers\exteralincomeproviderController;

use App\Http\Controllers\externalincomesourceController;







use App\Http\Controllers\banktransitionController;
/* medicinecontroller supplierduepayemnt
|--------------------------------------------------------------------------   
| Web Routes khorocer_khad
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These supplier
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [indexController::class, 'index']);





Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([ 'middleware'=>['auth','isdeleteduser','PreventBackHistory']], function(){
        Route::get('deleteduserdashboard',[deletedusercontroller::class,'index'])->name('deleteduser.dashboard');
});


Route::group([ 'middleware'=>['auth','isAdmin','PreventBackHistory']], function(){
	
	
//// poltury	






Route::get('balancesheetforcompany/pdf/{id}', [compnanybalncecontroller::class, 'printvoucher'])->name('balancesheetforcompany.pdf');

Route::resource('balancesheetforcompany',  compnanybalncecontroller::class);
Route::post('balancesheetforcompany/update', [ compnanybalncecontroller::class,'update'])->name('balancesheetforcompany.update');

Route::get('balancesheetforcompany/destroy/{id}', [ compnanybalncecontroller::class,'destroy']);






Route::get('balancesheetforBank/pdf/{id}', [balancesheetforBank::class, 'printvoucher'])->name('balancesheetforBank.pdf');

Route::resource('balancesheetforBank',  balancesheetforBank::class);
Route::post('balancesheetforBank/update', [ balancesheetforBank::class,'update'])->name('balancesheetforBank.update');

Route::get('balancesheetforBank/destroy/{id}', [ balancesheetforBank::class,'destroy']);


// external Income source 

Route::get('externalincomesource/dropdownlistforchild/{id}', [externalincomesourceController::class, 'dropdownlistforchild'])->name('externalincomesource.dropdownlistforchild');

Route::get('externalincomesource/dropdownlist', [externalincomesourceController::class, 'dropdownlist'])->name('externalincomesource.dropdownlist');



Route::resource('externalincomesource',  externalincomesourceController::class);
Route::post('externalincomesource/update', [ externalincomesourceController::class,'update'])->name('externalincomesource.update');

Route::get('externalincomesource/destroy/{id}', [ externalincomesourceController::class,'destroy']);




////////// khorocher khad exteralincomeprovider

Route::get('khorocer_khad/dropdownlistforchild/{id}', [Create_khorocer_khad_Controller::class, 'dropdownlistforchild'])->name('khorocer_khad.dropdownlistforchild');

Route::get('khorocer_khad/dropdownlist', [Create_khorocer_khad_Controller::class, 'dropdownlist'])->name('khorocer_khad.dropdownlist');



Route::resource('khorocer_khad',  Create_khorocer_khad_Controller::class);
Route::post('khorocer_khad/update', [ Create_khorocer_khad_Controller::class,'update'])->name('khorocer_khad.update');

Route::get('khorocer_khad/destroy/{id}', [ Create_khorocer_khad_Controller::class,'destroy']);
















///////////// income transaction   



Route::get('externalincometransition/fourthlevel/{id}', [incometranstaionController::class, 'fourthlevel'])->name('externalincometransition.fourthlevel');


Route::get('externalincometransition/thirdlevel/{id}', [incometranstaionController::class, 'thirdlevel'])->name('externalincometransition.thirdlevel');


Route::get('externalincometransition/secondlevel/{id}', [incometranstaionController::class, 'secondlevel'])->name('externalincometransition.secondlevel');


Route::get('externalincometransition/selectincome', [incometranstaionController::class, 'selectincome'])->name('externalincometransition.selectincome');

Route::post('externalincometransition/fetchkhoroch', [incometranstaionController::class, 'fetchkhoroch'])->name('externalincometransition.fetchkhoroch');



Route::get('externalincometransition/dropdown_list', [incometranstaionController::class, 'dropdown_list'])->name('externalincometransition.dropdown_list');

Route::resource('externalincometransition',  incometranstaionController::class);
Route::post('externalincometransition/update', [ incometranstaionController::class,'update'])->name('externalincometransition.update');

Route::get('externalincometransition/destroy/{id}', [ incometranstaionController::class,'destroy']);













///////////// khoroch transaction   



Route::get('khorochtransition/fourthlevel/{id}', [KhorochTransitionConTrollerController::class, 'fourthlevel'])->name('khorochtransition.fourthlevel');


Route::get('khorochtransition/thirdlevel/{id}', [KhorochTransitionConTrollerController::class, 'thirdlevel'])->name('khorochtransition.thirdlevel');


Route::get('khorochtransition/secondlevel/{id}', [KhorochTransitionConTrollerController::class, 'secondlevel'])->name('khorochtransition.secondlevel');


Route::get('khorochtransition/selectkhoroch', [KhorochTransitionConTrollerController::class, 'selectkhoroch'])->name('khorochtransition.selectkhoroch');

Route::post('khorochtransition/fetchkhoroch', [KhorochTransitionConTrollerController::class, 'fetchkhoroch'])->name('khorochtransition.fetchkhoroch');



Route::get('khorochtransition/dropdown_list', [KhorochTransitionConTrollerController::class, 'dropdown_list'])->name('khorochtransition.dropdown_list');

Route::resource('khorochtransition',  KhorochTransitionConTrollerController::class);
Route::post('khorochtransition/update', [ KhorochTransitionConTrollerController::class,'update'])->name('khorochtransition.update');

Route::get('khorochtransition/destroy/{id}', [ KhorochTransitionConTrollerController::class,'destroy']);














/////////incomprovider 
Route::resource('exteralincomeprovider',  exteralincomeproviderController::class);
Route::post('exteralincomeprovider/update', [ exteralincomeproviderController::class,'update'])->name('exteralincomeprovider.update');

Route::get('exteralincomeprovider/destroy/{id}', [ exteralincomeproviderController::class,'destroy']);







/////////Supplier 
Route::resource('supplier',  CreaterSupplierController::class);
Route::post('supplier/update', [ CreaterSupplierController::class,'update'])->name('supplier.update');

Route::get('supplier/destroy/{id}', [ CreaterSupplierController::class,'destroy']);











Route::get('businessforcashtrasition/pdf/{id}', [balancesheetforCashtransform::class, 'printvoucher'])->name('businessforcashtrasition.pdf');

Route::resource('businessforcashtrasition',  balancesheetforCashtransform::class);
Route::post('businessforcashtrasition/update', [ balancesheetforCashtransform::class,'update'])->name('businessforcashtrasition.update');

Route::get('businessforcashtrasition/destroy/{id}', [ balancesheetforCashtransform::class,'destroy']);




Route::get('business/pdf/{id}', [balanceofbusinessController::class, 'printvoucher'])->name('business.pdf');

Route::resource('business',  balanceofbusinessController::class);
Route::post('business/update', [ balanceofbusinessController::class,'update'])->name('business.update');

Route::get('business/destroy/{id}', [ balanceofbusinessController::class,'destroy']);





Route::get('balancesheetforCustomer/pdf/{id}', [balancesheetforCustomer::class, 'printvoucher'])->name('balancesheetforCustomer.pdf');

Route::resource('balancesheetforCustomer',  balancesheetforCustomer::class);
Route::post('balancesheetforCustomer/update', [ balancesheetforCustomer::class,'update'])->name('balancesheetforCustomer.update');

Route::get('balancesheetforCustomer/destroy/{id}', [ balancesheetforCustomer::class,'destroy']);




Route::resource('unitconversion', unitconvertercontroller::class);
Route::post('unitconversion/update', [unitconvertercontroller::class,'update'])->name('unitconversion.update');

Route::get('unitconversion/destroy/{id}', [unitconvertercontroller::class,'destroy']);
	


Route::get('expenses/dropdownlistforchild/{id}', [expensesController::class, 'dropdownlistforchild'])->name('expenses.dropdownlistforchild');

Route::get('expenses/dropdownlist', [expensesController::class, 'dropdownlist'])->name('expenses.dropdownlist');

Route::resource('expenses', expensesController::class);
Route::post('expenses/update', [expensesController::class,'update'])->name('expenses.update');

Route::get('expenses/destroy/{id}', [expensesController::class,'destroy']);





Route::resource('bank', BanaknameController::class);
Route::post('bank/update', [BanaknameController::class,'update'])->name('bank.update');

Route::get('bank/destroy/{id}', [BanaknameController::class,'destroy']);
	




Route::get('banktransition/dropdownlist', [banktransitionController::class, 'dropdownlist'])->name('banktransition.dropdownlist');
		
Route::get('banktransition/pdf/{id}', [banktransitionController::class, 'printvoucher'])->name('banktransition.pdf');

Route::resource('banktransition',  banktransitionController::class);
Route::post('banktransition/update', [ banktransitionController::class,'update'])->name('banktransition.update');

Route::get('banktransition/destroy/{id}', [ banktransitionController::class,'destroy']);




Route::get('customerduetransition/dropdownlist', [customerduetransitionController::class, 'dropdownlist'])->name('customerduetransition.dropdownlist');
		
Route::get('customerduetransition/pdf/{id}', [customerduetransitionController::class, 'printvoucher'])->name('customerduetransition.pdf');

Route::resource('customerduetransition',  customerduetransitionController::class);
Route::post('customerduetransition/update', [ customerduetransitionController::class,'update'])->name('customerduetransition.update');

Route::get('customerduetransition/destroy/{id}', [ customerduetransitionController::class,'destroy']);




Route::get('productcompanduetra/dropdownlist', [companyduepaymentController::class, 'dropdownlist'])->name('productcompanduetra.dropdownlist');

Route::resource('productcompanduetra',  companyduepaymentController::class);
Route::post('productcompanduetra/update', [ companyduepaymentController::class,'update'])->name('productcompanduetra.update');

Route::get('productcompanduetra/destroy/{id}', [ companyduepaymentController::class,'destroy']);




Route::get('productcompanytrans/purchase', [productcompanytransitionController::class, 'purchase'])->name('productcompanytrans.purchase');


Route::post('productcompanytrans/purchasefetch', [productcompanytransitionController::class, 'purchasefetch'])->name('productcompanytrans.purchasefetch');



Route::get('productcompanytrans/dropdownlist', [productcompanytransitionController::class, 'dropdownlist'])->name('productcompanytrans.dropdownlist');

Route::resource('productcompanytrans',  productcompanytransitionController::class);
Route::post('productcompanytrans/update', [ productcompanytransitionController::class,'update'])->name('productcompanytrans.update');

Route::get('productcompanytrans/destroy/{id}', [ productcompanytransitionController::class,'destroy']);


// return product from customer balancesheetforCustomer


Route::get('returnproduct/dropdownlist', [returnproductfromcustomerController::class, 'dropdownlist'])->name('returnproduct.dropdownlist');

		

Route::get('returnproduct/pdf/{id}', [returnproductfromcustomerController::class, 'printvoucher'])->name('returnproduct.pdf');


Route::resource('returnproduct',  returnproductfromcustomerController::class);
Route::post('returnproduct/update', [ returnproductfromcustomerController::class,'update'])->name('returnproduct.update');

Route::get('returnproduct/destroy/{id}', [ returnproductfromcustomerController::class,'destroy']);













//product transition returnproduct



Route::get('producttransition/convertstock', [producttransitionController::class, 'convertstock'])->name('producttransition.convertstock');

Route::post('producttransition/convertstockfetch', [producttransitionController::class, 'convertstockfetch'])->name('producttransition.convertstockfetch');

Route::post('producttransition/saveconverted', [producttransitionController::class, 'saveconverted'])->name('producttransition.saveconverted');



Route::get('producttransition/saleproduct', [producttransitionController::class, 'producttransfetch'])->name('producttransition.producttransfetch');


Route::post('producttransition/salereportfetch', [producttransitionController::class, 'salereportfetch'])->name('producttransition.salereportfetch');


Route::get('producttransition/dropdowndynamic/{id1}/{id2}', [producttransitionController::class, 'dropdowndynamic'])->name('producttransition.dropdowndynamic');

Route::get('producttransition/fetchunit/{id1}', [producttransitionController::class, 'fetchunit'])->name('producttransition.fetchunit');

Route::get('producttransition/dropdownlist', [producttransitionController::class, 'dropdownlist'])->name('producttransition.dropdownlist');

		

Route::get('producttransition/pdf/{id}', [producttransitionController::class, 'printvoucher'])->name('producttransition.pdf');


Route::resource('producttransition',  producttransitionController::class);
Route::post('producttransition/update', [ producttransitionController::class,'update'])->name('producttransition.update');

Route::get('producttransition/destroy/{id}', [ producttransitionController::class,'destroy']);







Route::get('Productstock', [ProductController::class, 'stock'])->name('Product.stock');




Route::get('Product/editdproduct/{id}', [ProductController::class, 'editdproduct'])->name('Product.editdproduct');


Route::get('dropdownlist', [ProductController::class, 'dropdownlist'])->name('Product.dropdownlist');
		
Route::resource('Product', ProductController::class);
Route::post('Product/update', [ProductController::class,'update'])->name('Product.update');

Route::get('Product/destroy/{id}', [ProductController::class,'destroy']);	


Route::resource('productcaategory', productCategoryController::class);
Route::post('productcaategory/update', [productCategoryController::class,'update'])->name('productcaategory.update');

Route::get('productcaategory/destroy/{id}', [productCategoryController::class,'destroy']);
	


Route::resource('productcompany', ProductCompanyController::class);
Route::post('productcompany/update', [ProductCompanyController::class,'update'])->name('productcompany.update');

Route::get('productcompany/destroy/{id}', [ProductCompanyController::class,'destroy']);

	
	
	
Route::resource('areacode', AreaController::class);
Route::post('areacode/update', [AreaController::class,'update'])->name('areacode.update');

Route::get('areacode/destroy/{id}', [AreaController::class,'destroy']);
	
	
	
	
Route::get('customer/areacode', [CustomerController::class, 'areacode'])->name('customer.areacode');
		
Route::resource('customer', CustomerController::class);
Route::post('customer/update', [CustomerController::class,'update'])->name('customer.update');

Route::get('customer/destroy/{id}', [CustomerController::class,'destroy']);	
	
	
	
// agent details 


Route::resource('agentlist',  agentdetailcontroller::class);
Route::post('agentlist/update', [ agentdetailcontroller::class,'update'])->name('agentlist.update');


Route::get('agentlist/destroy/{id}', [ agentdetailcontroller::class,'destroy']);
	
	




// agent transaction 

// agent transaction 

Route::get('agenttransaction/selectagent', [AgenttransactionControllerController::class, 'selectagent'])->name('agenttransaction.selectagent');

Route::post('agentfetch', [AgenttransactionControllerController::class, 'agentfetch'])->name('agenttransaction.agentfetch');

Route::get('agenttransaction/pdf/{id}', [AgenttransactionControllerController::class, 'printpdf'])->name('agenttransaction.pdf');

 //Route::post('agenttransaction/paid/{id}', [AgenttransactionControllerController::class, 'paid'])->name('agenttransaction.paid');

Route::post('agenttransaction/paid', [AgenttransactionControllerController::class, 'paid'])->name('agenttransaction.paid');

Route::get('agenttransaction/paidsenddata/{id}', [AgenttransactionControllerController::class, 'paidsenddata'])->name('agenttransaction.paidsenddata');


Route::get('agenttransaction/dropdown_list', [AgenttransactionControllerController::class, 'dropdown_list'])->name('agenttransaction.dropdown_list');
Route::resource('agenttransaction',  AgenttransactionControllerController::class);
Route::post('agenttransaction/update', [ AgenttransactionControllerController::class,'update'])->name('agenttransaction.update');















	
	
	
	
	
	
        Route::get('admindashboard',[Admincontroller::class,'index'])->name('admin.dashboard');
   

///  release patiient    productcompanduetra  saleproduct

	Route::get('relesepatient',[relesepatient::class,'index'])->name('relesepatient');
	Route::get('relesepatientdeatilsindividual/{id}',[relesepatient::class,'relesepatientdeatilsindividual'])->name('relesepatientdeatilsindividual');
			
Route::resource('showuserlist', employeerolecangecontroller::class);
Route::post('showuserlist/update', [employeerolecangecontroller::class,'update'])->name('showuserlist.update');

Route::get('showuserlist/destroy/{id}', [employeerolecangecontroller::class,'destroy']);
	
		
		
		
		
		

Route::get('patientlist/pdf/{id}', [patientcontroller::class, 'printpdfforintroductoryslip'])->name('patientlist.pdf');
		
Route::resource('patientlist', patientcontroller::class);
Route::post('patientlist/update', [patientcontroller::class,'update'])->name('patientlist.update');

Route::get('patient/destroy/{id}', [patientcontroller::class,'destroy']);


Route::resource('medicinecategory',  medicine_categorycontroller::class);
Route::post('medicinecategory/update', [ medicine_categorycontroller::class,'update'])->name('medicinecategory.update');

Route::get('medicinecategory/destroy/{id}', [ medicine_categorycontroller::class,'destroy']);




Route::resource('cabinelist',  cabinelistController::class);
Route::post('cabinelist/update', [ cabinelistController::class,'update'])->name('cabinelist.update');

Route::get('cabinelist/destroy/{id}', [cabinelistController::class,'destroy']);


// add medicine  

Route::get('medicine/category_list', [medicinecontroller::class, 'category_list'])->name('medicine.category_list');

Route::resource('medicine',  medicinecontroller::class);
Route::post('medicine/update', [ medicinecontroller::class,'update'])->name('medicine.update');


Route::get('medicine/destroy/{id}', [ medicinecontroller::class,'destroy']);

// add surgery list 



Route::resource('surgerylist',  surgeryaddlistcontroller::class);
Route::post('surgerylist/update', [ surgeryaddlistcontroller::class,'update'])->name('surgerylist.update');


Route::get('surgerylist/destroy/{id}', [ surgeryaddlistcontroller::class,'destroy']);


// Report list 


Route::resource('reportlist',  reportcontroller::class);
Route::post('reportlist/update', [ reportcontroller::class,'update'])->name('reportlist.update');


Route::get('reportlist/destroy/{id}', [ reportcontroller::class,'destroy']);



//////////////// pathology test component list 

Route::get('pathologytestcomponent/mlist', [Pathology_test_Component_Controller::class, 'mlist'])->name('pathologytestcomponent.mlist');

Route::resource('pathologytestcomponent',  Pathology_test_Component_Controller::class);
Route::post('pathologytestcomponent/update', [ Pathology_test_Component_Controller::class,'update'])->name('pathologytestcomponent.update');


Route::get('pathologytestcomponent/destroy/{id}', [ Pathology_test_Component_Controller::class,'destroy']);









// report transaction 

Route::get('reporttransaction/mlist', [reporttransactionController::class, 'mlist'])->name('reporttransaction.mlist');

Route::get('reporttransaction/fetch', [reporttransactionController::class, 'fetch'])->name('reporttransaction.fetch');


Route::resource('reporttransaction',  reporttransactionController::class);
Route::post('reporttransaction/update', [ reporttransactionController::class,'update'])->name('reporttransaction.update');

Route::get('reporttransaction/destroy/{id}', [ reporttransactionController::class,'destroy']);

	// doctor appointment transiction	


Route::get('doctortransition/dropdown_list', [doctorappointmenttransactionController::class, 'dropdown_list'])->name('doctortransition.dropdown_list');


Route::get('doctortransition/pdf/{id}', [doctorappointmenttransactionController::class, 'printpdffordoctorappointment'])->name('doctortransition.pdf');



Route::resource('doctortransition',  doctorappointmenttransactionController::class);
Route::post('doctortransition/update', [ doctorappointmenttransactionController::class,'update'])->name('doctortransition.update');

Route::get('doctortransition/destroy/{id}', [ doctorappointmenttransactionController::class,'destroy']);












/// surgery transition 


Route::get('surgerytansition/dropdown_list', [surgerytransitionController::class, 'dropdown_list'])->name('surgerytansition.dropdown_list');


Route::get('surgerytansition/pdf/{id}', [surgerytransitionController::class, 'printpdffordoctorappointment'])->name('surgerytansition.pdf');


Route::resource('surgerytansition',  surgerytransitionController::class);
Route::post('surgerytansition/update', [ surgerytransitionController::class,'update'])->name('surgerytansition.update');

Route::get('surgerytansition/destroy/{id}', [ surgerytransitionController::class,'destroy']);

///////// Final Report 

Route::get('finalreport/pdfbill/{id}', [finalreporttransitionController::class, 'printpdfforbill'])->name('finalreport.pdfbill');

Route::get('finalreport/pdf/{id}', [finalreporttransitionController::class, 'printpdfforfinalreport'])->name('finalreport.pdf');


Route::get('finalreport/outdoor',  [finalreporttransitionController::class, 'outdoor'] )->name('finalreport.outdoor');
Route::resource('finalreport',  finalreporttransitionController::class);
Route::post('finalreport/update', [ finalreporttransitionController::class,'update'])->name('finalreport.update');

Route::get('finalreport/destroy/{id}', [ finalreporttransitionController::class,'destroy']);













/////////////////// Make Pathological Report 



Route::get('pathologyreportmaking/dropdownfortest/{id}', [makepathologyreport::class, 'dropdownfortest'])->name('pathologyreportmaking.dropdownfortest');


Route::get('pathologyreportmaking/dropdown_list', [makepathologyreport::class, 'dropdown_list'])->name('pathologyreportmaking.dropdown_list');


Route::get('pathologyreportmaking/pdf/{id}', [makepathologyreport::class, 'printpdffordoctorappointment'])->name('pathologyreportmaking.pdf');

Route::get('pathologyreportmaking/showreport', [ makepathologyreport::class,'findreport']);


Route::resource('pathologyreportmaking',  makepathologyreport::class);





Route::post('pathologyreportmaking/update', [ makepathologyreport::class,'update'])->name('pathologyreportmaking.update');

Route::get('pathologyreportmaking/destroy/{id}', [ makepathologyreport::class,'destroy']);













// employee list 


Route::resource('employeelist',  employeedetailscontroller::class);
Route::post('employeelist/update', [ employeedetailscontroller::class,'update'])->name('employeelist.update');


Route::get('employeelist/destroy/{id}', [ employeedetailscontroller::class,'destroy']);


// doctor list 

Route::resource('doctorlist',  doctorcontroller::class);
Route::post('doctorlist/update', [ doctorcontroller::class,'update'])->name('doctorlist.update');


Route::get('doctorlist/destroy/{id}', [ doctorcontroller::class,'destroy']); 





//hospital service 

Route::get('servicelist/dropdown_list', [ servicelisthospitalController::class,'dropdown_list'])->name('servicelist.dropdown_list');
Route::resource('servicelist',  servicelisthospitalController::class);
Route::post('servicelist/update', [ servicelisthospitalController::class,'update'])->name('servicelist.update');


Route::get('servicelist/destroy/{id}', [ servicelisthospitalController::class,'destroy']);

// service transtion controller servicetranstionController

Route::resource('servicetranstion',  servicetranstionController::class);


//booking patient list  finalreport

Route::resource('bookingpatient',  show_booking_patient_and_release::class);


// cabine transaction  
Route::get('cabinetransaction/details_of_individual_booking_patient/{id}', [ cabinetransactioncontroller::class,'details_of_individual_booking_patient'])
->name('cabinetransaction.details_of_individual_booking_patient');

Route::get('cabinetransaction/showbookingpatient', [ cabinetransactioncontroller::class,'showbooking_patientlist'])
->name('cabinetransaction.showbookingpatient');

Route::Post('cabinetransaction/release_a_patient_from_cabin/{id}/{cabinetransactionid}', [ cabinetransactioncontroller::class,'release_a_patient_from_cabin'])
->name('cabinetransaction.release_a_patient_from_cabin');


Route::get('cabinetransaction/makecabinebillpdf/{id}', [ cabinetransactioncontroller::class,'makecabinebillpdf'])
->name('cabinetransaction.makecabinebillpdf');


Route::get('cabinetransaction/dropdown_list', [cabinetransactioncontroller::class, 'dropdown_list'])->name('cabinetransaction.dropdown_list');
Route::resource('cabinetransaction',  cabinetransactioncontroller::class);
Route::post('cabinetransaction/update', [ cabinetransactioncontroller::class,'update'])->name('cabinetransaction.update');


Route::get('cabinetransaction/destroy/{id}', [ cabinetransactioncontroller::class,'destroy']);



// Report transaction delete 
Route::get('reporttransaction/destroy/{id}', [ reporttransactionController::class,'destroy']);

 
// employee transaction delete 

Route::get('employeetransactioncon/destroy/{id}', [ employeetransactioncontroller::class,'destroy']);
///////////////  agenttransaction delete 

Route::get('agenttransaction/destroy/{id}', [ AgenttransactionControllerController::class,'destroy']);
///////////////  external cost transaction delete 
Route::get('externalcost/destroy/{id}', [ externalcostcontroller::class,'destroy']);




 
////////////////////////////////////////prothisthaner khoroch///////////////////////////////


// report transaction 
//Route::get('reporttransaction/mlist', [reporttransactionController::class, 'mlist'])->name('reporttransaction.mlist');
//Route::get('reporttransaction/fetch', [reporttransactionController::class, 'fetch'])->name('reporttransaction.fetch');



//////////////////////// registration doctor for prescription 

Route::post('doctorregiserforprescriptionpost', [prescriptionController::class, 'doctorregiserforprescriptionpost'])->name('prescription.doctorregiserforprescriptionpost');

Route::get('doctorregiserforprescription', [prescriptionController::class, 'doctorregiserforprescription'])->name('prescription.doctorregiserforprescription');

// print prescription
Route::get('printprescription', [prescriptionController::class, 'printprescription'])->name('prescription.printprescription');



// income provider due payemnt

Route::get('incomeproviderduetrans/dropdownlist', [ incomeproviderduetransitionController::class,'dropdownlist'])->name('incomeproviderduetrans.dropdownlist');

Route::resource('incomeproviderduetrans',  incomeproviderduetransitionController::class);
Route::post('incomeproviderduetrans/update', [ incomeproviderduetransitionController::class,'update'])->name('incomeproviderduetrans.update');

Route::get('incomeproviderduetrans/destroy/{id}', [ incomeproviderduetransitionController::class,'destroy']);








//////////   dhar shod korun othoba advance bujhe pan 





Route::get('supplierduepayemnt/dropdownlist', [ supplierduepaymentController::class,'dropdownlist'])->name('supplierduepayemnt.dropdownlist');

Route::resource('supplierduepayemnt',  supplierduepaymentController::class);
Route::post('supplierduepayemnt/update', [ supplierduepaymentController::class,'update'])->name('supplierduepayemnt.update');

Route::get('supplierduepayemnt/destroy/{id}', [ supplierduepaymentController::class,'destroy']);





//////////////// medicine companyer dena o pawna shod 


Route::POST('medcinercompanydenapawanshod/transition', [ medicineComapnyrDenaPawnaShodController::class,'medcinercompanydenapawanshod'])->name('medcinercompanydenapawanshod.transition');

Route::resource('medcinercompanydenapawanshod',  medicineComapnyrDenaPawnaShodController::class);
//Route::post('khorocer_khad/update', [ Create_khorocer_khad_Controller::class,'update'])->name('khorocer_khad.update');

//Route::get('khorocer_khad/destroy/{id}', [ Create_khorocer_khad_Controller::class,'destroy']);









///////////// Taka uttolon o joma  transaction   

Route::get('takauttolon/dropdown_list', [TakaUttolonTransitionController::class, 'dropdown_list'])->name('takauttolon.dropdown_list');

Route::resource('takauttolon',  TakaUttolonTransitionController::class);
//Route::post('khorochtransition/update', [ KhorochTransitionConTrollerController::class,'update'])->name('khorochtransition.update');

Route::get('takauttolon/destroy/{id}', [ TakaUttolonTransitionController::class,'destroy']);








///////////// business Partner   


Route::resource('businesspartner',  CreatePartnerController::class);
Route::post('businesspartner/update', [ CreatePartnerController::class,'update'])->name('businesspartner.update');

Route::get('businesspartner/destroy/{id}', [ CreatePartnerController::class,'destroy']);


///////////////////////// Taka uttolon o joma report ////////////////////////////////



 Route::get('joma_uttolon_statement_today', [joma_uttolon_report_statement_Controller::class, 'todaystatement'])->name('joma_uttolon_statement_today');


 Route::get('joma_uttolon_statement_yesterday', [joma_uttolon_report_statement_Controller::class, 'yesterdaystatment'])->name('joma_uttolon_statement_yesterday');


 Route::get('joma_uttolon_statement_month', [joma_uttolon_report_statement_Controller::class, 'thismonthstatment'])->name('joma_uttolon_statement_month');

 Route::get('joma_uttolon_statement_year', [joma_uttolon_report_statement_Controller::class, 'thisyear'])->name('joma_uttolon_statement_year');

 Route::get('joma_uttolon_statement_lastmonth', [joma_uttolon_report_statement_Controller::class, 'lastmonth'])->name('joma_uttolon_statement_lastmonth');

// Route::post('incomestatbtwtwodate', [incomestatemnetController::class, 'recordbetweentwodate'])->name('incomestatbtwtwodate');

//Route::get('/picktwodate', function () {
//    return view('incomestatement.picktwodate');
//});





 Route::get('doctorstatementoday', [outdoordoctortranstion::class, 'todaystatment'])->name('outdoordoctortranstion.doctorstatementoday');


 Route::get('doctorstatementyesterday', [outdoordoctortranstion::class, 'yesterdaystatment'])->name('outdoordoctortranstion.doctorstatementyesterday');


 Route::get('doctorstatementthismonth', [outdoordoctortranstion::class, 'thismonth'])->name('outdoordoctortranstion.doctorstatementthismonth');


 Route::get('doctorstatementthisyear', [outdoordoctortranstion::class, 'thisyear'])->name('outdoordoctortranstion.doctorstatementthisyear');


 Route::post('outdoordoctorbtwtwodate', [outdoordoctortranstion::class, 'outdoordoctorbtwtwodate'])->name('outdoordoctorbtwtwodate');




Route::get('/picktwodatefordoctortransition', function () {
    return view('incomefromdoctoroutdoor.picktwodate');
});
//// show due transition 



 Route::get('dueofpatient', [dueshowtranstionController::class, 'showduecustomerpage'])->name('dueofpatient.fontpage');

 Route::post('dueshow', [dueshowtranstionController::class, 'showduetransition'])->name('dueofpatient.showduetransition');





////////////////////////////// Income Statement 

 Route::get('incomestatementtoday', [incomestatemnetController::class, 'todaystatment'])->name('incomestatementtoday.todaystatment');


 Route::get('incomestatementyesterday', [incomestatemnetController::class, 'yesterdaystatment'])->name('incomestatementyesterday.incomestatementyesterday');


 Route::get('incomestatementthismonth', [incomestatemnetController::class, 'thismonthstatment'])->name('thismonthstatment.thismonthstatment');

 Route::get('incomestatementthisyear', [incomestatemnetController::class, 'thisyearstatment'])->name('thisyearstatment.thisyearstatment');

 Route::get('incomestatementlastmonth', [incomestatemnetController::class, 'lastmonthstatment'])->name('incomestatementlastmonth.incomestatementlastmonth');

 Route::post('incomestatbtwtwodate', [incomestatemnetController::class, 'recordbetweentwodate'])->name('incomestatbtwtwodate');

Route::get('/picktwodate', function () {
    return view('incomestatement.picktwodate');
});






////////////////////////////// Doctor Commission /////////////
Route::get('doctorcommission/paid/{id}', [DoctorCommissionController::class, 'paid'])->name('doctorcommission.paid');
Route::get('doctorcommission', [DoctorCommissionController::class, 'index'])->name('doctorcommission.index');  

Route::get('doctorcommission/delete/{id}', [DoctorCommissionController::class, 'destroy'])->name('doctorcommission.destroy');  

Route::post('doctorcommission/insert', [DoctorCommissionController::class, 'store'])->name('doctorcommission.store'); 






///////////////////// Medicne Company medicinecomapny 

Route::get('medicinecomapny', [medicineCompanyController::class, 'index'])->name('medicinecomapny.index');  

Route::get('medicinecomapny/edit/{id}', [medicineCompanyController::class, 'edit'])->name('medicinecomapny.edit'); 

Route::post('medicinecomapny/insert', [medicineCompanyController::class, 'store'])->name('medicinecomapny.store'); 

Route::post('medicinecomapny/update', [medicineCompanyController::class, 'update'])->name('medicinecomapny.update'); 

Route::get('medicinecomapny/delete/{id}', [medicineCompanyController::class, 'destroy'])->name('medicinecomapny.destroy');  



///////////////////// Medicne Company medicinecomapny transaction


Route::get('medicinecomapnytransition/dropdown_list', [medicine_comapny_transition_Controller::class, 'dropdown_list'])->name('medicinecomapnytransition.dropdown_list');  


Route::get('medicinecomapnytransition', [medicine_comapny_transition_Controller::class, 'index'])->name('medicinecomapnytransition.index');  


Route::get('medicinecomapnytransition/edit/{id}', [medicine_comapny_transition_Controller::class, 'edit'])->name('medicinecomapnytransition.edit'); 

Route::post('medicinecomapnytransition/insert', [medicine_comapny_transition_Controller::class, 'store'])->name('medicinecomapnytransition.store'); 

Route::post('medicinecomapnytransition/update', [medicine_comapny_transition_Controller::class, 'update'])->name('medicinecomapnytransition.update'); 

Route::get('medicinecomapnytransition/delete/{id}', [medicine_comapny_transition_Controller::class, 'destroy'])->name('medicinecomapnytransition.destroy');  



//////// check balance 
 Route::get('balance', [BalanceController::class, 'index'])->name('balance');






});

 
 
 
 
 
 ////////////////////////////////////////////// Phermacy Section 
Route::group([ 'middleware'=>['auth','isPhermachy','PreventBackHistory']], function(){
        Route::get('Phermachydepdashboard',[phermacyController::class,'index'])->name('phermachy.dashboard');
       
		
		
Route::get('medicinetransition/mlist', [medicinetransactionController::class, 'mlist'])->name('medicinetransition.mlist');
Route::get('medicinetransition/fetch', [medicinetransactionController::class, 'fetch'])->name('medicinetransition.fetch');
		

Route::get('medicinetransition/pdf/{id}', [medicinetransactionController::class, 'printpdfformedicineslip'])->name('medicinetransition.pdf');


Route::resource('medicinetransition',  medicinetransactionController::class);
Route::post('medicinetransition/update', [ medicinetransactionController::class,'update'])->name('medicinetransition.update');

Route::get('medicinetransition/destroy/{id}', [ medicinetransactionController::class,'destroy']);



Route::get('returnmedicinetransition/mlist', [ReturnmedicinetransactionController::class, 'mlist'])->name('ReturnmedicinetransactionController.mlist');
Route::get('returnmedicinetransition/fetch', [ReturnmedicinetransactionController::class, 'fetch'])->name('ReturnmedicinetransactionController.fetch');

Route::resource('returnmedicinetransition',  ReturnmedicinetransactionController::class);
		


       
}); 


 /////////////////////////////////////////////// Account  Section 
 
 Route::group([ 'middleware'=>['auth','isAccount','PreventBackHistory']], function(){
        Route::get('accountdashboard',[AccountController::class,'index'])->name('account.dashboard');
        
		
		
		
/// report transaction 


Route::get('reporttransaction/pdf/{id}', [reporttransactionController::class, 'printpdfforreportslip'])->name('reporttransaction.pdf');

Route::get('reporttransaction/mlist', [reporttransactionController::class, 'mlist'])->name('reporttransaction.mlist');
Route::get('reporttransaction/fetch', [reporttransactionController::class, 'fetch'])->name('reporttransaction.fetch');


Route::resource('reporttransaction',  reporttransactionController::class);
Route::post('reporttransaction/update', [ reporttransactionController::class,'update'])->name('reporttransaction.update');



///////


/// employee transaction 


 Route::get('employeeshow', [employeetransactioncontroller::class, 'employeeshow'])->name('employeetransactioncon.employeeshow');

 Route::post('employeesalaryfetch', [employeetransactioncontroller::class, 'employeesalaryfetch'])->name('employeetransactioncon.employeesalaryfetch');

Route::get('employeetransactioncon/dropdown_list', [employeetransactioncontroller::class, 'dropdown_list'])->name('employeetransactioncon.dropdown_list');
Route::resource('employeetransactioncon',  employeetransactioncontroller::class);
Route::post('employeetransactioncon/update', [ employeetransactioncontroller::class,'update'])->name('employeetransactioncon.update');





// external cost 

Route::resource('externalcost',  externalcostcontroller::class);
Route::post('externalcost/update', [ externalcostcontroller::class,'update'])->name('externalcost.update');


















		
		


       
});
 
 
 ///////////////////////////////////////////////////
 



Route::group([ 'middleware'=>['auth','PreventBackHistory','isUser']], function(){
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
  







//Route::get('categorylist', [PhotoController::class, 'popular']);
//Route::get('category_list', [categorylist::class,'category_list'])->name('medicine.category_list');








});  



Route::group([ 'middleware'=>['auth','isDoctor','PreventBackHistory']], function(){
   //////////////////// prescription 



Route::get('prescription/pdf/{id}', [prescriptionController::class, 'printpdf'])->name('prescription.pdf');

Route::get('prescription/dropdownlist', [prescriptionController::class, 'dropdownlist'])->name('prescription.dropdownlist');

Route::resource('prescription',  prescriptionController::class);
Route::post('prescription/update', [ prescriptionController::class,'update'])->name('prescription.update');

Route::get('prescription/destroy/{id}', [ prescriptionController::class,'destroy']);

       
}); 













