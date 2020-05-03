<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Imports\PasienImport;
use Excel;
use App\Pasien;

class ExcelParserController extends Controller
{
    public function import(Request $request)
    {
    	// set validation
    	$this->validate($request, [
    		'uploaded_file' => 'required|mimes:xls,xlsx'
    	]);

    	// set temporary path from uploaded file
    	$file = $request->file('uploaded_file');

    	$datas = Excel::toCollection(new PasienImport, $file);
    	$insert_data = [];

    	return response()->json([
			'status' => TRUE,
			'msg' => 'Data excel berhasil disimpan',
			'data' => $datas
		], 500);

    	// Validation and store values
    	if($datas->count() > 0) {

			foreach($datas as $row) {
				if(count($insert_data) > 1) {
					$availableData = Pasien::get_data_by('id_pasien_status', $row['status'], $row);
					$jumlah = $row['jumlah'];
					
					// Sum available jumlah dengan setiap row
					foreach($availableData as $key => $value) {
						$jumlah += $value->jumlah;
					}

					$insert_data[] = array(
						'id_kabkota' => $row['kota'],
						'id_pasien_status' => $row['status'],
						'tgl_input' => $row['tgl_input'],
						'jumlah' => $jumlah,
					);
				}
				else {
					$insert_data[] = array(
						'id_kabkota' => $row['kota'],
						'id_pasien_status' => $row['status'],
						'tgl_input' => $row['tgl_input'],
						'jumlah' => $row['jumlah'],
					);
				}
			}
    	}
    	else {
    		return response()->json([
    			'status' => FALSE,
    			'msg' => ['Excel File harus memiliki data pasien!']
    		], 400);
    	}

    	// Insert to DB
    	if(count($insert_data) > 0) {
    		$inserted = Pasien::insert($insert_data);

    		if($inserted) {
    			return response()->json([
    				'status' => TRUE,
    				'msg' => 'Data excel berhasil disimpan'
    			], 200);
    		}
    		else {
    			return response()->json([
    				'status' => FALSE,
    				'msg' => 'Data excel gagal disimpan'
    			], 500);
    		}
    	}

    }
}
