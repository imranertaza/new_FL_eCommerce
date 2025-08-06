<section class="main-container" id="tableReload2">
    <div class="container">
        <div class="cart">
            <div class="row">
                <div class="col-md-12 ">
                    <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                    endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="cart-table w-100 text-center ">
                    <thead>
                        <tr>
                            <th>Delete</th>
                            <th>Product Picture</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modules = modules_access();
                        $img_size = ($modules['watermark'] == '1')?'100_wm_':'100_';
                        $symbol = get_lebel_by_value_in_settings('currency_symbol');
                        foreach (Cart()->contents() as $val) { ?>
                            <tr>
                                <td class="product-remove mo-text-center">
                                    <a href="javascript:void(0)" onclick="removeCart('<?php echo $val['rowid']; ?>')"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                                <td class="product-thumbnail mo-text-center">
                                    <a href="#">
                                        <?php $img = get_all_row_data_by_id('cc_products', 'product_id', $val['id']); ?>
                                        <img data-sizes="auto"  id="" src="<?php echo product_image_view('uploads/products', $val['id'], $img->image, 'noimage.png',  '100', '100') ?>" alt="<?php echo $img->alt_name?>" class="img-fluid " loading="lazy">
                                    </a>
                                </td>
                                <td class="product-name text-start mo-text-center">
                                    <a href="#"><?php echo $val['name']; ?></a>
                                </td>

                                <td class="product-price mo-text-center" width="100">
                                    <span class="price"><?php echo currency_symbol_with_symbol($val['price'],$symbol); ?></span>
                                </td>

                                <td class="product-quantity mo-text-center" width="180">
                                    <div class="quantity d-flex justify-content-end justify-content-lg-center">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-dark btn-sm" onclick="minusItem('<?php echo $val['rowid']; ?>')" id="minus-btn"><i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="text" id="qty_input" name="qty" class="form-control form-control-sm item_<?php echo $val['rowid']; ?>" value="<?php echo $val['qty']; ?>" min="1">
                                            <!--                                    <input type="hidden"  name="rowid[]"  value="--><?php //echo $val['rowid'];
                                                                                                                                    ?>
                                            <!--" >-->
                                            <div class="input-group-prepend">
                                                <button class="btn btn-dark btn-sm" onclick="plusItem('<?php echo $val['rowid']; ?>')" id="plus-btn"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="input-group justify-content-center">
                                        <button class="btn bg-custom-color text-white btn-sm" id="btn_<?php echo $val['rowid']; ?>" style="display:none;" onclick="updateQty('<?php echo $val['rowid']; ?>')">Update</button>
                                    </div>
                                </td>
                                <td class="product-subtotal mo-text-center">
                                    <span class="price"><?php echo currency_symbol_with_symbol($val['subtotal'],$symbol); ?></span>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="4" style="border-right:0">
                                <?php if (modules_key_by_access('coupon') == '1') { ?>
                                <form action="<?php echo base_url('checkout_coupon_action') ?>" method="post">
                                    <div class="d-flex coupon">
                                        <input type="text" class="form-control w-auto rounded-0 me-1" name="coupon" placeholder="Coupon Code" required>
                                        <input class="btn bg-custom-color rounded-0 px-4 text-white" type="submit" name="submit" value="Apply Coupon">

                                    </div>
                                    <?php if (isset(newSession()->coupon_discount_shipping)){ ?>
                                        <small class="mt-3 text-danger" style="float: left;">Shipping coupon discount will show up after you checkout.</small>
                                    <?php } ?>
                                </form>

                                <?php } ?>
                            </td>
                            <td class="border-end-0 mo-text-center" style="text-align:left;">
                                <?php
                                    $disc = 0;
                                    $offerdisc = 0;
                                    if (isset(newSession()->coupon_discount) || !empty($offer['discount_amount'])) {
                                ?>
                                    <span class="fs-4 ">Price</span><br>
                                    <span class="fs-4 ">Discount</span><br>
                                <?php } ?>
                                <span class="fs-4 fw-bold">Total</span>
                            </td>
                            <td class="mo-text-center mo-amount" style="text-align:left; width: 170px">
                                <?php if (isset(newSession()->coupon_discount) || !empty($offer['discount_amount'])) {
                                    if (newSession()->discount_type == 'Percentage') {
                                        $disc = (Cart()->total() * newSession()->coupon_discount / 100);
                                    }else{
                                        if (Cart()->total() > newSession()->coupon_discount) {
                                            $disc = newSession()->coupon_discount;
                                        }else{
                                            $disc = Cart()->total();
                                        }
                                    }

                                    $offerdisc = $offer['discount_amount'];

                                    $totalDiscount = $disc + $offerdisc;
                                    $finalDiscount = (Cart()->total() > $totalDiscount)?$totalDiscount:Cart()->total();

                                    ?>
                                    <span class=" fs-4"><?php echo currency_symbol_with_symbol(Cart()->total(),$symbol) ?></span><br>
                                    <span class=" fs-4"><?php echo currency_symbol_with_symbol(($finalDiscount),$symbol) ?></span><br>
                                <?php }
                                $total = (isset(newSession()->coupon_discount) || !empty($offer['discount_amount']) ) ? Cart()->total() - $finalDiscount : Cart()->total(); ?>
                                <span class="fw-bold fs-4"><?php echo currency_symbol_with_symbol($total,$symbol) ?></span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <?php if (!empty(Cart()->contents())) { ?>
                <p class="text-end"><a href="<?php echo base_url('checkout') ?>" class="btn bg-custom-color text-white rounded-0 px-4 btn-checkout">Proceed to checkout</a></p>
            <?php } ?>
        </div>
    </div>
</section>