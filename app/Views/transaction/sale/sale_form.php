<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- konten title -->
<?= $this->section('title') ?>
<title>Sales &mdash; myPOS</title>
<?= $this->endSection()?>


<!-- konten dashboard -->
<?= $this->section('content') ?>

<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl text-left">
            <i class="align-middle mr-2" data-feather="shopping-cart"></i><span class="align-middle"><strong class="mr-2">Sales</strong>Penjualan</span>
        </div>
    </div>
</div>

<!-- row 1 -->
<div class="row mt-3">
    <div class="col-lg-4">
        <!-- row 1 col 1 -->
        <div class="card">
            <div class="card-body">
                <form action="">

                </form>
                <table width="100%">
                    <tr>
                        <td style="vertical-align:top">
                            <label for="date">Date</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="date" id="date" name="date" value="<?= date('Y-m-d'); ?>" class="form-control">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; width:30%">
                            <label for="user">Kasir</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <!-- nama user yg login -->
                                <input type="text" id="user" value="<?= session()->get('name'); ?>" class="form-control" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <label for="customer">Customer</label>
                        </td>
                        <td>
                            <div>
                                <select id="customer" class="form-select">
                                    <!-- berikan select to, biar kalau data customernya banyak bisa disearch langsung di combobox ny -->
                                    <!-- <option value="0">Umum</option> -->
                                    <option selected value="13">Umum</option>
                                    <?php foreach($customer as $customers): ?>
                                    <option value="<?= $customers['customer_id']; ?>"><?= $customers['name']; ?></option>
                                    <?php endForeach; ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- row 1 col 2 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <!-- ketika diklik button=add, akan menuju controller sale/add_cart, yg akan inset 'item_id' ke tabel cart-->
                <!-- button type='submit' untuk button=add, agar dapat menjalankan fungsi form -->
                <!-- jgn lupa pakai csrf_field karena sudah diaktifkan -->
                <?= form_open('sale/add_cart', ['class' => 'menambahcart']); ?>
                <?= csrf_field(); ?>
                <table width="100%">
                    <tr>
                        <td style="vertical-align:top; width:30%">
                            <label for="barcode">Barcode</label>
                        </td>
                        <td>
                            <div class="form-group input-group">
                                <input type="hidden" id="item_id" name="item_id">
                                <input type="hidden" id="price" name="price">
                                <input type="hidden" id="stock">
                                <input type="hidden" id="invoice" name="invoice" value="<?= $invoice; ?>">
                                <input type="text" id="barcode" class="form-control" name="barcode" autofocus readonly>
                                <span class="input-group-btn">
                                    <!-- disini type='button' agar tidak mengganggu fungsi form -->
                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <label for="cart_qty">Qty</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" id="cart_qty" class="form-control" value="1" min="1" name="cart_qty">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div>
                                <button type="submit" class="btn btn-primary" id="button_add">
                                    <i class="align-middle mr-2" data-feather="shopping-cart"></i> Add
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- row 1 col 3 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div align="right">
                    <h4>Invoice <b><span id="invoice"><?= $invoice; ?></span></h4>
                    <h1>
                        <b>
                            <span id="grand_total2" style="font-size:50pt">0</span>
                        </b>
                    </h1>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- row 2 (data_cart) -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="table_cart">
                    <thead>
                        <tr class="hehe">
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Product Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th width="10%">Discount Item/pcs</th>
                            <th width="15%">Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cart_table">
                        <!-- tr td akan keluar jika ada request ajax -->
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- row 3 -->
<div class="row">
    <!-- row 3 col 1 -->
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <table width="100%" class="row3col1">
                    <tr>
                        <td style="vertical-align:top; width:30%">
                            <label for="sub_total">Sub Total</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <!-- jika ada request ajax maka akan set value #sub_total -->
                                <input type="number" id="sub_total" class="form-control" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <label for="discount">Discount</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" id="discount" value="0" min="0" class="form-control">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <label for="grand_total">Grand Total</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" id="grand_total" class="form-control" readonly>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- row 3 col 2 -->
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <table width="100%" class="transaksi">
                    <tr>
                        <td style="vertical-align:top; width:30%">
                            <label for="cash">Cash</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" id="cash" value="0" min="0" class="form-control">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <label for="change">Change</label>
                        </td>
                        <td>
                            <div>
                                <input type="number" id="change" value="0" min="0" class="form-control" readonly>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- row 3 col 3 -->
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td style="vertical-align:top">
                            <label for="note">Note</label>
                        </td>
                        <td>
                            <div>
                                <textarea id="note" rows="3" class="form-control"></textarea>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- row 3 col 4 -->
    <div class="col-lg-3">
        <div>
            <!-- untuk menyimpan inputan yg tidak dibungkus form, (kasus disini karena inputannya random temapatnya), -->
            <!-- maka gunakan jquery ajax saja -->
            <!-- untuk memasukkan data input ke jqajax gunakan fungsi klik yg akan set variabel dengan value inputan, -->
            <!-- nanti variabelnya tinggal dimasukkan (data:) yg ada di jqajax -->
            <button id="process_payment" class="btn btn-flat btn-lg btn-success">
                <i class="fas fa-paper-plane align-middle mr-2"></i> Process Payment
            </button>
        </div>
    </div>

