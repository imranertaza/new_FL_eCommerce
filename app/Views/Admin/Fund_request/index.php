<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fund Request List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Fund Request List</li>
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
                        <h3 class="card-title">Fund Request List</h3>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body" id="tablereload">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($found_request as $val){ ?>
                        <tr>
                            <td width="40"><?php echo $i++;?></td>
                            <td><?php echo get_data_by_id('firstname','cc_customer','customer_id',$val->customer_id).' '.get_data_by_id('lastname','cc_customer','customer_id',$val->customer_id);?></td>
                            <td><?php echo currency_symbol($val->amount);?></td>
                            <td><?php echo get_data_by_id('name','cc_payment_method','payment_method_id',$val->payment_method_id);?></td>
                            <td><?php echo saleDate($val->createdDtm);?></td>
                            <td width="180">
                                <?php if($val->status == 'Pending'){ ?>
                                    <select name="status" id="status" onchange="found_request_update(this.value,'<?php echo $val->fund_request_id;?>')" >
                                        <option value="Pending" <?php echo ($val->status == 'Pending')?'selected':'';?>>Pending</option>
                                        <option value="Complete" <?php echo ($val->status == 'Complete')?'selected':'';?>>Complete</option>
                                        <option value="Canceled" <?php echo ($val->status == 'Canceled')?'selected':'';?>>Canceled</option>
                                    </select>
                                <?php }else{ echo $val->status;} ?>

                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
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
    function found_request_update(val,id){
        $.ajax({
            url: '<?php echo base_url('fund_request_action') ?>',
            type: "POST",
            data: {
                status: val,
                fund_request_id: id
            },
            success: function(data) {
                $("#message").html(data);
                $('#tablereload').load(document.URL + ' #example1');
            }
        });
    }
</script>
<?= $this->endSection() ?>