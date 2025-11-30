<section class="main-container my-3 my-md-5">
    <div class="container">
        <div class="popular-category mb-5">
            <div class="card rounded-0 border">
                <div class="card-body p-3 p-md-5">
                    <div class="row">
                        <div class="col-md-12 mb-4" id="message">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>

                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                            <div class="d-flex justify-content-between">
                                <span class="mt-3 con-tit">Total Order</span>
                                <?php
                                    $modules = modules_access();
                                    $all = 0;
                                    foreach ($order as $acVal){ $all++;}
                                ?>
                                <span class="amount-or"><?php echo $all;?></span>
                            </div>

                            <div class="mt-2 d-flex justify-content-between">
                                <span class="mt-3 con-tit">Total Complete <br>Order</span>
                                <?php
                                $complete = 0;
                                foreach ($order as $acVal){
                                    $orderSt = order_id_by_status($acVal->order_id);
                                    if ($orderSt == 'Complete'){ $complete++; }
                                }
                                ?>
                                <span class="amount-or"><?php echo $complete;?></span>
                            </div>

                            <div class="mt-2 d-flex justify-content-between">
                                <span class="mt-3 con-tit">Total Cancel <br>Order</span>
                                <?php
                                $canceled = 0;
                                foreach ($order as $acVal){
                                    $orderSt = order_id_by_status($acVal->order_id);
                                    if ($orderSt == 'Canceled'){ $canceled++; }
                                }
                                ?>
                                <span class="amount-or"><?php echo $canceled;?></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                            <h4 class="ti-or-n">Join our mailing list.</h4>
                            <p class="mb-3 con-or">Stay in the loop! Join our mailing list for exclusive updates, offers, and exciting news.</p>
                            <h4 class="ti-or-n">Newsletters</h4>
                            <p class="mb-3 con-or">You aren't subscribed to our newsletter.</p>
                            <?php $check = get_data_by_id('newsletter','cc_customer','customer_id',newSession()->cusUserId);?>
                            <div class="form-check">
                                <input class="form-check-input" onclick="subscription()" <?php echo ($check == 1)?'checked':'';?> type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label lab-st" for="flexCheckDefault">
                                    General Subscription
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                            <h4 class="ti-or-n">Change Password</h4>
                            <form action="<?php echo base_url('password_action_update')?>" method="post" onsubmit="return resetPassword()">
                                <?= csrf_field() ?>
                            <div class="mb-3 mt-3">
                                <input type="password" id="current_password" name="current_password" class="form-control con-or in_err fw-bolder" placeholder="Current Password*"  >
                                <span class="text-danger d-inline-block err text-capitalize" id="password_err_mess"></span>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="new_password" id="new_password" class="form-control  in_err con-or fw-bolder"  placeholder="New Password*"  >
                                <span class="text-danger d-inline-block err text-capitalize" id="new_password_err_mess"></span>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" id="confirm_password"     class="form-control con-or in_err fw-bolder" placeholder="Confirm Password*"  >
                                <span class="text-danger d-inline-block err text-capitalize" id="confirm_password_err_mess"></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn bg-custom-color text-white w-100 rounded-0" >Update</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                            <h4 class="ti-or-n">Recent Order</h4>
                            <?php if (!empty($orderItem)){  foreach ($orderItem as $item){ ?>
                                <div class="d-flex">
                                    <div><?php $img = get_all_row_data_by_id('cc_products', 'product_id', $item->product_id); ?>
                                        <img data-sizes="auto"  id="" src="<?php echo product_image_view('uploads/products', $item->product_id, $img->image, 'noimage.png', '100', '100');?>" alt="<?php echo $img->alt_name?>" class="img-fluid" loading="lazy">

                                    </div>
                                    <div class="ms-3">
                                        <p class="p-date"><?php echo invoiceDateFormat($item->createdDtm);?></p>
                                        <p class="p-sty mt-2"><?php echo get_data_by_id('name','cc_products','product_id',$item->product_id);;?></p>
                                    </div>
                                </div>
                            <?php } } else{ ?>
                                <p class="p-sty">No products available!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>