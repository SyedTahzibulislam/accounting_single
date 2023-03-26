

@extends('layout.main')

@section('content')


<h6 style="color:red;">আপনি যে দুই তারিখসহ ও দুই তারিখের মধ্যবর্তী সকল ডেটের -  যে কোন একটি নির্দিষ্ট আয় দেখতে চান তা নিচের  ফিল্ডে লিখুন। 
ধরুন আপনি ১ আগষ্ট ২০২১  হতে ৭ আগষ্ট ২০২১ পর্যন্ত হওয়া  সিট দেখতে চাচ্ছেন। 
সেই ক্ষেত্রে <b style="color:green">শুরুর তারিখ</b> এর স্থলে ১ আগষ্ট ২০২১ হবে ও<b style="color:green"> শেষের তারিখ</b> এর স্থলে  ৭ আগষ্ট ২০২১ হবে।     </h6>
<br>
<h6  style="background-color:yellow" >যদি শুধু একটি নির্দিষ্ট ডেটের  হিসাব দেখতে চান সেই ক্ষেত্রে <b style="color:green"> শেষের তারিখ</b> এর স্থলে ও প্রথম তারিখা বসান। যদি শুধু ৭ আগস্ট এর  সিট দেখতে চান সেই ক্ষেত্রে দুই ক্ষেত্রে ৭ আগস্ট সিলেক্ট করেন।   </h6>

<form   class="khorochform"   method="post"       action="{{route('externalincometransition.fetchkhoroch')}}"   >
 @csrf
  <div class="form-group">
   <label for="birthday">শুরুর তারিখ :</label><br>
  <input type="date" id="startdate" name="startdate" required ><br>
  @if($errors->has('startdate'))
    <div class="error"><h2 style="font-size:15px;color:red;">{{ $errors->first('startdate') }}</h2></div>
@endif
  
  
  </div>
  <div class="form-group">
    <label for="birthday">শেষের  তারিখ :</label><br>
  <input type="date" id="enddate" name="enddate"><br>
    @if($errors->has('enddate'))
    <div   class="error"><h2 style="font-size:20px;color:red;"> {{ $errors->first('enddate') }}</h2></div>
@endif
  </div>


First Level Cat:
<select class="firstlevel" style="width:300px;" name="firstlevel" id="firstlevel" >
  <option value=""></option>
@foreach ( $firstlevel as $p  )
  <option value="{{$p->id}}">{{$p->name}}</option>
  @endforeach
</select>
<br>
</P>
Second Level Cat:
<select  style="width:300px;" class="secondlevel"  id="secondlevel"   name="secondlevel"  >
  <option value=""></option>

</select>
</P>
Third Level Cat:
<select  style="width:300px;" class="thirdlevel" name="thirdlevel" id="thirdlevel" >
  <option value=""></option>

</select>
</P>
Fourth Level Cat:
<select  style="width:300px;"  name="fourthlevel" id="fourthlevel" >
  <option value=""></option>

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



$("#firstlevel").select2();

$("#secondlevel").select2();
$("#thirdlevel").select2();
$("#fourthlevel").select2();




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





 function fetchtsecondlevel( id )
 {
	   $.ajax({
   url:"secondlevel/"+id,
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
		$("#secondlevel").html("");
		var secondlevel = "<option  value='' ></option>"; 
						
					   $("#secondlevel").append(secondlevel);
					
					
					
					                    var len = 0;
                    if (response.secondlevel != null) {
                        len = response.secondlevel.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.secondlevel[i].id;
                             var name = response.secondlevel[i].name;


                             var secondlevel = "<option    value='"+id+"'>"+name+"</option>"; 
							

                             $("#secondlevel").append(secondlevel);
                        }
                    }
}
	   });					
	 
	 
 }




$('.khorochform').delegate('.firstlevel','change',function(){
	
	
	$("#normalvalue").val('');
	$("#unit").val('');	
		$("#result").val('');
var id = $('.firstlevel option:selected').val();
	
fetchtsecondlevel(id);

});








 function thirdlevel( id )
 {
	   $.ajax({
   url:"thirdlevel/"+id,
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
		$("#thirdlevel").html("");
		var thirdlevel = "<option  value='' ></option>"; 
						
					   $("#thirdlevel").append(thirdlevel);
					
					
					
					                    var len = 0;
                    if (response.thirdlevel != null) {
                        len = response.thirdlevel.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.thirdlevel[i].id;
                             var name = response.thirdlevel[i].name;


                             var thirdlevel = "<option    value='"+id+"'>"+name+"</option>"; 
							

                             $("#thirdlevel").append(thirdlevel);
                        }
                    }
}
	   });					
	 
	 
 }




$('.khorochform').delegate('.secondlevel','change',function(){
	
	
	$("#normalvalue").val('');
	$("#unit").val('');	
		$("#result").val('');
var id = $('.secondlevel option:selected').val();
	
thirdlevel(id);

});










 function fourthlevel( id )
 {
	   $.ajax({
   url:"fourthlevel/"+id,
   dataType:"json",
   
   ////////////////////fetch data for dropdown menu 
success:function (response) {
		$("#fourthlevel").html("");
		var fourthlevel = "<option  value='' ></option>"; 
						
					   $("#fourthlevel").append(fourthlevel);
					
					
					
					                    var len = 0;
                    if (response.fourthlevel != null) {
                        len = response.fourthlevel.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.fourthlevel[i].id;
                             var name = response.fourthlevel[i].name;


                             var fourthlevel = "<option    value='"+id+"'>"+name+"</option>"; 
							

                             $("#fourthlevel").append(fourthlevel);
                        }
                    }
}
	   });					
	 
	 
 }




$('.khorochform').delegate('.thirdlevel','change',function(){
	
	
	$("#normalvalue").val('');
	$("#unit").val('');	
		$("#result").val('');
var id = $('.thirdlevel option:selected').val();
	
fourthlevel(id);

});












});
</script>
	  


@stop