

@extends('layout.main')

@section('content')
         
<body>

  <?php  
$totalkhoroch = 0;
$totalbaki =0;
$totaladvance = 0; 
$totalbeton=0;
 $totalcommission=0; 
 $totaldharshod=0;
 $totaldoctorcommission=0;

$totaldoctorshare=0;

///////////// income variable 

$totalincome_from_pathology=0;
$total_discoubt_in_patho=0;
$total_vat_in_patho=0;
$net_income_from_pth =0;
$total_due_paid=0;
$mot_nogod_income_from_pathology=0;

  ?>
  
  
<div class="container">
  <div class="row">
    <div style="background-color: #add8e6" class="col-sm">
  <h2 style="color:red">    এই বছরের খরচ </h2>
  <hr>  
  
  <h5 style="color:red;"> বিভিন্ন খাতে এই বছরের খরচের পরিমাণ </h5>  
  <table class="table"> 
  <thead>
    <tr>
    
      <th scope="col">খরচের নাম </th>
	  <th scope="col"> ক্রয় করা সেবা/পণ্যের পরিমাণ  </th>
      <th scope="col">ক্রয় মূল্য  </th>
      <th scope="col">বাকিতে ক্রয় </th>
	   <th scope="col">এডভান্স প্রদান  </th>
    </tr>
  </thead>
  <tbody>
  

    
	@foreach($externalcost as $e)
	
	
	<?php  

$totalkhoroch = $totalkhoroch+ $e->total_amount ;
$totalbaki = $totalbaki + $e->total_due ;
$totaladvance = $totaladvance + $e->total_advance ; 




	?>
	
	
	
	
	<tr>
      <th >{{$e->khorocer_khad->name}}</th>
	  <td>{{$e->total_unit}}</td>
      <td>{{$e->total_amount}}</td>
      <td>{{$e->total_due}}</td>
      <td>{{$e->total_advance}}</td>
    </tr>
@endforeach
  </tbody>
</table>(+) 

<hr>
<span style="color:blue;"> বিভিন্ন খাতে এই বছরের   মোট খরচঃ  </span> <?php echo $totalkhoroch  ?> টাকা 

  

  
  <br>
 
  <br><br>
   <hr >


<br><br>







<!---------------------------------- employee transition. chechk if threre any transition in the daterange. 
if yes then exexute  -->

<?php if (!$employee_salary->isEmpty())  { ?>
<h5 style="color:red">     স্টাফদের বেতন প্রদান বাবদ খরচ  </h5>
  <hr>
  <table class="table">
  <thead>
    <tr>
    
      <th scope="col"> স্টাফের নাম  </th>
      <th scope="col">বেতনের পরিমাণ   </th>
     
    </tr>
  </thead>
  <tbody>
    
	
	
	
	
	
	
	@foreach($employee_salary as $ems)
	<?php  
	$totalbeton = $totalbeton + $ems->total_given_salary_of_a_employee;
	
	?>
	
	<tr>
      <th >{{$ems->employeedetails->name}}</th>
      <td>{{$ems->total_given_salary_of_a_employee}}</td>
      
    </tr>
@endforeach
  </tbody>
</table>
<hr>
<span style="color:blue;"> বেতন দেয়া বাবদ  মোট খরচঃ  </span> <?php echo $totalbeton  ?> টাকা 

  

  
  <br>
 
  <br><br>
   <hr >












  <?php } ?>
  
  
 


<!---------------------------------- Agent transition. chechk if threre any transition in the daterange. 
if yes then exexute  -->
 
 <br><br>
