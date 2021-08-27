<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Tambah Items Data &mdash; myPOS</title>
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
                <h1 class="card-title">Generated Barcode</h1>
            </div>
            <div class="card-body">
                <?php
                // This will output the barcode as HTML output to display in the browser
                $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                echo $generator->getBarcode($item['barcode'], $generator::TYPE_CODE_128);
                ?>
                <br>
                <?= $item['barcode']; ?>
                <br><br>
                <a href="<?= site_url('item/print_barcode/'. $item['item_id']) ?>" target="_blank" class="btn btn-default btn-outline-primary btn-sm">
                    <i class="fa fa-print"></i>Print
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>