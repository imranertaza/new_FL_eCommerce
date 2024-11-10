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
                <form action="<?php echo base_url('album_update_action')?>" method="post" enctype="multipart/form-data">
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
                        <div class="col-md-4">
                            <h3>Multiple Image</h3>
                        </div>
                        <div class="col-md-8 mt-3">
                            <div id="success"  style="display:none;"  class="alert alert-success alert-dismissible w-50 mb-1 text-center " role="alert">Update Success </div>
                            <div class="row mb-4" >
                                <?php foreach ($albumAll as $img){ ?>
                                    <div class="col-md-2 img_view">
                                        <input type="text" onchange="album_image_sort_update('<?=$img->album_details_id?>',this.value)" class="form-control mb-2 text-center" style="height: 25px;" name="sort_order" value="<?= $img->sort_order;?>">
                                        <?php echo multi_image_view('uploads/album', $img->album_id, $img->album_details_id, '198_' . $img->image, 'noimage.png', 'img-fluid');?>
                                        <a href="javascript:void(0)" onclick="removeAlbumImg(<?php echo $img->album_details_id;?>)" class="btn del-btn"><i class="fas fa-trash"></i> Delete</a>
                                    </div>
                                <?php } ?>
                            </div>

                            <div id="frames"></div><br>
                            <input type="file" class="form-control" id="image" name="multiImage[]" multiple />


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