<?php if (!$agent_commision->isEmpty())  { ?>
<h5 style="color:red">     এজেন্টদের কমিশন দেয়া বাবদ খরচ  </h5>
  <hr>
  <table class="table">
  <thead>
    <tr> 
    
      <th scope="col"> এজেন্টের নাম  </th>
      <th scope="col">কমিশনের পরিমাণ   </th>
     
    </tr>
  </thead>
  <tbody>
    
	
	
	
	@foreach($agent_commision as $agentcom)
	
	<?php 
	$totalcommission = $totalcommission+ $agentcom->total_given_paidamount_of_a_agents ;
	?>
	<tr>
      <th >{{$agentcom->agentdetail->name}}</th>
      <td>{{$agentcom->total_given_paidamount_of_a_agents}}</td>
      
    </tr>
@endforeach
  </tbody>
</table>(+)


<hr>
<span style="color:blue;"> কমিশন বাবদ  মোট খরচঃ  </span> <?php echo $totalcommission  ?> টাকা 

  

  
  <br>
 
  <br><br>
   <hr >


  <?php } ?> 
  
  
  
 






 <!---------------------------------- DoctorCommission . chechk if threre any transition in the daterange. 
if yes then exexute  -->

<?php if (!$doctorcommission->isEmpty())  { ?>
<h5 style="color:red">     ডাক্তারদের কমিশন বাবদ খরচ   </h5>
  <hr>
  <table class="table">
  <thead>
    <tr>
    
      <th scope="col">  নাম  </th>
      <th scope="col">টাকার পরিমাণ   </th>
     
    </tr>
  </thead>
  <tbody>
    
	
	
	
	
	
	
	@foreach($doctorcommission as $doctorcom)
	<?php  
	$totaldoctorcommission = $totaldoctorcommission + $doctorcom->total_deya_commission;
	
	?>
	
	<tr>
      <th >{{$doctorcom->doctor->name}}</th>
      <td>{{$doctorcom->total_deya_commission}}</td>
      
    </tr>
@endforeach
  </tbody>
</table>
 (+)
<hr>
<span style="color:blue;">ডাক্তারদের কমিশন বাবদ  মোট খরচঃ  </span> <?php echo $totaldoctorcommission  ?> টাকা 

  

  
  <br>
 
  <br><br>
 
   <hr >


  <?php } ?>
  






 <!---------------------------------- Doctor er outdoor er share er taka  . chechk if threre any transition in the daterange. 
if yes then exexute  -->

<?php if (!$doctor_er_sharer_taka->isEmpty())  { ?>
<h5 style="color:red">     ডাক্তাররা আপনার ক্লিনিকে  আউট ডোরে রোগী দেখলে সেই বাবদ তার শেয়ারের টাকা   </h5>
  <hr>
  <table class="table">
  <thead>
    <tr>
    
      <th scope="col"> ডাক্তারের  নাম  </th>
      <th scope="col">টাকার পরিমাণ   </th>
     
    </tr>
  </thead>
  <tbody>
    
	
	
	
	
	
	
	@foreach($doctor_er_sharer_taka as $doctorshare)
	<?php  
	$totaldoctorshare = $totaldoctorshare + $doctorshare->deya_share;
	
	?>
	
	<tr>
      <th >{{$doctorshare->doctor->name}}</th>
      <td>{{$doctorshare->deya_share}}</td>
      
    </tr>
@endforeach
  </tbody>
</table>
(+)
<hr>
<span style="color:blue;">   আউট ডোরে রোগী দেখার জন্য শেয়ারের  বাবদ ডাক্তারদের  দেয়া টাকার পরিমাণ    </span> <?php echo $totaldoctorshare  ?> টাকা 

  

  
  <br>
 
  <br><br>
   <hr >


  <?php } ?>
  

























<!---------------------------------- dhar shod  transition. chechk if threre any transition in the daterange. 
if yes then exexute  -->
 
 <br><br>
