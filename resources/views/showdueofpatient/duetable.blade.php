

@extends('layout.main')

@section('content')



<h6  style="background-color:yellow" >  প্যাশেন্টের বাকির ট্রাঞ্জিশন  </h6>
<div class="table-responsive">
<table class="table">
  <caption>List of users</caption>
  <thead>
    <tr>
      <th scope="col">নং </th>
      <th scope="col"> ট্রাঞ্জিশনের নাম  </th>
      <th scope="col"> প্রকৃতি </th>
      <th scope="col"> ক্রয়করা সেবার মূল্য   </th>
	  <th scope="col"> বাকি   </th>
	   <th scope="col"> তারিখ    </th>
    </tr>
  </thead>
  <tbody>
  <?php $i=0; ?>
  @foreach($duetransition as $d )
    <?php $i= $i+1; ?>
  
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td>{{$d->comment}}</td>
	  <?php if( $d->transitiontype == 2 ) { ?>
	  
      <td>নতুন  বাকি  </td>
	  <?php } if( $d->transitiontype == 1 ) { ?>
	  
	  <td> বাকি পরিষোধ   </td>
	  
	  <?php } ?>
	  
      <td> {{$d->totalamount}}  </td>
	   <td>{{$d->amount}}</td>
	   	   <td> {{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y  h:i:sa'); }} </td>
    </tr>
   @endforeach
  </tbody>
</table>
</div>




 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  


<script type="text/javascript">


$(document).ready(function(){

$("#patient").select2();





});
</script>
	  


@stop