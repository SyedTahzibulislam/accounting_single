

@extends('layout.main')

@section('content')




 
 






</head>

  
 






<body>



<div class="container"   style="background-color:#EEE8AA; "  >

  
  
          <form  method="post" id="sample_form" action="{{route('productcompany.store')}}" class="form-horizontal" enctype="multipart/form-data"  onsubmit="event.preventDefault()">
		
		@csrf
	
	  <div class="row">

    <div class="col-6">
       Name:			  
			  <input type="text" class="form-control register_form " name="name" id="name"  placeholder="Enter Name" autocomplete="off">
           
    </div>
    <div class="col-6">
   Address:     
			   <input type="text" class="form-control register_form " name="address" id="address" placeholder="address" autocomplete="off">
    </div>
  </div>
	

  <div class="row">
    <div class="col-6">
     Mobile:  <input type="text" class="form-control register_form " name="mobile" id="mobile" placeholder="Mobile"  autocomplete="off" >
    </div>
    <div class="col-6">
  Present Due Amount:   <input type="text" class="form-control register_form " name="due" id="due" placeholder="Due Amount"  autocomplete="off" >
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
    <h1>Company List</h1>
    

	
	<div class="table-responsive">
    <table id="patient_table"  class="table  table-success table-striped data-tablem">
        <thead>
            <tr>
<th>No</th>
			<th>ID</th>
				<th>Name</th>
	<th>Address</th>
             <th>Mobile</th>
			 <th> Due Amnt.</th>
			
			     
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
	
        ajax: "{{ route('productcompany.index') }}",
	
        columns: [
		
		 
		 
		  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
			 {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
			 {data: 'mobile', name: 'mobile'},
			 {data: 'due', name: 'due'},
			

			
			 
 {data: 'action', name: 'action', orderable: false, searchable: false},
			    
           
        ]
    });


	  
   
  /////////////////////////////////ADD Data //////////////////////////// 
   
   

$('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
  
   $.ajax({
    url:"{{ route('productcompany.store') }}",
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
    url:"{{ route('productcompany.update') }}",
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
   url:"/productcompany/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#address').val(html.data.address);
    $('#name').val(html.data.name);
	$('#mobile').val(html.data.mobile);
    $('#due').val(html.data.due);
      
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
   url:"productcompany/destroy/"+user_id,
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