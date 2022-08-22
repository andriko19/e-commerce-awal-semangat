<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Users Admin</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="<?= base_url(); ?>administrator/users_admin/add"
				class="btn btn-primary"
				>Tambah</a
			>
		</div>
		<div class="card-body">
      <?php echo $this->session->flashdata('failed'); ?> 
      <?php if($users_admin->num_rows() > 0){ ?>
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
							<th>Username</th>
              <th>Role</th>
              <th>Aksi</th>
						</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
            <?php $no = 1 ?>
						<?php foreach($users_admin->result_array() as $data): ?>
						<tr>
                <td><?= $no ?></td>
                <td><?= $data['username']; ?></td>
                <td><?= $data['role']; ?></td>
                <td style="width: 100px">
                  <?php if ($data['role'] == "admin") : ?>
                    
                  <?php else : ?>
                    <a href="<?= base_url() ;?>administrator/delete_users_admin/<?= $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus data?');" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                  <?php endif ?>    
                </td>
            </tr>
            <?php $no++ ?>
            <?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php }else{ ?>
			<div class="alert alert-warning" role="alert">
				Opss, users admin masih kosong, yuk tambah sekarang.
			</div>
            <?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->