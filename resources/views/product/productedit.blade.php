

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

<input type="hidden" id="percentageofagent" value="0" name="percentageofagent" >	  

<div  class="container" style="background-color:#EEE8AA; "  >
  <span id="form_result"></span>
		<form method="post" action="{{ route('Product.update') }}"   id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
		   
		   
		 

	  <div class="row">
    <div class="col-4">
    Category 	<select id="category"  class="form-control "  name="category"  required   style='width: 270px;'>
   <option value="{{$product->productcategory->id}}" > {{$product->productcategory->name}} <option>
  
  @foreach($category as $c)
    <option value="{{$c->id}}" > {{$c->name}} <option>
  
  @endforeach 
  
   </select>
    </div>
    
	
	
	<div class="col-4">
    Company 	<select id="company"  class="form-control "   name="company"  required   style='width: 270px;'>
 
  <option value="{{$product->Productcompany_id}}" > {{$selectedcomapny}} <option>  
  @foreach($productcompany as $p)
    <option value="{{$p->id}}" > {{$p->name}} <option>
  
  @endforeach    
   </select>
    </div>
    <div class="col-4">
     Product Code:  <input type="text" class="form-control register_form " value="{{$product->productcode}}" name="productcode" id="productcode" placeholder="productcode" required autocomplete="off" >
    </div>
  </div>
	
	
	<div class="row">
	

	
	
		   <div class="col-4">
Product Name	

<input type="text" class="form-control register_form " name="name" value="{{$product->name}}" id="name" placeholder="Name" required autocomplete="off" >

    </div>
	

	
			   <div class="col-4">
Go-down Stock	<input type="text" class="form-control register_form " value="{{$product->stock}}"      name="godownstock" id="Fo-down Stock" placeholder="godownstock" required autocomplete="off" >

    </div>
	

	
	
	</div>
	



	   
	
	





<input type="hidden" class="form-control register_form " name="productid" value="{{$product->id}}" id="name" placeholder="Name" required autocomplete="off" >






			 <table   class="table" id="products_table">
                <thead>
                    <tr>
                   
						<th>Unit</th>
                        <th  style="width:100px;"  >Unit Price</th>
						<th style="width:150px;" >Qun. </th>
				

					
						
                    </tr>
                </thead>
                <tbody class="addmoreproduct">
                   
@foreach ($product->productpriceaccunit as $u )

				   <tr >  
		
                   <input type="hidden" class="form-control register_form " name="unitcoversion_id[]" value="{{$u->unitcoversion_id}}" id="name" placeholder="Name" required autocomplete="off" >
    
	
	                   <input type="hidden" class="form-control register_form " name="productpriceaccunitid[]" value="{{$u->id}}" id="name" placeholder="Name" required autocomplete="off" >
    
	
					 <td>	  <input type="text" style="width:150px;" autocomplete="off"  value="{{$u->unitcoversion->name }}" class="form-control numbers  unit_price" required style='width: 100px;' />   </td>
                           
        


					 <td>	  <input type="text" style="width:150px;" autocomplete="off" name="unitprice[]" value="{{$u->unitprice }}" class="form-control numbers  unit_price" required style='width: 100px;' />   </td>
                        

					 <td>	  <input type="text" style="width:150px;" autocomplete="off" name="stock[]"  value="{{$u->stock }}" class="form-control numbers  unit_price" required style='width: 100px;' />   </td>
                        						

                    </tr>
                   @endforeach
                </tbody>
            </table>









	
			
	
        
   
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action"  value="Add" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>
		   <span id="form_result_footer"></span>

</div>


<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-6" >

   

	


<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog  modal-lg">
  <div class="modal-content modal-xl">
   <div class="modal-header ">
          <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class=" modal-body modal-xl  ">
         <span id="form_result"></span>

        </div>
     </div>

    </div>
	</div>
	
	
	</div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
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

  $("#category").select2();
 $("#company").select2();

});
</script>
	  
</body>

@stop