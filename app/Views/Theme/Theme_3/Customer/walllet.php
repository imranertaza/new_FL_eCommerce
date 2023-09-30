<section class="main-container my-5">
    <div class="container">
        <form action="<?php echo base_url('profile_update_action') ?>" method="Post">
            <div class="card border rounded-0">
                <div class="card-body p-3 p-md-5">
                    <div class="row mb-4">
                        <div class="col-md-12 px-5">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                            endif; ?>
                        </div>
                        <div class="col-md-12 px-5 text-center">

                            <a href="<?php echo base_url('add_founds');?>" class="btn btn-primary" style="float: right;">Add founds</a>
                            <div class="card" style="width: 10rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title">My Balance</h5>
                                    <p><?php echo currency_symbol($cust->balance);?></p>
                                </div>
                            </div>
                            <!-- <div class="card " style="width: 18rem; float:left;margin-left: 15px;">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Pending request</h5>
                                    <p>100</p>
                                </div>
                            </div> -->
                            

                        </div>

                        <div class="col-md-12 px-5 mt-5">

                            <table class="cart-table w-100 text-center">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payment method</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($found_request as $req ){ ?>
                                    <tr>
                                        <td><?php echo $i++?></td>
                                        <td><?php echo get_data_by_id('name','cc_payment_method','payment_method_id',$req->payment_method_id); ?></td>
                                        <td><?php echo currency_symbol($req->amount)?></td>
                                        <td><?php echo $req->status?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>



                    </div>
                </div>
            </div>
        </form>
    </div>
</section>