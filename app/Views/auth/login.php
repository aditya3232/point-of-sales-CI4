<?= $this->extend('auth/template_auth'); ?>

<!-- konten title -->
<?= $this->section('title') ?>
<title>Login &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten -->
<?= $this->section('content'); ?>
<div class="text-center mt-4">
    <h1 class="h2">Point of Sales</h1>
    <p class="lead">
        Sign in to your account to continue
    </p>
</div>

<div class="card">
    <div class="card-body">
        <div class="m-sm-4">
            <div class="text-center">
                <img src="/assets/dist/img/avatars/lol.jpg" class="img-fluid rounded-circle" width="132" height="132" />
            </div>
            <!-- flashData error ketika salah memasukkan email/password -->
            <?php if(session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">x</button>
                    <b>Error !</b>
                    <?=session()->getFlashdata('error') ?>
                </div>
            </div>
            <?php endif; ?>
            <form action="<?= site_url('auth/process'); ?>" method="POST">
                <!-- csrf_field -->
                <?= csrf_field()?>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control form-control-lg" type="text" name="username" placeholder="Username" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-lg btn-primary" name="login">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- akhir konten -->
<?= $this->endSection(); ?>