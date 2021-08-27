<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Report Sales &mdash; myPOS</title>
<?= $this->endSection()?>


<!-- konten tampil category data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="briefcase"></i><span class="align-middle"><strong class="mr-2">Report Sales</strong>Laporan Penjualan</span>
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
            <h1 class="card-title">Data Laporan Penjualan</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Grand Total</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($report_sale as $report_sales): ?>
                    <tr>
                        <td><?= $i++; ?></td> <!-- looping $i (nomor baris) -->
                        <td><?= $report_sales['invoice']; ?></td>
                        <td><?= $report_sales['date']; ?></td>
                        <td><?= $report_sales['customer_name']; ?></td>
                        <td><?= $report_sales['total_price']; ?></td>
                        <td><?= $report_sales['discount']; ?></td>
                        <td><?= $report_sales['final_price']; ?></td>


                        <td class="table-action">
                            <!-- onklik akan mengirimkan data dari tabel sale ke controller -->
                            <!-- hilangkan data-toggle="modal" data-target="" ketika menggunakan modal dengan style bootstrap dan prosesnya jqajax -->
                            <button class="btn btn-outline-warning btn-sm" id="detail_report_sale"
                                onclick="detail('<?= $report_sales['invoice']; ?>', '<?= $report_sales['customer_name']; ?>', '<?= $report_sales['date']; ?>', '<?= $report_sales['user_realname']; ?>', '<?= $report_sales['total_price']; ?>', '<?= $report_sales['cash']; ?>', '<?= $report_sales['discount']; ?>', '<?= $report_sales['remaining']; ?>', '<?= $report_sales['final_price']; ?>', '<?= $report_sales['note']; ?>')"><i
                                    class="align-middle" data-feather="eye"></i></button>

                            <button class="btn btn-default btn-outline-primary btn-sm"
                                onclick="print('<?= $report_sales['invoice']; ?>', '<?= $report_sales['customer_name']; ?>', '<?= $report_sales['date']; ?>', '<?= $report_sales['user_realname']; ?>', '<?= $report_sales['total_price']; ?>', '<?= $report_sales['cash']; ?>', '<?= $report_sales['discount']; ?>', '<?= $report_sales['remaining']; ?>', '<?= $report_sales['final_price']; ?>', '<?= $report_sales['note']; ?>')"><i
                                    class="fa fa-print"></i>Print</button>
                            <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('apakah anda yakin?')"><i class="align-middle" data-feather="trash"></i></button>

                        </td>
                    </tr>
                    <?php endForeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<!-- Modal detail -->
<div class="viewmodal" style="display: none;"></div>
<!-- end modal detail -->

<!-- fungsi set modal -->
<script>
// fungsi detail
function detail(invoice, customer_name, date, user_realname, total_price, cash, discount, remaining, final_price, note) {
    $.ajax({
        type: "post",
        url: "<?= site_url('reportsale/modaldetail'); ?>", //daftarkan url di pengecualian csrf token
        data: {
            invoice: invoice,
            customer_name: customer_name,
            date: date,
            user_realname: user_realname,
            total_price: total_price,
            cash: cash,
            discount: discount,
            remaining: remaining,
            final_price: final_price,
            note: note,
        },
        dataType: "json",
        success: function(response) {
            $('.viewmodal').html(response.sukses).show(); //memanggil div class="viewmodal di view(report_sales)" (bayangan ketika muncul modal)
            $('#modal_detail').modal('show'); //kemudian menampilkan modal dengan id="modal_detail" (modal adalah sebuah view terpisah)
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}


// fungsi print_nota
function print(invoice, customer_name, date, user_realname, total_price, cash, discount, remaining, final_price, note) {
    $.ajax({
        type: "post",
        url: "<?= site_url('reportsale/print_nota'); ?>", //daftarkan url di pengecualian csrf token
        data: {
            invoice: invoice,
            customer_name: customer_name,
            date: date,
            user_realname: user_realname,
            total_price: total_price,
            cash: cash,
            discount: discount,
            remaining: remaining,
            final_price: final_price,
            note: note,
        },
        dataType: "json",

    });
}
</script>
<?= $this->endSection()?>