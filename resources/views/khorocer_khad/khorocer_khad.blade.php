

@extends('layout.main')

@section('content')




 
 






</head>






<body>




		<div  class="container" style="background-color:#EEE8AA; "  >
		<h2>Expenses Category</h2>
  <span id="form_result"></span>
	
		<form method="post" action="{{ route('khorocer_khad.store') }}"   id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		   
		   

			 
			 <div class="row">
			 			 <div class="col-4" >
			Expenses Name:   <input type="text" autocomplete="off"  name="expensesname" id="expensesname" class="form-control numbers  expensesname" required  />
			
			</div>
			 
   <input type="hidden" value="1"  name="mark" id="mark" class="form-control numbers  mark" required  />
		

		
	
   <input type="hidden"   name="firstparentid" id="firstparentid" class="form-control numbers  firstparentid" required  />
			

	
   <input type="hidden"   name="parentid" id="parentid" class="form-control numbers  parentid" required  />
			
	 <input type="hidden"   name="second" id="second" class="form-control numbers  second" required  />


 <input type="hidden"   name="third" id="third" class="form-control numbers  third" required  />
	 
			 </div>
			 <div id="formhide" class="table-responsive">
			
			 <table   class="table" id="products_table">
                <thead>
                    <tr>
                        <th>Category</th>
			
						
                    </tr>
                </thead>
                <tbody class="addmoreproduct">
                    <tr id="product0">
                        <td>
       <select id="medicine_name"  class="form-control medicine_name"  name="medicine_name[]"     style='width: 200px;'>  
  
		</select>
                        </td>
						
			
						
						

					
	
						
						
                    </tr>
                    <tr id="product1"></tr>
                </tbody>
            </table>
			 
			 
			 
			 
			 
			 
			
		   <div id="child"> 
		   
		   </div>
		   
		   
		   <button type="button" id="add_row" class="btn btn-primary">ADD Next Level of Category</button>
		   
		   
		   
	
		   	
			
	
        
   
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action"  value="Add" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>
	</div>
			   <span id="form_result_footer"></span>  
<p>



</div>	















<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-6" >
    <h6 style="color:red;">আপনি এখানে প্রতিষ্ঠানের খরচের খাতসমূহ দেখতে পারবেন। চাইলে ইডিট বা ডিলিট ও করতে পারবেন। নতুন করে কোন খরচের খাত তৈরি করতে ADD Button  এ ক্লিক করুন । </h6>
    <a style="float:right; margin-bottom:20px;" class="btn btn-success" href="javascript:void(0)" id="create_record"> Add New </a>
	
	
	<div class="table-responsive">
    <table id="patient_table"  class="table  table-success table-striped data-tablem">
        <thead>
            <tr>
	
			<th>ID</th>
			<th>No</th>
                <th>Name</th>
				<th>Path</th>
				
				
			     
             
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody   >

        </tbody>
    </table>
	</div>
</div>
</div>
</div>



<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" > Name : </label>
            <div class="col-md-8">
             <input type="text" name="name" id="name" class="form-control" />
            </div>
           </div>
           
   
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>
        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>





 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  


<script type="text/javascript">


