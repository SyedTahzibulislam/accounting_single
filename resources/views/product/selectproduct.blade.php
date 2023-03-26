

@extends('layout.main')

@section('content')










<h2> {{$message}} </h2>


<h6  style="background-color:yellow" > যে প্রডাক্টের স্টোকের ইউনিট কনভার্সন করতে চান সেটা- সিলেক্ট করেন।     </h6>

<form      method="post"  action="{{route('producttransition.convertstockfetch')}}"   >
 @csrf
Product Name:<select style="width:300px;" required name="product" id="product">
<option value=""></option>
@foreach($product as $p)
  <option value="{{$p->id}}">{{$p->name}}</option>
 @endforeach
</select>




  <button   type="submit"   target="_blank" class="btn btn-primary">Submit</button>
</form>





 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  


<script type="text/javascript">


$(document).ready(function(){

 $(document).on('change', '#startdate , #enddate', function(){
 
  var start = $('#startdate').val();
    var end= $('#enddate').val();
	var date1 = new Date(start);
	var date2 = new Date(end);
 if (date1 > date2 )
 {
	alert("শেষের তারিখ অব্যশ্যই শুরুর তারিখ থেকে পেছনে হবে। পুনরায় ইনপুট দিন।"); 
	$('#enddate').val('');
 }
  
 });


$("#product").select2();


});
</script>
	  


@stop