<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Monhoc;
use Auth;

class MonhocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testvvv()
    {
        echo 'ds cho nhan vien';
    }

    public function index()
    {
        //
        $data = array(
            'title' => "DS mon hoc",
        );



        // sắp xếp dữ liệu theo DESC
        $data['monhocs']  = Monhoc::orderBy('monhoc_id', 'DESC');
        // phân trang
        $data['monhocs'] = $data['monhocs']->paginate(5);

        //print_r($data['monhocs']);
        //die;
        return view('admin.monhoc.list', ['data' => $data]);


        // lay du lieu va hien thi ds mon hoc

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //them on hoc
        $data = array(
            'title' => "Tạo Môn Học",
        );


        return view('admin.monhoc.create', ['data' => $data]);
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
        //

        $validator = Validator::make($request->all(), [
            'tenmonhoc' => 'required|max:255|min:5',
            'tenmonhoc1' => 'required|max:255|min:5',
        ]);

        if ($validator->fails()) {
            return redirect('admin/monhoc/create')
                ->withErrors($validator)
                ->withInput();
        }

        $monhoc = new Monhoc;
        $monhoc->monhoc_id = substr(time() . rand(1, 1000000), 5, 8);
        $monhoc->tenmonhoc = $request->tenmonhoc;
        $monhoc->user_id = Auth::id();
        $monhoc->save();
        //chuyen trang index
        return redirect('admin/monhoc')->with('messenger', 'Them mon hoc thanh cong');
        // C M V=> MOnhoc V 
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) // c controller
    {
        $data = array(
            'title' => "SỬa Môn Học",
        );
        //model 
        $monhoc = Monhoc::find($id); //lay du lieu mon hoc co id=id


        //chuyen ra view
        return view('admin.monhoc.edit', ['data' => $data, 'monhoc' => $monhoc]);
        //
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
        //kiem tra du lieu 
        //
        $monhoc = Monhoc::find($id);
        $monhoc->tenmonhoc = $request->tenmonhoc;
        $monhoc->save();

        return redirect('admin/monhoc')->with('messenger', 'Sua mon hoc thanh cong ' . $request->tenmonhoc);

        // b1cap nhat du lieu vaf db

        // b2 chuen trang 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $monhoc = Monhoc::find($id);
        if ($monhoc) $monhoc->delete();
    }
}
