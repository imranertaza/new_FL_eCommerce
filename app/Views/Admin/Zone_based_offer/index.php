<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Offer List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Offer List</li>
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
                            <h3 class="card-title">Offer List</h3>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php echo base_url('zone_based_offer_create') ?>" class="btn btn-primary btn-block btn-xs"><i class="fas fa-plus"></i> Create</a>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-capitalize">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Offer On</th>
                            <th>Discount On</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($offer as $val){ ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo $val->name;?></td>
                                <td><?php echo $val->offer_on;?></td>
                                <td><?php echo $val->discount_on;?></td>
                                <td><?php echo bdDateFormat($val->start_date);?></td>
                                <td><?php echo bdDateFormat($val->expire_date);?></td>
                                <td><?php echo image_view('uploads/offer',$val->offer_id,'50_'.$val->banner,'50_noimage.png','','');?></td>
                                <td width="180">
                                    <a href="<?php echo base_url('zone_based_offer_update/'.$val->offer_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                    <a href="<?php echo base_url('zone_based_offer_delete/'.$val->offer_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php }?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Offer On</th>
                            <th>Discount On</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Image</th>
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