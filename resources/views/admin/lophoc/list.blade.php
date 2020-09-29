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

    <div><a class='btn btn-primary' href="{{ route('lophoc.create')}}">Thêm Mới</a></div>


    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <th>Tên lop hoc</th>
                <th>Địa chỉ dạy</th>
                <th>Ccsh thức day</th>
                <th>Cac mon hoc</th>
                <th>Chức năng</th>
                @foreach ($data['lophocs'] as $m)
                <tr id="lophoc{{$m->lophoc_id}}">
                    <td>Mon hoc: {{ $m->tenlophoc }}</td>
                    <td>Mon hoc: {{ $m->diachiday }}</td>
                    <td>
                        @if( $m->cachthucday==1)
                        Off
                        @endif

                        @if( $m->cachthucday==2)
                        ON
                        @endif

                        @if( $m->cachthucday==3)
                        Off & ON
                        @endif

                    </td>
                    <td>
                        <?php
                        foreach ($monhocs[$m->lophoc_id] as $val) {
                            echo '<p>' . $val->tenmonhoc . '</p>';
                        }
                        ?>
                    </td>
                    <td>[<a style="cursor:pointer;color:blue;" onclick="delObj({{$m->lophoc_id}})">X</a>][<a href="{{ URL::to('admin/lophoc/' . $m->lophoc_id . '/edit')}}">S</a>]</td>
                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>
<script>
    function delObj(id) {

        var r = confirm('Bạn chắc chắn xóa lóp học này?');
        if (r) {
            $.ajaxSetup({
                // truyen csrf thi lavavel moi nhan chay
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //-------
            $.ajax({
                url: 'lophoc/' + id,
                type: "DELETE", //phuong thuc
                data: {}, //'active' : id
                success: function(data) { //alert("YES");//alert(data['success']);
                    alert("Xóa lớp học thành công ");
                    var idm = "#lophoc" + id;
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