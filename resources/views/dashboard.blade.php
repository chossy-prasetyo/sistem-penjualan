@extends('template')
@section('title', 'Dashboard')
@section('active_dashboard', 'active')

@section('content')
  <div class="page-heading mb-4">
    <div class="page-title d-flex">
      <div class="input-group mb-0 me-2" style="width: 15rem;">
        <input type="text" class="form-control daterangepicker-clear bg-white" placeholder="Tanggal" style="width: 12rem; border-top-left-radius: 6px; border-bottom-left-radius: 6px; font-size: 14px;" readonly id="range-tanggal">
        <button class="btn btn-light border position-relative" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px; font-size: 14px;" id="cari-tanggal"><i class="bi bi-search position-relative" style="top: 2px;"></i></button>
      </div>

      <div>
        <button class="btn btn-light border font-bold py-2 d-flex" style="border-radius: 8px; padding-left: 0.7rem; padding-right: 0.7rem;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Panduan"><i class="bi bi-info-circle" style="margin-bottom: 0.095rem"></i></button>

        <div class="dropdown-menu shadow-sm border p-3 mt-3" style="border-radius: 8px; min-width: 18rem;">
          <p class="mb-2" style="font-size: 15px;">Panduan :</p>
          <ul class="ps-3 mb-0" style="font-size: 14px;">
            <li>Filter rentang waktu :<br><span style="font-size: 12px;">Pilih waktu, klik Apply, klik icon search</span></li>
            <li>Reset filter :<br><span style="font-size: 12px;">Klik Clear pada waktu, klik icon search</span></li>
            <li>Klik judul kolom untuk menyortir</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="page-content">
    <!-- 
    <div class="row">
      <div class="col-md-4 col-sm-6">
        <div class="card">
          <div class="card-body ps-5 position-relative">
            <div class="stats-icon purple position-absolute" style="left: -12px;">
              <i class="iconly-boldBookmark"></i>
            </div>
            <h6 class="text-muted font-semibold">Total Investasi</h6>
            <h6 class="font-extrabold mb-0">Rp {{ number_format(219233604, 0, ',', '.') }}</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card">
          <div class="card-body ps-5 position-relative">
            <div class="stats-icon blue position-absolute" style="left: -12px;">
              <i class="iconly-boldWallet"></i>
            </div>
            <h6 class="text-muted font-semibold">Dikembalikan</h6>
            <h6 class="font-extrabold mb-0">Rp {{ number_format(26135000, 0, ',', '.') }}</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card">
          <div class="card-body ps-5 position-relative">
            <div class="stats-icon green position-absolute" style="left: -12px;">
              <i class="iconly-boldBuy"></i>
            </div>
            <h6 class="text-muted font-semibold">Sisa</h6>
            <h6 class="font-extrabold mb-0">Rp {{ number_format(193098604, 0, ',', '.') }}</h6>
          </div>
        </div>
      </div>
    </div>
     -->


    <div class="row">
      <div class="col-lg-6">
        <div class="card shadow-none border overflow-hidden" style="border-radius: 8px;">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="bg-light" style="font-size: 14px;">
                  <tr>
                    <th></th>
                    <th class="py-3">Barang</th>
                    <th>
                      <a href="javascript:void(0);" class="link-underline" id="sort-barang-terjual" data-sort="desc">
                        Terjual
                        <span id="nav-barang-terjual" class="position-relative"></span>
                      </a>
                    </th>
                    <th>
                      <a href="javascript:void(0);" class="link-underline" id="sort-barang-transaksi" data-sort="desc">
                        Transaksi
                        <span id="nav-barang-transaksi" class="position-relative"></span>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody id="daftar-barang">
                  @foreach ($barang as $br)
                    <tr>
                      <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                      <td>
                        <a href="/barang-show?c={{ $br['code_barang'] }}" class="text-primary fw-bolder link-underline">{{ $br['barang'] }}</a><br>
                        <small style="font-size: 11px;">{{ $br['jenis'] }}</small>
                      </td>
                      <td>@if ($br['terjual']) {{ $br['terjual'] }} @endif</td>
                      <td>@if ($br['transaksi']) {{ $br['transaksi'] }} @endif</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow-none border overflow-hidden" style="border-radius: 8px;">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="bg-light" style="font-size: 14px;">
                  <tr>
                    <th></th>
                    <th class="py-3">Jenis Barang</th>
                    <th>
                      <a href="javascript:void(0);" class="link-underline" id="sort-jenis-terjual" data-sort="desc">
                        Terjual
                        <span id="nav-jenis-terjual" class="position-relative"></span>
                      </a>
                    </th>
                    <th>
                      <a href="javascript:void(0);" class="link-underline" id="sort-jenis-transaksi" data-sort="desc">
                        Transaksi
                        <span id="nav-jenis-transaksi" class="position-relative"></span>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody id="daftar-jenis-barang">
                  @foreach ($jenis_barang as $jenis)
                    <tr>
                      <td class="text-center py-3 px-0" style="width: 60px;">{{ $loop->iteration }}</td>
                      <td class="fw-bolder">{{ $jenis['jenis'] }}</td>
                      <td>@if ($jenis['terjual']) {{ $jenis['terjual'] }} @endif</td>
                      <td>@if ($jenis['transaksi']) {{ $jenis['transaksi'] }} @endif</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  <script>
    $(function()
    {
      let column_list = ['terjual', 'transaksi']

      $('#cari-tanggal').click(function()
      {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/dashboard/search",
          type: "post",
          dataType: 'json',
          data: {
            'tanggal': $('#range-tanggal').val()
          },
          success: function(result)
          {
            $('#daftar-barang').html(result['barang'])
            $('#daftar-jenis-barang').html(result['jenis_barang'])
          }
        })



        column_list.forEach(function(value)
        {
          $('#sort-barang-'+value).data('sort', 'desc')
          $('#nav-barang-'+value).html('')

          $('#sort-jenis-'+value).data('sort', 'desc')
          $('#nav-jenis-'+value).html('')
        });
      })





      $('#sort-barang-terjual').click(function()
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

        sort_barang('terjual', sort, nav)
      })



      $('#sort-barang-transaksi').click(function()
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

        sort_barang('transaksi', sort, nav)
      })



      function sort_barang(column, sort, nav)
      {
        column_list.forEach(function(value)
        {
          if (value.replace('-', '_') != column)
          {
            $('#sort-barang-'+value).data('sort', 'desc')
            $('#nav-barang-'+value).html('')
          }
          else
          {
            $('#sort-barang-'+value).data('sort', sort)
            $('#nav-barang-'+value).html(nav)
          }
        })



        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/dashboard/sort-barang",
          type: "post",
          dataType: 'json',
          data: {
            'tanggal': $('#range-tanggal').val(),
            'column': column,
            'sort': sort
          },
          success: function(result)
          {
            $('#daftar-barang').html(result['barang'])
          }
        })
      }





      $('#sort-jenis-terjual').click(function()
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

        sort_jenis('terjual', sort, nav)
      })



      $('#sort-jenis-transaksi').click(function()
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

        sort_jenis('transaksi', sort, nav)
      })



      function sort_jenis(column, sort, nav)
      {
        column_list.forEach(function(value)
        {
          if (value.replace('-', '_') != column)
          {
            $('#sort-jenis-'+value).data('sort', 'desc')
            $('#nav-jenis-'+value).html('')
          }
          else
          {
            $('#sort-jenis-'+value).data('sort', sort)
            $('#nav-jenis-'+value).html(nav)
          }
        })



        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/dashboard/sort-jenis-barang",
          type: "post",
          dataType: 'json',
          data: {
            'tanggal': $('#range-tanggal').val(),
            'column': column,
            'sort': sort
          },
          success: function(result)
          {
            $('#daftar-jenis-barang').html(result['jenis_barang'])
          }
        })
      }
    })
  </script>
@endsection