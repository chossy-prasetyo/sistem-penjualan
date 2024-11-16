<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

class DashboardController extends Controller
{
  // halaman dashboard
  public function index()
  {
  	$barang = Barang::f01_get_barang()->get();
  	$jenis_barang = Barang::f02_get_jenis_barang()->get()->groupBy('jenis_id')->values();
  	$transaksi = Transaksi::f06_get_transaksi_dashboard()->get();

  	$data['barang'] = $barang->map(function($value, $index) use ($transaksi)
  	{
  		$transaksi_barang = $transaksi->where('barang_id', $value->id_barang);
      $transaksi_barang_count = $transaksi_barang->count();
      $terjual = $transaksi_barang->sum('terjual');
  		return [
  			'code_barang'	=> $value->code_barang,
  			'barang'			=> $value->barang,
  			'jenis'				=> $value->jenis,
  			'terjual'			=> $terjual,
  			'transaksi'		=> $transaksi_barang_count
  		];
  	})->sortBy('barang')->sortByDesc('transaksi')->sortByDesc('terjual')->values();



  	$data['jenis_barang'] = $jenis_barang->map(function($value, $index) use ($transaksi)
  	{
      $transaksi_jenis = $transaksi->where('jenis_id', $value->first()->jenis_id);
      $transaksi_jenis_count = $transaksi_jenis->count();
      $terjual_jenis = $transaksi_jenis->sum('terjual');
  		return [
  			'jenis'			=> $value->first()->jenis,
  			'terjual'		=> $terjual_jenis,
  			'transaksi'	=> $transaksi_jenis_count
  		];
  	})->sortBy('jenis')->sortByDesc('transaksi')->sortByDesc('terjual')->values();

  	return view('dashboard', $data);
  }





