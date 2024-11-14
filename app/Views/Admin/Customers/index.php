<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customers List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Customers List</li>
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
                        <h3 class="card-title">Customers List</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('customers_create') ?>" class="btn btn-primary btn-block btn-xs"><i class="fas fa-plus"></i> Add</a>
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
                            <th>Sl</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($customer as $val){ ?>
                        <tr>
                            <td width="40"><?php echo $i++;?></td>
                            <td><?php echo $val->firstname;?></td>
                            <td><?php echo $val->lastname;?></td>
                            <td><?php echo $val->email;?></td>
                            <td><?php echo $val->phone;?></td>
                            <td width="200">
                            <a href="<?php echo base_url('customers_ledger/'.$val->customer_id);?>" class="btn btn-info btn-xs"><i class="fas fa-book"></i> Ledger</a>
                                <a href="<?php echo base_url('customers_update/'.$val->customer_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <a href="<?php echo base_url('customers_delete/'.$val->customer_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>

                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>email</th>
                            <th>Phone</th>
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

    </script>
<?= $this->endSection() ?>