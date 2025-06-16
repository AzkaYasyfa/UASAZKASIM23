<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Register</h1>
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
                <h2 class="card-title">Form Pendaftaran</h2>

                <?php if ($this->session->flashdata('success')): ?>
                    <p style="color:green;"><?= $this->session->flashdata('success'); ?></p>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <p style="color:red;"><?= $this->session->flashdata('error'); ?></p>
                <?php endif; ?>

                <?= validation_errors('<p style="color:red;">', '</p>'); ?>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <form action="<?= base_url('auth/process_register'); ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="sales">Sales</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

            <div class="card-footer">
            </div>
        </div>
    </section>
</div>