<?php if (!$dharshod->isEmpty())  { ?>
<h5 style="color:red">    পূর্বের বাকি/ঋণ শোধ বাবদ খরচ  </h5>
  <hr>
  <table class="table">
  <thead>
    <tr> 
    
      <th scope="col"> সাপ্লাইয়ারের নাম  </th>
      <th scope="col"> বাকি/ঋণ শোধের পরিমাণ   </th> 
     
    </tr>
  </thead>
  <tbody>
    
	
	
	
	@foreach($dharshod as $dhar)
	
	<?php 
	$totaldharshod = $totaldharshod+ $dhar->total_baki_shod ;
	?>
	<tr>
      <th >{{$dhar->supplier->name}}</th>
      <td>{{$dhar->total_baki_shod}}</td>
      
    </tr>
@endforeach
  </tbody>
</table>(+)
<hr>
<span style="color:blue;"> বাকি/ঋণ শোধ বাবদ মোট খরচঃ  </span> <?php echo $totaldharshod  ?> টাকা 

  <?php } ?> 

  
  <br>
 
  <br><br>
   <hr >
  <b style="color:green" > এই বছরের খরচের  সামারি  </b>
  <br>
  <span style="color:red;"> বিভিন্ন খাতে খরচের পরিমাণ   </span> <?php echo $totalkhoroch ?> টাকা <br>
   <span style="color:red;"> এজেন্টদের কমিশন দেয়া বাবদ খরচ   </span> <?php echo $totalcommission ?> টাকা <br>
   <span style="color:red;"> স্টাফদের বেতন দেয়া বাবদ খরচ    </span> <?php echo $totalbeton ?> টাকা <br> 
    <span style="color:red;"> ডাক্তারদের কমিশন বাবদ খরচ   </span> <?php echo $totaldoctorcommission ?> টাকা  <br> 
 <span style="color:red;"> আপনার ক্লিনিকে আউট ডোরে রোগী দেখার জন্য শেয়ারের বাবদ ডাক্তারদের দেয়া টাকার পরিমাণ:   </span> <?php echo $totaldoctorshare ?> টাকা  <br> 
  (+) <br >
  <hr style="width:50%">
<span style="color:red;">  সেবা/ পণ্য ক্রয় বাবদ মোট খরচঃ </span> <?php echo $khoroch= $totalcommission + $totaldoctorshare + $totalbeton + $totalkhoroch + $totaldoctorcommission ?> টাকা 
 <br>
<span style="color:red;"> বাকিতে সেবা/ পণ্য ক্রয়ঃ  </span> <?php echo $totalbaki ?> টাকা <br>
(-)
 <br>
 <hr style="width:50%"> 
 <span style="color:red;"> সুতরাং নগদে সেবা/ পণ্য ক্রয়ঃ  </span> <?php echo $nogodkroy = ($khoroch -  $totalbaki) ?> টাকা 
 <br>

 <span style="color:red;"> পূর্বের  বাকি/ঋণ শোধ বাবদ মোট খরচঃ  </span> <?php echo $totaldharshod  ?> টাকা 
 <br>(+) 
 <hr  style="width:50%">
<span style="color:red;"> সুতরাং  এই বছরের মোট খরচ    </span> <?php echo $totalkhorochafteradjustingdue = ($nogodkroy+ $totaldharshod) ?> টাকা  
  
<hr style="width:50%">

<b  style="background-color:#00FEFE">বি দ্রঃ  আপনি যে পরিমাণ বাকিতে ক্রয় করেছেন তার পরিমাণঃ {{ $totalbaki}} টাকা। এই টাকাকে খরচের থেকে বাদ দেয়া হয়েছে। এই টাকা যে তারিখে শোধ দিবেন , সেই তারিখের খরচের সাথে যুক্ত হবে।   </b>

<br>
<span style="background-color:#00FF00"> আজকে সেবা/পণ্য ক্রয় বাবদ এডভান্স প্রদান করেছেনঃ    <?php echo $totaladvance ?> টাকা  </span>
  <br>
 <span style="background-color:yellow"> আপনার প্রতিষ্ঠানের কি পরিমাণ ঋণ আছে ও কি পরিমাণ টাকা আপনার প্রতিষ্ঠান অন্য লোক/ প্রতিষ্ঠানের কাছে পায় সেই সম্পর্কে বিস্তারিত জানতে রিপোর্ট সেকশনে গিয়ে বাকি-শোধ-বাকি-আদায় অপশনে ক্লিক করেন ।   </span>  
  
  
  
  
  
  
    </div>
   
