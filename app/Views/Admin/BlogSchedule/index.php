<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog Schedule List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Blog Schedule List</li>
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
                        <h3 class="card-title">Blog Schedule List</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('blog-schedule-create') ?>" class="btn btn-primary btn-block btn-xs"><i class="fas fa-plus"></i> Add</a>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== null) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Schedule Name</th>
                        <th>Start Date</th>
                        <th>Start Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($blogSchedule as $val) { ?>
                        <tr>
                            <td width="40"><?php echo $i++;?></td>
                            <td><?php echo $val->schedule_name;?></td>
                            <td><?php echo $val->start_date;?></td>
                            <td><?php echo $val->end_date;?></td>

                            <td width="180">
                                <a href="<?php echo base_url('blog-schedule-update/' . $val->blog_schedule_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <a href="<?php echo base_url('blog-schedule-delete/' . $val->blog_schedule_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Sl</th>
                        <th>Schedule Name</th>
                        <th>Start Date</th>
                        <th>Start Date</th>
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
