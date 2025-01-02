<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Order View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Order View</h3>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                        endif; ?>
                    </div>
                </div>
            </div>
            <?php $symbol = get_lebel_by_value_in_settings('currency_symbol');?>
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-sm-3">
                        <div class="nav flex-column nav-tabs h-100 text-right font-weight-bolder " id="vert-tabs-tab"
                             role="tablist" aria-orientation="vertical">
                            <a class="nav-link <?php echo isset($_GET['selTab']) ? '' : 'active'; ?> text-dark"
                               id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab"
                               aria-controls="vert-tabs-home" aria-selected="true">Order Details</a>
                            <a class="nav-link text-dark" id="vert-tabs-profile-tab" data-toggle="pill"
                               href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile"
                               aria-selected="false">Payment Details</a>
                            <a class="nav-link text-dark" id="vert-tabs-messages-tab" data-toggle="pill"
                               href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"
                               aria-selected="false">Shipping Details</a>
                            <a class="nav-link text-dark" id="vert-tabs-settings-tab" data-toggle="pill"
                               href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings"
                               aria-selected="false">Products</a>
                            <a class="nav-link text-dark <?php echo isset($_GET['selTab']) ? 'active' : ''; ?>"
                               id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-history" role="tab"
                               aria-controls="vert-tabs-settings" aria-selected="false">History</a>
                        </div>
                    </div>
                    <div class="col-7 col-sm-9">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade  <?php echo isset($_GET['selTab']) ? '' : 'show active'; ?>"
                                 id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                <table class="table  table-striped text-capitalize">
                                    <tr>
                                        <td>Order ID</td>
                                        <td>#<?php echo $order->order_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Store Name</td>
                                        <td><?php echo get_data_by_id('name', 'cc_stores', 'store_id', $order->store_id); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td><?php echo get_data_by_id('firstname', 'cc_customer', 'customer_id', $order->customer_id) . ' ' . get_data_by_id('lastname', 'cc_customer', 'customer_id', $order->customer_id); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail</td>
                                        <td><?php echo $order->payment_email; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Telephone</td>
                                        <td><?php echo $order->payment_phone; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td><?php echo currency_symbol_with_symbol($order->final_amount,$symbol); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Status</td>
                                        <td><?php echo get_data_by_id('name', 'cc_order_status', 'order_status_id', $orderhistoryLast->order_status_id); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                 aria-labelledby="vert-tabs-profile-tab">
                                <table class="table  table-striped text-capitalize">
                                    <tr>
                                        <td>First Name</td>
                                        <td><?php echo $order->payment_firstname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><?php echo $order->payment_lastname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address 1</td>
                                        <td><?php echo $order->payment_address_1; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Postcode</td>
                                        <td><?php echo $order->payment_postcode; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Region/State</td>
                                        <td><?php echo get_data_by_id('name', 'cc_zone', 'zone_id', $order->payment_city); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td><?php echo  get_data_by_id('name', 'cc_country', 'country_id', $order->payment_country_id); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Payment Method</td>
                                        <td><?php echo get_data_by_id('name', 'cc_payment_method', 'payment_method_id', $order->payment_method); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status</td>
                                        <td>
                                            <select name="payment_status" onchange="payment_status_update(this.value,'<?php echo $order->order_id;?>')">
                                                <option value="Pending" <?php echo ($order->payment_status == 'Pending')?'selected':'';?> >Pending</option>
                                                <option value="Paid" <?php echo ($order->payment_status == 'Paid')?'selected':'';?> >Paid</option>
                                                <option value="Failed" <?php echo ($order->payment_status == 'Failed')?'selected':'';?> >Failed</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <?php
                                    $paymentDet =  get_all_row_data_by_id('cc_order_card_details', 'order_id', $order->order_id);
                                    if (!empty($paymentDet)) {
                                        ?>
                                        <tr>
                                            <td>Payment Details</td>
                                            <td>
                                                <b>Card Name:</b> <?php echo $paymentDet->card_name; ?><br>
                                                <b>Card Number:</b> <?php echo $paymentDet->card_number; ?><br>
                                                <b>Expiration:</b> <?php echo $paymentDet->card_expiration; ?><br>
                                                <b>CVC:</b> <?php echo $paymentDet->card_cvc; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </table>
                            </div>

                            <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                 aria-labelledby="vert-tabs-messages-tab">
                                <table class="table  table-striped text-capitalize">
                                    <tr>
                                        <td>First Name</td>
                                        <td><?php echo $order->shipping_firstname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><?php echo $order->shipping_lastname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address 1</td>
                                        <td><?php echo $order->shipping_address_1; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Postcode</td>
                                        <td><?php echo $order->shipping_postcode; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Region/State</td>
                                        <td><?php echo get_data_by_id('name', 'cc_zone', 'zone_id', $order->shipping_city); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td><?php echo get_data_by_id('name', 'cc_country', 'country_id', $order->shipping_country_id); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Method</td>
                                        <td><?php echo $order->shipping_method; ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel"
                                 aria-labelledby="vert-tabs-settings-tab">
                                <table class="table  table-striped text-capitalize">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($orderItem as $vew) { ?>
                                        <tr>
                                            <td width="400">
                                                <?php echo get_data_by_id('name', 'cc_products', 'product_id', $vew->product_id); ?><br>
                                                <?php
                                                $orOption = order_iten_id_by_order_options($vew->order_item);
                                                if (!empty($orOption)) {
                                                    foreach ($orOption as $op) { ?>
                                                        <?php
                                                        $firstCar =  mb_substr($op->value, 0, 1);
                                                        $length = strlen($op->value);
                                                        $isColor = (($firstCar == '#') && ($length == 7)) ? '' : $op->value;
                                                        $style = empty($isColor) ? "background-color: $op->value;padding: 13px 14px; border: unset;" : "padding: 0px 4px;";
                                                        ?>
                                                        <span><?php echo $op->name ?> :</span>
                                                        <label class="btn btn-outline-secondary pd-new"
                                                               style="<?php echo $style; ?> border-radius: unset; margin-left:8px;"><?php echo !empty($isColor) ? $op->value : ''; ?></label>

                                                    <?php }
                                                } ?>
                                            </td>
                                            <td><?php echo $vew->quantity; ?></td>
                                            <td><?php echo currency_symbol_with_symbol($vew->price,$symbol); ?></td>
                                            <td><?php echo currency_symbol_with_symbol($vew->final_price,$symbol); ?></td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td class="text-right" colspan="3">Sub-Total:</td>
                                        <td><?php echo currency_symbol_with_symbol($order->total,$symbol); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3">Discount:</td>
                                        <td><?php echo currency_symbol_with_symbol($order->discount,$symbol); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3">Shipping Charge:</td>
                                        <td><?php echo currency_symbol_with_symbol($order->shipping_charge,$symbol); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3">Total:</td>
                                        <td><?php echo currency_symbol_with_symbol($order->final_amount,$symbol); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade <?php echo isset($_GET['selTab']) ? 'show active' : ''; ?>"
                                 id="vert-tabs-history" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>History</h5>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Comment</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($orderhistory as $hist) { ?>
                                                <tr>
                                                    <td><?php echo invoiceDateFormat($hist->date_added) ?></td>
                                                    <td><?php echo get_data_by_id('name', 'cc_order_status', 'order_status_id', $hist->order_status_id) ?>
                                                    </td>
                                                    <td><?php echo $hist->comment ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('order_history_action') ?>" method="post">
                                            <div class="form-group">
                                                <label>Status <span class="requi">*</span></label>

                                                <select class="form-control" name="order_status_id" required >
                                                    <option>Please select</option>
                                                    <?php echo getListInOption($orderhistoryLast->order_status_id, 'order_status_id', 'name', 'cc_order_status'); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Comments <span class="requi">*</span></label>
                                                <textarea name="comment" rows="3" class="form-control"
                                                          placeholder="Comments" required ></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="order_id"
                                                       value="<?php echo $order->order_id; ?>">
                                                <button type="submit" class="btn btn-primary ">Add History</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>
        function payment_status_update(status,orderId){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('order_payment_status_action');?>",
                data: {status:status,order_id:orderId },
                success: function(data){
                    $('#message').html(data); // show response from the php script.
                }
            });
        }
    </script>
<?= $this->endSection() ?>