$(document).ready(function(){




     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	



    var table = $('#patient_table').DataTable({
		
	
		
        processing: true,
        serverSide: true,
		responsive: true,
	
        ajax: "{{ route('khorocer_khad.index') }}",
        columns: [
		
		 {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
			 {data: 'path', name: 'path'},
			    
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });






















	
	
/////////////////////////////// Replace non deimal number 
/////////////////////////////// Replace non deimal number 
$('.addmoreproduct').delegate('.numbers','change',function(){


    this.value = this.value.replace(/[^0-9\.]/g,'');
});	
	
fetch();





 $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

        var allFields = document.querySelectorAll(".form-control");

        for (var i = 0; i < allFields.length; i++) {

            allFields[i].addEventListener("keyup", function(event) {

                if (  (event.keyCode === 13) || (event.keyCode === 40) ) {
                    console.log('Enter clicked')
                    event.preventDefault();
                    if (this.parentElement.nextElementSibling.querySelector('input')) {
                        this.parentElement.nextElementSibling.querySelector('input').focus();
                    }
                }
				
				
				                if (event.keyCode === 38) {
                    
                    event.preventDefault();
                    if (this.parentElement.previousElementSibling.querySelector('input')) {
                        this.parentElement.previousElementSibling.querySelector('input').focus();
                    }
                }
				
            });

        }









	///// clear modal data after close it 
$(".modal").on("hidden.bs.modal", function(){
    $("#category").html("");
	
	  $(".medicine_name").val("");
	   $("#child").html("");

   $(".customer_id").html("");
   $(".unit_price").val(0);
  $(".quantity").val('');
  $(".vat").val(0);   
 $(".discount").val(0);   
  $(".paid").val(0); 
   $(".due").val(0); 
    $(".adjust").val(0); 
	$(".amount").val(0); 
	$(".totalamount").val(0); 
  



 $("#products_table tr:gt(1)").remove(); // remove all row whose index is greater than 1



 
 
  
	
 

	

});
///////////////////////////////
	

	
	
  $("#category").select2();
  
  $("#customer_name").select2();
    $("#customer_mobile").select2();
	  $("#customer_id").select2();
	    $('.medicine_name').select2();
 $('.unit').select2();		 

       $("#cusname").hide();
	  $("#cusmobile").hide();


  
  
  
    $("#cid").click(function(){
     $("#cusname").hide();
	  $("#cusmobile").hide();
    $("#cusid").show();

  });
  
  
    $("#cname").click(function(){

	  $("#cusmobile").hide();
    $("#cusid").hide();
	$("#cusname").show();

  });
  
  
      $("#cmobile").click(function(){

    $("#cusid").hide();
	$("#cusname").hide();
	$("#cusmobile").show();

  });
  
  
  





    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	
                     

function fetch()
{

 $.ajax({
   url:"khorocer_khad/dropdownlist",
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
	
	
					

					///////////////////////   set first option value ///////////////////
					
						  $("#medicine_name").html("");
					
					var optionformedicine = "<option  ></option>"; 
               	$("#medicine_name").append(optionformedicine);
					
					
					///////////////////////   set dynamic select option values from Database ///////////////////
					
					
					                    var len = 0;
                    if (response.expenseslist != null) {
                        len = response.expenseslist.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.expenseslist[i].id;
                             var name = response.expenseslist[i].name;
							 
					        
                             
				//////////////////////////////////// Set user dfeined atribute data-price//////			 
							 var optionformedicine = "<option     value='"+id+"'>"+name+"</option>"; 
							 /////////////////////////////////////////////////////////////
							 
					


							   

                             $("#medicine_name").append(optionformedicine);
							  
                        }
                    }
               





					



			   }
				
				
	//////////////////////////////////////////////////////////////////////////////
  })

 	
	
}



function refresh(){
	
$('#sample_form')[0].reset();

fetch();
$("#products_table tr:gt(1)").remove();

 $('.medicine_name').select2();	
 $('.unit').select2();		
}







///////////////////////////////// insert value in unit price /////////////////////

$('.addmoreproduct').delegate('.medicine_name','change',function(){
	
	console.log('click');
	
	var tr= $(this).parent().parent();
	
	
	
	var parent = tr.find('.medicine_name option:selected').val();
	 tr.find(".medicine_name").prop("disabled",true); 
		$("#parentid").val(parent);
var mark=	 parseFloat($("#mark").val());


	
		if (mark == 1)
	{
	$("#firstparentid").val(parent);	

	}
	
	
	if (mark == 2)
	{

	$("#second").val(parent);	
		
	}
	
	
	
	
		if (mark == 3)
	{
	
		$("#third").val(parent);	
	}

	mark= mark+1;
	$("#mark").val(mark);

});


////////////////////////////////////////keyup//////////////////////////////


















































  $("#percentofdicountontaotal").change(function(){
     this.value = this.value.replace(/[^0-9\.]/g,'');
	 totalamount();


  });










/////////////////////////////////////// Remove row ////////////////////////


$('.addmoreproduct').delegate('.remove','click',function(){ 
var rowCount = $('table#products_table tr:last').index() + 1; // find out the length of the row 
console.log(rowCount);

 
 
   var rowindex = $(this).closest('tr').index();  // find out the index number of the row 
    
 if (rowindex > 0 )
 {
$(this).parent().parent().remove();
  totalamount();
 }

 });



  /////////////////////////////////ADD Data //////////////////////////// 
   
   

$('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('khorocer_khad.store') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#sample_form')[0].reset();
      $('#patient_table').DataTable().ajax.reload();
	  $("#firstparentid").val('');	
	    $("#parentid").val('');
	    $("#second").val('');	
		  $("#third").val('');	
		    $("#mark").val(1);	
	  
     }
	 
	      if(data.error)
     {
      html = '<div class="alert alert-danger">' + data.error + '</div>';
      $('#sample_form')[0].reset();
      $('#patient_table').DataTable().ajax.reload();
     }
	 $(".medicine_name").prop("disabled",false); 
$('#form_result').html(html);

$('#form_result').fadeIn();
$('#form_result').delay(1500).fadeOut();

$('#form_result_footer').html(html);

$('#form_result_footer').fadeIn();
$('#form_result_footer').delay(1500).fadeOut();



fetch();


 $("#products_table tr:gt(1)").remove();
 
 //remover por select2 dite hobe 
 $('.medicine_name').select2();
	
	 
	 
	 
	 
    }
   })
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('patientlist.update') }}",
    method:"POST",
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#sample_form')[0].reset();
      $('#store_image').html('');
      $('#patient_table').DataTable().ajax.reload();
     }
     $('#form_result').html(html);
    }
   });
  }
 });
 







 /////////////////////////////////////// Dynamically Add New row and Add New select2 for dynamically added new medicine name  ////////////////////////
 

  let row_number = 1;
    $("#add_row").click(function(e){
		
		
		      e.preventDefault();
      let new_row_number = row_number - 1;
	  
	  	   $latest_tr  = $('#product0');
   
     $latest_tr.find(".medicine_name").each(function(index)
    {
        $(this).select2('destroy');
		
		
    }); 
	
 $latest_tr  = $('#product0');
	  
      $('#product' + row_number).html($('#product0' ).html()).find('td:first-child');
	  
	    	  
      $('.addmoreproduct').append('<tr id="product' + (row_number + 1) + '"></tr>');
     

	 
	 
	 
	 
	 
	 
	 $latest_tr  = $('#product' + row_number);
	 $latest_tr.find(".medicine_name").prop("disabled",false); 
var id = $('#parentid').val();





 $.ajax({
   url:"khorocer_khad/dropdownlistforchild/"+id,
   dataType:"json",
   

   ////////////////////fetch data for dropdown menu 
success:function (response) {
	
 console.log("AA");	
					

					///////////////////////   set first option value ///////////////////
					
						  $latest_tr.find(".medicine_name").html("");
					
					var optionformedicine = "<option  ></option>"; 
               $latest_tr.find(".medicine_name").append(optionformedicine);
					
					
					///////////////////////   set dynamic select option values from Database ///////////////////
					
					
					                    var len = 0;
                    if (response.expenseslistchild != null) {
                        len = response.expenseslistchild.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.expenseslistchild[i].id;
                             var name = response.expenseslistchild[i].name;	 
							 var optionformedicine = "<option     value='"+id+"'>"+name+"</option>"; 
                              $latest_tr.find(".medicine_name").append(optionformedicine);
							  
                        }
                    }



			   }
				
				
	//////////////////////////////////////////////////////////////////////////////
  })




























	 row_number++;
     

 
     
    
  $('.medicine_name').select2(); 
 
    
	
	
	});
 
 

