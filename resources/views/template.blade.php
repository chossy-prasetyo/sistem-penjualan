<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon icon -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="favicon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicon/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicon/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="favicon/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="60x60" href="favicon/apple-touch-icon-60x60.png" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="favicon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon-precomposed" sizes="76x76" href="favicon/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="favicon/apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="favicon/favicon-196x196.png" sizes="196x196" />
  <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/png" href="favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="favicon/favicon-16x16.png" sizes="16x16" />
  <link rel="icon" type="image/png" href="favicon/favicon-128.png" sizes="128x128" />
  <meta name="application-name" content="&nbsp;"/>
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="favicon/mstile-144x144.png" />
  <meta name="msapplication-square70x70logo" content="favicon/mstile-70x70.png" />
  <meta name="msapplication-square150x150logo" content="favicon/mstile-150x150.png" />
  <meta name="msapplication-wide310x150logo" content="favicon/mstile-310x150.png" />
  <meta name="msapplication-square310x310logo" content="favicon/mstile-310x310.png" />

  <title>@yield('title')</title>

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Include Choices CSS -->
  <link rel="stylesheet" href="vendors/choices.js/choices.min.css" />

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.css">

  <link rel="stylesheet" href="vendors/iconly/bold.css">

  <link rel="stylesheet" href="vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="css/app.css">

  <!-- datepicker -->
  <link rel="stylesheet" href="vendors/datepicker/bootstrap-datepicker.css">

  <!-- Date Range Picker -->
  <link rel="stylesheet" href="vendors/date-range-picker/daterangepicker.css" />

  <!-- toastify -->
  <link rel="stylesheet" href="vendors/toastify/toastify.css">

  <style>
    #main-content {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    .bg-light-danger {
      color: #F8294B !important;
      background-color: #FDD4DA !important;
    }

    .bg-light-success {
      color: #0BD540 !important;
      background-color: #C3F9D5 !important;
    }

    .action-hover:hover {
      background-color: #E8E8E8;
    }

    .link-underline:hover {
      text-decoration: underline;
    }
  </style>

  <!-- jquery -->
  <script src="js/jquery-3.7.0.min.js"></script>

  <!-- maskMoney -->
  <script src="js/jquery.maskMoney.min.js"></script>

  <!-- toastify -->
  <script src="vendors/toastify/toastify.js"></script>

  <!-- Date Range Picker -->
  <script src="vendors/date-range-picker/moment.min.js"></script>
</head>

<body>
  <div id="app">
    <div id="sidebar" class="active">
      <div class="sidebar-wrapper active">
        <div class="sidebar-header">
          <div class="d-flex justify-content-between">
            <div class="logo">
              <a href="/"><img src="img/logo/penjualan.png" alt="Logo" srcset=""></a>
            </div>
            <div class="toggler">
              <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
          </div>
        </div>
        <div class="sidebar-menu">
          <ul class="menu">
            <li class="sidebar-item @yield('active_dashboard')">
              <a href="/dashboard" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item @yield('active_transaksi')">
              <a href="/transaksi" class='sidebar-link'>
                <i class="bi bi-receipt"></i>
                <span>Transaksi</span>
              </a>
            </li>

            <li class="sidebar-item @yield('active_barang')">
              <a href="/barang" class='sidebar-link'>
                <i class="bi bi-box"></i>
                <span>Barang</span>
              </a>
            </li>

            <li class="sidebar-item @yield('active_dokumentasi')">
              <a href="/" class='sidebar-link'>
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Dokumentasi</span>
              </a>
            </li>
          </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
      </div>
    </div>





    <div id="main" class='layout-navbar'>
      <header>
        <nav class="navbar navbar-expand navbar-light">
          <div class="container-fluid">
            <a href="javascript:void(0);" class="burger-btn d-block">
              <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="ms-auto">
                <div class="user-menu d-flex">
                  <div class="user-name text-end me-3">
                    <h6 class="mb-0 text-gray-600">Chossy Aulia</h6>
                    <p class="mb-0 text-sm text-gray-600" style="font-size: 14px;">Administrator
                  </div>
                  <div class="user-img d-flex align-items-center">
                    <div class="avatar avatar-md">
                      <img src="img/faces/pp-chossy.jpg">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </header>


      <div id="main-content">
        @yield('content')

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>&copy; 2024</p>
            </div>
            <div class="float-end">
              <p>Penjualan | Chossy</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <script src="vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

  <script src="js/pages/dashboard.js"></script>

  <!-- choices -->
  <script src="vendors/choices.js/choices.min.js"></script>

  <script src="js/main.js"></script>

  <!-- datepicker -->
  <script src="vendors/datepicker/bootstrap-datepicker.js"></script>

  <!-- daterangepicker -->
  <script src="vendors/date-range-picker/daterangepicker.min.js"></script>
  <script src="vendors/date-range-picker/moment.min.js"></script>

  <script>
    $('.nominal').maskMoney({
      prefix:'Rp ', 
      thousands:'.', 
      decimal:',', 
      precision:0
    })


    // datepicker
    $('.datepicker').datepicker({
      format: "dd MM yyyy",
      autoclose: true
    })


    // daterange picker + clear
    $(function()
    {
      $('.daterangepicker-clear').daterangepicker({
        autoUpdateInput: false,
        locale: {
          cancelLabel: 'Clear'
        }
      })

      $('.daterangepicker-clear').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'))
      })

      $('.daterangepicker-clear').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('')
      })
    })


    $('.dropdown-static').click(function(event)
    {
      event.stopPropagation();
    })


    // tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    @if (session()->has('alert_success'))
      Toastify({
        text: "{{ session('alert_success') }}",
        duration: 3000,
        gravity:"top",
        position: "center",
        backgroundColor: "#30CE59"
      }).showToast()
    @endif



    @if (session()->has('alert_failed'))
      Toastify({
        text: "{{ session('alert_failed') }}",
        duration: 4000,
        gravity:"top",
        position: "center",
        backgroundColor: "#DC3545"
      }).showToast()
    @endif
  </script>
</body>
</html>