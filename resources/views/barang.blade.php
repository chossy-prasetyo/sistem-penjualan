@extends('template')
@section('title', 'Barang')
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

  <div class="page-heading mb-4">
    <div class="page-title">
      <button class="btn btn-primary font-bold px-3 py-2" style="border-radius: 8px; font-size: 12px;" data-bs-toggle="modal" data-bs-target="#tambah-barang">Tambah Barang</button>
    </div>
  </div>

  <div class="page-content">
    <div class="card shadow-none">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0 border">
            <thead class="bg-light" style="font-size: 14px;">
              <tr>
                <th></th>
                <th class="py-3">Barang</th>
                <th>Jenis</th>
                <th>Stok</th>
                <th>Terjual</th>
                <th>Transaksi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($barang as $br)
                @php
                  $stok_barang = $stok->where('barang_id', $br->id_barang)->sum('stok');
                  $transaksi_barang = $transaksi->where('barang_id', $br->id_barang);
                  $transaksi_barang_count = $transaksi_barang->count();
                  $terjual = $transaksi_barang->sum('terjual');
                @endphp
                <tr>
                  <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                  <td class="text-primary fw-bolder">
                    <a href="/barang-show?c={{ $br->code_barang }}" class="link-underline">{{ $br->barang }}</a>
                  </td>
                  <td class="fst-italic" style="font-size: 14px;">{{ $br->jenis }}</td>
                  <td>@if ($stok_barang - $terjual) {{ $stok_barang - $terjual }} @endif</td>
                  <td>@if ($terjual) {{ $terjual }} @endif</td>
                  <td>@if ($transaksi_barang_count) {{ $transaksi_barang_count }} @endif</td>
                  <td>
                    <a href="#" class="action-hover position-relative" style="border-radius: 6px; padding: 0.35rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots-vertical position-relative" style="top: 2px;"></i></a>

                    <div class="dropdown-menu shadow-sm border" style="min-width: 12rem; font-size: 14px;">
                      <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#tambah-stok-{{ $br->id_barang }}">
                        <i class="bi bi-box-seam me-3 position-relative" style="top: 3px;"></i> Tambah Stok
                      </a>

                      <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-barang-{{ $br->id_barang }}">
                        <i class="bi bi-pencil me-3 position-relative" style="top: 3px;"></i> Edit
                      </a>

                      <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#hapus-barang-{{ $br->id_barang }}">
                        <i class="bi bi-trash me-3 position-relative" style="top: 3px;"></i> Hapus
                      </a>
                    </div>
                  </td>
                </tr>





                <!-- modal tambah stok -->
                <div class="modal fade text-left modal-borderless" id="tambah-stok-{{ $br->id_barang }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px;">
                      <div class="modal-body pt-4 px-4">
                        <form action="/barang/store_stok" method="post">
                          @csrf
                          <input type="hidden" name="id_barang" value="{{ $br->id_barang }}">

                          <div class="form-group mb-4">
                            <label class="form-label" style="font-size: 14px;">Barang</label>
                            <input type="text" class="form-control mt-1" style="border-radius: 8px;" disabled value="{{ $br->barang }}">
                          </div>

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





                <!-- modal edit barang -->
                <div class="modal fade text-left modal-borderless" id="edit-barang-{{ $br->id_barang }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px;">
                      <div class="modal-body pt-4 px-4">
                        <form action="/barang/update" method="post">
                          @csrf
                          <input type="hidden" name="id_barang" value="{{ $br->id_barang }}">

                          <div class="form-group mb-4">
                            <label class="form-label" for="barang" style="font-size: 14px;">Edit Barang</label>
                            <input type="text" class="form-control mt-1" style="border-radius: 8px;" id="barang" name="barang" autocomplete="off" required value="{{ $br->barang }}">
                          </div>

                          <div class="form-group">
                            <label class="form-label" for="jenis" style="font-size: 14px;">Jenis</label>
                            <select class="form-select mt-1" name="jenis" id="jenis" style="border-radius: 8px;" required>
                              <option value=""></option>
                              @foreach ($jenis_barang as $jenis)
                                <option value="{{ $jenis->id_jenis }}" @if ($jenis->id_jenis == $br->jenis_id) selected @endif>{{ $jenis->jenis }}</option>
                              @endforeach
                            </select>
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
                <div class="modal fade text-left modal-borderless" id="hapus-barang-{{ $br->id_barang }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px;">
                      <div class="modal-body pt-4 px-4">
                        <h6 class="mb-2">Hapus "{{ $br->barang }}" ?</h6>
                        <p class="mb-0" style="font-size: 13px;">Menghapus barang berarti juga menghapus transaksinya</p>
                      </div>
                      <div class="modal-footer pt-0 d-flex justify-content-end">
                        <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                        <a href="/barang/delete/{{ $br->id_barang }}" class="btn fw-bold btn-danger tambah-ya ms-1">Ya</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>





  <!-- modal tambah barang -->
  <div class="modal fade text-left modal-borderless" id="tambah-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-body pt-4 px-4">
          <form action="/barang/store" method="post">
            @csrf

            <div class="form-group mb-4">
              <label class="form-label" for="barang" style="font-size: 14px;">Nama Barang</label>
              <input type="text" class="form-control mt-1" style="border-radius: 8px;" id="barang" name="barang" autocomplete="off" required value="{{ session('barang') }}">
            </div>

            <div class="form-group mb-4">
              <label class="form-label" for="jenis" style="font-size: 14px;">Jenis</label>
              <select class="form-select mt-1" name="jenis" id="jenis" style="border-radius: 8px;" required>
                <option value=""></option>
                @foreach ($jenis_barang as $jenis)
                  <option value="{{ $jenis->id_jenis }}" @if ($jenis->id_jenis == session('jenis')) selected @endif>{{ $jenis->jenis }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group mb-4">
              <label class="form-label" for="stok" style="font-size: 14px;">Stok</label>
              <input type="number" class="form-control mt-1" style="border-radius: 8px;" id="stok" name="stok" autocomplete="off" required value="{{ session('stok') }}">
            </div>

            <div class="form-group">
              <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal Stok</label>
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





  <script>
    $(function()
    {
      @if (session()->has('show_modal'))
        $('#tambah-barang').modal('show')
      @endif

      @if (session()->has('show_modal_edit'))
        $('#edit-barang-{{ session("id_barang") }}').modal('show')
      @endif
    })
  </script>
@endsection