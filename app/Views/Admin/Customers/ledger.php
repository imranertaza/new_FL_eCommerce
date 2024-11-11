<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customers Ledger List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Customers Ledger List</li>
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
                        <h3 class="card-title">Customers Ledger List</h3>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
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
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Particulars</th>
                            <th>Trangaction Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Rest Balance</th>
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

    </script>
<?= $this->endSection() ?>