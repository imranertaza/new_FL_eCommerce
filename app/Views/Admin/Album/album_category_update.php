<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Album update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Album update</li>
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
                        <h3 class="card-title">Album update</h3>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('album_category_update_action')?>" method="post" enctype="multipart/form-data">
                    <div class="row" id="reloadImg">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $album->name;?>" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order_al" class="form-control" value="<?= $album->sort_order;?>" placeholder="sort order" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Parent Category</label>
                                <select name="parent_album_id" class="form-control">
                                    <option value="">Please Select</option>
                                    <?php foreach ($albumParent as $val){ ?>
                                        <option value="<?= $val->album_id?>" <?php echo ($val->album_id == $album->parent_album_id )?'selected':'';?> ><?= display_folder_parent_with_parent($val->album_id); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><div class="col-md-6"></div>

                        <div class="col-md-4">
                            <h3>Default Image <span class="requi">*</span></h3>
                        </div>
                        <div class="col-md-8">
                            <div class="row ">
                                <div class="col-md-2 img_view">
                                    <?php echo image_view('uploads/album',$album->album_id,'198_'.$album->thumb,'noimage.png','img-w-h-100');?>
                                </div>
                            </div>
                            <div id="framesdef"></div><br>
                            <input type="file" id="defimage" name="thumb" class="form-control" >

                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 mt-3 text-center">
                            <button class="btn btn-primary" >Update</button>
                            <input type="hidden" class="form-control" name="album_id" value="<?= $album->album_id;?>" >
                            <a href="<?php echo base_url('album')?>" class="btn btn-danger" >Back</a>
                        </div>
                    </div>
                </form>
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
    function album_image_sort_update(album_details_id,val){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('album_image_sort_action') ?>",
            data: {album_details_id: album_details_id,value:val},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                $("#success").show(0).delay(1000).fadeOut();
            }
        });
    }

    function removeAlbumImg(album_details_id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('album_image_delete') ?>",
            data: {
                album_details_id: album_details_id
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#message").html(data);
                $('#reloadImg').load(document.URL + ' #reloadImg');
            }

        });
    }

</script>
<?= $this->endSection() ?>