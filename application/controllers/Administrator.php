<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
        $this->load->model('Settings_model');
        $this->load->model('Promo_model');
        $this->load->model('Testi_model');
        $this->load->model('Order_model');
        $this->load->model('Transaksi_model');
        $this->load->model('User_model');

        if(!$this->session->userdata('admin')){
            $cookie = get_cookie('djehbicd');
            if($cookie == NULL){
                redirect(base_url());
            }else{
                $getCookie = $this->db->get_where('admin', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $this->session->set_userdata('admin', true);
                }else{
                    redirect(base_url());
                }
            }
        }
    }

    public function index(){
        $data['title'] = 'Dashboard - Admin Panel';
        $username = $this->session->userdata('username');
        $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/index');
        $this->load->view('templates/footer_admin');
    }

    public function users(){
        $username = $this->session->userdata('username');
        $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengguna - Admin Panel';
        $config['base_url'] = base_url() . 'administrator/users/';
        $config['total_rows'] = $this->User_model->getUsers("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['users'] = $this->User_model->getUsers($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/users', $data);
        $this->load->view('templates/footer_admin');
    }

    public function active_user($id){
        $this->db->set('is_activate', 1);
        $this->db->where('id', $id);
        $this->db->update('user');
        redirect(base_url() . 'administrator/users');
    }

    public function nonactive_user($id){
        $this->db->set('is_activate', 0);
        $this->db->where('id', $id);
        $this->db->update('user');
        redirect(base_url() . 'administrator/users');
    }

    // transaksi pembelian
    public function transaksi(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $id_admin = $data['usersAdmin']['id'];
          $data['title'] = 'Transaksi Pembayaran - Admin Panel';
      if ($id_admin == 1){
        $data['getTransaksi'] = $this->Transaksi_model->getTransaksi();
      } else {
        $data['getTransaksi'] = $this->Transaksi_model->getTransaksiKasir($id_admin);
      }
      $this->load->view('templates/header_admin', $data);
      $this->load->view('administrator/transaksi', $data);
      $this->load->view('templates/footer_admin');
    }

    public function add_transaksi(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $data['title'] = 'Transaksi Pembayaran - Admin Panel';
      $data['get_id_nota']=$this->Transaksi_model->get_id_nota();
      $this->load->view('administrator/add_transaksi', $data);
    //   $this->load->view('templates/footer_admin');
    }

    public function search_product()
    {
      $data = $this->Transaksi_model->search_product($_REQUEST['keyword']);
      echo json_encode($data);
    }

    public function add_keranjang()
    {
      $data = [
        'id'    => $this->input->post('product_id'),
        'name'  => $this->input->post('product_name'),
        'price' => $this->input->post('selling_price2'),
        'qty'   => $this->input->post('product_qty'),
      ];
      echo json_encode([
        'status' => $this->cart->insert($data),
        'total'  => $this->cart->total(),
      ]);
    }

    public function list_shoping_cart()
    {
      $data = [];
      $no   = 1;

      foreach ($this->cart->contents() as $items) {
        $row   = [];
        $row[] = $no;
        $row[] = $items['name'];
        $row[] = 'Rp. ' . number_format($items['price'], 0, '', '.') . ',-';
        $row[] = $items['qty'];
                // '
                //     <nav aria-label="Page navigation example">
                //       <ul class="pagination pagination-sm">
                //         <li class="page-item">
                //           <a class="page-link bg-danger" href="javascript:void(0)" onclick="minus_cart(' . $items['id'] . ', ' . "'" . $items['name'] . "'" . ', ' . $items['price'] . ', ' . $items['qty'] . ', ' . "'" . $items['rowid'] . "'" . ')">
                //             <i class="fas fa-minus fas-xs text-white"></i>
                //           </a>
                //         </li>
                //         <li class="page-item border border-light pl-2 pr-2">
                //           ' . $items['qty'] . '
                //         </li>
                //         <li class="page-item">
                //           <a class="page-link bg-success" href="javascript:void(0)" onclick="plus_cart(' . $items['id'] . ', ' . "'" . $items['name'] . "'" . ', ' . $items['price'] . ' )">
                //             <i class="fas fa-plus fas-xs text-white"></i>
                //           </a>
                //         </li>
                //       </ul>
                //     </nav>
                //   ';

        $row[] = 'Rp. ' . number_format($items['qty'] * $items['price'], 0, '', '.') . ',-';
                  $sub_total = $items['qty'] * $items['price'];
        $row[] = '<a href="javascript:void(0)" style="" onclick="delete_cart(' . "'" . $items['rowid'] . "'" . ')">
                    <i class="fas fa-times text-danger"></i>
                  </a>';
        $data[] = $row;
        $no++;
      }
      $output = [
        'data' => $data,
      ];
      echo json_encode($output);
    }

    public function delete_shoping_cart($rowid)
    {
      $res = $this->cart->update(
        [
          'rowid' => $rowid,
          'qty'   => 0,
        ]
      );
      if (! $res) {
        echo json_encode(
          [
            'status'  => 200,
            'message' => 'Internal server error',
            'total'   => $this->cart->total(),
          ]
        );

        return;
      }
      echo json_encode(
        [
          'status'  => 200,
          'message' => 'success',
          'total'   => $this->cart->total(),
        ]
      );
    }

    public function save_orders()
	{
		// $this->load->model('model_merchant');
		$bayar   = $this->input->post('bayar');
		$kembali = $this->input->post('kembali');
        $id_nota = $this->input->post('id_nota');
		// $toko    = $this->Transaksi_model->find_merchant();
        $username = $this->session->userdata('username');
        $data = $this->db->get_where('admin', ['username' => $username])->row();
		$no      = 1;
		$output  = '';

		$output .= '<div>';

		$output .= '
              <div style="text-align: center; font-size: 20px; font-weight: bold;"> Awal Semangat</div>
              <div style="text-align: center"> Semua orang berhak minum enak <br/> <br/> <input class="form-control" type="hidden" name="id_nota_transaction" id="id_nota_transaction" readonly="" placeholder="0" value="' . $id_nota . '"></div>
              <div> No. Nota : ' . $id_nota . '</div>
              <div> Kasir : ' . $data->nama . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date('Y-m-d  h:i:s') . '</div>
              
              ';
		$output .= '<div style="border-top:1px dashed; border-bottom:1px dashed; margin: 20px 0;">'; // body

		$output .= '<div style="display: flex; border-bottom:1px dashed; margin-bottom: 10px;">
                  <div style="width: 20%; font-weight: bold;">No</div>
                  <div style="width: 35%; font-weight: bold;">Nama</div>
                  <div style="width: 15%; font-weight: bold;">Harga</div>
                  <div style="width: 15%; font-weight: bold; text-align: center;">Qty</div>
                  <div style="width: 35%; font-weight: bold;">Sub Total</div>
                </div>
              ';

		foreach ($this->cart->contents() as $row) {
			$output .= '
                <div style="display: flex; margin-bottom: 10px;">
                  <div style="width: 10%;">' . $no++ . '</div>
                  <div style="width: 40%;">' . $row['name'] . '</div>
                  <div style="width: 20%;">Rp.' . $row['price'] . '</div>
                  <div style="width: 15%; text-align: center;">' . $row['qty'] . '</div>
                  <div style="width: 35%;">Rp.' . $row['price'] * $row['qty']. '</div>
                </div>';
		}

		$output .= '</div>';

		$output .= '
                <div style="display: flex;">
                  <div style="width: 80%; text-align: right;">Total</div>
                  <div style="width: 5%; text-align: center;">:</div>
                  <div style="width: 35%;">Rp.' . number_format($this->cart->total(), 0, ',', '.') . '</div>
                </div>
              ';

		$output .= '
                <div style="display: flex;">
                  <div style="width: 80%; text-align: right;">Bayar</div>
                  <div style="width: 5%; text-align: center;">:</div>
                  <div style="width: 35%;">Rp.' . number_format($bayar, 0, ',', '.') . '</div>
                </div>
              ';

		$output .= '
                <div style="display: flex;">
                  <div style="width: 80%; text-align: right;">Kembali</div>
                  <div style="width: 5%; text-align: center;">:</div>
                  <div style="width: 35%;">Rp.' . $kembali . '</div>
                </div>
              ';

		$output .= '<div style="text-align:center; margin: 20px 0;">
                  Terimakasih atas kunjungan anda <br/> Semoga anda puas dengan produk dan pelayanan kami <br/> Website : https://awalsemangat.id
                </div>';
		$output .= '</div>';
		echo $output;
	}

    public function shoping()
	{   
        $username = $this->session->userdata('username');
        $data = $this->db->get_where('admin', ['username' => $username])->row();
		$id_nota_transaction = $this->input->post('id_nota_transaction');
		$response         = [];
		if ($this->cart->contents() !== []) {
			$time_transaction = date('Y-m-d  h:i:s');

            $order = [
                'id_nota'   => $id_nota_transaction,
                'date'      => $time_transaction,
                'price'     => $this->cart->total(),
                'status'    => "selesai",
                'id_admin'  => $data->id,
                
            ];

            // insert ke tabel payment_transaction
            $this->Transaksi_model->create_order($order);

			foreach ($this->cart->contents() as $cart) {
				$detailOrder = [
					'id_nota'       => $id_nota_transaction,
					'products_name'  => $cart['name'],
					'price'         => $cart['price'],
					'qty'           => $cart['qty'],
				];

                // kurangi stock pada tabel product
				// $res      = $this->model_product->get_product_qty($cart['id']);
				// $last_qty = $res->product_qty - $cart['qty'];
				// $this->model_product->update_product_qty($cart['id'], $last_qty);

                // insert ke tabel payment_transaction_detail
                $this->Transaksi_model->create_detail_order($detailOrder);
			}

			$this->cart->destroy();
			$response = [
				'status'  => 200,
				'message' => 'success',
			];
		} else {
			$response = [
				'status'  => 400,
				'message' => 'internal server error',
			];
		}
		echo json_encode($response);
	}

    public function cetak_transaksi(){
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        $tanggal_awal1 = $tanggal_awal.' 00:00:00';
        $tanggal_akhir1 = $tanggal_akhir.' 23:59:59';

        $data['tanggal_awal'] = $tanggal_awal;
        $data['tanggal_akhir'] = $tanggal_akhir;

        $data['getLaporan'] = $this->Transaksi_model->getLaporan($tanggal_awal1, $tanggal_akhir1);
    
        $this->load->library('dompdf_gen');

        $this->dompdf_gen->setFileName('Laporan Pembelian '.date("Y-m-d H:i:s").'.pdf');
        $this->dompdf_gen->setPaper('A4', 'potrait');
        $this->dompdf_gen->loadView('administrator/laporan_pdf', $data);

    }

    public function detail_transaksi($id_nota){
        $username = $this->session->userdata('username');
        $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Detail Transaksi - Admin Panel';
        $data['transaksi'] = $this->Transaksi_model->getTransaksiById($id_nota);
        $data['detailTransaksi'] = $this->Transaksi_model->getDetailTransaksiById($id_nota);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/detail_transaksi', $data);
        $this->load->view('templates/footer_admin');
    }

    public function print_transaksi($id_nota){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Print Detail Transaksi - Admin Panel';
        $data['transaksi'] = $this->Transaksi_model->getTransaksiById($id_nota);
        $data['detailTransaksi'] = $this->Transaksi_model->getDetailTransaksiById($id_nota);
        $this->load->view('administrator/print_detail_transaksi', $data);
    }

    public function proof(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Bukti Pembayaran - Admin Panel';
        $data['proof'] = $this->db->get_where('payment_proof', ['status' => 0]);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/proof', $data);
        $this->load->view('templates/footer_admin');
    }

    public function confirm_proof($id){
        $type = $_GET['type'];
        $this->db->set('status', 1);
        $this->db->where('invoice', $id);
        $this->db->update('payment_proof');
        $this->db->set('status', 1);
        $this->db->where('invoice_code', $id);
        $this->db->update('invoice');
        $get = $this->db->get_where('payment_proof', ['invoice' => $id])->row_array();
        unlink("./assets/images/confirmation/".$get['file']);
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Bukti pembayaran terverifikasi',
            icon: 'success'
            });
        </script>");
        if($type == "order"){
            redirect(base_url() . 'administrator/order/' . $id);
        }else{
            redirect(base_url() . 'administrator/proof/');
        }
    }

    // orders
    public function orders(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pesanan - Admin Panel';
        // $config['base_url'] = base_url() . 'administrator/orders/';
        // $config['total_rows'] = $this->Order_model->getOrders("","")->num_rows();
        // $config['per_page'] = 10;
        // $config['first_link']       = 'First';
        // $config['last_link']        = 'Last';
        // $config['next_link']        = 'Next';
        // $config['prev_link']        = 'Prev';
        // $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        // $config['full_tag_close']   = '</ul></nav></div>';
        // $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        // $config['num_tag_close']    = '</span></li>';
        // $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        // $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        // $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        // $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['prev_tagl_close']  = '</span>Next</li>';
        // $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        // $config['first_tagl_close'] = '</span></li>';
        // $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['last_tagl_close']  = '</span></li>';
        // $from = $this->uri->segment(3);
        // $this->pagination->initialize($config);
        $data['orders'] = $this->Order_model->getOrders($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/orders', $data);
        $this->load->view('templates/footer_admin');
    }

    public function detail_order($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        if($this->Order_model->getDataInvoice($id)){
            $data['title'] = 'Detail Pesanan - Admin Panel';
            $data['orders'] = $this->Order_model->getOrderByInvoice($id);
            $data['invoice'] = $this->Order_model->getDataInvoice($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/detail_order', $data);
            $this->load->view('templates/footer_admin');
        }else{
            redirect(base_url() . 'administrator/orders');
        }
    }

    public function print_detail_order($id){
        if($this->Order_model->getDataInvoice($id)){
            $data['title'] = 'Detail Pesanan - Admin Panel';
            $data['orders'] = $this->Order_model->getOrderByInvoice($id);
            $data['invoice'] = $this->Order_model->getDataInvoice($id);
            $this->load->view('administrator/order_invoice', $data);
        }else{
            redirect(base_url() . 'administrator/orders');
        }
    }

    public function process_order($id){
        $buyer = $this->db->get_where('invoice', ['invoice_code' => $id])->row_array();
        $this->db->set('status', 2);
        $this->db->where('invoice_code', $id);
        $this->db->update('invoice');
        $transaction = $this->db->get_where('transaction', ['id_invoice' => $id]);
        foreach($transaction->result_array() as $t){
            $this->db->set('transaction', 'transaction+'.$t['qty'].'', FALSE);
            $this->db->set('stock', 'stock-'.$t['qty'].'', FALSE);
            $this->db->where('slug', $t['slug']);
            $this->db->update('products');
        }
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['useragent'] = $this->config->item('app_name');
        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $this->config->item('host_mail');
        $config['smtp_port'] = $this->config->item('port_mail');
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = $this->config->item('mail_account');
        $config['smtp_pass'] = $this->config->item('pass_mail');
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
        $this->email->to($buyer['email']);
        $this->email->subject('Pesanan Sedang Diproses '.$id);
        $this->email->message(
            '<p><strong>Halo '.$buyer['name'].'</strong><br>
            Pembayaranmu sudah kami terima dan pesanan sedang kami proses. Jika ada pertanyaan silakan hubungi Whatsapp '.$this->config->item('whatsapp').' atau <a href="https://wa.me/'.$this->config->item('whatsappv2').'">klik disini</a>.</p>
            <p>Terima kasih atas kepercayaannya kepada kami.<br/>
            Terima Kasih</p>
            ');
        $this->email->send();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Status berhasil diubah menjadi Sedang Diproses',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/order/'.$id);
    }

    public function finish_order_cod($id){
        $this->db->set('status', 4);
        $this->db->where('invoice_code', $id);
        $this->db->update('invoice');
        $transaction = $this->db->get_where('transaction', ['id_invoice' => $id]);
        foreach($transaction->result_array() as $t){
            $this->db->set('transaction', 'transaction+1', FALSE);
            $this->db->set('stock', 'stock-1', FALSE);
            $this->db->where('slug', $t['slug']);
            $this->db->update('products');
        }
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Pesanan selesai',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/order/'.$id);
    }

    public function sending_order($id){
        $resi = $this->input->post('resi', true);
        if($resi == NULL){
            redirect(base_url() . 'administrator/orders');
        }
        $buyer = $this->db->get_where('invoice', ['invoice_code' => $id])->row_array();
        $this->db->set('status', 3);
        $this->db->where('invoice_code', $id);
        $this->db->update('invoice');
        $this->db->set('resi', $resi);
        $this->db->where('invoice_code', $id);
        $this->db->update('invoice');
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['useragent'] = $this->config->item('app_name');
        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $this->config->item('host_mail');
        $config['smtp_port'] = $this->config->item('port_mail');
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = $this->config->item('mail_account');
        $config['smtp_pass'] = $this->config->item('pass_mail');
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
        $this->email->to($buyer['email']);
        $this->email->subject('Pemesanan Telah Dikirim '.$id);
        $this->email->message(
            '<p><strong>Halo '.$buyer['name'].'</strong><br>
            Pesananmu telah kami kirim. <br/> Nomor Resi: <strong>'.$resi.'</strong> <br/> Jika ada pertanyaan silakan bisa menghubungi kami melalui Whatsapp'.$this->config->item('whatsapp').' atau <a href="https://wa.me/'.$this->config->item('whatsappv2').'">klik disini</a>.</p>
            ');
        $this->email->send();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Nomor Resi telah dikirim kepada pembeli melalui email',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/order/'.$id);
    }

    public function delete_order($id){
        $buyer = $this->db->get_where('invoice', ['invoice_code' => $id])->row_array();
        $this->db->where('invoice_code', $id);
        $this->db->delete('invoice');
        $this->db->where('id_invoice', $id);
        $this->db->delete('transaction');
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['useragent'] = $this->config->item('app_name');
        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $this->config->item('host_mail');
        $config['smtp_port'] = $this->config->item('port_mail');
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = $this->config->item('mail_account');
        $config['smtp_pass'] = $this->config->item('pass_mail');
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
        $this->email->to($buyer['email']);
        $this->email->subject('Pemesanan Anda Ditolak '.$id);
        $this->email->message(
            '<p><strong>Halo '.$buyer['name'].'</strong><br>
            Pesanan Anda kami tolak. <br/> Silakan hubungi kami melalui Whatsapp'.$this->config->item('whatsapp').' atau <a href="https://wa.me/'.$this->config->item('whatsappv2').'">klik disini</a>.</p>
            ');
        $this->email->send();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Pesanan ditolak dan telah dihapus',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/orders');
    }

    // email
    public function email(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Kirim Email - Admin Panel';
        $data['email'] = '';
        $this->db->select("*, email_send.id AS sendId");
        $this->db->from("email_send");
        $this->db->join("subscriber", "email_send.mail_to=subscriber.id");
        $this->db->order_by('email_send.id', 'desc');
        $data['email'] = $this->db->get();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/email', $data);
        $this->load->view('templates/footer_admin');
    }

    public function detail_email($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Detail Email - Admin Panel';
        $data['email'] = '';
        $this->db->select("*, email_send.id AS sendId");
        $this->db->from("email_send");
        $this->db->join("subscriber", "email_send.mail_to=subscriber.id");
        $this->db->where('email_send.id', $id);
        $data['email'] = $this->db->get()->row_array();
        if(!$data['email']){
            redirect(base_url() . 'administrator/email');
        }
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/detail_email', $data);
        $this->load->view('templates/footer_admin');
    }

    public function send_mail(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('sendMailTo', 'sendMailTo', 'required', ['required' => 'Ke wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Kirim Email - Admin Panel';
            $data['email'] = $this->Settings_model->getEmailAccount();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/send_mail', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $to = $this->input->post('sendMailTo');
            $subjet = $this->input->post('subject');
            $message = $this->input->post('description');
            $data = [
                'mail_to' => $to,
                'subject' => $subjet,
                'message' => $message
            ];
            $this->db->insert('email_send', $data);

            if($to == 0){
                $data = $this->db->get('subscriber');
                foreach($data->result_array() as $d){
                    $this->load->library('email');
                    $config['charset'] = 'utf-8';
                    $config['useragent'] = $this->config->item('app_name');
                    $config['smtp_crypto'] = $this->config->item('smtp_crypto');
                    $config['protocol'] = 'smtp';
                    $config['mailtype'] = 'html';
                    $config['smtp_host'] = $this->config->item('host_mail');
                    $config['smtp_port'] = $this->config->item('port_mail');
                    $config['smtp_timeout'] = '5';
                    $config['smtp_user'] = $this->config->item('mail_account');
                    $config['smtp_pass'] = $this->config->item('pass_mail');
                    $config['crlf'] = "\r\n";
                    $config['newline'] = "\r\n";
                    $config['wordwrap'] = TRUE;

                    $message .= '<br/><br/><a href="'.base_url().'unsubscribe-email?email='.$d['email'].'&code='.$d['code'].'">Berhenti berlangganan</a>';

                    $this->email->initialize($config);
                    $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
                    $this->email->to($d['email']);
                    $this->email->subject($subjet);
                    $this->email->message(nl2br($message));
                    $this->email->send();
                }
            }else{
                $this->load->library('email');
                $config['charset'] = 'utf-8';
                $config['useragent'] = $this->config->item('app_name');
                $config['smtp_crypto'] = $this->config->item('smtp_crypto');
                $config['protocol'] = 'smtp';
                $config['mailtype'] = 'html';
                $config['smtp_host'] = $this->config->item('host_mail');
                $config['smtp_port'] = $this->config->item('port_mail');
                $config['smtp_timeout'] = '5';
                $config['smtp_user'] = $this->config->item('mail_account');
                $config['smtp_pass'] = $this->config->item('pass_mail');
                $config['crlf'] = "\r\n";
                $config['newline'] = "\r\n";
                $config['wordwrap'] = TRUE;

                $dataEmail = $this->db->get_where('subscriber', ['id' => $to])->row_array();
                $message .= '<br/><br/><a href="'.base_url().'unsubscribe-email?email='.$dataEmail['email'].'&code='.$dataEmail['code'].'">Berhenti berlangganan</a>';
                $this->email->initialize($config);
                $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
                $this->email->to($dataEmail['email']);
                $this->email->subject($subjet);
                $this->email->message(nl2br($message));
                $this->email->send();
            }
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Email berhasil dikirim',
                icon: 'success'
                });
            </script>");
            redirect(base_url() . 'administrator/email');
        }
    }

    public function detele_email($id){
        $this->db->where('id', $id);
        $this->db->delete('email_send');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Email berhasil dihapus',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/email');
    }

    // categories
    public function categories(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Kategori - Admin Panel';
            $data['getCategories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/categories', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Categories_model->uploadIcon();

            if($upload['result'] == 'success'){
                $this->Categories_model->insertCategory($upload);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/categories');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function category($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Kategori - Admin Panel';
            $data['category'] = $this->Categories_model->getCategoryById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_category', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['icon']['name'] != ""){
                $data = array();
                $upload = $this->Categories_model->uploadIcon();
                if($upload['result'] == 'success'){
                    $this->Categories_model->updateCategory($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Kategori berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/categories');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                  </div>");
                    redirect(base_url() . 'administrator/category/' . $id);
                }
            }else{
                $oldIcon = $this->input->post('oldIcon');
                $this->Categories_model->updateCategory($oldIcon, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function deleteCategory($id){
        $this->db->where('id', $id);
        $this->db->delete('categories');
        $this->db->where('category', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Kategori berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/categories');
    }

    // products
    public function products(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Produk - Admin Panel';
        // $config['base_url'] = base_url() . 'administrator/products/';
        // $config['total_rows'] = $this->Products_model->getProducts("","")->num_rows();
        // $config['per_page'] = 10;
        // $config['first_link']       = 'First';
        // $config['last_link']        = 'Last';
        // $config['next_link']        = 'Next';
        // $config['prev_link']        = 'Prev';
        // $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        // $config['full_tag_close']   = '</ul></nav></div>';
        // $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        // $config['num_tag_close']    = '</span></li>';
        // $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        // $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        // $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        // $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['prev_tagl_close']  = '</span>Next</li>';
        // $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        // $config['first_tagl_close'] = '</span></li>';
        // $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['last_tagl_close']  = '</span></li>';
        // $from = $this->uri->segment(3);
        // $this->pagination->initialize($config);
        $data['getProducts'] = $this->Products_model->getProducts();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/products', $data);
        $this->load->view('templates/footer_admin');
    }

    public function search_products(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $key = $_GET['q'];
        $data['title'] = 'Produk - Admin Panel';
        $config['base_url'] = base_url() . 'administrator/products/';
        $config['total_rows'] = $this->Products_model->getSearchProducts($key,"","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['getProducts'] = $this->Products_model->getSearchProducts($key,$config['per_page'], $from);
        $data['search'] = $key;
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/products', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_product(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        $this->form_validation->set_rules('description', 'description', 'required', ['required' => 'Deskripsi wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Produk - Admin Panel';
            $data['categories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Products_model->uploadImg();

            if($upload['result'] == 'success'){
                $this->Products_model->insertProduct($upload);
                if($this->input->post('sendemail') == 1){
                    $mail = $this->db->get('subscriber');
                    $title = $this->input->post('title');
                    function toSlugFromText($text='') {
                        $text = trim($text);
                        if (empty($text)) return '';
                        $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
                        $text = strtolower(trim($text));
                        $text = str_replace(' ', '-', $text);
                        $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
                        return $text;
                    }
                    foreach($mail->result_array() as $d){
                        $this->load->library('email');
                        $config['charset'] = 'utf-8';
                        $config['useragent'] = $this->config->item('app_name');
                        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
                        $config['protocol'] = 'smtp';
                        $config['mailtype'] = 'html';
                        $config['smtp_host'] = $this->config->item('host_mail');
                        $config['smtp_port'] = $this->config->item('port_mail');
                        $config['smtp_timeout'] = '5';
                        $config['smtp_user'] = $this->config->item('mail_account');
                        $config['smtp_pass'] = $this->config->item('pass_mail');
                        $config['crlf'] = "\r\n";
                        $config['newline'] = "\r\n";
                        $config['wordwrap'] = TRUE;
    
                        $message = '<p>
                        Hai
                        Gimana kabarnya? Kami punya produk terbaru nih. Ayo buruan dapatkan sebelum kehabisan stok.
                        <strong>'.$this->input->post('title').'</strong>
                        <stong>Rp '.number_format($this->input->post('price'),0,",",".").'</stong>
                        <a href="'.base_url().'p/'.toSlugFromText($title).'">Lihat Produk</a></p>
                        <br/><br/>
                        <a href="'.base_url().'unsubscribe-email?email='.$d['email'].'&code='.$d['code'].'">Berhenti berlangganan</a>
                        ';
                        $this->email->initialize($config);
                        $this->email->from($this->config->item('mail_account'), $this->config->item('app_name'));
                        $this->email->to($d['email']);
                        $this->email->subject($this->input->post('title'));
                        $this->email->message(nl2br($message));
                        $this->email->send();
                    }
                }
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/products');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/product/add');
            }
        }
    }

    public function add_img_product($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('help', 'help', 'required');
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Gambar - Admin Panel';
            $data['product'] = $this->Products_model->getProductById($id);
            $data['img'] = $this->db->get_where('img_product', ['id_product' => $id]);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_img_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Products_model->uploadImg();
            if($upload['result'] == 'success'){
                $this->Products_model->insertImg($upload, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Gambar berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/add-img/'.$id);
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah gambar, pastikan gambar berukuran maksimal 10mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/product/add-img/'.$id);
            }
        }
    }

    public function add_grosir_product($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('min', 'min', 'required', ['required' => 'Jumlah min. harus diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Harga Grosir - Admin Panel';
            $data['product'] = $this->Products_model->getProductById($id);
            $this->db->order_by('id', 'desc');
            $data['grosir'] = $this->db->get_where('grosir', ['product' => $id]);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_grosir_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->db->order_by('id', 'desc');
            $check = $this->db->get_where('grosir', ['product' => $id]);
            $min = $this->input->post('min');
            $price = $this->input->post('price');
            $product = $this->Products_model->getProductById($id);
            if($check->num_rows() > 0){
                $jmlsebelumnya = $check->row_array()['min'] + 1;
                if($min < $jmlsebelumnya){
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal menambahkan harga grosir, pastikan jumlah minimal adalah $jmlsebelumnya
                  </div>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }else{
                    $data = [
                        'min' => $min,
                        'price' => $price,
                        'product' => $id
                    ];
                    $this->db->insert('grosir', $data);
                    $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Harga grosir berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }
            }else{
                if($min < 2){
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal menambahkan harga grosir, pastikan jumlah minimal adalah 2
                  </div>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }else{
                    $data = [
                        'min' => $min,
                        'price' => $price,
                        'product' => $id
                    ];
                    $this->db->insert('grosir', $data);
                    $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Harga grosir berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }
            }
        }
    }

    public function delete_img_other_product($id, $idp){
        $this->db->where('id', $id);
        $this->db->delete('img_product');
        $this->session->set_flashdata('upload', "<script>
        swal({
        text: 'Gambar berhasil dihapus',
        icon: 'success'
        });
        </script>");
        redirect(base_url() . 'administrator/product/add-img/'.$idp);
    }

    public function edit_product($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Produk - Admin Panel';
            $data['categories'] = $this->Categories_model->getCategories();
            $data['product'] = $this->Products_model->getProductById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['img']['name'] != ""){
                $data = array();
                $upload = $this->Products_model->uploadImg();

                if($upload['result'] == 'success'){
                    $this->Products_model->updateProduct($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Produk berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/products');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                </div>");
                    redirect(base_url() . 'administrator/product/' . $id . '/edit');
                }
            }else{
                $oldImg = $this->input->post('oldImg');
                $this->Products_model->updateProduct($oldImg, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/products');
            }
        }
    }

    public function product($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Detail Produk - Admin Panel';
        $data['product'] = $this->Products_model->getProductById($id);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/detail_product', $data);
        $this->load->view('templates/footer_admin');
    }

    public function delete_product($id){
        $this->db->where('id', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Produk berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/products');
    }

    // promo
    public function promo(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Promo Produk - Admin Panel';
        // $config['base_url'] = base_url() . 'administrator/promo/';
        // $config['total_rows'] = $this->Promo_model->getProducts("","")->num_rows();
        // $config['per_page'] = 10;
        // $config['first_link']       = 'First';
        // $config['last_link']        = 'Last';
        // $config['next_link']        = 'Next';
        // $config['prev_link']        = 'Prev';
        // $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        // $config['full_tag_close']   = '</ul></nav></div>';
        // $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        // $config['num_tag_close']    = '</span></li>';
        // $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        // $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        // $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        // $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['prev_tagl_close']  = '</span>Next</li>';
        // $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        // $config['first_tagl_close'] = '</span></li>';
        // $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        // $config['last_tagl_close']  = '</span></li>';
        // $from = $this->uri->segment(3);
        // $this->pagination->initialize($config);
        $data['getProducts'] = $this->Promo_model->getProducts();
        $data['setting'] = $this->Settings_model->getSetting();
        $data['promo'] = $this->Promo_model->getPromo();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/promo', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_promo(){
        $this->Promo_model->insertPromo();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Produk berhasil dijadikan promo',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/promo');
    }

    public function delete_promo($id){
        $this->Promo_model->deletePromo($id);
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Produk untuk promo berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/promo');
    }

    // testimonials
    public function testimonials(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Testimosi - Admin Panel';
            $data['testi'] = $this->Testi_model->getTesti();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/testi', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Testi_model->insertTesti();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Testimoni berhasil ditambahkan',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/testimonials');
        }
    }

    public function testimonial($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Testimosi - Admin Panel';
            $data['testi'] = $this->Testi_model->getTestiById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_testi', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Testi_model->updateTesti($id);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Testimoni berhasil diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/testimonials');
        }
    }

    public function delete_testimonial($id){
        $this->db->where('id', $id);
        $this->db->delete('testimonial');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Testimoni berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/testimonials');
    }

    // pages
    public function pages(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Halaman - Admin Panel';
        $data['pages'] = $this->Settings_model->getPages();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/pages', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_page(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('title', 'Judul', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Halaman - Admin Panel';
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_page', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->insertPage();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Halaman berhasil ditambahkan',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/pages');
        }
    }

    public function edit_page($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('title', 'Judul', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Halaman - Admin Panel';
            $data['page'] = $this->Settings_model->getPageById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_page', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->updatePage($id);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Halaman berhasil diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/pages');
        }
    }

    public function delete_page($id){
        $this->db->where('id', $id);
        $this->db->delete('pages');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Halaman Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/pages');
    }

    // users admin
    public function users_admin(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $data['title'] = 'Users Admin - Admin Panel';
      $data['users_admin'] = $this->User_model->getUsersAdmin();
      $this->load->view('templates/header_admin', $data);
      $this->load->view('administrator/users_admin', $data);
      $this->load->view('templates/footer_admin');
    }

    public function add_users_admin(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Judul wajib diisi']);
      $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[admin.username]', [
        'required' => 'Judul wajib diisi',
        'is_unique' => 'Username sudah digunakan! Ganti dengan yang lain.'
      ]);
      $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
        'required' => 'Judul wajib diisi',
        'min_length' => 'Password harus 6 karakter!',
        'matches' => 'Password harus sama!'
      
      ]);
      $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

      if($this->form_validation->run() == false){
          $data['title'] = 'Tambah Users Admin - Admin Panel';
          $this->load->view('templates/header_admin', $data);
          $this->load->view('administrator/add_users_admin', $data);
          $this->load->view('templates/footer_admin');
      }else{
          $data = [
            'nama' => htmlspecialchars($this->input->post('nama', 'true')),
            'username' => htmlspecialchars($this->input->post('username', 'true')),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'cookie' => "",
            'role' => "kasir",
          ];
          $this->User_model->insertUsersAdmin($data);
          $this->session->set_flashdata('upload', "<script>
              swal({
              text: 'Users Kasir berhasil ditambahkan',
              icon: 'success'
              });
              </script>");
          redirect(base_url() . 'administrator/users_admin');
      }
    }

    public function edit_users_admin($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $data['usersAdminById'] = $this->db->get_where('admin', ['id' => $id])->row_array();
      $data['title'] = 'Edit Users Admin - Admin Panel';
      $this->load->view('templates/header_admin', $data);
      $this->load->view('administrator/edit_users_admin', $data);
      $this->load->view('templates/footer_admin');
    }

    public function edit_username_users_admin(){
      $id = $this->input->post('id');
      // $data['usersAdmin'] = $this->db->get_where('admin', ['id' => $id])->row_array();
      // $id_admin = $data['usersAdmin']['id'];
      $this->db->set('username', $this->input->post('username'));
      $this->db->where('id', $id);
      $this->db->update('admin');
      $this->session->set_flashdata('upload', "<script>
          swal({
          text: 'Username berhasil diubah',
          icon: 'success'
          });
          </script>");
      redirect(base_url() . 'administrator/users_admin');
    }

    public function edit_pass_users_admin(){
      $id = $this->input->post('id');
      $data['usersAdmin'] = $this->db->get_where('admin', ['id' => $id])->row_array();
      $admin = $data['usersAdmin']['password'];
      if(password_verify($this->input->post('oldPassword'), $admin)){
          if($this->input->post('newPassword') ==  $this->input->post('confirmPassword')){
              $pass = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);
              $this->db->set('password', $pass);
              $this->db->where('id', $id);
              $this->db->update('admin');
              $this->session->set_flashdata('upload', "<script>
                  swal({
                  text: 'Password berhasil diubah',
                  icon: 'success'
                  });
                  </script>");
              redirect(base_url() . 'administrator/users_admin');
          }else{
              $this->session->set_flashdata('upload', "<script>
                  swal({
                  text: 'Konfirmasi password tidak sama. Silakan coba lagi',
                  icon: 'error'
                  });
                  </script>");
              redirect(base_url() . 'administrator/users_admin');
          }
      }else{
          $this->session->set_flashdata('upload', "<script>
              swal({
              text: 'Password lama salah. Silakan coba lagi',
              icon: 'error'
              });
              </script>");
          redirect(base_url() . 'administrator/users_admin');
      }
    }

    public function delete_users_admin($id){
      $this->db->where('id', $id);
      $this->db->delete('admin');
      $this->session->set_flashdata('upload', "<script>
          swal({
          text: 'Users Kasir Berhasil Dihapus',
          icon: 'success'
          });
          </script>");
      redirect(base_url() . 'administrator/users_admin');
    }

    // settings
    public function settings(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengaturan - Admin Panel';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/settings', $data);
        $this->load->view('templates/footer_admin');
    }

    public function banner_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengaturan - Admin Panel';
        $data['banner'] = $this->Settings_model->getBanner();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_banner', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_banner_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengaturan - Admin Panel';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/add_setting_banner', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_banner_setting_post(){
        $data = array();
        $upload = $this->Settings_model->uploadImg();
        if($upload['result'] == 'success'){
            $insert = $this->Settings_model->insertBanner($upload);
            if($insert){
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Banner berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/setting/banner');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah banner, gambar yang kamu upload tidak berukuran 1700x400px.
                </div>");
                redirect(base_url() . 'administrator/setting/banner/add');
            }
        }else{
            $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
            Gagal menambah banner, pastikan banner berukuran maksimal 2mb, berformat png, jpg, jpeg. Dan berukuran 1600x400px.
            </div>");
            redirect(base_url() . 'administrator/setting/banner/add');
        }
    }

    public function delete_banner($id){
        $this->db->where('id', $id);
        $this->db->delete('banner');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Banner Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/banner');
    }

    public function description_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengaturan - Admin Panel';
        $data['desc'] = $this->Settings_model->getSetting();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_description', $data);
        $this->load->view('templates/footer_admin');
    }

    public function edit_description_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->Settings_model->editDescription();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Deskripsi singkat berhasil diubah',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/description');
    }

    public function rekening_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Pengaturan - Admin Panel';
        $data['rekening'] = $this->Settings_model->getRekening();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_rekening', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_rekening_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Nama', 'required', ['required' => 'Nama wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_setting_rekening', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->addRekening();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Rekening Berhasil Disimpan',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/rekening');
        }
    }

    public function edit_rekening_setting($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Nama', 'required', ['required' => 'Nama wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $data['rekening'] = $this->Settings_model->getRekeningById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_setting_rekening', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->editRekening($id);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Rekening Berhasil Diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/rekening');
        }
    }

    public function delete_rekening($id){
        $this->db->where('id', $id);
        $this->db->delete('rekening');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Rekening Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/rekening');
    }

    public function sosmed_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $data['title'] = 'Pengaturan - Admin Panel';
      $data['sosmed'] = $this->Settings_model->getSosmed();
      $this->load->view('templates/header_admin', $data);
      $this->load->view('administrator/setting_sosmed', $data);
      $this->load->view('templates/footer_admin');
    }

    public function add_sosmed_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $this->form_validation->set_rules('name', 'Nama', 'required', ['required' => 'Nama wajib diisi']);
      if($this->form_validation->run() == false){
          $data['title'] = 'Pengaturan - Admin Panel';
          $this->load->view('templates/header_admin', $data);
          $this->load->view('administrator/add_setting_sosmed', $data);
          $this->load->view('templates/footer_admin');
      }else{
          $this->Settings_model->addSosmed();
          $this->session->set_flashdata('upload', "<script>
              swal({
              text: 'Sosial Media Berhasil Disimpan',
              icon: 'success'
              });
              </script>");
          redirect(base_url() . 'administrator/setting/sosmed');
      }
    }

    public function edit_sosmed_setting($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('name', 'Nama', 'required', ['required' => 'Nama wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $data['sosmed'] = $this->Settings_model->getSosmedById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_setting_sosmed', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->editSosmed($id);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Sosmed Berhasil Diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/sosmed');
        }
    }

    public function delete_sosmed($id){
        $this->db->where('id', $id);
        $this->db->delete('sosmed');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Sosmed Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/sosmed');
    }

    public function address_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $this->form_validation->set_rules('address', 'Alamat', 'required', ['required' => 'Alamat wajib diisi']);
      if($this->form_validation->run() == false){
        $data['title'] = 'Pengaturan - Admin Panel';
        $data['address'] = $this->Settings_model->getSetting();
        $data['regency'] = $this->Settings_model->getRegency();
        $data['selectRegency'] = $this->Settings_model->getRegencyById();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_address', $data);
        $this->load->view('templates/footer_admin');
      }else{
        $this->Settings_model->editAddress();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Alamat Berhasil Diubah',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/address');
      }
    }

    public function delivery_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Biaya Antar - Admin Panel';
        $data['delivery'] = $this->Settings_model->getCostDelivery();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_delivery', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_delivery_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('destination', 'Tujuan', 'required', ['required' => 'Tujuan wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $data['regency'] = $this->Settings_model->getRegency();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_setting_delovery', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->addDelivery();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Biaya Antar Berhasil Ditambah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/delivery');
        }
    }

    public function edit_delivery_setting($id){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('destination', 'Tujuan', 'required', ['required' => 'Tujuan wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $data['delivery'] = $this->Settings_model->getCostDeliveryById($id);
            $data['regency'] = $this->Settings_model->getRegency();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_setting_delivery', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->editDelivery($id);
            $destination = $this->input->post('destination', true);
            $price = $this->input->post('price', true);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Biaya Antar Berhasil Diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/delivery');
        }
    }

    public function delete_delivery($id){
        $this->db->where('id', $id);
        $this->db->delete('cost_delivery');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Biaya Antar Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/delivery');
    }

    public function cod_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $data['title'] = 'Cash on Delivery - Admin Panel';
        $data['cod'] = $this->Settings_model->getCOD();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_cod', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_cod_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $this->form_validation->set_rules('destination', 'Tujuan', 'required', ['required' => 'Tujuan wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan - Admin Panel';
            $data['regency'] = $this->Settings_model->getRegency();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_setting_cod', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->addCOD();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'COD Berhasil Ditambah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/cod');
        }
    }

    public function delete_cod($id){
        $this->db->where('id', $id);
        $this->db->delete('cod');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'COD Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/cod');
    }

    public function footer_setting(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $this->form_validation->set_rules('page', 'Page', 'required', ['required' => 'Page wajib diisi']);
      if($this->form_validation->run() == false){
        $data['title'] = 'Pengaturan - Admin Panel';
        $data['footerhelp'] = $this->Settings_model->getFooterHelp();
        $data['footerinfo'] = $this->Settings_model->getFooterInfo();
        $data['pages'] = $this->Settings_model->getPages();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_footer', $data);
        $this->load->view('templates/footer_admin');
      }else{
        $this->Settings_model->addFooter();
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Navigasi Footer berhasil ditambah',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/footer');
      }
    }

    public function off_promo_setting($type){
        if($type == 1){
            $this->db->set('promo', 0);
            return $this->db->update('settings');
        }else{
            $this->db->set('promo', 1);
            return $this->db->update('settings');
        }
    }

    public function set_time_promo(){
        $pdate = $this->input->post("pdate");
        $this->db->set('promo_time', $pdate);
        return $this->db->update('settings');
    }

    // ajax
    public function ajax_get_product_by_id($id){
        $return = $this->Products_model->getProductById($id);
        echo json_encode($return);
    }

    // edit
    public function edit(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $data['title'] = 'Edit Profil Admin - Admin Panel';
      // $admin = $this->db->get('admin')->row_array();
      // $data['admin'] = $admin;
      $this->load->view('templates/header_admin', $data);
      $this->load->view('administrator/edit', $data);
      $this->load->view('templates/footer_admin');
    }

    public function edit_username(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
      $id_admin = $data['usersAdmin']['id'];
      $this->db->set('username', $this->input->post('username'));
      $this->db->where('id', $id_admin);
      $this->db->update('admin');
      $this->session->set_flashdata('upload', "<script>
          swal({
          text: 'Username berhasil diubah',
          icon: 'success'
          });
          </script>");
      redirect(base_url() . 'administrator/edit');
    }

    public function edit_pass(){
      $username = $this->session->userdata('username');
      $data['usersAdmin'] = $this->db->get_where('admin', ['username' => $username])->row_array();
        $admin = $data['usersAdmin']['password'];
        $id_admin = $data['usersAdmin']['id'];
        if(password_verify($this->input->post('oldPassword'), $admin)){
            if($this->input->post('newPassword') ==  $this->input->post('confirmPassword')){
                $pass = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);
                $this->db->set('password', $pass);
                $this->db->where('id', $id_admin);
                $this->db->update('admin');
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Password berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/edit');
            }else{
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Konfirmasi password tidak sama. Silakan coba lagi',
                    icon: 'error'
                    });
                    </script>");
                redirect(base_url() . 'administrator/edit');
            }
        }else{
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Password lama salah. Silakan coba lagi',
                icon: 'error'
                });
                </script>");
            redirect(base_url() . 'administrator/edit');
        }
    }

    public function logout(){
      $sess = ['admin'];
		  $this->session->unset_userdata($sess);
        delete_cookie('djehbicd');
        redirect(base_url() . 'login/admin');
    }

}
