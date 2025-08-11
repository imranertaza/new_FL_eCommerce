<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Album List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Album List</li>
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
                        <h3 class="card-title">Album List</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('album_category_create') ?>" class="btn btn-info   btn-xs"><i class="fas fa-plus"></i> Create Album Category</a>
                        <a href="<?php echo base_url('album_create') ?>" class="btn btn-primary   btn-xs"><i class="fas fa-plus"></i> Create Album</a>
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
                            <th>Thumbnail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($album as $val){ ?>
                        <tr>
                            <td width="40"><?php echo $i++;?></td>
                            <td><?php echo $val->name;?></td>
                            <td><img data-sizes="auto"  id="" src="<?php echo product_image_view('uploads/album', $val->album_id, $val->thumb, 'noimage.png', '50', '50');?>" alt="<?php echo $val->alt_name?>" class="img-fluid " loading="lazy"></td>
                            <td width="240">
                                <?php if ($val->is_album_uploadable == 0){ ?>
                                    <a href="<?php echo base_url('album_sub_category_list/'.$val->album_id);?>" class="btn btn-info btn-xs"><i class="fas fa-list"></i> Sub Category List</a>
                                <?php }else{ ?>
                                    <a href="<?php echo base_url('album_list/'.$val->album_id);?>" class="btn btn-dark btn-xs"><i class="fas fa-list"></i> Album List</a>
                                <?php } ?>

                                <?php if ($val->is_parent == 0){ ?>
                                <a href="<?php echo base_url('album_update/'.$val->album_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <?php }else{ ?>
                                <a href="<?php echo base_url('album_category_update/'.$val->album_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <?php } ?>

                                <a href="<?php echo base_url('album_category_delete/'.$val->album_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Thumbnail</th>
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