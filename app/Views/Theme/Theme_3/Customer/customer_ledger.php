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
                        <?php $i = 1; $symbol = get_lebel_by_value_in_settings('currency_symbol');
                        foreach ($ledger as $val) { ?>
                            <tr>
                                <td width="40"><?php echo $i++; ?></td>
                                <td><?php echo $val->particulars; ?></td>
                                <td><?php echo ($val->trangaction_type == 'Cr.') ? 'Deposit' : 'Purchase'; ?></td>
                                <td><?php echo saleDate($val->createdDtm); ?></td>
                                <td><?php echo currency_symbol_with_symbol($val->amount,$symbol); ?></td>
                                <td><?php echo currency_symbol_with_symbol($val->rest_balance,$symbol); ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>