<!-------------------------------------------------- income ---------------------------------->








   <div  style="background-color: #EEE8AA" class="col-sm">
<h2 style="color:green">      এই বছরের বিক্রি </h2>
<hr>


<!---------------------------------- pathology transition . chechk if threre any transition in the daterange. 
if yes then exexute  -->
 
 <br><br>
<?php if (!$income_from_pathology_test->isEmpty())  { ?>
<h5 style="color:red">     বিভিন্ন প্রকারের টেস্ট বাবদ প্যাথলজি বিভাগ থেকে আয়  </h5>
  <hr>
  <table class="table table-responsive">
  <thead>
    <tr> 
    
      <th scope="col"> টেস্টের নাম  </th>
	  	 <th scope="col"> বিক্রির পরিমাণ ৳  </th>
     
     <th scope="col">  ভ্যাট  ৳  </th> 
	
	 <th scope="col">  ডিস্কাউন্ট ৳    </th>
	  
 <th scope="col">  আয়ের পরিমাণ  ৳ =  (বিক্রি -  ডিস্কাউন্ট) + ভ্যাট   </th>
    </tr>
  </thead>
  <tbody>
    
	
	
	
	@foreach($income_from_pathology_test as $inc )
	
	<?php 
	
$totalincome_from_pathology= $totalincome_from_pathology+ $inc->amount ;
$total_discoubt_in_patho= $total_discoubt_in_patho + $inc->discount ;
$total_vat_in_patho= $total_vat_in_patho + $inc->vat ;
$net_income = (	$inc->amount + $inc->discount - $inc->vat);
$net_income_from_pth = $net_income_from_pth + $net_income ;
	
	
	?>
	<tr>
      <th >{{$inc->reportlist->name}}</th>
	  <td>{{ $net_income }}</td>
      
	  <td>{{$inc->vat}}</td>
      <td>{{$inc->discount}}</td>
	  <td>{{$inc->amount}}</td>
    </tr>
@endforeach

  </tbody>
</table>(+)


<hr>
<span style="color:blue;"> প্যাথলজি বিভাগ থেকে মোট যে পরিমাণ টাকার সেবা বিক্রি করেছেনঃ  </span> <?php echo $net_income_from_pth  ?> টাকা <br>
<span style="color:blue;"> বিক্রি করা সেবার উপর মোট ভ্যাটের পরিমাণঃ    </span> <?php echo $total_vat_in_patho  ?> টাকা <br>
<span style="color:blue;"> বিক্রি করা সেবার উপর আপনি যে পরিমাণ ডিস্কাউন্ট দিয়েছেনঃ     </span> <?php echo $total_discoubt_in_patho  ?> টাকা <br> <br><hr style="height:2px; width:100%; border-width:0; color:red; background-color:red" > 
<b><span style="color:green;"> তাহলে  মোট আয় ( মোট বিক্রি করা সেবা + ভ্যাট - ডিস্কাউন্ট) :  </span> </b> {{$net_income_from_pth}}+ {{$total_vat_in_patho}}- {{$total_discoubt_in_patho}} =     <?php echo $totalincome_from_pathology  ?> টাকা <br>
    <span style="color:blue;">  বাকিতে বিক্রির পরিমাণঃ   </span>  {{$total_due_patho}} টাকা <br>
  (-) 
  <hr>
   <b> <span style="color:blue;">  সুতরাং প্যাথলজি বিভাগ থেকে মোট নগদ আয়ঃ    </span> <?php $mot_nogod_income_from_pathology =  $totalincome_from_pathology - $total_due_patho ?>  {{ $mot_nogod_income_from_pathology }}      টাকা <br></b>
  <br> 
  

   <hr >


  <?php } ?> 
  
  





