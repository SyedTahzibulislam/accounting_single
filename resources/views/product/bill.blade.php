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

</head>
<body style="font-family: Times New Roman;">
<div id="c" >
<div id="head" >
<img width="500px;"   src="img/logo.jpg" >
<hr>
</div>



    <div style="height:10px;" id="one" >
    <div style="width:30%; float:left;" >

      <b><u>Sale's Report:</u></b>

	</div>




  </div>


    <div style="height:10px;" id="two" >
    <div style="width:40%; float:left;" >
      <b>Customer Name :  {{$customer}}    </b> 
    </div>

	


	


  </div>
     


  
 <b>Transition: From  <?php echo date('d/m/Y ', strtotime($start)); ?> to <?php echo date('d/m/Y ', strtotime($e)); ?> </b><p>

  
  
  
 <br> 




<table>

<thead>
  <tr>
     
	
 <th style="width:40px;" >	Product Name</th>
  
    <th style="width:100px;" >
	
Unit 
    
	 </th>
	  <th style="width:100px;"  > Qun.  </th>
    <th style="width:100px;"  >Qun.(Base) </th>
	<th style="width:100px;"  > Gross Amnt. </th>
<th style="width:100px;"  > Dis. </th>
<th style="width:100px;"  > Receiveable Amnt. </th>
  </tr>
  </thead>
 @foreach ( $producttransition as $p )
 <tr>
 <td>{{$p->Product->name}} </td>
 <td>{{$p->unitcoversion->name}} </td>
   <td><?php echo round($p->quantity,2); ?> </td>
   <td><?php echo round($p->quantityinbase,2); ?> </td>
    <td><?php echo round($p->amount,2); ?> </td>  
    <td><?php echo round($p->discount,2); ?> </td>
    <td><?php echo round($p->finalamountafterdiscount,2); ?> </td>
	 
	 
  </tr>

@endforeach 
</table>
	
	
	
	
	<p>
	
<b> Return Product from Customer </b> 


<table>






<thead>
  <tr>
     
	
 <th style="width:40px;" >	Product Name</th>
  
    <th style="width:100px;" >
	
Unit 
    
	 </th>
	  <th style="width:100px;"  > Qun.  </th>
    <th style="width:100px;"  >Qun.(Base) </th>
	<th style="width:100px;"  > Gross Amnt. </th>
<th style="width:100px;"  > Dis. </th>
<th style="width:100px;"  > Return Amnt. </th>
  </tr>
  </thead>
 @foreach ( $returnproduct as $p )
 <tr>
 <td>{{$p->Product->name}} </td>
 <td>{{$p->unitcoversion->name}} </td>
   <td><?php echo round($p->quantity,2); ?> </td>
   <td><?php echo round($p->quantityinbase,2); ?> </td>
    <td><?php echo round($p->amount,2); ?> </td>  
    <td><?php echo round($p->discount,2); ?> </td>
    <td><?php echo round($p->finalamountafterdiscount,2); ?> </td>
	 
	 
  </tr>

@endforeach 
</table>	
	
	
	
	
	
	
	
	
	
	
	
	<p>
	
	
	
	
	
	
	<b> Product Stock </b>
	
	
	
	
	<table>






<thead>	
  <tr>
     
	
 
  
    <th style="width:150px;" >
	
	  Product Name
    
	 </th>
	  <th style="width:100px;"  >Go-Down</th>
    <th style="width:100px;"  >For Sale</th>
  <th style="width:100px;"  >Total</th>

  </tr>
  </thead>	
 @foreach ( $product as $p )



  <tr>
 
 
 
 
 
 
  <td> {{$p->name  }} </td>
 
  <td><?php   $s = $p->stock; echo round($p->stock ,2); ?> </td>
 
 
 
    <td> 

<table>
  <thead>
  <tr>
    <th style="width:100px;" >Unit Name </th>
    <th>Qun.</th>
	<th>KG/Piece </th>
    
  </tr>
    </thead>

 
 @foreach ( $p->productpriceaccunit as $t )
  <tr>

 <td> {{ $t->unitcoversion->name }} </td>

   <td>{{ $t->stock }}     </td> 
   <td> <?php $amnt=  $t->stock * $t->unitcoversion->coversionamount ; $s= $s+$amnt;  ?> {{ $amnt }}    </td> 
	 

	 
	 
  </tr>
@endforeach 




</table>

</td>
  
  <td><?php echo round($s ,2); ?> </td>







	 
	 
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



</body>
</html>