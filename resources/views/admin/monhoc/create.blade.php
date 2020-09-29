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



            <form method="POST" action="{{ route('monhoc.store')}}" enctype="multipart/form-data">
                @csrf
                <label for="fname">Tên môn hoc:</label><br>
                <input type="text" name="tenmonhoc" value=" {{ old('tenmonhoc') }}"><br>
                @error('tenmonhoc')
                <div class="alert alert-danger">{{ $message }}</div>



                @enderror
                <input type="text" name="tenmonhoc1" value=" {{ old('tenmonhoc1') }}"><br>
                @error('tenmonhoc1')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="submit" value="Submit">
            </form>


        </div>
    </div>
</div>
@endsection