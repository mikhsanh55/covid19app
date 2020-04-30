<?php

use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// 6 => OTG, 4 => ODP PRoses, 7 => ODP Selesai, 
        $data = [
        	['id_kabkota' => 436, 'id_pasien_status' => 6, 'jumlah' => 6, 'tgl_input' => '2020-04-20'],
        	['id_kabkota' => 436, 'id_pasien_status' => 4, 'jumlah' => 43, 'tgl_input' => '2020-04-20'],
        	['id_kabkota' => 436, 'id_pasien_status' => 7, 'jumlah' => 88, 'tgl_input' => '2020-04-20'],
        	['id_kabkota' => 436, 'id_pasien_status' => 2, 'jumlah' => 5,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 437, 'id_pasien_status' => 6, 'jumlah' => 4,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 437, 'id_pasien_status' => 5, 'jumlah' => 2,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 437, 'id_pasien_status' => 7, 'jumlah' => 12,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 437, 'id_pasien_status' => 1, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 438, 'id_pasien_status' => 6, 'jumlah' => 60,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 4, 'jumlah' => 27,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 7, 'jumlah' => 139,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 5, 'jumlah' => 3,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 8, 'jumlah' => 5,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 2, 'jumlah' => 5,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 1, 'jumlah' => 4,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 438, 'id_pasien_status' => 3, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 439, 'id_pasien_status' => 4, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 439, 'id_pasien_status' => 7, 'jumlah' => 3,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 439, 'id_pasien_status' => 5, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 441, 'id_pasien_status' => 4, 'jumlah' => 3,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 442, 'id_pasien_status' => 4, 'jumlah' => 10,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 442, 'id_pasien_status' => 7, 'jumlah' => 23,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 442, 'id_pasien_status' => 5, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 443, 'id_pasien_status' => 6, 'jumlah' => 4,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 11, 'jumlah' => 4,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 4, 'jumlah' => 11,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 7, 'jumlah' => 41,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 5, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 2, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 443, 'id_pasien_status' => 3, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 444, 'id_pasien_status' => 4, 'jumlah' => 8,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 444, 'id_pasien_status' => 7, 'jumlah' => 97,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 444, 'id_pasien_status' => 8, 'jumlah' => 3,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 446, 'id_pasien_status' => 6, 'jumlah' => 30,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 446, 'id_pasien_status' => 4, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 446, 'id_pasien_status' => 7, 'jumlah' => 2,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 446, 'id_pasien_status' => 2, 'jumlah' => 1,  'tgl_input' => '2020-04-20'], 

        	['id_kabkota' => 447, 'id_pasien_status' => 11, 'jumlah' => 12,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 447, 'id_pasien_status' => 4, 'jumlah' => 3,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 447, 'id_pasien_status' => 7, 'jumlah' => 15,  'tgl_input' => '2020-04-20'], 


        	['id_kabkota' => 476, 'id_pasien_status' => 6, 'jumlah' => 6,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 1, 'jumlah' => 56,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 4, 'jumlah' => 50,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 7, 'jumlah' => 82,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 5, 'jumlah' => 6,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 8, 'jumlah' => 11,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 2, 'jumlah' => 4,  'tgl_input' => '2020-04-20'], 
        	['id_kabkota' => 476, 'id_pasien_status' => 3, 'jumlah' => 2,  'tgl_input' => '2020-04-20']
        ];

        foreach ($data as $key => $value) {
        	DB::table('pasiens')->insert($value);
        }
    }
}