  // filter tanggal (from ajax)
  public function search(Request $request)
  {
  	$barang = Barang::f01_get_barang()->get();
  	$jenis_barang = Barang::f02_get_jenis_barang()->get()->groupBy('jenis_id')->values();
  	$data['barang'] = '';
  	$data['jenis_barang'] = '';

    if (empty($request->tanggal))
    {
    	$transaksi = Transaksi::f06_get_transaksi_dashboard()->get();
    }
    else
    {
      $ex_tanggal = explode(' - ', $request->tanggal);
      $start = date_create_from_format('m/d/Y', $ex_tanggal[0])->format('Y-m-d');
      $end = date_create_from_format('m/d/Y', $ex_tanggal[1])->format('Y-m-d');
      $transaksi = Transaksi::f07_get_transaksi_dashboard_periode($start, $end)->get();
    }





  	$daftar_barang = $barang->map(function($value, $index) use ($transaksi)
  	{
  		$transaksi_barang = $transaksi->where('barang_id', $value->id_barang);
      $transaksi_barang_count = $transaksi_barang->count();
      $terjual = $transaksi_barang->sum('terjual');
  		return [
  			'code_barang'	=> $value->code_barang,
  			'barang'			=> $value->barang,
  			'jenis'				=> $value->jenis,
  			'terjual'			=> $terjual,
  			'transaksi'		=> $transaksi_barang_count
  		];
  	})->sortBy('barang')->sortByDesc('transaksi')->sortByDesc('terjual')->values();

  	foreach ($daftar_barang as $index => $br)
  	{
  		$data['barang'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td>
            <a href="/barang-show?c='.$br['code_barang'].'" class="text-primary fw-bolder link-underline">'.$br['barang'].'</a><br>
            <small style="font-size: 11px;">'.$br['jenis'].'</small>
          </td>
          <td>'.(($br['terjual']) ? $br['terjual'] : '').'</td>
          <td>'.(($br['transaksi']) ? $br['transaksi'] : '').'</td>
        </tr>
  		';
  	}





  	$daftar_jenis = $jenis_barang->map(function($value, $index) use ($transaksi)
  	{
      $transaksi_jenis = $transaksi->where('jenis_id', $value->first()->jenis_id);
      $transaksi_jenis_count = $transaksi_jenis->count();
      $terjual_jenis = $transaksi_jenis->sum('terjual');
  		return [
  			'jenis'			=> $value->first()->jenis,
  			'terjual'		=> $terjual_jenis,
  			'transaksi'	=> $transaksi_jenis_count
  		];
  	})->sortBy('jenis')->sortByDesc('transaksi')->sortByDesc('terjual')->values();

  	foreach ($daftar_jenis as $index => $jenis)
  	{
  		$data['jenis_barang'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td class="fw-bolder">'.$jenis['jenis'].'</td>
          <td>'.(($jenis['terjual']) ? $jenis['terjual'] : '').'</td>
          <td>'.(($jenis['transaksi']) ? $jenis['transaksi'] : '').'</td>
        </tr>
  		';
  	}

    echo json_encode($data);
  }





  // sortir barang (from ajax)
  public function sort_barang(Request $request)
  {
  	$barang = Barang::f01_get_barang()->get();
  	$data['barang'] = '';

    if (empty($request->tanggal))
    {
    	$transaksi = Transaksi::f06_get_transaksi_dashboard()->get();
    }
    else
    {
      $ex_tanggal = explode(' - ', $request->tanggal);
      $start = date_create_from_format('m/d/Y', $ex_tanggal[0])->format('Y-m-d');
      $end = date_create_from_format('m/d/Y', $ex_tanggal[1])->format('Y-m-d');
      $transaksi = Transaksi::f07_get_transaksi_dashboard_periode($start, $end)->get();
    }



  	$barang_map = $barang->map(function($value, $index) use ($transaksi)
  	{
  		$transaksi_barang = $transaksi->where('barang_id', $value->id_barang);
      $transaksi_barang_count = $transaksi_barang->count();
      $terjual = $transaksi_barang->sum('terjual');
  		return [
  			'code_barang'	=> $value->code_barang,
  			'barang'			=> $value->barang,
  			'jenis'				=> $value->jenis,
  			'terjual'			=> $terjual,
  			'transaksi'		=> $transaksi_barang_count
  		];
  	});



  	$second_column = ($request->column == 'terjual') ? 'transaksi' : 'terjual';

  	if ($request->sort == 'desc') {
  		$daftar_barang = $barang_map->sortBy('barang')->sortByDesc($second_column)->sortByDesc($request->column)->values();
  	}
  	else {
  		$daftar_barang = $barang_map->sortBy('barang')->sortByDesc($second_column)->sortBy($request->column)->values();
  	}

  	foreach ($daftar_barang as $index => $br)
  	{
  		$data['barang'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td>
            <a href="/barang-show?c='.$br['code_barang'].'" class="text-primary fw-bolder link-underline">'.$br['barang'].'</a><br>
            <small style="font-size: 11px;">'.$br['jenis'].'</small>
          </td>
          <td>'.(($br['terjual']) ? $br['terjual'] : '').'</td>
          <td>'.(($br['transaksi']) ? $br['transaksi'] : '').'</td>
        </tr>
  		';
  	}

  	echo json_encode($data);
  }





  // sortir jenis barang (from ajax)
  public function sort_jenis_barang(Request $request)
  {
  	$jenis_barang = Barang::f02_get_jenis_barang()->get()->groupBy('jenis_id')->values();
  	$data['jenis_barang'] = '';

    if (empty($request->tanggal))
    {
    	$transaksi = Transaksi::f06_get_transaksi_dashboard()->get();
    }
    else
    {
      $ex_tanggal = explode(' - ', $request->tanggal);
      $start = date_create_from_format('m/d/Y', $ex_tanggal[0])->format('Y-m-d');
      $end = date_create_from_format('m/d/Y', $ex_tanggal[1])->format('Y-m-d');
      $transaksi = Transaksi::f07_get_transaksi_dashboard_periode($start, $end)->get();
    }



  	$jenis_barang_map = $jenis_barang->map(function($value, $index) use ($transaksi)
  	{
      $transaksi_jenis = $transaksi->where('jenis_id', $value->first()->jenis_id);
      $transaksi_jenis_count = $transaksi_jenis->count();
      $terjual_jenis = $transaksi_jenis->sum('terjual');
  		return [
  			'jenis'			=> $value->first()->jenis,
  			'terjual'		=> $terjual_jenis,
  			'transaksi'	=> $transaksi_jenis_count
  		];
  	});



  	$second_column = ($request->column == 'terjual') ? 'transaksi' : 'terjual';

  	if ($request->sort == 'desc') {
  		$daftar_jenis = $jenis_barang_map->sortBy('jenis')->sortByDesc($second_column)->sortByDesc($request->column)->values();
  	}
  	else {
  		$daftar_jenis = $jenis_barang_map->sortBy('jenis')->sortByDesc($second_column)->sortBy($request->column)->values();
  	}

  	foreach ($daftar_jenis as $index => $jenis)
  	{
  		$data['jenis_barang'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td class="fw-bolder">'.$jenis['jenis'].'</td>
          <td>'.(($jenis['terjual']) ? $jenis['terjual'] : '').'</td>
          <td>'.(($jenis['transaksi']) ? $jenis['transaksi'] : '').'</td>
        </tr>
  		';
  	}

  	echo json_encode($data);
  }
}
