<div class="modal fade" id="modal_edit" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Discount Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form open -->
            <!-- ketika menggunakan helper form, autload dulu di basecontroller -->
            <?= form_open('sale/updateProductitem', ['class' => 'formedit']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body form_edit_peritem">
                <!-- hidden cart_id agar dapat updateproductitem berdasarkan cart_id -->
                <!-- hidden item_id agar dapat update stock berdasarkan item_id -->
                <input type="hidden" class="form-control" id="cart_id" name="cart_id" value="<?= $cart_id; ?>">
                <input type="hidden" class="form-control" id="item_id" name="item_id" value="<?= $item_id; ?>">
                <div class="mb-3">
                    <label class="form-label" for="product_item">Product Item</label>
                    <input type="text" class="form-control mb-3" id="product_item" name="barcode" value="<?= $barcode; ?>" readonly>
                    <input type="text" class="form-control" id="product_item" name="name_item" value="<?= $name_item; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?= $price; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="qty">Qty</label>
                    <!-- disini value price akan dimasukkan ke data-price di input ini -->
                    <!-- alasannya karena value price itu dari phpp, jadi tidak dapat langsung diambil langsung valuenya-->
                    <input type="number" class="form-control" id="get_qty_peritem" name="qty" data-price="<?= $price; ?>" value="<?= $qty; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="discount_per_item">Discount Per-Item</label>
                    <input type="number" class="form-control" id="discount_per_item" name="discount_per_item" data-price="<?= $price; ?>" value="<?= $discount; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="total_per_item">Total</label>
                    <input type="number" class="form-control" id="total_per_item" name="total_per_item" value="<?= $total; ?>" readonly>
                </div>

            </div>
            <div class="modal-footer">
                <!-- jika pakai form type button jadi submit -->
                <button type="submit" class="btn btn-primary btnsimpan">
                    <i class="fas fa-paper-plane align-middle mr-2"></i>Save
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
// fungsi kalkulasi (price x qty)
// untuk menangkap value dari foreach atau phpp, gunakan data-(nama variabel), masukkan data-() ke trigger fungsi.
// kalau valuenya adalah value dari inputan langsung, maka dapat langsung ditangkap dari idnya contohnya,
// ex:var grand_total = $("#sub_total").val();
// TIDAK DIPAKAI LAGI FUNGSI INI
function calc_priceXqty() {
    $(".form_edit_peritem").on('input', '#get_qty_peritem', function() { //fungsi dijalankan setiap ada input di id get_qty_peritem
        var price = $(this).data('price'); //mendapatkan value id price
        var discount_per_item = $('#discount_per_item').val(); //mengambil value discount_per_item
        $(".form_edit_peritem #get_qty_peritem").each(function() {
            //khusus mendapatkan value qty_peritem, bisa langsung diambil valuenya
            var get_qty_peritem = $(this).val();
            if ($.isNumeric(get_qty_peritem)) {
                total = (price - discount_per_item) * parseFloat(get_qty_peritem); // total = (price - discount) * qty
            }
        });
        $('#total_per_item').val(total);
    });
}

// fungsi kalkulasi diskon total=(price - discount)*qty
// kalkulasi diskon jgn begini total= total-discount 
function calc_disc_peritem() {
    $(".form_edit_peritem").on('input', '#discount_per_item', function() { //menjalankan fungsi setiap ada input di discount_per_item
        var price = $(this).data('price'); //mendapatkan value id price
        var get_qty_peritem = $('#get_qty_peritem').val(); //mendapatkan qty
        var get_discount_peritem = $(this).val(); //mendapatkan discount_per_item
        $('#total_per_item').val((price - get_discount_peritem) * get_qty_peritem);
    });
}

$(document).ready(function() {

    // menjalankan fungsi calc_disc_peritem
    calc_disc_peritem();

    $('.formedit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            // beforeSend => aksi merubah atribut button dengan class="btnsimpan" menjadi disable, 
            // kemudian  merubah html button jadi html icon spinner
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled');
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            // ketika aksi beforeSend sudah selesai, remove atributr disable, dan rubah ke html simpan
            complete: function() {
                $('.btnsimpan').removeAttr('disable');
                $('.btnsimpan').html('Update');
            },
            success: function(response) {
                //tidak pakai response error sperti di modal_tambah
                //jika form valid memunculkan pesan sukses, dan menutup modal tambah, dan memunculkan fungsi data_mahasiswa()
                // alert(response.sukses);
                $('#modal_edit').modal('hide');
                data_cart();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });
})
</script>