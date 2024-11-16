<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  use HasFactory;
  protected $table = 'transaksi';
  protected $primaryKey = 'id_transaksi';
  public $timestamps = false;

  // get daftar transaksi
  public static function f01_get_transaksi()
  {
  	return self::whereNull('barang.deleted_at')
                ->join('barang', 'id_barang', 'barang_id')
  							->join('jenis_barang', 'id_jenis', 'jenis_id')
  							->orderBy('tanggal_transaksi', 'desc')
  							->select('transaksi.*', 'barang', 'code_barang', 'jenis');
  }



  // cari transaksi
  public static function f02_cari_transaksi($search)
  {
  	return self::whereNull('barang.deleted_at')
                ->where(function($query) use ($search)
                {
                  $query->where('barang', 'like', '%'.$search.'%')
                        ->orWhere('jenis', 'like', '%'.$search.'%');
                })
								->join('barang', 'id_barang', 'barang_id')
								->join('jenis_barang', 'id_jenis', 'jenis_id')
								->orderBy('tanggal_transaksi', 'desc')
								->select('transaksi.*', 'barang', 'code_barang', 'jenis');
  }



  // cari transaksi + tanggal
  public static function f03_cari_transaksi_tanggal($search, $tanggal)
  {
  	return self::whereNull('barang.deleted_at')
                ->where(function($query) use ($search)
						  	{
						  		$query->where('barang', 'like', '%'.$search.'%')
						  					->orWhere('jenis', 'like', '%'.$search.'%');
						  	})
  							->where('tanggal_transaksi', 'like', $tanggal.'%')
  							->join('barang', 'id_barang', 'barang_id')
  							->join('jenis_barang', 'id_jenis', 'jenis_id')
  							->orderBy('tanggal_transaksi', 'desc')
  							->select('transaksi.*', 'barang', 'code_barang', 'jenis');
  }



  // sort transaksi
  public static function f04_sort_transaksi($search, $column, $sort)
  {
  	return self::whereNull('barang.deleted_at')
                ->where(function($query) use ($search)
                {
                  $query->where('barang', 'like', '%'.$search.'%')
                        ->orWhere('jenis', 'like', '%'.$search.'%');

                })
								->join('barang', 'id_barang', 'barang_id')
								->join('jenis_barang', 'id_jenis', 'jenis_id')
								->orderBy($column, $sort)
								->select('transaksi.*', 'barang', 'code_barang', 'jenis');
  }



  // sort transaksi + tanggal
  public static function f05_sort_transaksi_tanggal($search, $tanggal, $column, $sort)
  {
  	return self::whereNull('barang.deleted_at')
                ->where(function($query) use ($search)
						  	{
						  		$query->where('barang', 'like', '%'.$search.'%')
						  					->orWhere('jenis', 'like', '%'.$search.'%');
						  	})
  							->where('tanggal_transaksi', 'like', $tanggal.'%')
  							->join('barang', 'id_barang', 'barang_id')
  							->join('jenis_barang', 'id_jenis', 'jenis_id')
  							->orderBy($column, $sort)
  							->select('transaksi.*', 'barang', 'code_barang', 'jenis');
  }



  // get daftar transaksi (for dashboard)
  public static function f06_get_transaksi_dashboard()
  {
    return self::whereNull('barang.deleted_at')
                ->join('barang', 'id_barang', 'barang_id')
                ->join('jenis_barang', 'id_jenis', 'jenis_id')
                ->select('transaksi.*', 'jenis_id');
  }



  // get daftar transaksi + periode (for dashboard)
  public static function f07_get_transaksi_dashboard_periode($start, $end)
  {
    return self::whereNull('barang.deleted_at')
                ->whereBetween('tanggal_transaksi', [$start.' 00:00:00', $end.' 23:59:59'])
                ->join('barang', 'id_barang', 'barang_id')
                ->join('jenis_barang', 'id_jenis', 'jenis_id')
                ->select('transaksi.*', 'jenis_id');
  }
}
