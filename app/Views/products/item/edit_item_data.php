<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Edit Items Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tambah supplier data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="briefcase"></i><span class="align-middle"><strong class="mr-2">Items</strong>Data Barang</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('item'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Data Items</h1>
            </div>
            <div class="card-body">
                <!-- form tambah data, tambahkan enctype supaya form bisa bekerja dengan inputan file -->
                <form action="<?=site_url('item/update/' . $item['item_id'])?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $item['item_id']; ?>">
                    <!-- input yg menyimpan nama file gambar lama-->
                    <input type="hidden" name="imageLama" value="<?= $item['image']; ?>">
                    <div class="mb-3">
                        <label class="form-label" for="barcode">Barcode</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <!-- value (jika benar ada old, ganti pakai old, jika tidak, ganti pakai value)  (?) artinya true, (:) artinya false -->
                        <input type="text" class="form-control <?= ($validation->hasError('barcode')) ? 'is-invalid' : ''; ?>" id="barcode" name="barcode" value="<?= (old('barcode')) ? old('barcode') : $item['barcode'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('barcode'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name_item">Product item</label>
                        <input type="text" class="form-control <?= ($validation->hasError('name_item')) ? 'is-invalid' : ''; ?>" id="name_item" name="name_item" value="<?= (old('name_item')) ? old('name_item') : $item['name_item'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('name_item'); ?></div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select <?= ($validation->hasError('category_id')) ? 'is-invalid' : ''; ?>" id="category_id" name="category_id">
                            <option selected disabled value="">Pilih...</option>
                            <!-- jika benar old gender = L/P maka pilih, jika tidak maka null -->
                            <?php foreach($category as $categorys): ?>
                            <option value="<?= $categorys['category_id']; ?>" <?= $categorys['category_id'] == $item['category_id'] ? 'selected' : '' ?>><?= $categorys['name']; ?></option>
                            <?php endForeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('category_id'); ?></div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="Unit" class="form-label">Unit</label>
                        <select class="form-select <?= ($validation->hasError('unit_id')) ? 'is-invalid' : ''; ?>" id="Unit" name="unit_id">
                            <option selected disabled value="">Pilih...</option>
                            <!-- jika benar old gender = L/P maka pilih, jika tidak maka null -->
                            <?php foreach($unit as $units): ?>
                            <option value="<?= $units['unit_id']; ?>" <?= $units['unit_id'] == $item['unit_id'] ? 'selected' : '' ?>><?= $units['name']; ?></option>
                            <?php endForeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('unit_id'); ?></div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="price">Price</label>
                        <input type="text" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : ''; ?>" id="price" name="price" value="<?= (old('price')) ? old('price') : $item['price'] ?>">
                        <div class="invalid-feedback"><?= $validation->getError('price'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="sampul" class="col-sm-2 col-form-label">Product Image</label>
                        <!-- preview gambar yg akan diupload -->
                        <div class="row">
                            <div class="col-sm-2 mt-3">
                                <!-- gambar diambil dari database (berdasarkan id), jika gambar bukan default.png ambil, jika iya jgn ambil-->
                                <img src="/img/<?= $item['image'] ?>" class="img-thumbnail img-preview">
                            </div>
                            <div class="col-sm-10">
                                <!-- file input bootstrap5 -->
                                <div class="input-group mt-3">
                                    <!-- onchange, ketika file berubah, jalankan script previewImg yg ada di template.php -->
                                    <input type="file" class="form-control <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" id="image" name="image" onchange="previewImg()">
                                    <div class="invalid-feedback"><?= $validation->getError('image'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>