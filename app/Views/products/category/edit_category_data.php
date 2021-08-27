<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Edit Categories Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten edit category data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="briefcase"></i><span class="align-middle"><strong class="mr-2">Categories</strong>Kategori Barang</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('category'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Data Categories</h1>
            </div>
            <div class="card-body">
                <form action="<?=site_url('category/update/' . $category['category_id'])?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $category['category_id']; ?>">
                    <div class="mb-3">
                        <label class="form-label" for="name">Category Name</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <!-- bisa menggunakan $supplier karena halaman edit_supplier_data.php dikirimi $data ('supplier') oleh method edit -->
                        <!-- value (jika benar ada old, ganti pakai old, jika tidak, ganti pakai value)  (?) artinya true, (:) artinya false -->
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= (old('name')) ? old('name') : $category['name'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>