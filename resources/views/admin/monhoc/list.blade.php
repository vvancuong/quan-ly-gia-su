@extends('layouts.layoutadmin')
@section('title')
{{$data['title']}}
@endsection

@section('content')
<div class="container">

    @if(session('messenger'))
    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
        {{session('messenger')}} <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    @endif

    <div><a class='btn btn-primary' href="{{ route('monhoc.create')}}">Thêm Mới</a></div>


    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <th>Tên mon học</th>
                <th>Chức năng</th>
                @foreach ($data['monhocs'] as $m)
                <tr id="monhoc{{$m->monhoc_id}}">
                    <td>Mon hoc: {{ $m->tenmonhoc }}</td>
                    <td>[<a style="cursor:pointer;color:blue;" onclick="delObj({{$m->monhoc_id}})">X</a>][<a href="{{ URL::to('admin/monhoc/' . $m->monhoc_id . '/edit')}}">S</a>]</td>
                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>


    <!-- lệnh phân trang-->
    {{ $data['monhocs']->render() }}


</div>
<script>
    function delObj(id) {

        var r = confirm('Bạn chắc chắn xóa mon hoc này?');
        if (r) {
            $.ajaxSetup({
                // truyen csrf thi lavavel moi nhan chay
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //-------
            $.ajax({
                url: 'monhoc/' + id,
                type: "DELETE", //phuong thuc
                data: {}, //'active' : id
                success: function(data) { //alert("YES");//alert(data['success']);
                    alert("Xóa mon hoc thành công ");
                    var idm = "#monhoc" + id;
                    $(idm).hide();
                },
                error: function() { //alert("NO");
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
    }
</script>
@endsection