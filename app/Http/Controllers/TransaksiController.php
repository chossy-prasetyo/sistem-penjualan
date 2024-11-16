<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Stok;
use App\Models\Barang;

class TransaksiController extends Controller
{
  // halaman daftar transaksi
  public function index()
  {
  	$data['transaksi'] = Transaksi::f01_get_transaksi()->get();
  	$data['stok'] = Stok::all();
  	$data['barang'] = Barang::whereNull('deleted_at')->orderBy('barang')->get();
  	return view('transaksi', $data);
  }





  // cari transaksi (from ajax)
  public function search(Request $request)
  {
  	if (empty($request->tanggal)) $transaksi = Transaksi::f02_cari_transaksi($request->search)->get();
  	else
  	{
  		$tanggal = date_create_from_format('d F Y', $request->tanggal)->format('Y-m-d');
  		$transaksi = Transaksi::f03_cari_transaksi_tanggal($request->search, $tanggal)->get();
  	}

  	$data['transaksi'] = '';
  	$stok = Stok::all();

  	foreach ($transaksi as $index => $tr)
  	{
      $stok_per_date = $stok->where('barang_id', $tr->barang_id)
                            ->where('tanggal_stok', '<=', $tr->tanggal_transaksi)
                            ->sum('stok');

      $terjual_before_date = $transaksi->where('barang_id', $tr->barang_id)
                                        ->where('tanggal_transaksi', '<', $tr->tanggal_transaksi)
                                        ->sum('terjual');

      $stok_all = $stok->where('barang_id', $tr->barang_id)->sum('stok');
      $terjual_all = $transaksi->where('barang_id', $tr->barang_id)->sum('terjual');

  		$data['transaksi'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td class="text-primary fw-bolder">
            <a href="/barang-show?c='.$tr->code_barang.'" class="link-underline">'.$tr->barang.'</a>
          </td>
          <td>'.($stok_per_date - $terjual_before_date).'</td>
          <td>'.$tr->terjual.'</td>
          <td style="font-size: 14px;">'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y').'</td>
          <td class="fst-italic" style="font-size: 14px;">'.$tr->jenis.'</td>
          <td>
            <a href="#" class="action-hover position-relative" style="border-radius: 6px; padding: 0.35rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots-vertical position-relative" style="top: 2px;"></i></a>

            <div class="dropdown-menu shadow-sm border" style="min-width: 12rem; font-size: 14px;">
              <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-transaksi-'.$tr->id_transaksi.'">
                <i class="bi bi-pencil me-3 position-relative" style="top: 3px;"></i> Edit
              </a>

              <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#hapus-transaksi-'.$tr->id_transaksi.'">
                <i class="bi bi-trash me-3 position-relative" style="top: 3px;"></i> Hapus
              </a>
            </div>
          </td>
        </tr>





        <!-- modal edit transaksi -->
        <div class="modal fade text-left modal-borderless" id="edit-transaksi-'.$tr->id_transaksi.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px;">
              <div class="modal-body pt-4 px-4">
                <h6 class="mb-3">Edit Transaksi</h6>

                <form action="/transaksi/update" method="post">
                  '.csrf_field().'
                  <input type="hidden" name="id_transaksi" value="'.$tr->id_transaksi.'">

                  <div class="form-group mb-4">
                    <label class="form-label" style="font-size: 14px;">Barang</label>
                    <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="'.$tr->barang.'">
                  </div>

                  <div class="form-group mb-4">
                    <label class="form-label" style="font-size: 14px;">
                      Stok
                      <small class="text-secondary ms-2 fw-light">(Stok - Penjualan Lain)</small>
                    </label>
                    <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" name="stok" readonly value="'.(($stok_all - $terjual_all) + $tr->terjual).'">
                  </div>

                  <div class="form-group mb-4">
                    <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal</label>
                    <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d F Y').'">
                  </div>

                  <div class="form-group">
                    <label class="form-label" for="terjual" style="font-size: 14px;">Terjual</label>
                    <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" id="terjual" name="terjual" autocomplete="off" required value="'.$tr->terjual.'">
                  </div>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn fw-bold btn-primary tambah-simpan ml-1">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>





        <!-- modal hapus transaksi -->
        <div class="modal fade text-left modal-borderless" id="hapus-transaksi-'.$tr->id_transaksi.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px;">
              <div class="modal-body pt-4 px-4">
                <h6 class="mb-2">Hapus transaksi ?</h6>
                <p class="mb-0" style="font-size: 13px;">
                  <span class="fw-bold">'.$tr->barang.'</span> : '.$tr->terjual.'
                  <span class="fst-italic ms-3">'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y').'</span>
                </p>
              </div>
              <div class="modal-footer pt-0 d-flex justify-content-end">
                <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                <a href="/transaksi/delete/'.$tr->id_transaksi.'" class="btn fw-bold btn-primary tambah-ya ms-1">Ya</a>
              </div>
            </div>
          </div>
        </div>
  		';
  	}

