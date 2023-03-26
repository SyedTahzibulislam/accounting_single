

@extends('layout.main')

@section('content')



<style>
.modal-lg {
    max-width: 90% !important;

}



tr:nth-child(even) {background-color: #f2f2f2;}
</style>
 
 






</head>






<body id="bodysellcorner">


    @if ($message = Session::get('success'))
        <div style="background-color:red;" class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
	
	
	
	
	
	
		<div  class="container" style="background-color:#EEE8AA; "  >
		<h2>Pay Due/ Receive Money  through Bank </h2>
  <span id="form_result"></span>
	
		<form method="post" action="{{ route('banktransition.store') }}"   id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		   
		   
		   <div class="row">
		   			 			 <div class="col-4">
<br><input type="radio"  name="transtype" value="0"  required >
			
<label for="html">ব্যাংকে  জমা   </label><br>
<input type="radio"  name="transtype" value="1"   required >
<label for="css"> ব্যাংক থেকে উত্তোলন  </label><br>

			    
			 </div>
			 
		   		কে জমা দিচ্ছে বা উত্তোলন করছে 	 			 <div class="col-4">
			 <input type="radio"  name="whom" value="1"  required >
<label for="html"> কাস্টমার    </label><br>
<input type="radio"  name="whom" value="2"   required >
<label for="css"> কোম্পানি  </label><br>
<input type="radio"  name="whom" value="0"   required >
<label for="css"> ব্যাবসা   </label><br>
<input type="radio"  name="whom" value="3"   required >
<label for="css"> ব্যাক্তিগত   </label><br>			    
			 </div>			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
		   
		   </div>
		   
		   
		   
		   
		   <div class="row">
		
           
            <div id="com" class="col-4">
	       Company Name  :   <select id="company_Id"  class="form-control "  name="company"     style='width: 270px;'>  
           
			
			</select>
             </div>
			 
			           
            <div id="cus" class="col-4">
	      Customer Name  :    <select id="customer"  class="form-control "  name="customer"     style='width: 270px;'>  
           
			
			</select>
             </div> 
</div>
			

			<div class="row">
			 			          
            <div id="part" class="col-4">
	       Partner Name  :    <select id="partner"  class="form-control "  name="partner"     style='width: 270px;'>  
           
			
			</select>
             </div> 
			             <div id="part" class="col-4">
	       Bank Name  :    <select id="Bank"  class="form-control "  name="Bank"   required  style='width: 270px;'>  
           
			
			</select>
             </div> 
			 </div>
			 
			
			
			 
			 

			 
			 <div id="formhide">


			 
			 
			 
			 
			
	
		   
		   

		   
	
		   
		  
   
	
	 <input type="hidden" id="statusvalue" name="statusvalue" class="statusvalue" >
	

		   
	<p>	   
  <div class="row">
			     <div class="col-4">
      
 Amount :  <input type="text" name="grossamount" id="grossamount" autocomplete="off"   class="form-control  grossamount" required />
		  
    </div>
	
    <div class="col-4">
      Date:<input type="date" id="date" name="transdate" required>
    </div>

	
	
	    <div class="col-4">
       
Descripton:  <textarea class="form-control"  name="comment" rows="3"></textarea>
		  
    </div>
	

  </div>
  
  

  
  	<p>	   

  
  
  
  
  
  
  
  
  
  
  

  
 <input type="hidden" name="discountatend" id="discountatend"  value="0"  class="form-control  discountatend" readonly  /> 
 <input type="hidden" name="percentofdicountontaotal" id="percentofdicountontaotal"  value="0"  class="form-control  percentofdicountontaotal"  />
	  <input type="hidden" name="totalamount" id="totalamount"  value="0" autocomplete="off"  class="form-control numbers totalamount"  />	  
  
</div>
		   
		   
	
		   	
			
	
        
   
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

	

	
		<div class="table-responsive">
    <table id="patient_table"  class="table  table-success table-striped data-tablem">
        <thead>
            <tr>
	
			<th>Serial NO.</th>
			<th>Orer NO.</th>
		
               
				<th>Amnt(TK)</th>
			<th>Type</th>
			<th>Trans By</th>
	<th>Entry By</th>
	
<th>Date</th>	
<th>Print</th>	
 <th>Action</th>            
               
            </tr>
        </thead>
        <tbody   >

        </tbody>
    </table>
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








 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  


<script type="text/javascript">





$(document).ready(function(){
	
	$("#com").hide();	
$("#cus").hide();	
$("#part").hide();	







$('input[type=radio][name=whom]').change(function() {
    if (this.value == '1') {
$('#cus').show();
$('#com').hide();
$('#part').hide();
fetch();	
    }
	
	
	    if (this.value == '2') {
$('#com').show();


$('#cus').hide();

$('#part').hide();

fetch();	
    }
	
	    if (this.value == '0') {
$('#com').hide();


$('#cus').hide();

$('#part').hide();

fetch();	
    }



	
	    if (this.value == '3') {
$('#part').show();


$('#cus').hide();
$('#com').hide();


fetch();	
    }
	
	
});
	










	
	//////////////////////////// Show record 

    var table = $('#patient_table').DataTable({
		
	
		
        processing: true,
        serverSide: true,
		responsive: true,
	
        ajax: "{{ route('banktransition.index') }}",
        columns: [
		
		 {data: 'DT_RowIndex', name: 'DT_RowIndex'},
		 
		 
		
            
			
			
			{data: 'id', name: 'id'},
             {data: 'amount', name: 'amount'},
			
  {data: 'transtype', name: 'transtype'},
  {data: 'whom', name: 'whom'},
			{data: 'entryby', name: 'entryby'},
			{data: 'created', name: 'created'},
	{data: 'pdf', name: 'pdf'},
			    {data: 'action', name: 'action'}, 
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










///////////////////////////////
	

	
	
  $("#customer").select2();
  

	  $("#company_Id").select2();
	    $('#partner').select2();
		 
 $('#Bank').select2();
 
 
 
       $("#cusname").hide();
	  $("#cusmobile").hide();


  
  
  
 
  
  
  





    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	
                     

function fetch()
{

  $("#customer").select2();
  

	  $("#company_Id").select2();
	    $('#partner').select2();
		 
 $('#Bank').select2();


 $.ajax({
   url:"banktransition/dropdownlist",
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
	
	   ////////////////////fetch data for Customer dropdown menu ////////////////////////////
	    $("#company_Id").html("");
	   
var optionforcustomer = "<option value=''></option>";                   
  $("#company_Id").append(optionforcustomer);

				   var len = 0;
                    if (response.Productcompany != null) {
                        len = response.Productcompany.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.Productcompany[i].id;
                             var name = response.Productcompany[i].name;

                              
                            var presentduebalance = response.Productcompany[i].due;
							
							  
							  
							  var optionforcustomer = "<option data-presentduebalance='"+presentduebalance+"' data-val='"+id+"'        value='"+id+"'>"+name+"</option>"; 
							  

							

                            
							  $("#company_Id").append(optionforcustomer);
                        }
                    }
					
			
					
		    $("#customer").html("");
	   
var customer = "<option value=''></option>";                   
  $("#customer").append(customer);

				   var len = 0;
                    if (response.customer != null) {
                        len = response.customer.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.customer[i].id;
                             var name = response.customer[i].name;

                              
                           
							  
							  
							  var customer = "<option        value='"+id+"'>"+name+"</option>"; 
							  

							

                            
							  $("#customer").append(customer);
                        }
                    }		

               
	    $("#partner").html("");
	   
var partner = "<option value=''></option>";                   
  $("#partner").append(partner);

				   var len = 0;
                    if (response.partner != null) {
                        len = response.partner.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.partner[i].id;
                             var name = response.partner[i].name;

                              
                           
							  
							  
							  var partner = "<option        value='"+id+"'>"+name+"</option>"; 
							  

							

                            
							  $("#partner").append(partner);
                        }
                    }	

	    $("#Bank").html("");
	   
var Bank = "<option value=''></option>";                   
  $("#Bank").append(Bank);

				   var len = 0;
                    if (response.Bank != null) {
                        len = response.Bank.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.Bank[i].id;
                             var name = response.Bank[i].name;

                              
                           
							  
							  
							  var Bank = "<option        value='"+id+"'>"+name+"</option>"; 
							  

							

                            
							  $("#Bank").append(Bank);
                        }
                    }	














			   }
				
				
	//////////////////////////////////////////////////////////////////////////////
  })

 	
	
}





 


















































  $("#percentofdicountontaotal").change(function(){
     this.value = this.value.replace(/[^0-9\.]/g,'');
	 totalamount();


  });













  /////////////////////////////////ADD Data //////////////////////////// 
   
   

$('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
	    $('#action_button').attr("disabled", true);
   $.ajax({
    url:"{{ route('banktransition.store') }}",
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
	    $('#action_button').attr("disabled", false);
     }
	 
	      if(data.error)
     {
      html = '<div class="alert alert-danger">' + data.error + '</div>';
      $('#sample_form')[0].reset();
      $('#patient_table').DataTable().ajax.reload();
     }
	 
$('#form_result').html(html);

$('#form_result').fadeIn();
$('#form_result').delay(3000).fadeOut();

$('#form_result_footer').html(html);

$('#form_result_footer').fadeIn();
$('#form_result_footer').delay(3000).fadeOut();

	$("#com").hide();	
$("#cus").hide();	
$("#part").hide();	

fetch();


 $("#products_table tr:gt(1)").remove();
 
 //remover por select2 dite hobe 
 $('.medicine_name').select2();
	
	 
	 
	 
	 
    }
   })
  }

 
 
 
 
 });
 







 


 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"banktransition/destroy/"+user_id,
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
	  
</body>

@stop