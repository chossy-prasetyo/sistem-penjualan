<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\JenisBarang as Jenis;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Transaksi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

    	Jenis::insert([['jenis' => 'Konsumsi'], ['jenis' => 'Pembersih']]);

    	Barang::insert([
    		[
    			'code_barang'	=> strtoupper(Str::random(8)),
    			'jenis_id'		=> 1,
    			'barang'			=> 'Kopi',
    			'created_at'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'code_barang'	=> strtoupper(Str::random(8)),
    			'jenis_id'		=> 1,
    			'barang'			=> 'Teh',
    			'created_at'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'code_barang'	=> strtoupper(Str::random(8)),
    			'jenis_id'		=> 2,
    			'barang'			=> 'Pasta Gigi',
    			'created_at'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'code_barang'	=> strtoupper(Str::random(8)),
    			'jenis_id'		=> 2,
    			'barang'			=> 'Sabun Mandi',
    			'created_at'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'code_barang'	=> strtoupper(Str::random(8)),
    			'jenis_id'		=> 2,
    			'barang'			=> 'Sampo',
    			'created_at'	=> '2024-11-01 00:00:00'
    		]
    	]);

    	Stok::insert([
    		[
    			'barang_id'			=> 1,
    			'stok'					=> 100,
    			'tanggal_stok'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'barang_id'			=> 2,
    			'stok'					=> 100,
    			'tanggal_stok'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'barang_id'			=> 3,
    			'stok'					=> 100,
    			'tanggal_stok'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'barang_id'			=> 4,
    			'stok'					=> 100,
    			'tanggal_stok'	=> '2024-11-01 00:00:00'
    		],
    		[
    			'barang_id'			=> 5,
    			'stok'					=> 100,
    			'tanggal_stok'	=> '2024-11-01 00:00:00'
    		]
    	]);

    	Transaksi::insert([
    		[
    			'barang_id'					=> 1,
    			'terjual'						=> 10,
    			'tanggal_transaksi'	=> '2024-11-01 10:00:00',
    		],
    		[
    			'barang_id'					=> 2,
    			'terjual'						=> 19,
    			'tanggal_transaksi'	=> '2024-11-05 10:00:00',
    		],
    		[
    			'barang_id'					=> 1,
    			'terjual'						=> 15,
    			'tanggal_transaksi'	=> '2024-11-10 10:00:00',
    		],
    		[
    			'barang_id'					=> 3,
    			'terjual'						=> 20,
    			'tanggal_transaksi'	=> '2024-11-11 10:00:00',
    		],
    		[
    			'barang_id'					=> 4,
    			'terjual'						=> 30,
    			'tanggal_transaksi'	=> '2024-11-11 11:00:00',
    		],
    		[
    			'barang_id'					=> 5,
    			'terjual'						=> 25,
    			'tanggal_transaksi'	=> '2024-11-12 10:00:00',
    		],
    		[
    			'barang_id'					=> 2,
    			'terjual'						=> 5,
    			'tanggal_transaksi'	=> '2024-11-12 11:00:00',
    		]
    	]);
    }
}
