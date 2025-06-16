<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 id="page-title">Tambah Sales Order</h1>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Form Tambah Sales Order</h3></div>
            <div class="card-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                <form action="<?= base_url('salesorder/insert') ?>" method="POST" id="formSalesOrder">
                    <div class="form-group">
                        <label for="kode_so">Kode Order</label>
                        <input type="text" class="form-control" name="kode_so" id="kode_so" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" required value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="idpelanggan">Pelanggan</label>
                        <select name="idpelanggan" id="idpelanggan" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach($pelanggan as $p): ?>
                                <option value="<?= $p['idpelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idsales">Sales</label>
                        <select name="idsales" id="idsales" class="form-control" required>
                            <option value="">-- Pilih Sales --</option>
                            <?php foreach($sales as $s): ?>
                                <option value="<?= $s['idsales'] ?>"><?= htmlspecialchars($s['nama_sales']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr>

                    <h5>Detail Produk</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>
                                        <button type="button" id="addRow" class="btn btn-sm btn-success">Tambah</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="produk[]" class="form-control produk-select" required>
                                            <option value="">-- Pilih Produk --</option>
                                            <?php foreach($produk as $pr): ?>
                                                <option value="<?= $pr['idproduk'] ?>" data-harga="<?= $pr['harga'] ?>">
                                                    <?= htmlspecialchars($pr['nama_produk']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="harga">0</td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1" required>
                                    </td>
                                    <td class="subtotal">0</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger removeRow">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                <label>Total Harga: </label>
                <span id="totalHarga">0</span>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function hitungSubtotal(row) {
        const harga = Number(row.querySelector('.produk-select').selectedOptions[0]?.dataset.harga || 0);
        const jumlah = Number(row.querySelector('.jumlah').value) || 0;
        const subtotal = harga * jumlah;
        row.querySelector('.harga').textContent = harga.toLocaleString('id-ID');
        row.querySelector('.subtotal').textContent = subtotal.toLocaleString('id-ID');
        return subtotal;
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('#produkTable tbody tr').forEach(row => {
            total += hitungSubtotal(row);
        });
        document.getElementById('totalHarga').textContent = total.toLocaleString('id-ID');
    }

    // Hitung saat produk dipilih atau jumlah diubah
    document.querySelector('#produkTable').addEventListener('change', function(e) {
        if (e.target.classList.contains('produk-select') || e.target.classList.contains('jumlah')) {
            hitungTotal();
        }
    });

    document.querySelector('#produkTable').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah')) {
            hitungTotal();
        }
    });

    // Tambah baris
    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.querySelector('#produkTable tbody');
        const newRow = tbody.rows[0].cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(el => {
            if(el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else if(el.tagName === 'INPUT') {
                el.value = '1';
            }
        });
        newRow.querySelector('.harga').textContent = '0';
        newRow.querySelector('.subtotal').textContent = '0';
        tbody.appendChild(newRow);
        hitungTotal();
    });

    // Hapus baris
    document.querySelector('#produkTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            const tbody = document.querySelector('#produkTable tbody');
            if (tbody.rows.length > 1) {
                e.target.closest('tr').remove();
                hitungTotal();
            } else {
                alert('Minimal harus ada satu produk.');
            }
        }
    });

    hitungTotal(); 
});
</script>