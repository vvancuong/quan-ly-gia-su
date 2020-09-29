<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Monhoc;

use App\Lophoc;
use App\Lophoc_Monhoc;

use Illuminate\Support\Facades\DB;

class LophocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => "DS lóp hoc",
        );

        $data['lophocs'] = Lophoc::All(); //  DB::table('lophoc')->get();


        $data['monhocs'] = array();


        foreach ($data['lophocs'] as $l) { //co lophoc_id => nhieeu monhoc_id => dung bang monhoc

            //Cach 1: database : query builder, theem  use Illuminate\Support\Facades\DB;
            $monhocs[$l->lophoc_id] =  DB::table('monhoc')
                ->join('lophoc_monhoc', 'lophoc_monhoc.monhoc_id', '=', 'monhoc.monhoc_id')
                ->select('monhoc.tenmonhoc')
                ->where('lophoc_monhoc.lophoc_id', '=', $l->lophoc_id)
                ->get();


            //print_r($monhocs);

        }




        return view('admin.lophoc.list', ['data' => $data, 'monhocs' => $monhocs]);
        // lay du lieu va hien thi ds mon hoc


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //tao lop hoc lop hoc
        //them on hoc
        $data = array(
            'title' => "Tạo Lớp học",
        );
        $data['monhocs'] = Monhoc::all();

        return view('admin.lophoc.create', ['data' => $data]);
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //luu lop hoc
        //hien thi ds lop hoc

        $validator = Validator::make($request->all(), [
            'tenlophoc' => 'required|max:255|min:5',

        ]);

        if ($validator->fails()) {
            return redirect('admin/lophoc/create')
                ->withErrors($validator)
                ->withInput();
        }

        $lophoc = new Lophoc;

        $lophoc_id = substr(time() . rand(1, 1000000), 5, 8);
        $lophoc->lophoc_id = $lophoc_id;
        $lophoc->tenlophoc = $request->tenlophoc;
        $lophoc->diachiday = $request->diachiday;
        $lophoc->cachthucday = $request->cachthucday1 + $request->cachthucday2; //3 chon ca 2, 1 cchonoff, 2 onl
        $lophoc->save();


        // lucs nay co lophoc->malophoc; 
        $monhocs = $request->monhocs;

        foreach ($monhocs as $monhoc_id) {
            $lhmh = new Lophoc_Monhoc;
            $lhmh->lophoc_id = $lophoc_id;
            $lhmh->monhoc_id = $monhoc_id;
            $lhmh->save();
        }




        //---xu ly phan chọn mon hoc cho lop hoc; luu du lieu vao bang lophoc_monhoc

        //chuyen trang index
        return redirect('admin/lophoc')->with('messenger', 'Them lop hoc thanh cong');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    //----

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = array(
            'title' => "SỬa lóp Học",
        );
        $data['monhocs'] = Monhoc::all();
        //model 
        $lophoc = Lophoc::find($id); //lay du lieu mon hoc co id=id

        // cac mon hoc ma lop nay hoc
        $monhocduocchons =  DB::table('monhoc')
            ->join('lophoc_monhoc', 'lophoc_monhoc.monhoc_id', '=', 'monhoc.monhoc_id')
            ->select('monhoc.*')
            ->where('lophoc_monhoc.lophoc_id', '=', $id)
            ->get();
        //-----------------dao mang luu id cua cac lop hoc duoc chon
        $dsmhdcs = array();
        foreach ($monhocduocchons as $val)
            $dsmhdcs[] = $val->monhoc_id;

        //chuyen ra view
        return view('admin.lophoc.edit', ['data' => $data, 'lophoc' => $lophoc, 'dsmhdcs' => $dsmhdcs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'tenlophoc' => 'required|max:255|min:5',

        ]);

        if ($validator->fails()) {
            return redirect('admin/lophoc/create')
                ->withErrors($validator)
                ->withInput();
        }

        $lophoc = Lophoc::find($id);


        $lophoc->tenlophoc = $request->tenlophoc;
        $lophoc->diachiday = $request->diachiday;
        $lophoc->cachthucday = $request->cachthucday1 + $request->cachthucday2; //3 chon ca 2, 1 cchonoff, 2 onl




        // lucs nay co lophoc->malophoc; 

        $lhmh = Lophoc_Monhoc::where('lophoc_id', $lophoc->lophoc_id)->delete(); // xóa môn học hiện tại
        ////----
        $monhocs = $request->monhocs;

        foreach ($monhocs as $monhoc_id) {
            $lhmh = new Lophoc_Monhoc;
            $lhmh->lophoc_id = $lophoc->lophoc_id;
            $lhmh->monhoc_id = $monhoc_id;
            $lhmh->save();
        }

        $lophoc->save();


        //---xu ly phan chọn mon hoc cho lop hoc; luu du lieu vao bang lophoc_monhoc

        //chuyen trang index
        return redirect('admin/lophoc')->with('messenger', 'Them lop hoc thanh cong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        //
        $lophoc = Lophoc::find($id);
        if ($lophoc) $lophoc->delete();
    }
}
