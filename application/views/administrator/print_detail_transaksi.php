<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Print Nota ID <?= $transaksi['id_nota']; ?> </title>

    <!-- Custom fonts for this template-->
    <link
      href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/logo/favicon.png" type="image/x-icon">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet" />

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/select2-4.0.6-rc.1/dist/css/select2.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

    <link rel="stylesheet" media="screen" type="text/css" href="<?= base_url(); ?>assets/css/colorpicker.css" />

    <style>

      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }

      .ck-editor__editable_inline {
          min-height: 300px;
      }

      .description-product-detail {
        color: #666;
      }

      .description-product-detail h2 {
        font-size: 22px;
      }

      .description-product-detail h3 {
        font-size: 19px;
      }

      .description-product-detail h4 {
        font-size: 17px;
      }

      .description-product-detail p {
        font-size: 14.5px;
      }

      .description-product-detail img {
        width: 50%;
      }

      .cetak-center {
        /* align-items:center; */
        text-align:center; 
      }

    </style>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body id="page-top">

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- <div class="row">
        <div class="col-md-3"></div> -->
        <div class="">
            <div  class="text-center">
              <img style="width:70px;" src="<?= base_url(); ?>assets/images/logo/favicon.png">
            </div>
            <br>
            <p class="cetak-center">Jalan Raya Benowo 1-3, Surabaya, <br> Jawa Timur - Indonesia</p>
            <hr style="border-style: dashed; border-width: 0.1125em;">
            <p>ID. Nota : <?= $transaksi['id_nota'];?> <br> Tanggal Transaksi : <?= $transaksi['date'];?> </p>
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
            <p class="cetak-center">Terima kasih atas kunjungan anda <br> Semoga anda puas dengan product dan pelayanan kami</p>
            <hr style="border-style: dashed; border-width: 0.1125em;">
            <p class="cetak-center">Website : https://awalsemangat.id</p>
        </div>
        <!-- <div class="col-md-3"></div>
    </div> -->
</div>
<!-- /.container-fluid -->


<script>
  window.print();
</script>

</body>

</html>
