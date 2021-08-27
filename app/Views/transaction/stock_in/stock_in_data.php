<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Stock In Data &mdash; myPOS</title>
<?= $this->endSection()?>

<!-- konten tampil customer data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="shopping-cart"></i><span class="align-middle"><strong class="mr-2">Stock In</strong>Barang Masuk / Pembelian</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('stock/in/add') ?>" class="btn btn-success"><i class="align-middle mr-2" data-feather="plus"></i> Add Stock In</a>
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
                        <h1 class="card-title">Data Stock In</h1>
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
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                    <?php foreach($stock as $stocks): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $stocks['barcode']; ?></td>
                        <td><?= $stocks['name_item']; ?></td>
                        <td><?= $stocks['qty']; ?></td>
                        <td><?= $stocks['date']; ?></td>
                        <td class="table-action">

                            <button class="btn btn-outline-info btn-sm" id="detail_stock_in" data-toggle="modal" data-target="#modal-detail" data-barcode="<?= $stocks['barcode']; ?>" data-itemname="<?= $stocks['name_item']; ?>"
                                data-suppliername="<?= $stocks['name_supplier']; ?>" data-qty="<?= $stocks['qty']; ?>" data-date="<?= $stocks['date']; ?>" data-detail="<?= $stocks['detail']; ?>"><i class="align-middle"
                                    data-feather="eye"></i></button>

                            <!-- fitur delete dengan http method spoofing -->
                            <!-- menuju controller Supplier dengan mengirimkan supplier_id berdasarkan database -->
                            <form action="<?= site_url('stockin/delete/' . $stocks['stock_id'] . '/' . $stocks['item_id']); ?>" method="POST" class="d-inline">
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
            <?= $pager->links('stock', 'my_pagination') ?>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock In Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3 table-responsive">
                <!-- table -->
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Barcode</th>
                            <td><span id="barcode"></span></td>
                        </tr>
                        <tr>
                            <th>Item Name</th>
                            <td><span id="item_name"></span></td>
                        </tr>
                        <tr>
                            <th>Detail</th>
                            <td><span id="detail"></span></td>
                        </tr>
                        <tr>
                            <th>Supplier Name</th>
                            <td><span id="supplier_name"></span></td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td><span id="qty"></span></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><span id="date"></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- akhir table -->
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<?= $this->endSection()?>