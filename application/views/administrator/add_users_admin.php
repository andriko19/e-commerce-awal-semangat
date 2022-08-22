<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800 mb-4">Tambah Users Admin</h1>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a
				href="<?= base_url(); ?>administrator/users_admin"
				class="btn btn-danger"
				><i class="fa fa-times-circle"></i> Batal</a
			>
		</div>
		<div class="card-body">
			<?php echo $this->session->flashdata('failed'); ?>
			<form
				action="<?= base_url(); ?>administrator/users_admin/add"
				method="post"
				enctype="multipart/form-data"
			>
				<div class="form-group">
					<label for="nama">Nama User</label>
					<input
						type="text"
						class="form-control"
						id="nama"
						name="nama"
						required
						autocomplete="off"
            value="<?= set_value('nama');?>"
            <?= form_error('nama', '<small class="text-danger">', '</small>')?>
					/>
				</div>

        <div class="form-group">
					<label for="username">Username</label>
					<input
						type="text"
						class="form-control"
						id="username"
						name="username"
						required
						autocomplete="off"
            value="<?= set_value('username');?>"
          />
          <?= form_error('username', '<small class="text-danger">', '</small>');?>
				</div>

        <div class="row">
          <div class="form-group col-6">
            <label for="password1">Password</label>
            <input
              type="password"
              class="form-control"
              id="password1"
              name="password1"
              required
              autocomplete="off"
            />
            <?= form_error('password1', '<small class="text-danger">', '</small>');?>
          </div>
          <div class="form-group col-6">
            <label for="password2">Password Configuration</label>
            <input
              type="password"
              class="form-control"
              id="password2"
              name="password2"
              required
              autocomplete="off"
            />
          </div>
        </div>
				
				<button type="submit" class="btn btn-primary">Tambah Users Kasir</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
