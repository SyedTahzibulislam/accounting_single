

@extends('layout.main')

@section('content')




 
 






</head>

  
 






<body>

<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-6" >
    <h6  style="color:red;">বিভিন্ন এজেন্টদের দেয়া কমিশনের ট্রাঞ্জিশন। এখানে তারিখসহ  ট্রাঞ্জিশন দেখতে পাবেন যে কত তারিখে কোন এজেন্টকে কত কমিশন দিয়েছেন। নতুন করে কাওকে কমিশন দিতে ডান দিকের Add New বাটনে ক্লিক করেন।  </h6>
    <a style="float:right; margin-bottom:20px;" class="btn btn-success  create_record" href="javascript:void(0)" id="create_record"> Add New </a>
	
	
	<div class="table-responsive">
    <table id="patient_table"  class=" table   table-success table-striped data-tablem             ">
        <thead>
            <tr>
<th>No</th>
			
				<th> Agent Name.</th>
	<th> Patient Name.</th>
      <th>Commission For </th>     
			 <th> Commission</th>
			 <th> Status</th>
			<th>Print</th>
			
				<th>Action</th>
      
			 <th>Date</th>	
				
			     
             
                
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
         <form method="post"  action="{{ route('employeetransactioncon.store') }}"   id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		  
		  <div class="form-group"> <b style="color:red"> (এই লিস্ট কোন এজেন্টের নাম খুজে না পেলে আপনি , খরচের খাতে ক্লিক করুন। সেখানে থাকা এজেন্ট লিস্টে গিয়ে তার নাম এজেন্ট তালিকায় যুক্ত করে নেন। ) </b><br>
            <label style="color:green" class="control-label col-md-4">Agents List  :   </label>
            <div class="col-md-8">
	
	<select id="employeelist"  class="form-control "  name="employeelist"  required   style='width: 270px;'>
  
   </select>
             </div>
			 </div>
			 
			 		             <div class="form-group">
            <label style="color:green"  class="control-label col-md-4" >Commission : </label>
            <div class="col-md-8">
             <input type="text" name="salary" id="salary" class="form-control" />
            </div>
           </div>
			 
				 		             <div class="form-group">
            <label style="color:green"  class="control-label col-md-4" >Comment: </label>
            <div class="col-md-8">
             <input type="text" name="comment" id="comment" class="form-control" />
            </div>
           </div>		 
			 
		
<b> কমিশন দেন  </b><br>
<input type="radio" id="commissionnogode" name="commissiontype" value="1"  required >
<label for="nogode"> নগদে   </label><br>
<input type="radio" id="commissionbakite" name="commissiontype" value="2"  required >
<label for="bakite"> বাকীতে  </label><br>

  
  

		   

			 
   
           <br />

		             <div class="form-group">
            <label class="control-label col-md-4" > Date: </label>
            <div class="col-md-8">
            <input type="date" id="datePicker" name="Date_of_Transition" class="form-control" />
            </div>
           </div>	




		   
	
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











<div id="agentcommModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" id="closecom" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_resultcom"></span>
         <form method="post"  action="{{ route('agenttransaction.paid') }}"   id="sample_formcom" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		  			 		             <div class="form-group">
            <label style="color:green"  class="control-label col-md-4" >Agent Name : </label>
            <div class="col-md-8">
             <input type="text" name="name" id="agentname" class="form-control" />
            </div>
           </div>
		   

		   
		   
		   
 <input type="hidden" name="nameid" id="agentnameid" class="form-control" />
			 
			 		             <div class="form-group">
            <label style="color:green"  class="control-label col-md-4" >Commission: </label>
            <div class="col-md-8">
             <input type="text" name="salary" id="salarycom" class="form-control" />
            </div>
           </div>
		   
		   

		   
			 
				 		             <div class="form-group">
            <label style="color:green"  class="control-label col-md-4" >Comment: </label>
            <div class="col-md-8">
             <input type="text" name="comment" id="commentcom" class="form-control" />
            </div>
           </div>		 
			 
		
           <br />






		   
	
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="actionforcom" />
            <input type="hidden" value="5" name="hidden_id" id="hidden_idforcom" />
            <input type="submit" name="action_button" id="action_buttonforcom" class="btn btn-warning" value="Submit" />
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


<div id="paidmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Do You want to Pay the Commission?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button_paid" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


 

paid


<script type="text/javascript">


