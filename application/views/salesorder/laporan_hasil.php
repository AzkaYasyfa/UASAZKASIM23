<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Laporan Sales Order</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Laporan Sales Order</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Hasil Laporan</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <h3>Laporan Sales Order dari <?= $tanggal_dari ?> sampai <?= $tanggal_sampai ?></h3>
        <table id="datatable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode SO</th>
              <th>Tanggal</th>
              <th>Pelanggan</th>
              <th>Sales</th>
              <th>Status</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($salesorder as $so): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $so->kode_so ?></td>
                <td><?= $so->tanggal ?></td>
                <td><?= $so->nama_pelanggan ?></td>
                <td><?= $so->nama_sales ?></td>
                <td><?= $so->status ?></td>
                <td><?= number_format($so->total_harga, 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer">
      </div>
    </div>
  </section>
</div>