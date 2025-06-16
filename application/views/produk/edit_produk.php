<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Produk</h3>
            </div>

            <div class="card-body">
                <form action="<?= base_url('produk/update/'.$produk['idproduk']); ?>" method="POST">
                    <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk" id="kode_produk"
                            value="<?= $produk['kode_produk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk"
                            value="<?= $produk['nama_produk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga"
                            value="<?= $produk['harga']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok"
                            value="<?= $produk['stok']; ?>" required>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('produk'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>

            <div class="card-footer">
            </div>
        </div>
    </section>
</div>