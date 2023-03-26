<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
<body>
<div id="c" >
<div id="head" >
<img    src="img/logo.jpg" >
<hr>
</div>

<div   >
    <div style="height:10px;" id="two" >
	

	
		    <div style="width:40%;float:left;" >
		<b><U>Money Paid Copy:</U></b> 
		 
    </div>


    <div style="width:60%; float:left;" >
    <b> Agent ID:</b> {{$agenttransaction->agentdetail_id}} <br>
    </div>

	


  </div>
  
  
  
      <div style="height:10px;" id="two" >
	

	
	    <div style="width:55%;float:left;" >
		<b>Agent Name:</b> {{$agenttransaction->agentdetail->name}}
		 
    </div>


	
    <div style="width:44%; float:left;" >
      <b> Patient Name :</b> {{$p}}
    </div>


	

  </div>
  
  
  
  
  
  
  
  
  
  
  
  
  


    <div style="height:10px;" id="two" >
	

	
	
<?php 	
	
	
if ($agenttransaction->transitiontype == 1)
					{
						$type= "Pathology Commission ";
					
					}
					
					elseif ($agenttransaction->transitiontype == 3)
					{
						$type= " Commission for surgery";
						
					}
					elseif ($agenttransaction->transitiontype == 4)
					{
						$type= " Commission for cabine fair";
						
					}
					elseif ($agenttransaction->transitiontype == 5)
					{
						$type= " Commission for the Patient got relased";
						
					}
					else
					{
						$type= " Not Applicable";
					return $type;	
					}
					

						
	
	
	
		if ($agenttransaction->paidorunpaid == 0)
				{
					
					 $status="Unpaid";
					
				}
								if ($agenttransaction->paidorunpaid == 1)
				{
					
					 $status="Paid";
					
				}
	
	
	
	
	
	
	
	
	
	?>
	
	
	    <div style="width:40%;float:left;" >
 <b>Commission For :</b>{{$type}} 
    </div>

	
		    <div style="width:34%;float:left;" >
<b>Amount:</b>  {{$agenttransaction->paidorunpaid}}
    </div>
	    <div style="width:20%;float:left;" >
 <b>Status :</b>{{$status}}
    </div>

  </div>


<?php if ($agenttransaction->comment) { ?>
      <div style="height:10px;" id="two" >


	    <div style="width:100%;float:left;" >
<b>Comment:</b> {{$agenttransaction->comment}}
    </div>

  </div>

<?php } ?>

  
  
      <div style="height:10px;" id="two" >

	
	    <div style="width:50%; float:left;" >
      <b>Date:</b> 
	  
	  <?php echo   $myDateTime = date('d/m/y h:i A', strtotime($agenttransaction->created_at) );   ?> 
    
	
	</div>
	

	    <div style="width:32%;float:left;" >
<b>Entry By:</b> {{$agenttransaction->user->name}}
    </div>

  </div>
  

</div>



</body>
</html>