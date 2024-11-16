<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\JenisBarang as Jenis;

class BarangController extends Controller
{
  // halaman daftar barang
  public function index()
  {
  	$data['barang'] = Barang::f01_get_barang()->get();
  	$data['stok'] = Stok::select('barang_id', 'stok')->get();
  	$data['transaksi'] = Transaksi::select('barang_id', 'terjual')->get();
  	$data['jenis_barang'] = Jenis::whereNull('deleted_at')->orderBy('jenis')->get();
  	return view('barang', $data);
  }





  // tambah barang baru
  public function store(Request $input)
  {
    if (Barang::where('barang', $input->barang)->exists())
    {
      return redirect('/barang')->with([
        'alert_failed'  => $input->barang.' sudah ada',
        'show_modal'    => 'show',
        'barang'        => $input->barang,
        'jenis'         => $input->jenis,
        'stok'          => $input->stok
      ]);
    }

    $code_barang = strtoupper(Str::random(8));

  	$insert = [
  		'code_barang'		=> $code_barang,
  		'barang'				=> $input->barang,
  		'jenis_id'			=> $input->jenis,
  		'created_at'		=> date('Y-m-d')
  	];

  	$id_barang = Barang::insertGetId($insert);

  	$insert_stok = [
  		'barang_id'			=> $id_barang,
  		'stok'					=> $input->stok,
  		'tanggal_stok'	=> date_create_from_format('d F Y', $input->tanggal)->format('Y-m-d').date(' H:i:s')
  	];

  	Stok::insert($insert_stok);
  	return redirect('/barang-show?c='.$code_barang)->with('alert_success', 'Success');
  }





  // update barang
  public function update(Request $input)
  {
    $redirect = (empty($input->code_barang)) ? '' : '-show?c='.$input->code_barang;

    if (Barang::where('id_barang', '!=', $input->id_barang)->where('barang', $input->barang)->exists())
    {
      return redirect('/barang'.$redirect)->with([
        'alert_failed'    => $input->barang.' sudah ada',
        'show_modal_edit' => 'show',
        'id_barang'       => $input->id_barang
      ]);
    }

  	Barang::where('id_barang', $input->id_barang)->update(['barang' => $input->barang, 'jenis_id' => $input->jenis]);
  	return redirect('/barang'.$redirect)->with('alert_success', 'Success');
  }





  // halaman detail barang
  public function show()
  {
    if (! request()->has('c')) abort(404);
    $data['barang'] = Barang::f03_get_detail_barang(request('c'))->first();
    if (empty($data['barang'])) abort(404);

  	$data['barang'] = Barang::f03_get_detail_barang(request('c'))->first();
  	$data['jenis_barang'] = Jenis::whereNull('deleted_at')->orderBy('jenis')->get();
    $data['stok'] = Stok::where('barang_id', $data['barang']->id_barang)->orderBy('tanggal_stok', 'desc')->get();
    $data['transaksi'] = Transaksi::where('barang_id', $data['barang']->id_barang)->orderBy('tanggal_transaksi', 'desc')->get();
  	return view('barang_show', $data);
  }





  // tambah stok
  public function store_stok(Request $input)
  {
  	$insert = [
  		'barang_id'			=> $input->id_barang,
  		'stok'					=> $input->stok,
  		'tanggal_stok'	=> date_create_from_format('d F Y', $input->tanggal)->format('Y-m-d').date(' H:i:s')
  	];

  	Stok::insert($insert);
  	$redirect = (empty($input->code_barang)) ? '' : '-show?c='.$input->code_barang;
  	return redirect('/barang'.$redirect)->with('alert_success', 'Success');
  }





  // hapus barang
  public function delete($id)
  {
    Barang::where('id_barang', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
    return redirect('/barang')->with('alert_success', 'Success');
  }
}
