<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Tambah Categories Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah supplier data -->
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
                <h1 class="card-title">Tambah Data Categories</h1>
            </div>
            <div class="card-body">
                <form action="<?=site_url('category/save')?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="name">Categories Name</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name'); ?>">
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