<!---------------------------------- due paid transition . chechk if threre any transition in the daterange. 
if yes then exexute  -->
 
 <br><br>
<?php if (!$income_from_due_payment->isEmpty())  { ?>
<h5 style="color:red">  আজকে যে পরিমাণ বাকি টাকা  আদায় হয়েছে।   </h5>
  <hr>
  <table class="table table-responsive">
  <thead>
    <tr> 
    
      <th scope="col"> গ্রাহকের নাম   </th>
	  	 <th scope="col"> আদায় করা টাকার পরিমাণ  ৳  </th>
     

    </tr>
  </thead>
  <tbody>
    
	
	
	
	@foreach($income_from_due_payment as $due_paid )
	
	<?php 
	
$total_due_paid = $total_due_paid+ $due_paid->amount_of_due_paid  ;

	
	
	?>
	<tr>
      <th >{{$due_paid->patient->name}}</th>
	  <td>{{ $due_paid->amount_of_due_paid }}</td>
      
	
    </tr>
@endforeach

  </tbody>
</table>(+) 


<hr>
<b><span style="color:blue;"> আজকে আদায় করা মোট বাকি টাকার পরিমাণঃ  </span> <?php echo $total_due_paid  ?> টাকা <br></b>




 <br><br>
   <hr >


  <?php } ?> 
  



 <br><br>

  <b style="color:green" > <u> আয়ের  সামারি </u> </b>
  <br>
  <br>
<b style="background-color:#FF00FF" >  #নগদ বিক্রির পরিমাণ </b> <br><br> 
  <span style="color:red;"> প্যাথলজি বিভাগ থেকে নগদ আয়ঃ    </span> <?php echo $mot_nogod_income_from_pathology ?> টাকা <br>
  <span style="color:red;"> বাকি আদায়ঃ    </span> <?php echo $total_due_paid ?> টাকা <br>
(+) <hr style="width:50%">
  <span style="color:red;"> মোট নগদ আয়   </span> <?php $final_income= $mot_nogod_income_from_pathology+ $total_due_paid ?> {{ $final_income }}    টাকা <br>

  <br>
<b style="background-color:#FF00FF" >  #বাকিতে  বিক্রির পরিমাণ </b> <br><br> 
  <span style="color:red;"> প্যাথলজি বিভাগ থেকে বাকিতে পণ্য/সেবা  বিক্রিঃ     </span> {{$total_due_patho}} টাকা <br><br>


<b style="background-color:#FF00FF" >  #আজকে গ্রাহকদের থেকে আদায় করা ভ্যাটের পরিমাণ </b> <br><br> 
  <span style="color:red;"> প্যাথলজি বিভাগ থেকে ভ্যাট আদায়     </span> {{$total_vat_in_patho}} টাকা <br><br>
 <b  style="background-color:#00FF00"> আপনি ভ্যাট বাবদ গ্রাহক থেকে টাকা তুলেছেন। এই টাকাকে আপনার নগদ আয় হিসাবে দেখানো হয়েছে। যে তারিখে এই ভ্যাট সরকারের কাছে জমা দিবেন , সেই তারিখের ব্যালেন্স সিটে এই ভ্যাটকে খরচ হিসাবে যুক্ত করা হবে।   </b><br>
 <b  style="background-color:#00FEFE">বি দ্রঃ  আপনি যে পরিমাণ পণ্য/সেবা  বাকিতে বিক্রয়  করেছেন তার পরিমাণঃ {{ $total_due_patho}} টাকা। এই টাকাকে আয়  থেকে বাদ দেয়া হয়েছে। আয় শুধু নগদ আয়ের উপর হিসাব করা হচ্ছে। এই বাকি টাকা যে তারিখে গ্রাহক শোধ দিবে সেই তারিখের আয় হিসাবে যুক্ত হবে।   </b><br>
 









    </div>


  </div>
</div>

 
 






</bodY>
@stop