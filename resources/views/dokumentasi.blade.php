@extends('template')
@section('title', 'Dokumentasi')
@section('active_dokumentasi', 'active')

@section('content')
	<style>
		ul {
			font-size: 15px;
		}
	</style>

  <div class="page-heading mb-3">
    <div class="page-title">
      <h6>Skema Database</h6>
    </div>
  </div>

  <div class="page-content" style="margin-bottom: 2.5rem;">
  	<div style="margin-bottom: 2.5rem;">
	    <img src="img/dokumentasi/skema-database.png" class="border" style="width: 100%; border-radius: 8px;">
	  </div>

	  <div style="margin-bottom: 2.5rem;">
	    <h6>Tabel Jenis Barang</h6>
	    <ul>
	    	<li>Direferensi oleh tabel barang</li>
	    </ul>
	    <h6>Tabel Barang</h6>
	    <ul>
	    	<li>Daftar barang yang dijual</li>
	    	<li>Barang di-restock dan dijual</li>
	    </ul>
	    <h6>Tabel Stok</h6>
	    <ul>
	    	<li>Mereferensi ke tabel barang</li>
	    	<li>Dibuat terpisah agar mudah dikelola</li>
	    	<li>Jumlah stok dapat diketahui dengan dikurangi jumlah terjual</li>
	    </ul>
	    <h6>Tabel Transaksi</h6>
	    <ul>
	    	<li>Mereferensi ke tabel barang</li>
	    	<li>Adalah transaksi yang ada dimana di dalamnya terdapat jumlah penjualan suatu barang</li>
	    </ul>
	  </div>

	  <div style="margin-bottom: 2.5rem;">
	  	<h6>Menu Barang</h6>
	  	<ul>
	  		<li>Adalah menu untuk mengelola barang yang dijual</li>
	  		<li>Barang dapat ditambah, diedit, dihapus, dan di-restock</li>
	  		<li>Pada halaman daftar terdapat update dari setiap barang : jumlah terjual, jumlah transaksi, sisa stok</li>
	  	</ul>
	  </div>

	  <div style="margin-bottom: 2.5rem;">
	  	<h6>Menu Transaksi</h6>
	  	<ul>
	  		<li>Adalah menu untuk mengelola penjualan barang</li>
	  		<li>Transaksi dapat ditambah, diedit, dan dihapus</li>
	  		<li>Setiap transaksi mereferensi ke suatu barang</li>
	  		<li>Pada halaman daftar terdapat detail setiap transaksi, nama barang, jumlah terjual, tanggal, serta stok barang sebelum transaksi terjadi</li>
	  		<li>Secara default transaksi diurutkan dari tanggal yang terakhir</li>
	  		<li>Daftar transaksi dapat disortir berdasarkan tanggal dan nama barang</li>
	  		<li>Suatu transaksi dapat dicari berdasarkan nama atau jenis barang serta dapat difilter berdasarkan tanggal</li>
	  	</ul>
	  </div>

	  <div>
	  	<h6>Menu Dashboard</h6>
	  	<ul>
	  		<li>Pada halaman dashbord terdapat data riwayat barang dan jenis barang</li>
	  		<li>Data terdiri dari jumlah terjual dan transaksi yang dapat disortir</li>
	  		<li>Secara default data adalah keseluruhan transaksi yang ada</li>
	  		<li>Data dapat difilter pada suatu rentang waktu</li>
	  		<li>Jangan lupa untuk selalu klik icon cari untuk mengupdate filter waktu</li>
	  	</ul>
	  </div>
  </div>
@endsection