@extends('template')
@section('title', 'Detail Barang')
@section('active_barang', 'active')

@section('content')
  <style>
    .tambah-batal {
      font-size: 12px;
      border-radius: 8px;
      padding: 8px 32px;
    }

    .tambah-simpan {
      font-size: 12px;
      border-radius: 8px;
      padding: 8px 26px;
    }

    .tambah-ya {
      font-size: 12px;
      border-radius: 8px;
      padding: 8px 36px;
    }
  </style>

  <div class="page-heading mb-2">
    <div class="page-title d-flex justify-content-between">
      <h5 class="d-flex align-items-center fw-light">
        <a href="/barang" class="d-block px-2 me-2 py-1 position-relative action-hover text-body" style="border-radius: 6px;"><i class="bi bi-arrow-left mt-2 position-relative" style="top: 3px;"></i></a>
        Detail
      </h5>
      <div class="d-flex">
        <div>
          <button class="btn btn-primary d-flex font-bold py-2" style="border-radius: 8px; font-size: 13px; padding-left: 0.7rem; padding-right: 0.7rem;" title="Tambah Stok" data-bs-toggle="modal" data-bs-target="#tambah-stok"><i class="bi bi-box-seam" style="margin-top: 2px;"></i></button>
        </div>

        <div class="ms-2">
          <button class="btn btn-success d-flex font-bold py-2" style="border-radius: 8px; font-size: 13px; padding-left: 0.7rem; padding-right: 0.7rem;" title="Edit" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-pencil" style="margin-top: 2px;"></i></button>

          <div class="dropdown-menu dropdown-static mt-3 shadow-sm border p-3" style="border-radius: 8px; min-width: 18rem;">
            <form action="/barang/update" method="post">
              @csrf
              <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
              <input type="hidden" name="code_barang" value="{{ $barang->code_barang }}">

              <div class="form-group mb-4">
                <input type="text" class="form-control mt-2" style="border-radius: 8px;" name="barang" autocomplete="off" required value="{{ $barang->barang }}">
              </div>

              <div class="form-group mb-4">
                <label class="form-label" for="jenis" style="font-size: 14px;">Jenis</label>
                <select class="form-select mt-1" name="jenis" id="jenis" style="border-radius: 8px;" required>
                  <option value=""></option>
                  @foreach ($jenis_barang as $jenis)
                    <option value="{{ $jenis->id_jenis }}" @if ($jenis->id_jenis == $barang->jenis_id) selected @endif>{{ $jenis->jenis }}</option>
                  @endforeach
                </select>
              </div>

              <div class="d-flex justify-content-center">
                <button type="submit" class="btn fw-bold btn-success px-3" style="border-radius: 8px; font-size: 12px;">Simpan</button>
              </div>
            </form>
          </div>
        </div>

        <div class="ms-2">
          <button class="btn btn-danger d-flex font-bold py-2" style="border-radius: 8px; font-size: 13px; padding-left: 0.7rem; padding-right: 0.7rem;" title="Hapus" data-bs-toggle="modal" data-bs-target="#hapus-barang"><i class="bi bi-trash" style="margin-top: 2px;"></i></button>
        </div>
      </div>
    </div>
  </div>

  <div class="page-content">
    <div class="card shadow-none border overflow-hidden" style="border-radius: 8px; margin-bottom: 2.5rem;">
      <div class="card-body pb-3">
        <h6 class="mb-1">{{ $barang->barang }}</h6>
        <small style="font-size: 12px;">{{ $barang->jenis }}</small>
        @php $sum_terjual = $transaksi->sum('terjual') @endphp
        <p class="mt-3 mb-0">
          <span class="me-4"><span class="fst-italic me-2" style="font-size: 14px;">Stok :</span> {{ $stok->sum('stok') - $sum_terjual }}</span>
          <span class="me-4"><span class="fst-italic me-2" style="font-size: 14px;">Terjual :</span> {{ $sum_terjual }}</span>
          <span class="me-4"><span class="fst-italic me-2" style="font-size: 14px;">Transaksi :</span> {{ $transaksi->count() }}</span>
        </p>
      </div>
    </div>



    <div class="row">
      @if ($stok->count())
        <div class="col-lg-6">
          <h6 class="mb-3" style="font-size: 14px;">Stok Masuk</h6>
          <div class="card shadow-none border overflow-hidden" style="border-radius: 8px;">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" style="font-size: 14px;">
                  <thead class="bg-light">
                    <tr>
                      <th></th>
                      <th class="py-3">Tanggal</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($stok as $st)
                      <tr>
                        <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                        <td>{{ date_create_from_format('Y-m-d H:i:s', $st->tanggal_stok)->format('d-m-Y') }}</td>
                        <td>{{ $st->stok }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @endif
      @if ($transaksi->count())
        <div class="col-lg-6">
          <h6 class="mb-3" style="font-size: 14px;">Transaksi</h6>
          <div class="card shadow-none border overflow-hidden" style="border-radius: 8px;">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0" style="font-size: 14px;">
                  <thead class="bg-light">
                    <tr>
                      <th></th>
                      <th class="py-3">Tanggal</th>
                      <th>Stok</th>
                      <th>Terjual</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($transaksi as $tr)
                      @php
                        $stok_per_date = $stok->where('tanggal_stok', '<=', $tr->tanggal_transaksi)->sum('stok');
                        $terjual_before_date = $transaksi->where('tanggal_transaksi', '<', $tr->tanggal_transaksi)->sum('terjual');
                      @endphp

                      <tr>
                        <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                        <td>{{ date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y') }}</td>
                        <td>{{ $stok_per_date - $terjual_before_date }}</td>
                        <td>{{ $tr->terjual }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>





  <!-- modal tambah stok -->
  <div class="modal fade text-left modal-borderless" id="tambah-stok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-body pt-4 px-4">
          <form action="/barang/store_stok" method="post">
            @csrf
            <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
            <input type="hidden" name="code_barang" value="{{ $barang->code_barang }}">

            <div class="form-group mb-4">
              <label class="form-label" for="stok" style="font-size: 14px;">Tambah Stok</label>
              <input type="number" class="form-control mt-1" style="border-radius: 8px;" id="stok" name="stok" autocomplete="off" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal</label>
              <input type="text" class="form-control mt-2 datepicker" style="border-radius: 8px; padding: 0.375rem 0.75rem;" id="tanggal" name="tanggal" autocomplete="off" required value="{{ date('d F Y') }}">
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





  <!-- modal hapus barang -->
  <div class="modal fade text-left modal-borderless" id="hapus-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-body pt-4 px-4">
          <h6 class="mb-2">Hapus "{{ $barang->barang }}" ?</h6>
          <p class="mb-0" style="font-size: 13px;">Menghapus barang berarti juga menghapus transaksinya</p>
        </div>
        <div class="modal-footer pt-0 d-flex justify-content-end">
          <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
          <a href="/barang/delete/{{ $barang->id_barang }}" class="btn fw-bold btn-danger tambah-ya ms-1">Ya</a>
        </div>
      </div>
    </div>
  </div>
@endsection