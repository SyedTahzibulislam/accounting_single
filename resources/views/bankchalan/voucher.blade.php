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
      <b><u>Money Receipt</u></b>
    <?php } if ( $i == 1){ ?>
	  <b>office's Copy  </b>
	  <?php } if ( $i == 2){ ?>
	 <b> Accountant's Copy  </b>
	  <?php } ?>
	</div>
    <div style="width:40%;float:left;" >
 <b>Type :</b> {{$type}}
    </div>

	    <div style="width:30%;float:left;" >
		<b>Bank Trans ID :</b> {{$Bankchalan->id}}

    </div>

  </div>


    <div style="height:10px;" id="two" >
    <div style="width:40%; float:left;" >
      <b> {{$type}} By :</b> {{$from}}
    </div>

	
	    <div style="width:26%;float:left;" >
 <b>Bank Name:</b> {{$bankname}}
    </div>

	
	
	    <div style="width:34%;float:left;" >
<b>Amount: </b> {{$Bankchalan->amount}} TK
    </div>

  </div>
     

    <div style="height:10px;" id="two" >


	
	
	    <div style="width:34%;float:left;" >
<b>Comment: </b> {{$Bankchalan->description}} 
    </div>

  </div>
 
  
  
  
  
  
  
 <br> 




	
	<div  style="height:10px;" id="btwo" >
    <div style="width:50%;float:left;" >
 <b>Date :</b><?php echo date("d/m/y") ;  ?>
    </div>

	    <div style="width:50%;float:left;" >
		<b>Entry By:</b>{{$username}}

    </div>

  </div>



</div>








</div>


			<?php if( $i < 2) { ?>
	<p style="page-break-after:always" ></p>
 <?php } } ?>
</body>
</html>