$(document).ready(function(){
	
	
	
	
            $('#patient_table thead tr').clone(true).appendTo( '#patient_table thead' );
            $('#patient_table thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input style="width:100px;" type="text" placeholder=" Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });


	
	
	
	
	
	
	
	
	
	
	
	
	
  $("#employeelist").select2();   
 $("#cabine_list").select2();   

///// clear modal data after close it 
$(".modal").on("hidden.bs.modal", function(){
    $("#employeelist").html("");
});
///////////////////////////////


     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	



    var table = $('#patient_table').DataTable({
		
	
		
        processing: true,
        serverSide: true,
		responsive: true,

        ajax: "{{ route('agenttransaction.index') }}",
	
        columns: [
		
		 
		 
		  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            
			 {data: 'employee_name', name: 'agentdetail.name'},
			{data: 'patient_name', name: 'patient_name'},
			{data: 'transitino_type', name: 'transitino_type'}, 
        
			 {data: 'paidamount', name: 'paidamount'},
			 	
			 {data: 'paid_staus', name: 'paid_staus'},	
				
		 {data: 'pdf', name: 'pdf'},				
			
 {data: 'action', name: 'action', orderable: false, searchable: false},
	    
     {data: 'created_at', name: 'created_at'},      
        ]
    });


   
   
  ///////// show the modal//////////////////////////////////////////////////////////////////////////////// 
    $(document).on('click', '.create_record', function(){
		  $('#form_result').html('');
    $('.modal-title').text("Add New Record");
     $('#action_button').val("Add");
     $('#action').val("Add");
       $('#formModal').modal('show');
  $.ajax({
   url:"agenttransaction/dropdown_list",
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
	
	$("#employeelist").html("");
	
	
	var option = "<option >select one</option>"; 
					   $("#employeelist").append(option);
	
	
                    var len = 0;
                    if (response.employeedetails != null) {
                        len = response.employeedetails.length;
                    }
                       
                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.employeedetails[i].id;
                             var name = response.employeedetails[i].name;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 
							

                             $("#employeelist").append(option);
                        }
                    }
					
					
						

        
					
					
					
					
					
					
					
					
                }
				
				
	//////////////////////////////////////////////////////////////////////////////
  })
 
 
 });
 
   
   
  /////////////////////////////////ADD Data //////////////////////////// 
   
  

$('#sample_formcom').on('submit', function(event){

  event.preventDefault();
  if($('#action_buttonforcom').val() == 'Submit')
  {

   $.ajax({
    url:"{{ route('agenttransaction.paid') }}",
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
      $('#sample_formcom')[0].reset();
      $('#patient_table').DataTable().ajax.reload();
     }
	 
	 $('#form_resultcom').html(html);

$('#form_resultcom').fadeIn();
$('#form_resultcom').delay(1500).fadeOut();

	 
	 
	 

    }
   })
  
  
  
  }

 





 });

















  

$('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
  
   $.ajax({
    url:"{{ route('agenttransaction.store') }}",
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
    	 $('#form_result').html(html);

$('#form_result').fadeIn();
$('#form_result').delay(1500).fadeOut();

    }
   })
  
  
  
  }

  if($('#action').val() == "Edit")
  {
   $.ajax({
    url:"{{ route('agenttransaction.update') }}",
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

$('#form_result').fadeIn();
$('#form_result').delay(1500).fadeOut();

    }
   });
  }
 });
   
   $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url:"/agenttransaction/"+id+"/edit",
   dataType:"json",
   success:function(html){
	   
	   
	   
   
	   $('#salary').val(html.data.paidamount);

	
	var len = html.employeedetails.length;
	console.log(len);
	var presentemployeedetails_id = html.data.employeedetails_id;

	
	
		                        for (var i = 0; i<len; i++) {
								
								if ( presentemployeedetails_id == html.employeedetails[i].id  ) 
								{
									var id = html.employeedetails[i].id;
                             var name = html.employeedetails[i].name;

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#employeelist").append(option);
								}
                             
                        }
						
						
							                        for (var i = 0; i<len; i++) {
								
								if ( presentemployeedetails_id != html.employeedetails[i].id  ) 
								{
									var id = html.employeedetails[i].id;
                             var name = html.employeedetails[i].name; 

                             var option = "<option value='"+id+"'>"+name+"</option>"; 

                             $("#employeelist").append(option);
								}
                             
                        }
						
				
	
	                        
	
	

						
						


   
	$('#hidden_id').val(html.data.id);
    $('.modal-title').text("Edit New Record");
    $('#action_button').val("Edit");
    $('#action').val("Edit");
    $('#formModal').modal('show');
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
   url:"agenttransaction/destroy/"+user_id,
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

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 var user_id;

 $(document).on('click', '.paid', function(){
  user_id = $(this).attr('id');
  console.log(user_id);


	 
	 

	 
	 
  $.ajax({
   url:"agenttransaction/paidsenddata/"+user_id,
  dataType:"json",
   success:function(html)
   {
	      $('#hidden_idforcom').val(html.data.id); 
	    $('#agentname').val(html.data.agentdetail.name);   
	   

	   
	     $('#agentnameid').val(html.data.agentdetail.id); 
		$('#comment').val(html.data.comment); 
		
		$('#salarycom').val(html.data.paidamount); 		
		
	     $('#agentcommModal').modal('show');

   }
  })
 });







   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
  
	 
	 
	 
	 
	 
	 

	 
	 






 
 $(document).on('click', '#close', function(){
$('#formModal').modal('hide');

 });


});
</script>
	  


@stop