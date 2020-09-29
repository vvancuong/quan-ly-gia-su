@extends('layouts.layoutadmin')
@section('title')
	{{$data['title']}}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{$data['title']}}</h1>


           
            <form method="POST"   action="{{url('admin/monhoc', [$monhoc->monhoc_id])}}"  enctype="multipart/form-data">
                     {{ method_field('PUT') }}
                      @csrf	
                    <label for="fname">Tên môn hoc:</label><br>
 					 <input type="text" name="tenmonhoc" value="{{$monhoc->tenmonhoc}}"><br>  
 					  <input type="submit" value="Submit">
             </form>

             
        </div>
    </div>
</div>
@endsection