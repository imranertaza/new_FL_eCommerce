<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog Category List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Blog Category List</li>
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
                        <h3 class="card-title">Blog Category List</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('blog_category_create') ?>" class="btn btn-primary btn-block btn-xs"><i class="fas fa-plus"></i> Add</a>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== null) : echo session()->getFlashdata('message');
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-capitalize ">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Icon</th>
                            <th>Sort Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;

foreach ($category as $val) {
    $main_cat = (!empty($val->parent_id)) ? get_data_by_id('parent_id', 'cc_category', 'cat_id', $val->parent_id) : '';
    $main     = (!empty($main_cat)) ? get_data_by_id('category_name', 'cc_category', 'cat_id', $main_cat) . '->' : '';
    $parCat   = (!empty($val->parent_id)) ? get_data_by_id('category_name', 'cc_category', 'cat_id', $val->parent_id) . '-> ' : ''; ?>
                            <tr>
                                <td width="40"><?php echo $i++; ?></td>
                                <td><?php echo display_blog_category_with_parent($val->cat_id); ?></td>

                                <td><?php echo common_image_view('uploads/blog_category', '', $val->image, 'noimage.png', 'width-80', '', '166', '208'); ?>
                                </td>
                                <td><?php print get_data_by_id('code', 'cc_icons', 'icon_id', $val->icon_id); ?> </td>
                                <td width="100"><input type="text" class="border-0" onchange="updateSorting(this.value,'<?php echo $val->cat_id ?>')" value="<?php echo $val->sort_order; ?>"></td>
                                <td width="180">
                                    <a href="<?php echo base_url('blog_category_update/' . $val->cat_id); ?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                    <a href="<?php echo base_url('blog_category_delete/' . $val->cat_id); ?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php
} ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Icon</th>
                            <th>Sort Order</th>
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
    function updateSorting(val, id) {
        $.ajax({
            url: '<?php echo base_url('admin/blog_category_sort_update_action') ?>',
            type: "POST",
            data: {
                value: val,
                cat_id: id
            },
            success: function(data) {
                $("#message").html(data);
            }
        });
    }
</script>
<?= $this->endSection() ?>