</div>

<!-- modal -->
<div class="modal fade" id="modal-item" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3 table-responsive">
                <!-- tabel -->
                <table class="table table-striped" id="data-item">
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
                                <!-- button yg akan mengambil data item_id & barcode, akan disimpan ke tabel row 2  -->
                                <button class="btn btn-xs btn-info" id="select-item" data-id="<?= $items['item_id']; ?>" data-barcode="<?= $items['barcode']; ?>" data-price="<?= $items['price']; ?>">
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
<!-- akhir modal -->

<!-- modal edit -->
<div class="viewmodal" style="display: none;"></div>
<!-- akhir modal edit -->

<script>
// request ajax, jika berhasil akan menampilkan cart_table.
function data_cart() {
    $.ajax({
        url: "<?= site_url('sale/data_cart'); ?>",
        dataType: "json",
        success: function(response) {
            $('#cart_table').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

// fungsi untuk mencetak nota 
function print_nota_afterpayment() {
    $.ajax({
        type: "post",
        url: "<?= site_url('reportsale/print_nota'); ?>", //daftarkan url di pengecualian csrf token
        data: {
            invoice: $("#invoice").val(),
            customer_name: $("#customer option:selected").text(), //select langsung namnya saja, g perlu valuenya
            date: $("#date").val(),
            user_realname: $("#user").val(),
            total_price: $("#sub_total").val(),
            cash: $("#cash").val(),
            discount: $("#discount").val(),
            remaining: $("#change").val(),
            final_price: $("#grand_total").val(),
            note: $("#note").val(),
        },
        dataType: "json",
    });
}

// menghitung Kembalian kembalian/change = cash - grand_total  
function kembalian() {
    $(".transaksi").on('input', '#cash', function() {
        var cash = $(this).val(); //mendapatkan value cash, masukkan ke variable agar dapat diambil datanya oleh jqajax
        var grand_total = $('#grand_total').val(); //mendapatkan value grand_total
        $('#change').val(cash - grand_total);
    });
}


// fungsi menambah cart
function menambahcart() {
    // menjalankan fungsi submit form=.menambahcart di row 1 col 2
    $('.menambahcart').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    // ketika response sukses akan menampilkan alert sukses
                    alert(response.sukses);
                    // kemudian menjalankan ulang fungsi data_cart()
                    data_cart();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    });
}

function resetafterpayment() {
    $.ajax({
        url: "<?= site_url('sale/resetafterpayment'); ?>",
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                data_cart(); //menampilkan data cart yang sudah kosong
                window.location.reload(); //reload halaman ini(sale)
                print_nota_afterpayment();

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

// fungsi process payment
function processpayment() {
    // ketika diklik id="process_payment" akan menset variabel dengan data inputan di halaman ini
    // nanti variabel disini akan berisi data inputan yg akan dimasukkan di request jqajax
    // fungsi processpayment akan dituliskan diatas document ready function
    $("#process_payment").click(function(e) {
        e.preventDefault(); //berfungsi menghilangkan event bawaan dari DOM / dari html asli
        // pakai val jika <input>
        // pakai text/html jika <span>
        // $("#customer option:selected").text(), pakai text() untuk teksnya, pakai value() untuk valuenya
        $.ajax({
            type: "post",
            url: "<?= site_url('sale/processpayment'); ?>",
            data: {
                invoice: $("#invoice").val(),
                customer_name: $("#customer option:selected").text(), //select langsung namnya saja, g perlu valuenya
                // item_id: $("#item_id").val(),
                total_price: $("#sub_total").val(),
                discount: $("#discount").val(),
                final_price: $("#grand_total").val(),
                cash: $("#cash").val(),
                remaining: $("#change").val(),
                note: $("#note").val(),
                date: $("#date").val(),
                user_realname: $("#user").val(),

            },
            dataType: "json",
            success: function(response) {
                // ketika response sukses akan menampilkan alert sukses
                alert(response.sukses);
                // ketika response sukses akan mereset halaman
                resetafterpayment();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });


    });



}






$(document).ready(function() {
    // datatable client side
    $('#data-item').DataTable();

    // menjalankan fungsi data_cart() langsung
    data_cart();

    // menjalankan fungsi kembalian()
    kembalian();

    // menjalankan fungsi menambahcart()
    menambahcart();

    // menjalankan fungsi processpayment()
    processpayment();



    // menjalankan fungsi ketika diklik #select-item, akan menset input=#item_id dengan nilai data-id=phpp $items['item_id].
    // nilai 'item_id' akan diinsertkan kedalam tabel cart dengan fitur form submit.
    // sehingga nantinya 'barcode','name_item','price' dapat diselect untuk ditampilkan di cart_table
    // disini nilai 'barcode' jg akan diinsertkan ke input seacrh barcode
    $(document).on('click', '#select-item', function() {
        var item_id = $(this).data('id');
        var barcode = $(this).data('barcode');
        var price = $(this).data('price');
        $('#item_id').val(item_id);
        $('#barcode').val(barcode);
        $('#price').val(price);
        $('#modal-item').modal('hide');

    });









});
</script>


<?= $this->endSection()?>