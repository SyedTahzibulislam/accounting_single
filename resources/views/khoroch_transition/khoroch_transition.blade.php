

@extends('layout.main')

@section('content')




 <style>
.modal-lg {
    max-width: 90% !important;

}


</style>
 






</head>

  
 






<body>



<div class="container" style="background-color:#EEE8AA; "          >

 
           <form method="post"  action="{{ route('khorochtransition.store') }}"   id="sample_form" class="form-horizontal  sample_form" enctype="multipart/form-data">
          @csrf
		  
		  
		  		<div  class="container" style="background-color:#EEE8AA; "  >
		<h2>Expenses Category</h2>
  <span id="form_result"></span>
	
		<form method="post" action="{{ route('expenses.store') }}"   id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		   
		   

			 
			 <div class="row">

			 
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
		   
		   
		   
	
		   	
			
	
        
   

	</div>
			 
<p>



</div>
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		   <div class="row">

    <div class="col-3">
 সাপ্লাইয়ারের নাম   :  <select id="supplier"  class="form-control supplier"  name="supplier"  required   style='width: 270px;'>
    </select>
    </div>
    <div class="col-3">
     মোট ক্রয়কৃত পণ্য/সেবার  মূল্য     : 	<input type="text" value="0"  autocomplete="off"  name="amount" id="amount" class="form-control amount" required  />
    </div>
	
	
	    <div class="col-3">
বাকি     : 	<input type="text"  autocomplete="off"  name="due" id="due" class="form-control  due" required  />
    </div>
	  </div>
	
<div class="row">

<div class="col-3">
Date:  <input type="date"  required id="datePicker" name="Date_of_Transition" class="form-control" />
</div>	
 </div>
<p> 
	  
	  
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action"    value="Add"  />
            <input type="hidden" name="hidden_id" id="hidden_id" />
			 <span id="form_resultfooter"></span>
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>	
	
	
	

</div>
















<input type="hidden" id="balance" name="balance" value="{{$balance->balance}}">
<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-6" >
    <h6 style="color:red;"> প্রতিষ্ঠানের জন্য ক্রয়কৃত সেবা / পণ্যের চালানের তথ্য নিচে টেবিলে দেয়া আছে। নতুন করে কোন পণ্য বা সেবা কিনতে ADD Record বাটনে ক্লিক করুন </h6>
  
	
	
	<div class="table-responsive">
    <table id="patient_table"  class="table  table-success table-striped data-tablem">
        <thead>
            <tr>
<th>নং </th>
			<th>পণ্য/সেবা/খরচের নাম </th>
			
			<th> সাপ্লাইয়ারের নাম  </th>
			<th> এন্ট্রি বাই   </th>
			
			<th>মোট মূল্য  </th>
			<th> বাকি থাকা টাকার পরিমান   </th>
			
			<th> ট্রাঞ্জিশনের তারিখ  </th>
			<th>Action </th>
				
			
				
    
				
				
			     
             
                
            </tr>
        </thead>
        <tbody   >
        
        </tbody>
    </table>
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





 




<script type="text/javascript">


$(document).ready(function(){
	
	
	Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
$('#datePicker').val(new Date().toDateInputValue());
	
  $("#khorocer_khad").select2();   
 $("#supplier").select2();   
  $("#medicine_name").select2(); 
 


///////////////////////////////







////////////////////////////////////////////////////// 



   













     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	



    var table = $('#patient_table').DataTable({
		
	
		
        processing: true,
        serverSide: true,
		responsive: true,
	
        ajax: "{{ route('khorochtransition.index') }}",
	
        columns: [
		
		 
		 
		  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	
			
			   
			   {data: 'khorocer_name', name: 'khorocer_khad.name'},
			  {data: 'supplier_name', name: 'supplier.name'},
{data: 'entryby', name: 'User.name'},
			   
			  
			 
			  {data: 'amount', name: 'amount'},
			 
			  {data: 'due', name: 'due'},
			 
		
           {data: 'created_at', name: 'created_at'},
	
			   {data: 'action', name: 'action', orderable: false, searchable: false},

 

			    
           
        ]
    });


   fetchdata();
   

 
 
 
 
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
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 function fetchdata(){
	 
	   $.ajax({
   url:"khorochtransition/dropdown_list",
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
	
 	 $("#khorocer_khad").html("");  
	$("#supplier").html("");   
	
	
	
	var optionforkhorocer_khad = "<option  value='' >select one</option>"; 
					   $("#khorocer_khad").append(optionforkhorocer_khad);
	
	
                    var len = 0;
                    if (response.khorocer_khad != null) {
                        len = response.khorocer_khad.length;
                    }
                       
                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.khorocer_khad[i].id;
                             var name = response.khorocer_khad[i].name;
							

                             var optionforkhorocer_khad = "<option    value='"+id+"'>"+name+"</option>"; 
							

                             $("#khorocer_khad").append(optionforkhorocer_khad);
                        }
                    }
					
					
						var optionforsupplier = "<option >select one</option>"; 
					   $("#supplier").append(optionforsupplier);
					
					
					
					                    var len = 0;
                    if (response.supplier != null) {
                        len = response.supplier.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.supplier[i].id;
                             var name = response.supplier[i].name;
						

                             var optionforsupplier = "<option     value='"+id+"'>"+name+"</option>"; 
							

                             $("#supplier").append(optionforsupplier);
                        }
                    } 

 }	//////////////////////////////////////////////////////////////////////////////
  })
 
 }
 
 fetchcate();
 function fetchcate()
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
 
















	









 
 
 

 


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
   
   
  /////////////////////////////////ADD Data //////////////////////////// 
   
   

