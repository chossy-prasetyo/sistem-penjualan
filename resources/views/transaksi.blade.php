@extends('template')
@section('title', 'Transaksi')
@section('active_transaksi', 'active')

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
    <div class="page-title d-flex justify-content-between">
      <div>
        <button class="btn btn-primary font-bold px-3 py-2" style="border-radius: 8px; font-size: 12px;" data-bs-toggle="modal" data-bs-target="#tambah-transaksi">Tambah Transaksi</button>
      </div>

      <div class="d-flex">
        <div class="form-group mb-0">
          <input type="text" class="form-control" id="cari-transaksi" style="border-radius: 8px; width: 11rem; font-size: 14px;" placeholder="Cari" autocomplete="off">
        </div>

        <div class="form-group mb-0 ms-2">
          <input type="text" class="form-control datepicker bg-white" id="cari-tanggal" style="border-radius: 8px; width: 11rem; font-size: 14px; padding: 0.375rem 0.75rem;" placeholder="Tanggal" readonly>
        </div>

        <div class="ms-2">
          <button class="btn btn-light border font-bold py-2 d-flex" style="border-radius: 8px; padding-left: 0.7rem; padding-right: 0.7rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Panduan"><i class="bi bi-info-circle" style="margin-bottom: 0.095rem"></i></button>

          <div class="dropdown-menu shadow-sm border p-3 mt-3" style="border-radius: 8px; min-width: 18rem;">
            <p class="mb-2" style="font-size: 15px;">Panduan :</p>
            <ul class="ps-3 mb-0" style="font-size: 14px;">
              <li>Cari nama atau jenis barang</li>
              <li>Filter tanggal</li>
              <li>Klik kembali tanggal untuk mereset</li>
              <li>Klik judul kolom untuk menyortir</li>
            </ul>
          </div>
        </div>
      </div>
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
                <th class="py-3">
                  <a href="javascript:void(0);" class="link-underline" id="sort-barang" data-sort="desc">
                    Barang
                    <span id="nav-barang" class="position-relative"></span>
                  </a>
                </th>
                <th>Stok</th>
                <th>Terjual</th>
                <th>
                  <a href="javascript:void(0);" class="link-underline" id="sort-tanggal-transaksi" data-sort="desc">
                    Tanggal
                    <span id="nav-tanggal-transaksi" class="position-relative"></span>
                  </a>
                </th>
                <th>Jenis</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="daftar-transaksi">
              @foreach ($transaksi as $tr)
                @php
                  $stok_per_date = $stok->where('barang_id', $tr->barang_id)
                                        ->where('tanggal_stok', '<=', $tr->tanggal_transaksi)
                                        ->sum('stok');

                  $terjual_before_date = $transaksi->where('barang_id', $tr->barang_id)
                                                    ->where('tanggal_transaksi', '<', $tr->tanggal_transaksi)
                                                    ->sum('terjual');

                  $stok_all = $stok->where('barang_id', $tr->barang_id)->sum('stok');
                  $terjual_all = $transaksi->where('barang_id', $tr->barang_id)->sum('terjual');
                @endphp

                <tr>
                  <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                  <td class="text-primary fw-bolder">
                    <a href="/barang-show?c={{ $tr->code_barang }}" class="link-underline">{{ $tr->barang }}</a>
                  </td>
                  <td>{{ $stok_per_date - $terjual_before_date }}</td>
                  <td>{{ $tr->terjual }}</td>
                  <td style="font-size: 14px;">{{ date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y') }}</td>
                  <td class="fst-italic" style="font-size: 14px;">{{ $tr->jenis }}</td>
                  <td>
                    <a href="#" class="action-hover position-relative" style="border-radius: 6px; padding: 0.35rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots-vertical position-relative" style="top: 2px;"></i></a>

                    <div class="dropdown-menu shadow-sm border" style="min-width: 12rem; font-size: 14px;">
                      <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-transaksi-{{ $tr->id_transaksi }}">
                        <i class="bi bi-pencil me-3 position-relative" style="top: 3px;"></i> Edit
                      </a>

                      <a class="dropdown-item d-flex position-relative" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#hapus-transaksi-{{ $tr->id_transaksi }}">
                        <i class="bi bi-trash me-3 position-relative" style="top: 3px;"></i> Hapus
                      </a>
                    </div>
                  </td>
                </tr>





                <!-- modal edit transaksi -->
                <div class="modal fade text-left modal-borderless" id="edit-transaksi-{{ $tr->id_transaksi }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px;">
                      <div class="modal-body pt-4 px-4">
                        <h6 class="mb-3">Edit Transaksi</h6>

                        <form action="/transaksi/update" method="post">
                          @csrf
                          <input type="hidden" name="id_transaksi" value="{{ $tr->id_transaksi }}">

                          <div class="form-group mb-4">
                            <label class="form-label" style="font-size: 14px;">Barang</label>
                            <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="{{ $tr->barang }}">
                          </div>

                          <div class="form-group mb-4">
                            <label class="form-label" style="font-size: 14px;">
                              Stok
                              <small class="text-secondary ms-2 fw-light">(Stok - Penjualan Lain)</small>
                            </label>
                            <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" name="stok" readonly value="{{ ($stok_all - $terjual_all) + $tr->terjual }}">
                          </div>

                          <div class="form-group mb-4">
                            <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal</label>
                            <input type="text" class="form-control mt-1 py-2" style="border-radius: 0;" disabled value="{{ date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d F Y') }}">
                          </div>

                          <div class="form-group">
                            <label class="form-label" for="terjual" style="font-size: 14px;">Terjual</label>
                            <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" id="terjual" name="terjual" autocomplete="off" required value="{{ $tr->terjual }}">
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
                <div class="modal fade text-left modal-borderless" id="hapus-transaksi-{{ $tr->id_transaksi }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px;">
                      <div class="modal-body pt-4 px-4">
                        <h6 class="mb-2">Hapus transaksi ?</h6>
                        <p class="mb-0" style="font-size: 13px;">
                          <span class="fw-bold">{{ $tr->barang }}</span> : {{ $tr->terjual }}
                          <span class="fst-italic ms-3">{{ date_create_from_format('Y-m-d H:i:s', $tr->tanggal_transaksi)->format('d-m-Y') }}</span>
                        </p>
                      </div>
                      <div class="modal-footer pt-0 d-flex justify-content-end">
                        <button type="button" class="btn fw-bold btn-light-primary tambah-batal" data-bs-dismiss="modal">Batal</button>
                        <a href="/transaksi/delete/{{ $tr->id_transaksi }}" class="btn fw-bold btn-primary tambah-ya ms-1">Ya</a>
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





  <!-- modal tambah transaksi -->
  <div class="modal fade text-left modal-borderless" id="tambah-transaksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 10px;">
        <div class="modal-body pt-4 px-4">
          <form action="/transaksi/store" method="post">
            @csrf

            <div class="form-group mb-4">
              <label class="form-label" for="cari-barang" style="font-size: 14px;">Barang</label>
              <select class="choices form-select mt-1" id="cari-barang" name="barang" required>
                <option value="" disabled selected></option>
                @foreach ($barang as $br)
                  <option value="{{ $br->id_barang }}" @if ($br->id_barang == session('barang')) selected @endif>{{ $br->barang }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group mb-4">
              <label class="form-label" style="font-size: 14px;">Stok</label>
              <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" id="show-stok" name="stok" autocomplete="off" required readonly value="{{ session('stok') }}">
            </div>

            <div class="form-group mb-4">
              <label class="form-label" for="tanggal" style="font-size: 14px;">Tanggal</label>
              <input type="text" class="form-control mt-1 datepicker py-2" style="padding: 0.375rem 0.75rem; border-radius: 0;" id="tanggal" name="tanggal" autocomplete="off" required value="{{ session('tanggal') }}">
            </div>

            <div class="form-group">
              <label class="form-label" for="terjual" style="font-size: 14px;">Terjual</label>
              <input type="number" class="form-control mt-1 py-2" style="border-radius: 0;" id="terjual" name="terjual" autocomplete="off" required value="{{ session('terjual') }}" min="1">
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
      $('#cari-barang').change(function()
      {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/transaksi/search-stok",
          type: "post",
          dataType: 'json',
          data: {
            'barang': $(this).val()
          },
          success: function(result)
          {
            $('#show-stok').val(result)
          }
        })
      })








      let column_list = ['barang', 'tanggal-transaksi'], ubah_tanggal = 0, input_tanggal

      $('#cari-transaksi').keyup(function()
      {
        if (this.value.length > 1 || this.value.length < 1)
        {
          cari_transaksi($(this).val(), $('#cari-tanggal').val())
        }
      })



      $('#cari-tanggal').change(function()
      {
        ubah_tanggal = ubah_tanggal + 1;
        input_tanggal = ($(this).val() == '') ? 2 : 3

        if (ubah_tanggal == input_tanggal)
        {
          ubah_tanggal = 0;
          cari_transaksi($('#cari-transaksi').val(), $(this).val())
        }
      })



      function cari_transaksi(search, tanggal)
      {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/transaksi/search",
          type: "post",
          dataType: 'json',
          data: {
            'search': search,
            'tanggal': tanggal
          },
          success: function(result)
          {
            $('#daftar-transaksi').html(result['transaksi'])
          }
        })



        column_list.forEach(function(value)
        {
          $('#sort-'+value).data('sort', 'desc')
          $('#nav-'+value).html('')
        });
      }








      $('#sort-barang').click(function()
      {
        if ($(this).data('sort') == 'desc')
        {
          sort  = 'asc'
          nav   = '<i class="bi bi-chevron-up position-relative" style="top: 3px;"></i>'
        }
        else
        {
          sort  = 'desc'
          nav   = '<i class="bi bi-chevron-down position-relative" style="top: 3px;"></i>'
        }

        sort_transaksi('barang', sort, nav)
      })



      $('#sort-tanggal-transaksi').click(function()
      {
        if ($(this).data('sort') == 'desc')
        {
          sort  = 'asc'
          nav   = '<i class="bi bi-chevron-up position-relative" style="top: 3px;"></i>'
        }
        else
        {
          sort  = 'desc'
          nav   = '<i class="bi bi-chevron-down position-relative" style="top: 3px;"></i>'
        }

        sort_transaksi('tanggal_transaksi', sort, nav)
      })



      function sort_transaksi(column, sort, nav)
      {
        column_list.forEach(function(value)
        {
          if (value.replace('-', '_') != column)
          {
            $('#sort-'+value).data('sort', 'desc')
            $('#nav-'+value).html('')
          }
          else
          {
            $('#sort-'+value).data('sort', sort)
            $('#nav-'+value).html(nav)
          }
        })



        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/transaksi/sort",
          type: "post",
          dataType: 'json',
          data: {
            'search': $('#cari-transaksi').val(),
            'tanggal': $('#cari-tanggal').val(),
            'column': column,
            'sort': sort
          },
          success: function(result)
          {
            $('#daftar-transaksi').html(result['transaksi'])
          }
        })
      }








      @if (session()->has('show_modal'))
        $('#tambah-transaksi').modal('show')
      @endif

      @if (session()->has('show_modal_edit'))
        $('#edit-transaksi-{{ session("id_transaksi") }}').modal('show')
      @endif
    })
  </script>
@endsection