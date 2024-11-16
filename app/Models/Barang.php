<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  use HasFactory;
  protected $table = 'barang';
  protected $primaryKey = 'id_barang';
  public $timestamps = false;

  // get daftar barang
  public static function f01_get_barang()
  {
  	return self::whereNull('barang.deleted_at')
  								->orderBy('barang')
  								->join('jenis_barang', 'id_jenis', 'jenis_id')
  								->select('barang.*', 'jenis');
  }



  // get daftar jenis barang
  public static function f02_get_jenis_barang()
  {
    return self::whereNull('barang.deleted_at')
                  ->join('jenis_barang', 'id_jenis', 'jenis_id')
                  ->orderBy('jenis')
                  ->select('jenis_id', 'jenis');
  }



  // get detail barang
  public static function f03_get_detail_barang($code)
  {
    return self::where('code_barang', $code)
                ->join('jenis_barang', 'id_jenis', 'jenis_id')
                ->select('barang.*', 'jenis');
  }
}
