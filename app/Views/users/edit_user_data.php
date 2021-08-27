<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Settings Users Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah supplier data -->
<?= $this->section('content') ?>

<!-- Judul Utama -->
<div class="card-header mb-3">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="user"></i><span class="align-middle"><strong class="mr-2">Users</strong>Pengguna</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('user'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>

<!-- TABLIST -->
<div class="row">
    <div class="col-md-3 col-xl-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><strong> Users Settings</strong> </h5>
            </div>

            <div class="list-group list-group-flush" role="tablist">
                <!-- ini adalah TABLIST ACCOUNT -->
                <!-- [jika benar ada eror di password, jgn aktifkan tablist account]. aktifkan ketika tidak ada eror di password -->
                <a class="list-group-item list-group-item-action <?= ($validation->hasError('password')) || ($validation->hasError('passwordConfirm')) ? '' : 'active';  ?>" data-toggle="list" href="#account" role="tab">
                    Account
                </a>
                <!-- ini adalah TABLIST PASSWORD -->
                <!-- [jika benar ada eror di password, aktifkan tablist password]. namun jika tidak ada eror di password, jgn diaktifkan -->
                <a class="list-group-item list-group-item-action <?= ($validation->hasError('password')) || ($validation->hasError('passwordConfirm')) ? 'active' : '';  ?> " data-toggle="list" href="#password" role="tab">
                    Password
                </a>
            </div>
        </div>
    </div>

    <!-- TABCONTENT -->
    <div class="col-md-9 col-xl-10">
        <div class="tab-content">

            <!-- setting accout -->
            <!-- [jika ada eror di password jgn show seting account]. show setting account ketika tidak ada eror password -->
            <div class="tab-pane fade <?= ($validation->hasError('password')) || ($validation->hasError('passwordConfirm')) ? '' : 'show active';  ?>" id="account" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Users Info</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?=site_url('user/update/' . $user['user_id'])?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <!-- input ini untuk keperluan redirect ke halaman edit dengan hasil validasi form, -->
                            <!-- agar redirectnya user/edit berisi data berdasarkan user_id -->
                            <input type="hidden" name="id" value="<?= $user['user_id']; ?>">
                            <!-- input yg menyimpan nama file gambar lama-->
                            <input type="hidden" name="imageLama" value="<?= $user['user_image']; ?>">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                                        <!-- value (jika benar ada old, ganti pakai old, jika tidak, ganti pakai value)  (?) artinya true, (:) artinya false -->
                                        <label class="form-label" for="inputUsername">Username</label>
                                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="inputUsername" name="username"
                                            value="<?= (old('username')) ? old('username') : $user['username'] ?>">
                                        <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputName">Name</label>
                                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="inputName" name="name" value="<?= (old('name')) ? old('name') : $user['name'] ?>">
                                        <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputAddress">Address</label>
                                        <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" rows="1" id="address"
                                            name="address"><?= (old('address')) ? old('address') : $user['address'] ?></textarea>
                                        <div class="invalid-feedback"><?= $validation->getError('address'); ?></div>
                                    </div>
                                    <label for="Pilih" class="form-label">Level</label>
                                    <select class="form-select <?= ($validation->hasError('level')) ? 'is-invalid' : ''; ?>" id="Pilih" name="level">
                                        <!-- disini ada informasi yg menampilkan level saat ini, yg sesuai dengan user_id -->
                                        <!-- jika tidak select level, maka otomatis select yg sebelumnya -->
                                        <option selected value="<?= $user['level']; ?>"> level saat ini adalah <?= $user['level'] == 1 ? '"Admin"' : '"Users"'; ?></option>
                                        <!-- jika benar old level = 1/2 maka pilih, jika tidak maka null -->
                                        <!-- tidak bisa pakai foreach, karena disini yg akan ditampilkan cuman value 1/2,-->
                                        <!-- bukan seluruh data level ditiap rownya -->
                                        <!-- disini ada kondisi jika level sebelumnya adalah admin, maka disediakan pilihan jadi user, dan kebalikannya -->
                                        <!-- ini kondisi sistem**: jika yg login adalah admin tidak bisa ganti ke user  -->
                                        <?php if ($user['level'] == 1): ?>
                                        <option value="2" <?= old('level') == '2' ? 'selected' : '' ?>>Ganti jadi "Users"</option>
                                        <?php elseif ($user['level'] == 2): ?>
                                        <option value="1" <?= old('level') == '1' ? 'selected' : '' ?>>Ganti jadi "Admin"</option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback"><?= $validation->getError('level'); ?></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <!-- gambar diambil dari database (berdasarkan id)-->
                                        <img src="/img/<?= $user['user_image'] ?>" class="rounded-circle img-preview" width="128" height="128" />
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

            <!-- setting password -->
            <!-- [jika ada eror di password tampilkan seting password]. namun ketika tidak ada eror password, jgn tampilkan setting password -->
            <div class="tab-pane fade <?= ($validation->hasError('password')) || ($validation->hasError('passwordConfirm')) ? 'show active' : '';  ?>" id="password" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Users Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?=site_url('user/updatePass/' . $user['user_id'])?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <!-- input ini untuk keperluan redirect ke halaman edit dengan hasil validasi form, -->
                            <!-- agar redirectnya user/edit berisi data berdasarkan user_id -->
                            <input type="hidden" name="id" value="<?= $user['user_id']; ?>">
                            <div class="mb-3">
                                <label class="form-label" for="inputPassword">New Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="inputPassword" name="password">
                                <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirm">Verify Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('passwordConfirm')) ? 'is-invalid' : ''; ?>" id="confirm" name="passwordConfirm">
                                <div class="invalid-feedback"><?= $validation->getError('passwordConfirm'); ?></div>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save changes</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>