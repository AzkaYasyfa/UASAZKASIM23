<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Berita</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">


    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List Berita</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i> </button>
        </div>
      </div>
      <h3>Laporan Berita dari <?= $tanggal_dari ?> sampai <?= $tanggal_sampai ?></h3>
      <table id="datatable" border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Tanggal Publish</th>
          <th>Isi Berita</th>
          <th>Penulis</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($berita as $b): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $b->judul ?></td>
          <td><?= $b->tanggal_publish ?></td>
          <td><?= $b->isi_berita ?></td>
          <td><?= $b->pengirim ?></td>
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