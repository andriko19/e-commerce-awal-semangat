<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cetak Laporan Pdf</title>
    <style type="text/css">
      .header {
      
      }

      .border-table {
        font-family: Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse: collapse;
        text-align:center;
        font-size:12px;
      }
      .footer {
        font-family: Arial, Helvetica, sans-serif;
        text-align:center;
        font-size:18px;
      }
    </style>
  </head>
  <body>

  <?php
    $path = 'logo.pnfg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
  ?>
    <!-- <img src="<?php echo $base64?>"/> -->
  
    <header>
      <div class="header">
        <h2>Laporan Pembelian</h2> 
        <p>Dari Tanggal <b> <?= date('d-m-Y', strtotime($tanggal_awal)) ?> </b> Sampai <b> <?= date('d-m-Y', strtotime($tanggal_akhir)) ?> </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  https://awalsemangat.id</p>
      </div>
      
      <hr/>
    </header>
    
    <main>
      <table class="border-table">
        <thead>
          <tr>
            <th>No.</th>
            <th>No. Nota</th>
            <th>Tanggal</th>
            <th>Total Harga</th>
            <th>Status</th>
          </tr>
          <tr> 
            <th> <hr/> </th>
            <th> <hr/> </th>
            <th> <hr/> </th>
            <th> <hr/> </th>
            <th> <hr/> </th>
          </tr>
          
        </thead>
        <tbody>
          
          <?php $no = 1;
          foreach ($getLaporan as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['id_nota'] ?></td>
              <td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
              <td><?= number_format($row['price'],0,'','.')  ?></td>
              <td><?= $row['status'] ?></td>
            </tr>
          <?php endforeach; ?>

          <!-- <?php
          for ($x = 0; $x <= 120; $x++) : ?>
            <tr>
            <td>No.</td>
            <td>No. Nota</td>
            <td>Tanggal</td>
            <td>Total darga</td>
            <td>Status</td>
          </tr>
          <?php endfor; 
          ?> -->

        </tbody>
      </table>
    </main>
    
    <footer>
      <p class="footer">Semua orang berhak minum enak</p>
    </footer>

  </body>
</html>