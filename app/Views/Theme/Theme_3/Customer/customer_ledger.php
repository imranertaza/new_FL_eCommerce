<section class="main-container my-5" >
    <div class="container">
        <div class="col-md-12 px-5">
            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
        </div>
        <div class="cart">
            <div class="table-responsive">
                <table class="cart-table w-100 text-center" id="tableReload">
                <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Particulars</th>
                            <th>Trangaction Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Rest Balance</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($ledger as $val) { ?>
                            <tr>
                                <td width="40"><?php echo $i++; ?></td>
                                <td><?php echo $val->particulars; ?></td>
                                <td><?php echo ($val->trangaction_type == 'Cr.') ? 'Deposit' : 'Purchase'; ?></td>
                                <td><?php echo saleDate($val->createdDtm); ?></td>
                                <td><?php echo currency_symbol($val->amount); ?></td>
                                <td><?php echo currency_symbol($val->rest_balance); ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>