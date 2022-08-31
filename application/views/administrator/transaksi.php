<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Data Transaksi Pembelian</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="<?= base_url(); ?>administrator/transaksi/add"
				class="btn btn-primary btn-sm"
				>Tambah Transaksi</a
			>
			<?php if ($usersAdmin['id'] == 1) : ?>
				<form action="<?=base_url();?>administrator/cetak_transaksi" method="post" class="form-inline float-right">
					Laporan :
					<input class="form-control form-control-sm mr-sm-2 ml-sm-2" type="date" placeholder="Tanggal Awal" aria-label="tanggal_awal" name="tanggal_awal" autocomplete="off"> s/d
					<input class="form-control form-control-sm mr-sm-2 ml-sm-2" type="date" placeholder="Tanggal Akhir" aria-label="tanggal_akhir" name="tanggal_akhir" autocomplete="off">
					<button class="btn btn-sm btn-outline-primary my-2 my-sm-0" type="submit">Cetak</button>
				</form>
			<?php endif; ?>
			
		</div>
		
		<div class="card-body">
				<?php echo $this->session->flashdata('failed'); ?>
				<?php if($getTransaksi->num_rows() > 0){ ?>

				<div class="table-responsive">
					<table
						class="table table-bordered"
						id="dataTable"
						width="100%"
						cellspacing="0"
					>
						<thead>
							<tr>
								<th>#</th>
								<th>No. Nota</th>
								<th>Tanggal</th>
								<th>Total Harga</th>
								<th>Status</th>
								<th style="width: 130px">Aksi</th>
							</tr>
						</thead>
						<tfoot>
						</tfoot>
						<tbody class="data-content">
							<?php $no = $this->uri->segment(3) + 1; ?>
							<?php foreach($getTransaksi->result_array() as $data): ?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $data['id_nota']; ?></td>
								<td><?= $data['date']; ?></td>
								<td>Rp. <?= str_replace(",",".",number_format($data['price'])); ?></td>
								<td><?= $data['status']; ?></td>
								<td>
									<a href="<?= base_url() ;?>administrator/detail_transaksi/<?= $data['id_nota']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
							<?php $no++ ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					
				</div>

				<?php }else{ ?>

				<div class="alert alert-warning" role="alert">
					Maaf, transaksi pembelian masih kosong.
				</div>
				
				<?php } ?>
		</div>








	</div>
</div>
<!-- /.container-fluid -->
