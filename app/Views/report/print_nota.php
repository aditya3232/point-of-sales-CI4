<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota <?= $invoice; ?></title>
</head>

<style>
th,
td {
    padding-right: 50px;
    font-family: Arial;
    font-size: 13px;
}
</style>

<body style="width:400px">

    <h2 style="font-weight: bold; text-align: center; margin-bottom: 0cm; font-family: Arial;">Toko adit</h2>
    <p style="text-align: center; margin-top: 0cm; margin-bottom: 0cm; font-family: Arial; font-size: 14px;">Puri Cempaka Putih II Blok A0-32 Malang</p>
    <p style="margin-top: 0cm; margin-bottom: 0cm; font-family: Arial;">---------------------------------------------------------------------------</p>

    <p style="display: inline; font-family: Arial; font-size: 14px;"><?= $date; ?> <span style="margin-left: 3cm;">cashier:<?= $user_realname; ?></span></p>
    <p style="display: inline; font-family: Arial; font-size: 14px;"><?= $invoice; ?> <span style="margin-left: 2.35cm;">customer:<?= $customer_name; ?></span></p>
    <p style="margin-top: 0cm; font-family: Arial;">__________________________________________________</p>
    <table>
        <tr>
            <th>item</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Disc</th>
        </tr>
        <?php foreach($data_purchased_product as $data_purchased_products): ?>
        <tr>
            <td><?= $data_purchased_products['name_item']; ?></td>
            <td><?= $data_purchased_products['price']; ?></td>
            <td><?= $data_purchased_products['cart_qty']; ?></td>
            <td><?= $data_purchased_products['cart_discount']; ?></td>
        </tr>
        <?php endForeach; ?>
    </table>
    <p style="margin-top: 0cm; margin-bottom: 0cm; font-family: Arial;">---------------------------------------------------------------------------</p>
    <p style="display: inline; font-family: Arial; font-size: 13px; margin-left: 6.2cm;">sub total <span style="margin-left: 1cm;"><?= $total_price; ?></span></p>
    <p style="display: inline; font-family: Arial; font-size: 13px; margin-left: 6.2cm;">disc. sale <span style="margin-left: 0.9cm;"><?= $discount; ?></span></p>
    <p style="margin-top: 0cm; margin-bottom: 0cm; font-family: Arial; margin-left: 6.2cm;">-------------------------------</p>
    <p style="display: inline; font-family: Arial; font-size: 13px; margin-left: 6.2cm;">Grand total <span style="margin-left: 0.6cm;"><?= $final_price; ?></span></p>
    <p style="margin-top: 0cm; margin-bottom: 0cm; font-family: Arial; margin-left: 6.2cm;">-------------------------------</p>
    <p style="display: inline; font-family: Arial; font-size: 13px; margin-left: 6.2cm;">Cash <span style="margin-left: 1.5cm;"><?= $cash; ?></span></p>
    <p style="display: inline; font-family: Arial; font-size: 13px; margin-left: 6.2cm;">Change <span style="margin-left: 1.1cm;"><?= $remaining; ?></span></p>
    <p style="margin-top: 0cm; margin-bottom: 0cm; font-family: Arial;">---------------------------------------------------------------------------</p>
    <p style="text-align: center; margin-top: 0cm; margin-bottom: 0cm; font-family: Arial; font-size: 14px;">--Terima Kasih--</p>

</body>

</html>