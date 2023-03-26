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
 <?php for ($i=0; $i<3; $i++){ ?>
</head>
<body style="font-family: Times New Roman;">
<div id="c" >
<div id="head" >
<img width="500px;"   src="img/logo.jpg" >
<hr>
</div>



    <div style="height:10px;" id="one" >
    <div style="width:30%; float:left;" >
	<?php if( $i == 0) { ?>
      <b><u>Balance Sheet</u></b>
    <?php } if ( $i == 1){ ?>
	  <b>office's Copy  </b>
	  <?php } if ( $i == 2){ ?>
	 <b> Accountant's Copy  </b>
	  <?php } ?>
	</div>




  </div>


    <div style="height:10px;" id="two" >
    <div style="width:40%; float:left;" >
      <b>Bank Name :</b> {{$data->name}}
    </div>

	


	


  </div>
     

    <div style="height:10px;" id="two" >
    <div style="width:30%; float:left;" >
      <b>Opening Balance :</b> {{$data->openingbalance}} TK
    </div>
    <div style="width:30%; float:left;" >
      <b>Current Balance :</b> {{$data->currentbalance}} TK
    </div>

    <div style="width:30%; float:left;" >
      <b> Balance  :</b> at the begining of the Transition:  {{$obtillfirstdate}} TK
    </div>
  </div>  
  
 <b>Transition: From  <?php echo date('d/m/Y ', strtotime($start)); ?> to <?php echo date('d/m/Y ', strtotime($end)); ?> </b><p>
  <?php  $b= $obtillfirstdate;  ?>
  
  
  
 <br> 




<table>






<thead>
  <tr>
     
	
 <th style="width:40px;" >	Date</th>
  
    <th style="width:150px;" >
	
Deposit
    
	 </th>
	  <th style="width:100px;"  >Withdrawl</th>
    <th style="width:100px;"  >By </th>
	<th style="width:100px;"  >Balance </th>

  </tr>
  </thead>
 @foreach ( $order as $o )

 <?php 

if ($o->type == 0)
{
$b = $b+ $o->credit;

}	

if ($o->type == 1)
{
$b = $b- $o->debit;

}




?> 


  <tr>
    <?php  //$myDateTime = DateTime::createFromFormat('Y-m-d', $o->created_at);  echo  $myDateTime->format('d/m/Y'); ?> 
  <td> <?php echo date('d/m/Y ', strtotime($o->transdate));; ?> </td>
    <td> 
	{{ $o->credit }}
</td>
 
    <td> 
	{{ $o->debit }}
</td>

 





 <td>       




  <?php if($o->whom == 0)
	{  ?>
		  Business:
<?php 	}


     if($o->whom == 1)
	{  ?>
		
		
		customer: {{  $o->customer->name }} 
<?php 	}
	
	
	
    if($o->whom == 2)
	{  ?>
		
	
		Company: {{  $o->Productcompany->name }} 
	
	 <?php }
	
	
	
    if($o->whom == 3)
	{  ?>
		
	
		
		Partner:{{  $o->sharepartner->name }} 
	<?php }
	 ?>



 </td>
   <td><?php echo round($b,2); ?> </td>

   


	 
	 
  </tr>

@endforeach 
</table>
	
	<div  style="height:10px;" id="btwo" >
    <div style="width:50%;float:left;" >
 <b>Date :</b><?php echo date("d/m/y") ;  ?>
    </div>

	    <div style="width:50%;float:left;" >
		<b>Print By:{{Auth()->user()->name}}</b>

    </div>

  </div>



</div>
<p>

</div>


			<?php if( $i < 2) { ?>
	<p style="page-break-after:always" ></p>
 <?php } } ?>
</body>
</html>