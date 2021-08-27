<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Stock Out Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tampil customer data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="shopping-cart"></i><span class="align-middle"><strong class="mr-2">Stock Out</strong>Barang Keluar</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('stock/out/add') ?>" class="btn btn-success"><i class="align-middle mr-2" data-feather="plus"></i> Add Stock Out</a>
        </div>
    </div>
</div>

<!-- menampilkan session dengan key 'pesan' -->
<?php if(session()->getFlashdata('pesan')) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="alert-message">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
</div>
<?php endif; ?>

<!-- table -->
<div class="col-12 col-xl mt-3">
    <div class="card">
        <div class="card-header">
            <!-- form search/pencarian -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 text-left">
                        <h1 class="card-title">Data Stock Out</h1>
                    </div>
                    <div class="col-6 text-right">
                        <form class="d-none d-sm-inline-block" method="GET">
                            <div class="input-group input-group-navbar">
                                <input type="text" class="form-control" placeholder="Search…" aria-label="Search" name="keyword">
                                <button class="btn" type="submit" name="submit">
                                    <i class="align-middle" data-feather="search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- akhir form search/pencarian  -->
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Barcode</th>
                        <th>Product Item</th>
                        <th>Qty</th>
                        <th>Info</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                    <?php foreach($stockout as $stockouts): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $stockouts['barcode']; ?></td>
                        <td><?= $stockouts['name_item']; ?></td>
                        <td><?= $stockouts['qty']; ?></td>
                        <td><?= $stockouts['info']; ?></td>
                        <td><?= $stockouts['date']; ?></td>
                        <td class="table-action">
                            <!-- fitur delete dengan http method spoofing -->
                            <!-- menuju stockout/delete dengan mengirimkan parameter stockout_id yg dihapus, dan item_id yg ditambahkan stocknya  -->
                            <form action="<?= site_url('stockout/delete/' . $stockouts['stockout_id'] . '/' . $stockouts['item_id']); ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('apakah anda yakin?')"><i class="align-middle" data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endForeach; ?>
            </table>
            <br>
            <!-- pager  parameter1=nama tabel, parameter2=file pagination-->
            <?= $pager->links('stockout', 'my_pagination') ?>
        </div>

    </div>
</div>

<?= $this->endSection()?>