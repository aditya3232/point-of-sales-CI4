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
            <a href="<?= site_url('stock/in'); ?>" class="btn btn-warning"><i class="align-middle mr-2" data-feather="arrow-left"></i>Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Tambah Stock In</h1>
            </div>
            <div class="card-body">
                <form action="<?=site_url('stockin/save')?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="date">Date</label>
                        <!-- terdapat kondisi mengeluarkan is-invalid jika ada error -->
                        <!-- terdapat function old() yang menyimpan data inputan sebelumnya-->
                        <input type="date" class="form-control" id="date" name="date" value="<?= old('date'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="barcode">Barcode</label>
                        <div class="input-group">
                            <!-- tag inputan [item_id],barcode,item_name,unit_name,stock akan terisi ketika proses select yg ada dimodal-->
                            <!-- bisa terisi karena ada script jquery yg dijalankan, yg berada di view template (#select) -->
                            <!-- input [hidden item_id] akan menerima data dari modal (dari data-id) ketika diselect, -->
                            <!-- kemudian seluruh inputan di dalam form ini akan disave di tabel stock  -->
                            <!-- untuk qty dan item_id akan dimasukkan ke tabel item, [agar qty-nya keupdate ditabel item] -->
                            <input type="hidden" name="item_id" id="item_id">
                            <input type="text" name="barcode" id="barcode" class="form-control" required autofocus>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="item_name">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" readonly>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label" for="unit_name">Item Unit</label>
                            <input type="text" class="form-control" id="unit_name" name="unit_name" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="stock">Initial Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" value="-" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="detail">Detail</label>
                        <input type="text" class="form-control" id="detail" name="detail" placeholder="tambahan / kulakan / etc" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="supplier">Supplier</label>
                        <select name="supplier" id="supplier" class="form-control">
                            <option selected disabled value="">Pilih...</option>
                            <?php foreach($supplier as $suppliers): ?>
                            <option value="<?= $suppliers['supplier_id']; ?>"><?= $suppliers['name']; ?></option>
                            <?php endForeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>

                    <button type="submit" class="btn btn-success" name="in_add"><i class="fas fa-paper-plane"></i>Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- Modal -->
<div class="modal fade" id="modal-item" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Data Product Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3 table-responsive">
                <!-- tabel -->
                <!-- id="table_for_modal" == akan mengarahkan ke script datatables -->
                <table class="table table-striped" id="table_datatables">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($item as $items): ?>
                        <tr>
                            <td><?= $items['barcode']; ?></td>
                            <td><?= $items['name_item']; ?></td>
                            <td><?= $items['unit_name']; ?></td>
                            <td class="text-right"><?php $number=$items['price']; echo "Rp " . number_format($number,0,',','.'); ?></td>
                            <td class="text-right"><?= $items['stock']; ?></td>
                            <td class="text-right">
                                <!-- button yg akan mengambil data item_id,barcode,name_item,unit_name,stock. kemudian disimpan di form -->
                                <button class="btn btn-xs btn-info" id="select" data-id="<?= $items['item_id']; ?>" data-barcode="<?= $items['barcode']; ?>" data-name="<?= $items['name_item']; ?>" data-unit="<?= $items['unit_name']; ?>"
                                    data-stock="<?= $items['stock']; ?>">
                                    <i class="fa fa-check">Select</i>
                                </button>
                            </td>
                        </tr>
                        <?php endForeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<?= $this->endSection()?>