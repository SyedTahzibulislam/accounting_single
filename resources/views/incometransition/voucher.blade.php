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
 
 
 
 
 <?php 

$sum=0;
$flag=0;
$due=0;
$totalsum=0;
$totaldue=0;
?>
</head>
<body style="font-family: Times New Roman;">
<div id="c" >
<div id="head" >
<img width="500px;"   src="img/logo.jpg" >
<hr>
</div>



 Income Source: {{$incomename}}

	  <br> Side Income Statemnet between date:
	   
	   <?php 
	     
	    $myDateTime = DateTime::createFromFormat('Y-m-d', $start);  echo  $myDateTime->format('d/m/Y'); ?> 
    
	   

	   to 
	   	   <?php 
   $myDateTime = DateTime::createFromFormat('Y-m-d', $datethatsentasenddatefromcust);  echo  $myDateTime->format('d/m/Y');
	   ?>
	   
	


     







<table>






<thead>
  <tr>
     

 
  <th> Trans ID </th>

    <th style="width:400px;" >
	
Income Source
    
	 </th>
	  <th style="width:100px;"  >Amount </th>
        <th style="width:100px;"  >Total </th>
	 <th style="width:100px;"  >Due </th>
	  <th style="width:100px;"  >Total Due </th>
		  <th style="width:100px;"  >Date </th> 
	

  </tr>
  </thead>
 @foreach ( $income as $o )

 <?php if ($o->externalincomesource->id == $t ) { 
 
 
 if ($o->externalincomesource->parent_id == $t ){
	$firtson = array();
$firtson[] = $o->externalincomesource->id;


	 
	 
 }
 
 ?>

  <tr>
   
     <td> 
	 <?php if ($o->externalincomesource->id  ) { ?>
	{{ $o->id }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
</td>






     <td> 
	 
	 
	 
	 	 <?php if ($o->externalincomesource ) { ?>
	{{ $o->externalincomesource->path }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
	 
	 
	 
	 

</td>

    <td> 
	{{ $o->amount }}
</td>
 


  	<?php  
	
	if ($flag == $o->externalincomesource->id    )
	{
	$sum = $sum +  $o->amount ;
	$due = $due + $o->due ;
	$color= "normal";
	}
	else 
	{
		$sum =   $o->amount ;
		$due =  $o->due ;
		$color = "red";
	}
$flag = $o->externalincomesource->id;

$totalsum= $totalsum+ $o->amount;
$totaldue = $totaldue+ $o->due;
	?>



     
<?php if($color == "red") { ?>	<td style="color:red;">{{ $sum }}</td> <?php } else{  ?>
		
<td >{{ $sum }}</td>
<?php } ?>

    <td> 
	{{ $o->due }}
	
</td>

<?php if($color == "red") { ?>	<td style="color:red;">{{ $due }}</td> <?php }  else{ ?>
     

 
<td >{{ $due }}</td>
<?php } ?>

<td > {{ Carbon\Carbon::parse($o->created_at)->format('d/m/Y , h:i:sa') }} </td>	 
	 







   


	 
	 
  </tr>

 <?php } ?>
@endforeach 
</table>
	
<p>










<table>






<thead>
  <tr>
     

 
  <th> Trans ID </th>

    <th style="width:400px;" >
	
 Name
    
	 </th>
	  <th style="width:100px;"  >Amount </th>
     <th style="width:100px;"  >Total </th>
	 <th style="width:100px;"  >Due </th>
	  <th style="width:100px;"  >Total Due </th>
		  <th style="width:100px;"  >Date </th> 
	

  </tr>
  </thead>
 @foreach ( $income as $o )

 <?php




 if ($o->externalincomesource->parent_id == $t ) { ?>

  <tr>
   
     <td> 
	 <?php if ($o->externalincomesource->id  ) { ?>
	{{ $o->id }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
</td>









     <td> 
	 
	 
	 
	 	 <?php if ($o->externalincomesource ) { ?>
	{{ $o->externalincomesource->path }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
	 
	 
	 
	 

</td>

    <td> 
	{{ $o->amount }}
</td>
 

 	<?php  
	
	if ($flag == $o->externalincomesource->id    )
	{
	$sum = $sum +  $o->amount ;
	$due = $due + $o->due ;
	$color= "normal";
	}
	else 
	{
		$sum =   $o->amount ;
		$due =  $o->due ;
		$color = "red";
	}
$flag = $o->externalincomesource->id;
$totalsum= $totalsum+ $o->amount;
$totaldue = $totaldue+ $o->due;
	?>



     
<?php if($color == "red") { ?>	<td style="color:red;">{{ $sum }}</td> <?php } else{  ?>
		
<td >{{ $sum }}</td>
<?php } ?>

    <td> 
	{{ $o->due }}
	
</td>

<?php if($color == "red") { ?>	<td style="color:red;">{{ $due }}</td> <?php }  else{ ?>
     

 
<td >{{ $due }}</td>
<?php } ?>

<td > {{ Carbon\Carbon::parse($o->created_at)->format('d/m/Y , h:i:sa') }} </td>	 
	 
 







   


	 
	 
  </tr>

 <?php } ?>
@endforeach 
</table>



<p>




<table>






<thead>
  <tr>
     

 
  <th> Trans ID. </th>

    <th style="width:400px;" >
	
Expenses Name
    
	 </th>
	  <th style="width:100px;"  >Amount </th>
   
	
	

    <th style="width:100px;"  >Total </th>
	 <th style="width:100px;"  >Due </th>
	  <th style="width:100px;"  >Total Due </th>
		  <th style="width:100px;"  >Date </th>
	
	
	
	

  </tr>
  </thead>
 @foreach ( $income as $o )

 <?php




 if ($o->externalincomesource->secondparent_id == $t ) { ?>

  <tr>
   
     <td> 
	 <?php if ($o->externalincomesource->id  ) { ?>
	{{ $o->id }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
</td>











     <td> 
	 
	 
	 
	 	 <?php if ($o->externalincomesource ) { ?>
	{{ $o->externalincomesource->path }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
	 
	 
	 
	 

</td>

    <td> 
	{{ $o->amount }}
</td>
 


 
 
 	<?php  
	
	if ($flag == $o->externalincomesource->id    )
	{
	$sum = $sum +  $o->amount ;
	$due = $due + $o->due ;
	$color= "normal";
	}
	else 
	{
		$sum =   $o->amount ;
		$due =  $o->due ;
		$color = "red";
	}
$flag = $o->externalincomesource->id;
$totalsum= $totalsum+ $o->amount;
$totaldue = $totaldue+ $o->due;
	?>



     
<?php if($color == "red") { ?>	<td style="color:red;">{{ $sum }}</td> <?php } else{  ?>
		
<td >{{ $sum }}</td>
<?php } ?>

    <td> 
	{{ $o->due }}
	
</td>

<?php if($color == "red") { ?>	<td style="color:red;">{{ $due }}</td> <?php }  else{ ?>
     

 
<td >{{ $due }}</td>
<?php } ?>

<td > {{ Carbon\Carbon::parse($o->created_at)->format('d/m/Y , h:i:sa') }} </td>	 
	 






   


	 
	 
  </tr>

 <?php } ?>
@endforeach 
</table>

<P>





<table>






<thead>
  <tr>
     

 
  <th> ID </th>

    <th style="width:150px;" >
	
Expenses Name
    
	 </th>
	 
	 
	  <th style="width:100px;"  >Amount </th>
    <th style="width:100px;"  >Total </th>
	 <th style="width:100px;"  >Due </th>
	  <th style="width:100px;"  >Total Due </th>
		  <th style="width:100px;"  >Date </th>

  </tr>
  </thead>
 @foreach ( $income as $o )

 <?php




 if ($o->externalincomesource->thirdparent_id == $t ) { ?>

  <tr>
   
     <td> 
	 <?php if ($o->externalincomesource->id  )    { ?>
	{{ $o->id }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
</td>










     <td> 
	 
	 
	 
	 	 <?php if ($o->externalincomesource ) { ?>
	{{ $o->externalincomesource->path }}
	
	 <?php } else { ?>
	 
	 NA
	 
	 <?php } ?>
	 
	 
	 
	 

</td>

    <td> 
	{{ $o->amount }}
	

	
	
</td>
 
 	<?php  
	
	if ($flag == $o->externalincomesource->id    )
	{
	$sum = $sum +  $o->amount ;
	$due = $due + $o->due ;
	$color= "normal";
	}
	else 
	{
		$sum =   $o->amount ;
		$due =  $o->due ;
		$color = "red";
	}
$flag = $o->externalincomesource->id;
$totalsum= $totalsum+ $o->amount;
$totaldue = $totaldue+ $o->due;
	?>



     
<?php if($color == "red") { ?>	<td style="color:red;">{{ $sum }}</td> <?php } else{  ?>
		
<td >{{ $sum }}</td>
<?php } ?>

    <td> 
	{{ $o->due }}
	
</td>

<?php if($color == "red") { ?>	<td style="color:red;">{{ $due }}</td> <?php }  else{ ?>
     

 
<td >{{ $due }}</td>
<?php } ?>

<td > {{ Carbon\Carbon::parse($o->created_at)->format('d/m/Y , h:i:sa') }} </td>	 
	 
  </tr>

 <?php } ?>
@endforeach 
</table>

 Total: {{$totalsum}} TK <br>
 Total Due: {{$totaldue}} TK




</div>
<p>

</div>


			<?php if( $i < 2) { ?>
	<p style="page-break-after:always" ></p>
 <?php } } ?>
</body>
</html>