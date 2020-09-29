@extends('layouts.layoutadmin')

@section('title')
{{$data['title']}}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{$data['title']}}</h1>
            {{$data['title']}}

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif



            <form method="POST" action="{{ route('lophoc.store')}}" enctype="multipart/form-data">
                @csrf
                <label for="fname">Tên lớp học:</label><br>
                <input type="text" name="tenlophoc" value=" {{ old('tenlophoc') }}"><br>
                @error('tenmonhoc')
                <div class="alert alert-danger">{{ $message }}</div>



                @enderror
                <input type="text" name="diachiday" value=" {{ old('diachiday') }}"><br>
                @error('diachiday')

                @enderror
                <input type="checkbox" id="cachthucday1" name="cachthucday1" value="1">
                <label for="cachthucday"> Tại nhà </label><br>
                <input type="checkbox" id="cachthucday2" name="cachthucday2" value="2">
                <label for="vehicle2"> Online</label><br>
                @error('cachthucday')

                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <!--17/9-->
                @if(count($data['monhocs'])>0)
                @foreach($data['monhocs'] as $val)
                {{$val->tenmonhoc}}
                <input type="checkbox" name="monhocs[]" value="{{$val->monhoc_id}}" />
                @endforeach
                @endif




                <input type="submit" value="Submit">
            </form>


        </div>
    </div>
</div>
@endsection