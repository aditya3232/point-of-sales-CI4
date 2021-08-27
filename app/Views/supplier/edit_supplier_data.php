<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Edit Supplier Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah supplier data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="truck"></i><span class="align-middle"><strong class="mr-2">Supplier</strong>Pemasok Barang</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('supplier'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Data Supplier</h1>
            </div>
            <div class="card-body">
                <form action="<?=site_url('supplier/update/' . $supplier['supplier_id'])?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="slug" value="<?= $supplier['slug']; ?>">
                    <div class="mb-3">
                        <label class="form-label" for="name">Supplier Name</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <!-- bisa menggunakan $supplier karena halaman edit_supplier_data.php dikirimi $data ('supplier') oleh method edit -->
                        <!-- value (jika benar ada old, ganti pakai old, jika tidak, ganti pakai value)  (?) artinya true, (:) artinya false -->
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= (old('name')) ? old('name') : $supplier['name'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                    </div>
                    <div class=" mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?= (old('phone')) ? old('phone') : $supplier['phone'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('phone'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" rows="1" id="address" name="address"><?= (old('address')) ? old('address') : $supplier['address'] ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('address'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" rows="1" id="description" name="description"><?= (old('description')) ? old('description') : $supplier['description'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>