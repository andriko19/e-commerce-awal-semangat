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

    <title><?= $title; ?></title>

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
    <link href="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet">
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

      .rotate img {
        width: 50%;
      }

      .rotate {
        
      }

      .cetak-center {
        /* align-items:center; */
        text-align:center; 
      }

    </style>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>

  <body id="page-top">
  <?php
  $setting = $this->db->get('settings')->row_array();
  $dateNow = date('Y-m-d H:i');
  $dateDB = $setting['promo_time'];
  $dateDBNew = str_replace("T"," ",$dateDB);
  if($dateNow >= $dateDBNew){
    $this->db->set('promo', 0);
    $this->db->update('settings');
  }
  ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="<?= base_url(); ?>administrator"
        >
          <div class="sidebar-brand-icon rotate">
            <img src="<?= base_url(); ?>assets/images/logo/favicon.png">
            <!-- <i class="fa fa-shopping-cart"></i> -->
          </div>
          <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>administrator">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <?php if ($usersAdmin['role'] == "admin") : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/users">
              <i class="fas fa-fw fa-users"></i>
              <span>Pengguna</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/transaksi">
              <i class="fas fa-fw fa-receipt"></i>
              <span>Transaksi Pembelian</span></a
            >
          </li>

          <?php $invoic = $this->db->get_where('payment_proof', ['status' => 0]); ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/proof">
              <i class="fas fa-fw fa-shopping-cart"></i>
              <?php if($invoic->num_rows() > 0){ ?>
                <span>Bukti Bayar</span> <small class="badge badge-warning"><?= $invoic->num_rows() ?> new</small>
              <?php }else{ ?>
                <span>Bukti Bayar</span> </small>
              <?php } ?>
              </a
            >
          </li>

          <?php $this->db->where('status', 0); $this->db->or_where('status', 1); $orders = $this->db->get('invoice'); ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/orders">
              <i class="fas fa-fw fa-shopping-cart"></i>
              <span>Pesanan</span> <small class="badge badge-warning"><?= $orders->num_rows() ?> new</small></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/email">
              <i class="fas fa-fw fa-envelope"></i>
              <span>Kirim Email</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/categories">
              <i class="fas fa-fw fa-tag"></i>
              <span>Kategori</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/products">
              <i class="fas fa-fw fa-box-open"></i>
              <span>Produk</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/promo">
              <i class="fas fa-fw fa-fire"></i>
              <span>Promo</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/testimonials">
              <i class="fas fa-fw fa-comments"></i>
              <span>Testimoni</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/pages">
              <i class="fas fa-fw fa-file"></i>
              <span>Halaman</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/settings">
              <i class="fas fa-fw fa-cog"></i>
              <span>Pengaturan</span></a
            >
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/users_admin">
              <i class="fas fa-fw fa-users"></i>
              <span>Users Admin</span></a
            >
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>administrator/transaksi">
              <i class="fas fa-fw fa-receipt"></i>
              <span>Transaksi Pembelian</span></a
            >
          </li>
        <?php endif?>

        <br />

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                    >Login sebagai <?= $usersAdmin['role'];?> <br> (<?= $usersAdmin['nama'];?>)
                  </span>
                </a>
                <!-- Dropdown - User Information -->
                <div
                  class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown"
                >
                  <a class="dropdown-item" href="<?= base_url(); ?>administrator/edit">
                    <i
                      class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Edit Profil
                  </a>
                  <a
                    class="dropdown-item"
                    href="#"
                    data-toggle="modal"
                    data-target="#logoutModal"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->


          <?php echo $this->session->flashdata('upload'); ?>

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800 mb-4">Tambah Transaksi Pembelian</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
              <a href="<?= base_url(); ?>administrator/transaksi" class="btn btn-danger"
                  ><i class="fa fa-times-circle"></i> Batal</a
                >
              </div>
              <div class="card-body">
                <?php echo $this->session->flashdata('failed'); ?>
                <div class="row">
                        
                  <div class="col-sm-12 col-md-6 ">
                    <form class="form-horizontal" id="form_order" role="form">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Cari Produk</label>
                        <div class="col-md-9">
                          <input class="form-control reset" id="search" name="search" type="text" placeholder="Masukkan Id atau Nama produk">
                        </div>
                      </div>
                      <input type="hidden" id="product_id" name="product_id">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama</label>
                        <div class="col-md-9">
                          <input class="form-control reset" type="text" id="product_name" name="product_name" readonly="" placeholder="Nama">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Harga</label>
                        <div class="col-md-9">
                          <input class="form-control reset" type="text" name="selling_price" id="selling_price" readonly="" placeholder="0" value="">
                          <input class="form-control reset" type="hidden" name="selling_price2" id="selling_price2" readonly="" placeholder="0" value="">
                        </div>
                      </div>

                      <input type="hidden" class="reset" id="jenis_promo" name="jenis_promo">
                      <input type="hidden" class="reset" id="potongan" name="potongan">
                      <input type="hidden" class="reset" id="harga_potongan" name="harga_potongan">

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Qty</label>
                        <div class="col-md-9">
                          <input class="form-control reset" type="number" readonly="readonly" onkeyup="subTotal(this.value)" id="product_qty" min="0" name="product_qty" placeholder="qty">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Sub total</label>
                        <div class="col-md-9">
                          <input class="form-control reset" type="text" name="sub_total" id="sub_total" readonly="" placeholder="0" value="">
                        </div>
                      </div>
                    </form>
                    <button type="button" class="btn btn-md btn-primary" id="tambah" disabled="disabled" onclick="save_to_cart()"><i class="fa fa-shopping-cart"></i> input</button>
                  </div>

                  <div class="col-sm-12 col-md-6" id="pembayaran">
                    <div class="form-group row">
                      <label class="col-md-3 col-form-label">Total</label>
                      <div class="col-md-9">
                        <input class="form-control form-control-lg res" type="text" readonly="" name="total" id="total" value="<?= number_format($this->cart->total(), 0, '', '.'); ?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label">Bayar</label>
                      <div class="col-md-9">
                        <input class="form-control form-control-lg res" type="number" id="bayar" name="bayar" onkeyup="showKembali(this.value)" placeholder="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label">Kembali</label>
                      <div class="col-md-9">
                        <input class="form-control form-control-lg res" type="text" id="kembali" readonly="" name="kembali">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-3 col-form-label">Id. Nota</label>
                      <div class="col-md-9">
                        <input class="form-control form-control-lg res" type="text" id="id_nota" readonly="" name="id_nota" value="<?= $get_id_nota;?>">
                      </div>
                    </div>
                  </div>

                </div>

                <hr/>

                <table id="shoping_cart_table" class="table table-striped table-bordered nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th>no</th>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Qty</th>
                      <th>Sub total</th>
                      <th>opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                
                <button type="button" class="btn btn-md btn-primary" id="selesai" disabled="disabled" onclick="preview_struck()">selesai </button>

              </div>
            </div>
          </div>
          <!-- /.container-fluid -->

        </div>
      </div>
    </div>  
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Pilih "Keluar" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?= base_url(); ?>administrator/logout">Keluar</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
    <script src="<?= base_url(); ?>assets/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url(); ?>assets/js/demo/datatables-demo.js"></script>


    <script>
      let table;
    
      $(document).ready(function(){
        list_transaction();
        $('#product_name').focus();
        listening_serch_product();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
      });

      function list_transaction() {
        table = $('#shoping_cart_table').DataTable({
          paging: false,
          "info": false,
          "searching": false,
          "ajax": {
            "url": "<?= site_url('administrator/list_shoping_cart') ?>",
            "type": "POST"
          },
          "columnDefs": [{
            "orderable": false,
          }, ],
        });
      }

      function listening_serch_product(params) {
      $("#search").autocomplete({
          minLength: 1,
          delay: 400,
          source: function(request, response) {
            jQuery.ajax({
              url: "<?= site_url('administrator/search_product') ?>",
              data: {
                keyword: request.term
              },
              dataType: "json",
              success: function(data) {
                response(data);
              }
            })
          },
          select: function(e, ui) {
            $("#search").val('');
            $("#product_id").val(ui.item.id);
            $("#product_name").val(ui.item.title);
            $("#selling_price").val(convertToRupiah(ui.item.price));
            $("#selling_price2").val(ui.item.price);
            $('#product_qty').removeAttr("readonly");
            $('#product_qty').focus();
            return false;
          //  console.log(ui.item.price);
          }
        })
        .data("ui-autocomplete")._renderItem = function(ul, item) {
          return $("<li>")
            .append("<a style='display: flex;'><div style='width: 100px;'>" + item.id + "</div> " + item.title + "</a>")
            .appendTo(ul);
        };
      }

      function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
          if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
      }

    function subTotal(qty) {
      var harga = $('#selling_price').val().replace(".", "").replace(".", "");
      // var promo = $('#jenis_promo').val();
      // var potongan = $('#potongan').val();
      // var hrg_potong = $('#harga_potongan').val();
      // if (promo == 'minimal') {
      //   var induk = Math.floor(qty / potongan);
      //   var sisa = qty % potongan;
      //   var sub = (induk * hrg_potong) + (harga * sisa);
      //   $('#sub_total').val(convertToRupiah(sub));
      //   $('#tambah').removeAttr("disabled");
      // } else {
      //   // var diskon = harga - (harga * potongan / 100);
      //   // $('#sub_total').val(convertToRupiah(diskon * qty));
      //   $('#sub_total').val(convertToRupiah(harga * qty));
      //   $('#tambah').removeAttr("disabled");
      // }
      $('#sub_total').val(convertToRupiah(harga * qty));
      $('#tambah').removeAttr("disabled");
    }

    function save_to_cart() {
      $.ajax({
        url: "<?= site_url('administrator/add_keranjang') ?>",
        type: "POST",
        data: $('#form_order').serialize(),
        dataType: "JSON",
        success: function(data){
          reload_table();
          $('#tambah').attr("disabled", "disabled");
          $('#product_qty').attr("readonly", "readonly");
          $('#bayar').focus();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error adding data');
        }
      });
      showTotal();
      showKembali($('#bayar').val());
      $('.reset').val('');
    }

    function reload_table() {
      table.ajax.reload(null, false);
    }

    function showTotal() {
      var total = $('#total').val().replace(".", "").replace(".", "");
      var sub_total = $('#sub_total').val().replace(".", "").replace(".", "");
      $('#total').val(convertToRupiah((Number(total) + Number(sub_total))));
    }

    function showKembali(str) {
      let total = $('#total').val().replace(".", "").replace(".", "");
      let bayar = str.replace(".", "").replace(".", "");
      let kembali = bayar - total;
      $('#kembali').val(convertToRupiah(kembali));
      if (kembali >= 0) {
        $('#selesai').removeAttr("disabled");
      } else {
        $('#selesai').attr("disabled", "disabled");
      }
      if (total == 0) {
        $('#selesai').attr("disabled", "disabled");
      }
    }

    document.onkeydown = function(e) {
      let qty = $('#product_qty').val();
      let bill = $('#bayar').val();
      if (qty !== '') {
        switch (e.keyCode) {
          case 13:
            save_to_cart();
            break;
        }
      }
      if (bill !== '') {
        switch (e.keyCode) {
          case 13:
            finish_transaction();
            break;
        }
      }
      switch (e.keyCode) {
        case 113:
          $('#product_name').focus();
          break;
      }
    };

    function delete_cart(id, sub_total) {
			$.ajax({
				url : "<?= site_url('administrator/delete_shoping_cart')?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function(data){
					reload_table();
          location.reload('#pembayaran');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Gagal hapus barang');
        }
      });
    }

    function preview_struck() {
      let bayar = $('#bayar').val();
      let kembali = $('#kembali').val();
      let id_nota = $('#id_nota').val();
      $.ajax({
        url: "<?= site_url('administrator/save_orders/') ?>",
        data: {
          bayar: bayar,
          kembali: kembali,
          id_nota: id_nota
        },
        method: "POST",
        success: function(data) {
          $('#modal_struck').modal('show');
          $('#content_struck').html(data);
        }
      });
    }

    function save_cart_to_order() {
      $.ajax({
        url: "<?= site_url('administrator/shoping/') ?>",
        type: "POST",
        data: {
          id_nota_transaction: $("#id_nota").val(),
        },
        dataType: "json",
        success: function(result) {
          //cetak_struk();
          window.print();
          $('#modal_struck').modal('hide');
          reload_table();
          $('.res').val('');
          $('#product_name').focus();
          window.location.href = "<?= site_url('administrator/transaksi') ?>";
				},
				error: function(err){
					alert('error transaksi')
				}
			});
		}

    </script>

    <div class="modal fade" id="modal_struck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          </div>

          <div class="modal-body" id="content_struck">

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" OnClick="save_cart_to_order()"><span class="fa fa-print"></span> Cetak</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

