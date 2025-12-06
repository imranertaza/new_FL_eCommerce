<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Order List</li>
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
                        <h3 class="card-title">Order List</h3>
                    </div>
                    <div class="col-md-4">
                        <form id="multiSubmitForm" action="<?php echo base_url('order_multi_delete_action'); ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class=" mt-2 btn btn-danger btn-xs float-right mr-2"><i class="fas fa-trash"></i> Multi Delete</button>
                        </form>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" onclick="allchecked(this)" ></th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Order Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $symbol = get_lebel_by_value_in_settings('currency_symbol');?>
                    <?php $i=1; foreach ($order as $val){ ?>
                        <tr>
                            <td width="10">
                                <input type="checkbox" name="order_id[]" value="<?php echo $val->order_id;?>" form="multiSubmitForm">
                            </td>
                            <td><?php echo $val->order_id;?></td>
                            <td><?php echo $val->payment_firstname . $val->payment_lastname;?></td>
                            <td><?php echo currency_symbol_with_symbol($val->final_amount,$symbol) ;?></td>
                            <td><?php echo order_id_by_status($val->order_id) ;?></td>
                            <td width="180">
                                <a href="<?php echo base_url('order_view/'.$val->order_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i> View</a>
                                <a href="<?php echo base_url('order_delete/'.$val->order_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Order Status</th>
                        <th>Action</th>
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
        function allchecked(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
<?= $this->endSection() ?>