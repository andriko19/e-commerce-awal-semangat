<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Detail Transaksi Pembelian</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
        <h1 class="h3 mb-2 text-gray-800">No. Nota : <?= $transaksi['id_nota']; ?></h1>
		</div>
		<div class="card-body">
      <?php echo $this->session->flashdata('failed'); ?>
      
      <div class>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6" id="area">
            <div  class="text-center">
              <img style="width:70px;" src="<?= base_url(); ?>assets/images/logo/favicon.png">
            </div>
            <br>
            <p class="cetak-center">Semua orang berhak minum enak</p>
            <hr style="border-style: dashed; border-width: 0.1125em;">
            <p>ID. Nota : <?= $transaksi['id_nota'];?> <br> Tanggal Transaksi : <?= $transaksi['date'];?> <br> Kasir : <?= $transaksi['nama'];?> </p>
            <hr style="border-style: dashed; border-width: 0.1125em;">
            
            <table>
              <?php 
                $total_harga = 0;
                foreach($detailTransaksi->result_array() as $data): 
              ?>  
              <tr>
								<td style="width: 800px"><?= $data['products_name']; ?></td>
								<td style="width: 100px"><?= $data['qty']; ?></td>
								<td style="width: 200px"><?= $data['price']; ?></td>
                <td style="width: 200px"><?= number_format($data['total_harga'],0,'','.'); ?></td>
              </tr>
              <?php 
                // untuk menghitung grand total
                $total_harga += $data['total_harga'];
                endforeach; 
              ?>
            </table>

            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <hr style="border-style: dashed; border-width: 0.1125em;">
                <table>
                <tr>
								  <td style="width: 1200px"></td>
                  <td style="width: 800px">Total :</td>
                  <td style="width: 800px"><?= number_format($total_harga,0,'','.'); ?></td>
                </tr>
                </table>
              </div>
            </div>
            <br>
            <p class="cetak-center">Terima kasih atas kunjungan anda <br> Semoga anda puas dengan produk dan pelayanan kami</p>
            <hr style="border-style: dashed; border-width: 0.1125em;">
            <p class="cetak-center">Website : https://awalsemangat.id</p>
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>

    </div>
    <div class="card-footer">
      <a href="<?= base_url(); ?>administrator/transaksi" class="btn btn-info"><i class="fa fa-chevron-left"></i> Kembali</a>
      <button onclick="return printArea('area')" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
      <!-- <a href="<?= base_url(); ?>administrator/print_transaksi/<?= $transaksi['id_nota']; ?>" class="btn btn-primary"><i class="fas fa-print"></i> Print</a> -->
    </div>
	</div>
</div>
<!-- /.container-fluid -->
