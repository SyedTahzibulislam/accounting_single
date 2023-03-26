

@extends('layout.main')

@section('content')

<body>


  
<div class="container">
  <div class="row">
    <div style="background-color: #add8e6" class="col-sm">
  <h2 style="color:red">  এই বছরে আউটডোরের  ডাক্তারদের রোগী দেখার পরিমাণ   </h2>
  <hr>
  

  <table class="table">
  <thead>
    <tr>
    
      <th scope="col"> ডাক্তারের নাম  </th>
	  <th scope="col"> রোগীর সংখ্যা </th>
      <th scope="col"> মোট টাকা   </th>
      <th scope="col">বাকি </th>

    </tr>
  </thead>
  <tbody>
  

    
	@foreach($doctorappointmenttransactions as $d)
	

	<tr>
      <th >{{$d->doctor->name}}</th>
	  <td>{{$d->total_unit}}</td>
      <td>{{$d->total_amount}}</td>
      <td>{{$d->total_due}}</td> 

    </tr>
@endforeach
  </tbody>
</table>

  </div>
</div>

 
 






</bodY>
@stop