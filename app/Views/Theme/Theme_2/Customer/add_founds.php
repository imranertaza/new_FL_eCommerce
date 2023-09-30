<section class="main-container my-5">
    <div class="container">

        <div class="card border rounded-0">
            <div class="card-body p-3 p-md-5">
                <div class="row mb-4">
                    <div class="col-md-12 px-5">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                            endif; ?>
                    </div>

                    <div class="col-md-12 px-5">
                        <h3>Add founds</h3>
                    </div>
                    <div class="col-md-6 px-5">
                        <form action="<?php echo base_url('add_founds_action')?>" method="post">
                            <div class="form-group mt-4">
                                <label>Amount</label>
                                <input type="text" name="amount" class="form-control" placeholder="Amount" required>
                            </div>

                            <div class="payment-method group-check mb-4 pb-4 mt-3">
                                <?php foreach (get_all_data_array('cc_payment_method') as $pay) {
                                if ($pay->status == '1') { if(($pay->code != 'cash_on') && ($pay->code != 'paypal') && ($pay->code != 'u_wallet')){ ?>
                                <div class="d-flex justify-content-between mt-3">
                                    <div class="form-check"><label class="form-check-label"><input
                                                class="form-check-input"
                                                onclick="instruction_view(this.value,'<?php echo $pay->code; ?>'),cardForm('<?php echo $pay->code; ?>')"
                                                type="radio" name="payment_method_id" id="payment_method"
                                                value="<?php echo $pay->payment_method_id; ?>" required>
                                            <?php echo !empty($pay->image) ? image_view('uploads/payment', '', $pay->image, 'noimage.png', 'img-payment') : $pay->name; ?>
                                        </label></div>
                                </div>
                                <?php } } } ?>

                            </div>

                            <div id="instruction"></div>
                            <div id="cardForm">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>

    </div>
</section>