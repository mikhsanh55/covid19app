<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Slider;
use Validator;
class SliderController extends Controller
{
    public function __construct()
    {
        ini_set('date.timezone', 'Asia/Jayapura');
    }
    public function index()
    {
    	$slides = Slider::all();
    	if($slides->count() > 0) {
    		foreach($slides as $i => $slide) {
    			$slides[$i]['encrypt_id'] = Crypt::encrypt($slide->id);
    		}
    	}

    	return view('admin/slide/index', [
    		'datas' => $slides,
    		'title' => 'Slide Banner',
    		'no' => 0
    	]);
    }

    public function insert(Request $request)
    {
    	$validation = Validator::make($request->all(), [
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    		'nama' => 'required'
    	]);

    	if($validation->passes())
    	{
    		$image = $request->file('image');
    		$newImageName = uniqid() . '_' . $image->getClientOriginalName();
    		$upload = $image->move(base_path('public/images/slider'), $newImageName);
    		if($upload) {
    			Slider::create([
    				'nama' => $request->input('nama'),
    				'image' => url('/public/images/slider') . '/' .$newImageName,
    				'path_image' => base_path('public/images/slider') . '/' . $newImageName
    			]);

    			return response()->json([
    				'status' => true,
    				'msg' => 'Slider berhasil ditambah'
    			], 200);
    		}
    		else {
    			return response()->json([
    				'status' => false,
    				'msg' => 'Tidak bisa mengupload gambar'
    			], 500);
    		}
    	}
    	else
    	{
    		return response()->json([
    			'status' => false,
    			'msg' =>$validation->errors()->all()
    		], 400);
    	}
    }

    public function update(Request $request)
    {
    	$validation = Validator::make($request->all(), [
    		'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
    		'nama' => 'required'
    	]);

    	if($validation->passes())
    	{
    		$id = Crypt::decrypt($request->input('_id'));
    		$data = Slider::find($id);
    		if(null !== $request->file('image')) {
    			if(file_exists($data->path_image)) 
	    		{
	    			if(!unlink($data->path_image))
	    			{
	    				return response()->json([
	    					'status' => false,
	    					'msg' => 'Tidak bisa menghapus gambar lama'
	    				], 500);
	    			}
	    		}
	    		$image = $request->file('image');
	    		$newImageName = rand() . '_' . $image->getClientOriginalName();
	    		$upload = $image->move(base_path('public/images/slider'), $newImageName);
	    		if($upload) {
	    			$data->nama = $request->input('nama');
	    			$data->image = url('/public/images/slider') . '/' .$newImageName;
	    			$data->path_image = base_path('public/images/slider') . '/' . $newImageName;
	    			// $data->path_image = $_SERVER['DOCUMENT_ROOT'] . '/images/slider/' . $newImageName;

	    			$data->save();

	    			return response()->json([
	    				'status' => true,
	    				'msg' => 'Slider berhasil diedit'
	    			], 200);
	    		}
	    		else {
	    			return response()->json([
	    				'status' => false,
	    				'msg' => 'Tidak bisa mengupload gambar'
	    			], 500);
	    		}
    		}
    		else {
    			$data->nama = $request->input('nama');
    			$data->save();
    			return response()->json([
    				'status' => true,
    				'msg' => 'Slider berhasil diedit'
    			], 200);
    		}
    	}
    	else
    	{
    		return response()->json([
    			'status' => false,
    			'msg' =>$validation->errors()->all()
    		], 400);
    	}
    }

    public function detail($encrypt_id)
    {
    	$id = Crypt::decrypt($encrypt_id);

    	$data = Slider::find($id);
    	return response()->json([
    		'status' => TRUE,
    		'data' => $data
    	], 200);
    }

    public function delete(Request $request)
    {
    	$id = Crypt::decrypt($request->input('encrypt_id'));

    	$data = Slider::find($id);
    	if(file_exists($data->path_image)) {
    		if(!unlink($data->path_image)) {
				return response()->json([
		    		'status' => FALSE,
		    		'msg' => 'Tidak dapat menghapus gambar lama'
		    	], 500);    			
    		}
    	}
    	$delete = $data->delete();
    	
    	if($delete) {
    		return response()->json([
	    		'status' => TRUE,
	    		'msg' => 'Data berhasil dihapus'
	    	]);
    	}

    	return response()->json([
    		'status' => FALSE,
    		'msg' => 'Something Wrong'
    	], 500);
    }
}
