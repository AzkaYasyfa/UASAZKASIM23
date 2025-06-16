<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Pelanggan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Edit Pelanggan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Pelanggan</h3>
            </div>

            <div class="card-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                <form action="<?= base_url('pelanggan/update/' . $pelanggan['idpelanggan']); ?>" method="POST">
                    <div class="form-group">
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama" id="nama" 
                            value="<?= $pelanggan['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" 
                            value="<?= $pelanggan['alamat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" 
                            value="<?= $pelanggan['no_telp']; ?>" required>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('pelanggan'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>

            <div class="card-footer">
            </div>
        </div>
    </section>
</div>