$('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
  
   $.ajax({
    url:"{{ route('khorochtransition.store') }}",
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
		 
	$('#sample_form')[0].reset();
      $('#patient_table').DataTable().ajax.reload();
	  fetchdata();
	  
	       html = '<div class="alert alert-success">' + data.success + '</div>';

	
      $('#patient_table').DataTable().ajax.reload();
 $('#datePicker').val(new Date().toDateInputValue());
     }
     $('#form_result').html(html);
	 	 $(".medicine_name").prop("disabled",false);
	  $('#form_resultfooter').html(html);
	 	$("#form_result").show().delay(5000).fadeOut();
			$("#form_resultfooter").show().delay(5000).fadeOut();
			 $("#products_table tr:gt(1)").remove();
	 fetchcate();
	  //remover por select2 dite hobe 
 $('.medicine_name').select2();
    }
   })
  
  
  
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('khorochtransition.update') }}",
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
	   $('#datePicker').val(new Date().toDateInputValue());
     }
     $('#form_result').html(html);
	  $('#form_resultfooter').html(html);
	 	$("#form_result").show().delay(5000).fadeOut();
			$("#form_resultfooter").show().delay(5000).fadeOut();
	      $('#action').val("Add");
		   $('#action_button').val("Add");  
		  
	 	     $("#khorocer_khad").select2();   
 $("#supplier").select2(); 
       fetchdata();
	
    }
   });
  }
 });
   
   $(document).on('click', '.edit', function(){
	  
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url:"/khorochtransition/"+id+"/edit",
   dataType:"json",
   success:function(html){
	   
	 	 $("#khorocer_khad").html("");  
	$("#supplier").html("");   
	   
	
	var len = html.khorocer_khad.length;
	console.log(len);
	var presentkhoroc = html.khoroch_transition.khorocer_khad_id;

	
	
		                        for (var i = 0; i<len; i++) {
								
								if ( presentkhoroc == html.khorocer_khad[i].id  ) 
								{
									var id = html.khorocer_khad[i].id;
                             var name = html.khorocer_khad[i].name;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#khorocer_khad").append(option);
								}
                             
                        }
						
						
							                        for (var i = 0; i<len; i++) {
								
								if ( presentkhoroc != html.khorocer_khad[i].id ) 
								{
			                 var id = html.khorocer_khad[i].id;
                             var name = html.khorocer_khad[i].name;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#khorocer_khad").append(option);
								}
                             
                        }
						
				


		/////////////////////////  fetch for patientlist 				
		
						var len = html.supplier.length;
	
	var presentsupplier = html.khoroch_transition.supplier_id;

	
	
		                        for (var i = 0; i<len; i++) {
								console.log('A' );
								if ( presentsupplier == html.supplier[i].id  ) 
								{
									var id = html.supplier[i].id;
                             var name = html.supplier[i].name;

                             var optionforsupplier = "<option value='"+id+"'>"+name+"</option>"; 
                              console.log(option);
                             $("#supplier").append(optionforsupplier);
								}
                             
                        }
						
						
							                        for (var i = 0; i<len; i++) {
								
								if ( presentsupplier != html.supplier[i].id  ) 
								{
									var id = html.supplier[i].id;
                             var name = html.supplier[i].name;

                             var optionforsupplier = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#supplier").append(optionforsupplier);
								}
                             
                        }
	                        
	
	




$('#unit').val(html.khoroch_transition.unit);						
$('#unit_price').val(html.khoroch_transition.unit_price);						
$('#amount').val(html.khoroch_transition.amount);						
$('#due').val(html.khoroch_transition.due);												
$('#datePicker').val(html.khoroch_transition.created_at);	

   
	$('#hidden_id').val(html.khoroch_transition.id);
    $('.modal-title').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
   
   }
  })
 });
 
 
 

 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"khorochtransition/destroy/"+user_id,
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
	     $("#khorocer_khad").select2();   
 $("#supplier").select2(); 
       fetchdata(); 	 
   }

  })
 });

   
   
   



   
   
   
   
   
   
   
   
   
   
   
   
   
  
	 
	 
	 
	 
	 
	 

	 
	 






 
 $(document).on('click', '#close', function(){
$('#formModal').modal('hide');

 });


});
</script>
	  


@stop