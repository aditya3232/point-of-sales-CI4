<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false">
    <!-- data-backdrop dan data-static agar modal tidak out ketika klik luar dan esc -->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan Penjualan</h5>
                <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- table -->
                <table class="table table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <th>Invoice</th>
                            <td><?= $invoice; ?></td>
                            <th>customer</th>
                            <td><?= $customer_name; ?></td>
                        </tr>
                        <tr>
                            <th>Date Time</th>
                            <td><?= $date; ?></td>
                            <th>Cashier</th>
                            <td><?= $user_realname; ?></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><?= $total_price; ?></td>
                            <th>Cash</th>
                            <td><?= $cash; ?></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td><?= $discount; ?></td>
                            <th>Change</th>
                            <td><?= $remaining; ?></td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td><?= $final_price; ?></td>
                            <th>Note</th>
                            <td><?= $note; ?></td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td colspan="3">
                                <table class="table">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Disc</th>
                                        <th>Total</th>
                                    </tr>
                                    <?php foreach($data_purchased_product as $data_purchased_products): ?>
                                    <tr id="detailx">
                                        <td><?= $data_purchased_products['name_item']; ?></td>
                                        <td><?= $data_purchased_products['price']; ?></td>
                                        <td><?= $data_purchased_products['cart_qty']; ?></td>
                                        <td><?= $data_purchased_products['cart_discount']; ?></td>
                                        <td><?= $data_purchased_products['cart_total']; ?></td>
                                    </tr>
                                    <?php endForeach; ?>

                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- akhir table -->
            </div>
            <!-- <div class="modal-footer">
                <p>lol</p>
            </div> -->
        </div>
    </div>

</div>