<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Geo Zone List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Geo Zone List</li>
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
                        <h3 class="card-title">Geo Zone List</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('geo_zone_create') ?>" class="btn btn-primary btn-block btn-xs"><i class="fas fa-plus"></i> Create</a>
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
                        <th>Name</th>
                        <th>Description	</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($geo_zone as $val){ ?>
                        <tr>
                            <td width="40"><?php echo $i++;?></td>
                            <td><?php echo $val->geo_zone_name;?></td>
                            <td><?php echo $val->geo_zone_description;?></td>
                            <td width="180">
                                <a href="<?php echo base_url('geo_zone_update/'.$val->geo_zone_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <a href="<?php echo base_url('geo_zone_delete/'.$val->geo_zone_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Description</th>
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