<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Create Users Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah supplier data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="user"></i><span class="align-middle"><strong class="mr-2">Users</strong>Pengguna</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('user'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Add Users</h1>
            </div>
            <div class="card-body">
                <!-- form tambah data, tambahkan enctype supaya form bisa bekerja dengan inputan file -->
                <form action="<?=site_url('user/save')?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label" for="inputUsername">Username</label>
                                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="inputUsername" name="username" placeholder="Username" value="<?= old('username'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputName">Name</label>
                                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="inputName" name="name" placeholder="Name" value="<?= old('name'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputPassword">Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="inputPassword" name="password" placeholder="Password" value="<?= old('password'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirm">Verify Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('passwordConfirm')) ? 'is-invalid' : ''; ?>" id="confirm" name="passwordConfirm" placeholder="Verify your password"
                                    value="<?= old('passwordConfirm'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('passwordConfirm'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputAddress">Address</label>
                                <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" rows="1" id="address" name="address" placeholder="Write your address here"><?= old('address'); ?></textarea>
                                <div class="invalid-feedback"><?= $validation->getError('address'); ?></div>
                            </div>
                            <label for="Pilih" class="form-label">Level</label>
                            <select class="form-select <?= ($validation->hasError('level')) ? 'is-invalid' : ''; ?>" id="Pilih" name="level">
                                <option selected disabled value="">Pilih...</option>
                                <!-- jika benar old level = 1/2 maka pilih, jika tidak maka null -->
                                <!-- tidak bisa pakai foreach, karena disini yg akan ditampilkan cuman value 1/2,-->
                                <!-- bukan seluruh data level ditiap rownya -->
                                <option value="1" <?= old('level') == '1' ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= old('level') == '2' ? 'selected' : '' ?>>Users</option>

                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('level'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <img src="/img/default.png" class="rounded-circle img-preview mt-3" width="128" height="128" />
                                <div class="mt-2">
                                    <!-- ini adalah tombol upload yg ketika diklik akan mengeluarkan input file -->
                                    <!-- disini tidak pakai button, tapi pakai span agar tidak terdeteksi oleh form action -->
                                    <span id="button_upload" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
                                    <input type="file" class="form-control <?= ($validation->hasError('user_image')) ? 'is-invalid' : ''; ?>" id="image" name="user_image" onchange="previewImg()" hidden>
                                    <div class="invalid-feedback"><?= $validation->getError('user_image'); ?></div>
                                </div>
                                <small>Agar tidak gagal upload, masukkan foto profil dengan ukuran tidak lebih dari 1MB didalam format jpg/jpeg/png.</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save changes</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>