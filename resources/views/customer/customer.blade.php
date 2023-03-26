

@extends('layout.main')

@section('content')




 
 






</head>

  
 






<body>



<div class="container"   style="background-color:#EEE8AA; "  >

  
  
          <form  method="post" id="sample_form" action="{{route('customer.store')}}" class="form-horizontal" enctype="multipart/form-data"  onsubmit="event.preventDefault()">
		
		@csrf
	
	  <div class="row">
    <div class="col-4">
    AreaCode 	<select id="areacode"  class="form-control "  name="areacode"  required   style='width: 270px;'>
  
   </select>
    </div>
    <div class="col-4">
      Customer Name:			  
			  <input type="text" class="form-control register_form " name="name" id="name"  placeholder="Enter Name" autocomplete="off">
           
    </div>
    <div class="col-4">
     Customer code:      
			   <input type="text" class="form-control register_form " name="customercode" id="customercode" placeholder="customercode" autocomplete="off">
    </div>
  </div>
	

  <div class="row">
    <div class="col-4">
     Mobile:  <input type="text" class="form-control register_form " name="mobile" id="mobile" placeholder="Mobile"  autocomplete="off" >
    </div>
    <div class="col-4">
     Address :   <input type="text" class="form-control register_form " name="address" id="address" placeholder="Address"  autocomplete="off" >
    </div>
    <div class="col-4">
    Due Limit:  <input type="text" class="form-control register_form " name="duelimit" id="duelimit" placeholder="duelimit"  autocomplete="off" >
    </div>
  </div>

	
	

  <div class="row">
    <div class="col-4">
   Present Balance:  <input type="text" class="form-control register_form " name="openingbalance" id="openingbalance" placeholder="Balance"  autocomplete="off" >
    </div>

  </div>

		
		
  

			

			
			
			

			



                      <br />
		   
	
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" value="Add" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
        </form>
    <br>
  <span id="form_result_footer"></span>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
</div>




<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-6" >
    <h1>Customer List</h1>
    <a style="float:right; margin-bottom:20px;" class="btn btn-success  create_record" href="javascript:void(0)" id="create_record"> Add New </a>
	
	
	<div class="table-responsive">
    <table id="patient_table"  class="table  table-success table-striped data-tablem">
        <thead>
            <tr>
<th>No</th>
			<th>ID</th>
				<th>Area Code</th>
	<th>Name</th>
             <th>Customer Code</th>
			 <th> Mobile </th>
				<th>Address</th>
    <th>Due Limit</th>
	 <th>OB</th>			
	 <th>Balance</th>				
			     
       <th>Action</th>	      
                
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
      
      
	  
	  
	  
	      <div class="container">
       

	
	
	</div>

        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="closedelete" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default closedelete" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>





 




<script type="text/javascript">


$(document).ready(function(){
	
  $("#areacode").select2();

///// clear modal data after close it 
$(".modal").on("hidden.bs.modal", function(){
    $("#areacode").html("");
});



 $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

var $check = $(document).find('input[type="text"]');
jQuery("input").on('keyup', function(event) {
  
  
  if (  (event.keyCode === 13) || (event.keyCode === 40) ) {
   $check.eq($check.index(this) + 1).focus();
  }

               if (event.keyCode === 38) {
                    
           $check.eq($check.index(this) - 1).focus();
                }





});


     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	



    var table = $('#patient_table').DataTable({
		
	
		
        processing: true,
        serverSide: true,
		responsive: true,
	
        ajax: "{{ route('customer.index') }}",
	
        columns: [
		
		 
		 
		  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
			 {data: 'areacode', name: 'areacode'},
            {data: 'name', name: 'name'},
			 {data: 'customercode', name: 'customercode'},
			 {data: 'mobile', name: 'mobile'},
			 {data: 'address', name: 'address'},
			 {data: 'duelimit', name: 'duelimit'},
			 {data: 'openingbalance', name: 'openingbalance'},
			
			 {data: 'presentduebalance', name: 'presentduebalance'}, 
			 
			 
 {data: 'action', name: 'action', orderable: false, searchable: false},
			    
           
        ]
    });


 fetch();  
   

 
  function fetch()
  {

  $.ajax({
   url:"customer/areacode",
   dataType:"json",
  
   ////////////////////fetch data for dropdown menu 
success:function (response) {
	 $("#areacode").html("");
                    var len = 0;
                    if (response.data != null) {
                        len = response.data.length;
                    }
                 var option = "<option value=''></option>"; 

                             $("#areacode").append(option);
                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.data[i].id;
                             var name = response.data[i].code;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 
							

                             $("#areacode").append(option);
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
    url:"{{ route('customer.store') }}",
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
     }
	  $('#form_result_footer').html(html);
    $('#form_result_footer').fadeIn();
	  $('#form_result_footer').delay(1500).fadeOut();
	  fetch();
	      $("#category").html("");
    }
   })
  
  
  
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('customer.update') }}",
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
	  $('#form_result_footer').html(html);
    $('#form_result_footer').fadeIn();
	  $('#form_result_footer').delay(1500).fadeOut();
	  fetch();
	         $('#action_button').val("Add");
    $('#action').val("Add");
		  
		  
		  
		  
		  
		  
    }
   });
  }
 });
   
   $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url:"/customer/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#areacode').val(html.data.Areacode_id);
    $('#name').val(html.data.name);
	$('#customercode').val(html.data.customercode);
    $('#mobile').val(html.data.mobile);
    $('#address').val(html.data.address);
	$('#duelimit').val(html.data.duelimit);
    $('#openingbalance').val(html.data.presentduebalance);
   
	
	var len = html.areacode.length;
	var presentareacode = html.data.Areacode_id;

 $("#areacode").html("");
           

                             $("#areacode").append(option);
	
	
		                        for (var i = 0; i<len; i++) {
								
								if ( presentareacode == html.areacode[i].id  ) 
								{
									var id = html.areacode[i].id;
                             var name = html.areacode[i].code;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#areacode").append(option);
								}
                             
                        }
						
						
							                        for (var i = 0; i<len; i++) {
								
								if ( presentareacode != html.areacode[i].id  ) 
								{
									var id = html.areacode[i].id;
                             var name = html.areacode[i].code;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#areacode").append(option);
								}
                             
                        }
	                        
	
						


   
	$('#hidden_id').val(html.data.id);
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
   url:"customer/destroy/"+user_id,
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
   }
  })
 });

   
   
   
   
   
     $(document).on('click', '.closedelete', function(){
$('#confirmModal').modal('hide');

 });
   
   
   
   
   
   
   
   
   
  
	 
	 
	 
	 
	 
	 

	 
	 






 
 $(document).on('click', '#close', function(){
$('#formModal').modal('hide');

 });


});
</script>
	  


@stop