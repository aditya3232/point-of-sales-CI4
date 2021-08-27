<!-- menampilkan td (tidak ada item) jika rownya 0 saja -->
<?php if($cartRow == 0) { ?>
<tr>
    <td colspan="9" class="text-center">Tidak ada item</td>
</tr>
<?php } ?>

<?php $i = 1; ?>
<?php foreach($cart as $carts): ?>
<tr class="lol145">
    <td><?= $i++; ?></td>
    <td class="text-center"><?= $carts['barcode']; ?></td>
    <td class="text-center"><?= $carts['name_item']; ?></td>
    <td class="text-center" id="ccc"><?= $carts['price']; ?></td>
    <td class="text-center"><?= $carts['cart_qty']; ?></td>
    <td class="text-center"><?= $carts['cart_discount']; ?></td>
    <td class="text-center" id="xxx"><?= $carts['cart_total']; ?></td>
    <td class="table-action text-right">
        <button type="submit" class="btn btn-outline-warning btn-sm" id="button_edit_data_cart" onclick="edit('<?= $carts['cart_id']; ?>')">
            <i class="far fa-edit"></i>
        </button>
        <!-- fungsi hapus data tidak perlu bantuan form, tapi tetap perlu diallow csrfnya -->
        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="hapus('<?= $carts['cart_id']; ?>','<?= $carts['barcode']; ?>','<?= $carts['item_id']; ?>','<?= $carts['cart_qty']; ?>')">
            <i class="far fa-trash-alt"></i>
        </button>
    </td>
</tr>
<?php endForeach; ?>

<script>
// fungsi hapus
// hapus(cart_id, barcode, item_id, cart_qty), urutannya WAJIB SESUAI dengan yang di onclick="hapus()
function hapus(cart_id, barcode, item_id, cart_qty) {

    //kondisi jika confirm bernilai true jalankan ajax, jika tidak return false (kembali ke awal)
    if (confirm(`Yakin menghapus data cart dengan barcode. ${barcode} ?`) == true) {
        $.ajax({
            type: "post",
            url: "<?= site_url('sale/hapus'); ?>",
            data: {
                cart_id: cart_id, //cart_id isinya cart_id dari form button hapus saat diklik, kemudian akan dikirimkan ke controller sale/hapus
                barcode: barcode,
                item_id: item_id, //untuk proses update stock setelah cart item dihapus
                cart_qty: cart_qty //untuk proses update stock setelah cart item dihapus
                // jgn lupa ketika menambahkan data di sini. masukkan ke paramter-nya
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    alert(response.sukses);
                    data_cart();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    } else {
        return false;
    }
}

// fungsi edit
function edit(cart_id) {
    $.ajax({
        type: "post",
        url: "<?= site_url('sale/formedit'); ?>",
        data: {
            cart_id: cart_id,
        },
        dataType: "json",
        success: function(response) {
            $('.viewmodal').html(response.sukses).show(); //memanggil div class="viewmodal di view(sale_form)" (bayangan ketika muncul modal)
            $('#modal_edit').modal('show'); //kemudian menampilkan modal dengan id="modal_edit" (modal adalah sebuah view terpisah)
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

// $("tr.lol145").each(function(index) {
//     $(this).find("td:eq(6)").css("color", "red");
// }); //merubah warna hanya td ke 6(cart_total)

// $("td#xxx").each(function(index) {
//     $(this).css("color", "red");
// }); //merubah warna hanya td ke 6(cart_total)

// $("td#ccc").each(function(index) {
//     $(this).css("color", "red");
// }); //merubah warna hanya td ke 6(cart_total)

// $("tr.lol145").each(function(index) {
//     var get_td_value = $(this).find("td:eq(6)").text();
//     $('#sub_total').val(get_td_value);
// });

// $("table#table_cart").each(function(index) {
//     $(this).css("color", "red");
//     // $('#sub_total').val(get_td_value);
// }); //script ini bisa mempengaruhi seluruh tabel

// $("tbody#cart_table").each(function(index) {
//     $(this).css("color", "red");
//     // $('#sub_total').val(get_td_value);
// }); //script ini mempengaruhi seluruh tbody
// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

// fungsi menghitung total dari cart_total keselurhan
function calc_total() {
    var sum = 0;
    $("td#xxx").each(function() {
        sum += parseFloat($(this).text());
    });
    $('#sub_total').val(sum);
    $('#grand_total').val(sum); //memberikan nilai grand_total awal
    $('#grand_total2').html(sum); //memberikan nilai grand_total2 awal

}

function calc_discount() { //ini akan memberikan nilai grand_total & grand_total2 baru ketika ada input discount
    $(".row3col1").on('input', '#discount', function() {
        var grand_total = $("#sub_total").val();
        $(".row3col1 #discount").each(function() {
            var get_discount_value = $(this).val();
            if ($.isNumeric(get_discount_value)) {
                grand_total -= parseFloat(get_discount_value);
            }
        });
        $('#grand_total').val(grand_total);
        $('#grand_total2').html(grand_total);
    });

}


$(document).ready(function() {

    calc_total();
    calc_discount();
});
</script>