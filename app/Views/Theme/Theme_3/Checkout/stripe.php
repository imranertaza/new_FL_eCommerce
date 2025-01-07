<section class="main-container checkout" >
    <!--    id="tableReload"-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')) : ?>
                            <div  style="color: green; border: 2px green solid; text-align: center; padding: 5px;margin-bottom: 10px;">  Payment Successful! </div>
                        <?php endif ?>
                        <form id='checkout-form' method='post' action="<?php echo base_url('payment_stripe_checkout_action'); ?>">
                            <input type='hidden' name='stripeToken' id='stripe-token-id'>
                            <label for="card-element" class="mb-5">Payment Forms</label>
                            <br>
                            <div id="card-element" class="form-control" ></div>
                            <button id='pay-btn' class="btn btn-success mt-3" type="button"  style="margin-top: 20px; width: 100%;padding: 7px;" onclick="createToken()">PAY </button>
                        <form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $key = get_all_row_data_by_id('cc_payment_settings', 'label', 'key');?>
<script src="https://js.stripe.com/v3/" ></script>
<script>
    var stripe = Stripe("<?php echo $key->value; ?>");
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {

            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }
            // creating token success
            if(typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }
</script>