  	echo json_encode($data);
  }





  // sortir transaksi (from ajax)
  public function sort(Request $request)
  {
  	if (empty($request->tanggal))
  	{
  		$transaksi = Transaksi::f04_sort_transaksi($request->search, $request->column, $request->sort)->get();
  	}
  	else
  	{
  		$tanggal = date_create_from_format('d F Y', $request->tanggal)->format('Y-m-d');
  		$transaksi = Transaksi::f05_sort_transaksi_tanggal($request->search, $tanggal, $request->column, $request->sort)->get();
  	}

  	$data['transaksi'] = '';
  	$stok = Stok::all();

  	foreach ($transaksi as $index => $tr)
  	{
      $stok_per_date = $stok->where('barang_id', $tr->barang_id)
                            ->where('tanggal_stok', '<=', $tr->tanggal_transaksi)
                            ->sum('stok');

      $terjual_before_date = $transaksi->where('barang_id', $tr->barang_id)
                                        ->where('tanggal_transaksi', '<', $tr->tanggal_transaksi)
                                        ->sum('terjual');

      $stok_all = $stok->where('barang_id', $tr->barang_id)->sum('stok');
      $terjual_all = $transaksi->where('barang_id', $tr->barang_id)->sum('terjual');

  		$data['transaksi'] .= '
        <tr>
          <td class="text-center py-3 px-0" style="width: 60px;">'.++$index.'</td>
          <td class="text-primary fw-bolder">
            <a href="/barang-show?c='.$tr->code_barang.'" class="link-underline">'.$tr->barang.'</a>
          </td>
          <td>'.($stok_per_date - $terjual_before_date).'</td>
          <td>'.$tr->terjual.'</td>
          <td style="font-size: 14px;">'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y').'</td>
          <td class="fst-italic" style="font-size: 14px;">'.$tr->jenis.'</td>
          <td>
            <a href="#" class="action-hover position-relative" style="border-radius: 6px; padding: 0.35rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots-vertical position-relative" style="top: 2px;"></i></a>

            <div class="dropdown-menu shadow-sm border" style="min-width: 12rem; font-size: 14px;">
              <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-transaksi-'.$tr->id_transaksi.'">
                <i class="bi bi-pencil me-3 position-relative" style="top: 3px;"></i> Edit
              </a>

              <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#hapus-transaksi-'.$tr->id_transaksi.'">
                <i class="bi bi-trash me-3 position-relative" style="top: 3px;"></i> Hapus
              </a>
            </div>
          </td>
        </tr>





        <!-- modal edit transaksi -->
        <div class="modal fade text-left modal-borderless" id="edit-transaksi-'.$tr->id_transaksi.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px;">
              <div class="modal-body pt-4 px-4">
                <h6 class="mb-3">Edit Transaksi</h6>

                <form action="/transaksi/update" method="post">
                  '.csrf_field().'
                  <input type="hidden" name="id_transaksi" value="'.$tr->id_transaksi.'">

                  <div class="form-group mb-4">
                    <label class="form-label" style="font-size: 14px;">Barang</label>
                    <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="'.$tr->barang.'">
                  </div>

                  <div class="form-group mb-4">
                    <label class="form-label" style="font-size: 14px;">
                      Stok
                      <small class="text-secondary ms-2 fw-light">(Stok - Penjualan Lain)</small>
                    </label>
                    <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" name="stok" readonly value="'.(($stok_all - $terjual_all) + $tr->terjual).'">
                  </div>

                  <div class="form-group mb-4">
                    <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal</label>
                    <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d F Y').'">
                  </div>

                  <div class="form-group">
                    <label class="form-label" for="terjual" style="font-size: 14px;">Terjual</label>
                    <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" id="terjual" name="terjual" autocomplete="off" required value="'.$tr->terjual.'">
                  </div>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn fw-bold btn-primary tambah-simpan ml-1">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>





        <!-- modal hapus transaksi -->
        <div class="modal fade text-left modal-borderless" id="hapus-transaksi-'.$tr->id_transaksi.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px;">
              <div class="modal-body pt-4 px-4">
                <h6 class="mb-2">Hapus transaksi ?</h6>
                <p class="mb-0" style="font-size: 13px;">
                  <span class="fw-bold">'.$tr->barang.'</span> : '.$tr->terjual.'
                  <span class="fst-italic ms-3">'.date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y').'</span>
                </p>
              </div>
              <div class="modal-footer pt-0 d-flex justify-content-end">
                <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                <a href="/transaksi/delete/'.$tr->id_transaksi.'" class="btn fw-bold btn-primary tambah-ya ms-1">Ya</a>
              </div>
            </div>
          </div>
        </div>
  		';
  	}

  	echo json_encode($data);
  }





  // cari stok suatu barang (from ajax)
  public function search_stok(Request $request)
  {
  	$stok = Stok::where('barang_id', $request->barang)->sum('stok');
  	$terjual = Transaksi::where('barang_id', $request->barang)->sum('terjual');
  	echo json_encode($stok - $terjual);
  }





  // tambah transaksi baru
  public function store(Request $input)
  {
    if ($input->terjual > $input->stok)
    {
      return redirect('/transaksi')->with([
        'alert_failed'  => 'Stok tidak cukup',
        'show_modal'    => 'show',
        'barang'        => $input->barang,
        'stok'          => $input->stok,
        'tanggal'       => $input->tanggal,
        'terjual'       => $input->terjual
      ]);
    }

  	$insert = [
  		'barang_id'					=> $input->barang,
  		'terjual'						=> $input->terjual,
  		'tanggal_transaksi'	=> date_create_from_format('d F Y', $input->tanggal)->format('Y-m-d').date(' H:i:s')
  	];

  	Transaksi::insert($insert);
  	return redirect('/transaksi')->with('alert_success', 'Success');
  }





  // update transaksi
  public function update(Request $input)
  {
    if ($input->terjual > $input->stok)
    {
      return redirect('/transaksi')->with([
        'alert_failed'    => 'Stok tidak cukup',
        'show_modal_edit' => 'show',
        'id_transaksi'    => $input->id_transaksi
      ]);
    }

  	Transaksi::where('id_transaksi', $input->id_transaksi)->update(['terjual' => $input->terjual]);
  	return redirect('/transaksi')->with('alert_success', 'Success');
  }





  // hapus transaksi
  public function delete($id)
  {
  	Transaksi::destroy($id);
  	return redirect('/transaksi')->with('alert_success', 'Success');
  }
}
