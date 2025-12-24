<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
<?= $this->include('Theme/Theme_3/Customer/menu'); ?>
<div class="main-container my-5" >
    <div class="container">
        <div class="col-md-12 px-5">
            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
        </div>
        <div class="cart">
            <div class="row">
                <div class="col-md-12 text-center">

                    <div class="card" style="width: 10rem; float: left; ">
                        <div class="card-body text-center">
                            <h5 class="card-title">My Point</h5>
                            <p><?php echo $cust->point;?></p>
                        </div>
                    </div>


                </div>
                <div class="col-md-12   mt-3">
                    <h3>Point History</h3>
                    <div class="table-responsive mt-3">
                        <table class="cart-table w-100 text-center" id="tableReload">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Particulars</th>
                                    <th>Transaction Type</th>
                                    <th>Date</th>
                                    <th>Point</th>
                                    <th>Rest Point</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ;
                            foreach ($point_history as $val) { ?>
                                <tr>
                                    <td width="40"><?php echo $i++; ?></td>
                                    <td><?php echo $val->particulars; ?></td>
                                    <td><?php echo ($val->trangaction_type == 'Cr.') ? 'Add' : 'Deducted'; ?></td>
                                    <td><?php echo saleDate($val->createdDtm); ?></td>
                                    <td><?php echo $val->point; ?></td>
                                    <td><?php echo $val->rest_point; ?></td>

                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>