//////////////////////////////////////// code to read selected table row cell data (values) to print invoice


    
    $("#patient_table").on('click','.btnSelect',function(){
		
	


		
		
         // get the current row
         var currentRow=$(this).closest("tr"); 
		 
		 
		 	var e= currentRow.find("td .n").text();
		console.log(e);
		 
		          var order_no =currentRow.find("td:eq(0)").text();
         
         var seller_name =currentRow.find("td:eq(1)").text();
		 // get current row 2nd  TD value
         var patient_name =currentRow.find("td:eq(2)").text(); 
		 var paid =currentRow.find("td:eq(3)").text(); 
		 var due =currentRow.find("td:eq(4)").text(); 
		 var date =currentRow.find("td:eq(5)").text();             
		   var totalinvoiceMPR =currentRow.find("td:eq(6)").text(); 
		  var totalinvoicediscount =currentRow.find("td:eq(7)").text(); 
		  var totalvoicevat =currentRow.find("td:eq(8)").text(); 
		   var totalinvoice_total_amount_including_vat_discount  =currentRow.find("td:eq(9)").text(); 
		 
		 
		
         var producttable=currentRow.find("td:eq(11)").html(); // get current row 8th TD
		          
		        
				 
				 
					
					
				
				
					
					
					
         
		 $('#invoicepatientname').html(patient_name);
		 $('#invoicepatientdue').html(due);
		 $('#invoicevat').html(totalvoicevat);
		 $('#invoicepatienttotal').html(totalinvoice_total_amount_including_vat_discount);
		 $('#invoicepatientdiscount').html(totalinvoicediscount);
		  $('#invoicepatientdate').html(date);
		  $('#invoicepatientorderno').html(order_no);
		   $('#invoicepatientseller').html(seller_name);
		     $('#invoicepatientmpr').html(totalinvoiceMPR);
		   
	  

		 $('#m').html(producttable);
       
    });


 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"khorocer_khad/destroy/"+user_id,
   beforeSend:function(){
    $('#ok_button').text('Deleting...');
   },
   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#user_table').DataTable().ajax.reload();
    }, 2000);
	
	      $('#patient_table').DataTable().ajax.reload();
		   $('#ok_button').text('Delete');
		   fetch();
   }
  })
 });





});
</script>
	  


@stop