<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Edit Customer Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah customer data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="users"></i><span class="align-middle"><strong class="mr-2">Customers</strong>Pelanggan</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('customer'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Data Customer</h1>
            </div>
            <div class="card-body">
                <form action="<?=site_url('customer/update/' . $customer['customer_id'])?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="slug" value="<?= $customer['slug']; ?>">
                    <div class="mb-3">
                        <label class="form-label" for="name">Customer Name</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <!-- bisa menggunakan $customer karena halaman edit_customer_data.php dikirimi $data ('customer') oleh method edit -->
                        <!-- value (jika benar ada old, ganti pakai old, jika tidak, ganti pakai value)  (?) artinya true, (:) artinya false -->
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= (old('name')) ? old('name') : $customer['name'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="Pilih" class="form-label">Gender</label>
                        <select class="form-select <?= ($validation->hasError('gender')) ? 'is-invalid' : ''; ?>" id="Pilih" name="gender">
                            <option selected disabled value="">Pilih...</option>
                            <!-- jika benar gender(dari database) == L/P maka selected, jika tidak null -->
                            <option value="L" <?= $customer['gender'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= $customer['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('gender'); ?></div>
                    </div>
                    <div class=" mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?= (old('phone')) ? old('phone') : $customer['phone'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('phone'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" rows="1" id="address" name="address"><?= (old('address')) ? old('address') : $customer['address'] ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('address'); ?></div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>