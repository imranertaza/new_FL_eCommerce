<section class="main-container my-5">
    <div class="container">
        <form action="<?php echo base_url('profile_update_action') ?>" method="Post">
            <?= csrf_field() ?>
            <div class="card border rounded-0">
                <div class="card-body p-3 p-md-5">
                    <div class="row mb-4">
                        <div class="col-md-12 px-5">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                            endif; $symbol = get_lebel_by_value_in_settings('currency_symbol'); ?>
                        </div>
                        <div class="col-md-12 px-5 text-center">

<!--                            <a href="--><?php //echo base_url('add_funds');?><!--" class="btn btn-primary" style="float: right;">Add funds</a>-->
<!--                            <div class="card" style="width: 10rem;">-->
<!--                                <div class="card-body text-center">-->
<!--                                    <h5 class="card-title">My Balance</h5>-->
<!--                                    <p>--><?php //echo currency_symbol_with_symbol($cust->balance,$symbol);?><!--</p>-->
<!--                                </div>-->
<!--                            </div>                            -->
                            <p class="text-danger">We are currently developing this page to serve you better</p>
                        </div>

<!--                        <div class="col-md-12 px-5 mt-5">-->
<!---->
<!--                            <table class="cart-table w-100 text-center">-->
<!--                                <thead>-->
<!--                                    <tr>-->
<!--                                        <th>Sl</th>-->
<!--                                        <th>Payment method</th>-->
<!--                                        <th>Amount</th>-->
<!--                                        <th>Status</th>-->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody>-->
<!--                                    --><?php //$i=1; foreach($fund_request as $req ){ ?>
<!--                                    <tr>-->
<!--                                        <td>--><?php //echo $i++?><!--</td>-->
<!--                                        <td>--><?php //echo get_data_by_id('name','cc_payment_method','payment_method_id',$req->payment_method_id); ?><!--</td>-->
<!--                                        <td>--><?php //echo currency_symbol_with_symbol($req->amount,$symbol)?><!--</td>-->
<!--                                        <td>--><?php //echo $req->status?><!--</td>-->
<!--                                    </tr>-->
<!--                                    --><?php //} ?>
<!--                                </tbody>-->
<!--                            </table>-->
<!---->
<!---->
<!--                        </div>-->



                    </div>
                </div>
            </div>
        </form>
    </div>
</section>