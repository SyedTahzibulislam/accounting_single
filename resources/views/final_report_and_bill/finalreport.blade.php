<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid black;
  text-align: left;
  padding: 2px;
}



#c{




margin: 0 auto;
position:relative;

}





#c img {
width:100%;
}

#c::before {
content:'';
position:absolute;
top:50px;
left:0;
background-image: url("img/watermark.jpg");
background-position:center;
background-repeat:no-repeat;
width: 100%;
height: 100%;;
opacity: .1;
}

#m{
  
 background-color:red;;

}







</style>





 <?php for ($j=0; $j<3; $j++){ ?>
</head>

<body style="font-family: Times New Roman;">
<div id="c" >
<div id="head" >
<img width="500px;"   src="img/logo.jpg" >
<hr>
</div>



    <div style="height:10px;" id="one" >
    <div style="width:33%; float:left;" >
	<?php if( $j == 0) { ?>
      <b><u>Money Receipt</u></b>
    <?php } if ( $j == 1){ ?>
	  <b>Office Copy </b>
	  <?php } if ( $j == 2){ ?>
	 <b> Accountant's Copy  </b>
	  <?php } ?>
	</div>
    <div style="width:33%;float:left;" >
 <b>Patient ID:</b> {{$data->id}}
    </div>



  </div>

 

   
    <div style="height:10px;" id="two" >
    <div style="width:40%; float:left;" >
      <b>Name :</b> {{$data->name}}
    </div>

	
	    <div style="width:13%;float:left;" >
 <b>Age:</b> {{$data->age}}
    </div>
	    <div style="width:13%;float:left;" >
 <b>Sex:</b>{{$data->sex}}
    </div>
	
	
	    <div style="width:34%;float:left;" >
<b>Mobile No.</b> {{$data->mobile}} 
    </div>

  </div>
    
   

   <div style="height:10px;" id="two" >
    <div style="width:50%; float:left;" >
      <b>Diagnosis For: </b> {{$data->diagnosisfor}}
    </div>

	
	    <div style="width:50%;float:left;" >
 <b>Reference Doctor:</b> {{$refdoctor}}
    </div>


  </div>


   <div style="height:10px;" id="two" >
    <div style="width:30%; float:left;" >
      <b>Cabine NO: </b> {{$cabine}}
    </div>

	
	    <div style="width:35%;float:left;" >
 <b>Admission Date:</b> {{$startingdate}}
    </div>
	    <div style="width:35%;float:left;" >
 <b>Discharing Date :</b> {{$enddate}}
    </div>

  </div>

















  <?php if ( $surdata != null) { ?>
  
  @foreach( $surdata as $sur)
   
   <table>
      <tr>
    <td> Surgery Name: {{$sur->surgerylist->name}} </td>
   <td> Cost </td>

  </tr>
   
   
   
   <tr>
    <td> Pre-Operative Charge</td>
   <td> {{$sur->pre_operative_charge}}</td>

  </tr>

  <tr>
    <td> Surgeon harge</td>
   <td> {{$sur->Surgeon_charge}}</td>

  </tr>
  
  <tr>
    <td> Anesthesia Charge</td>
   <td> {{$sur->anesthesia_charge}}</td>

  </tr>

  <tr>
    <td> Assistant Charge</td>
   <td> {{$sur->assistant_charge}}</td>

  </tr>

  <tr>
    <td> OT Charge</td>
   <td> {{$sur->ot_charge}}</td>

  </tr>

  <tr>
    <td> Oxygen/Nitrogen Charge</td>
   <td> {{$sur->o2_no2_charge}}</td>

  </tr>

  <tr>
    <td> C-Arme Charge</td>
   <td> {{$sur->c_arme_charge}}</td>

  </tr>

  <tr>
    <td> Post-Operative Charge</td>
   <td> {{$sur->post_operative_charge}}</td>

  </tr>  
  
    <tr>
    <td> Miscellaneous Expenses</td>
   <td> {{$sur->miscellaneous_expenses}}</td>

  </tr> 
  
  
  
      <tr>
    <td> Total Expenses </td>
   <td> {{$sur->total_cost_after_initial_vat_and_discount}}</td>

  </tr> 
  </table>
  <p>
  @endforeach
  
  <?php } ?>


<p>
<b> Other Expenses </b>
<table>
  <tr>
    <th>Service/Product Name </th>

	 <th>Total  </th> 
  </tr>
  
 
  <tr>
    <td> Medicine</td>
   
   

	 <td>{{$mtotal}}</td>
  </tr>
  <tr>
    <td>Cabine/Bed Fare</td>
   
 

	 <td>{{$cabinetotal}}</td>
  </tr>
    <tr>
    <td>Doctor's Visits Fees</td>
   
 

	 <td>{{$dtotal}}</td>
  </tr>
    <tr>
    <td> Pathological Tests</td>
   
   

	 <td>{{$rtotal}}</td>
  </tr>

 <?php if ( $servicecost != null) { ?>
 @foreach( $servicecost as $serv ) 
 
    <tr>
    <td> {{ $serv->servicelistinhospital->servicename }}  </td>
    <td> {{ $serv->charge }}  </td>
   

@endforeach
  </tr>

 <?php } ?>


</table>



<br>
<br>
    <div style="height:10px;" id="two" >
    <div style="width:30%; float:left;" >
      <b>Gross Amount:</b> {{$finalcosttable->gross_amount }} TK
    </div>

	
	    <div style="width:40%;float:left;" >
 <b>Receiveable Amount:</b> {{$finalcosttable->receiveable_amount }} TK
    </div>
	    <div style="width:30%;float:left;" >
 <b>Paid:</b> <?php echo  $finalcosttable->receiveable_amount - $finalcosttable->total_due ; ?> TK
    </div>

  </div>
  
     

	 <div style="height:10px;" id="two" >
    <div style="width:33%; float:left;" >
     <b>Discount:</b> {{$finalcosttable->total_discount}} TK
    </div>

	
	    <div style="width:33%;float:left;" >
 <b>Due:</b> {{$finalcosttable->total_due }} TK
    </div>
	    <div style="width:33%;float:left;" >
 <b>Entry By:</b> {{$finalreport->User->name}}
    </div>

  </div>
  <?php if( $j > 0) { ?>
	 <div style="height:10px;" id="two" >
    

<?php if($data->agentdetail_id){  ?>
<div style="width:50%; float:left;" >
     <b>Agent Name:</b>
	 {{$data->agentdetail->name}} 
	 
    </div>
	 
<?php } if($data->doctor_id){  ?>

<div style="width:50%; float:left;" >
     <b>Agent Name:</b>
	 {{$data->doctor->name}} 
	 
    </div>


	

<?php } ?>



	
	    <div style="width:50%;float:left;" >
 <b>Commission:</b> {{$finalcosttable->total_Commission }} TK
    </div>


  </div>  

  <?php } ?>



</div>





</div>


			<?php if( $j < 2) { ?>
	<p style="page-break-after:always" ></p>
 <?php } } ?>
</body>
</html>