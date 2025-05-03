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
        <form action="<?= base_url('album_download_action')?>" method="post">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Album List</h3>
                    </div>
                    <div class="col-md-4">
                        <?php if(modules_key_by_access('multi_album_download') == '1' ){ ?>
                        <button type="submit" class="btn btn-success   btn-xs">Album Download</button>
                        <?php } ?>
                        <a href="<?php echo base_url('album_category_create') ?>" class="btn btn-info   btn-xs"><i class="fas fa-plus"></i> Create Album Category</a>
                        <a href="<?php echo base_url('album_create') ?>" class="btn btn-primary   btn-xs"><i class="fas fa-plus"></i> Create Album</a>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        <span id="mess" style="display: none"><div class="alert alert-success alert-dismissible" role="alert">Album Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="parent_album_id" value="<?php echo $parent_album_id;?>"  >
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" onclick="allCheckedDemo(this)"  ></th>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Thumbnail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($album as $val){ ?>
                        <tr id="update_<?= $val->album_id;?>">
                            <td width="10">
                                <input type="checkbox" name="album_id[]" value="<?php echo $val->album_id;?>"  >
                            </td>
                            <td width="40"><?php echo $val->album_id;?></td>
                            <td>
                                <p onclick="updateFunctionAlbum('<?= $val->album_id;?>', 'name', '<?= $val->name;?>', 'view_name_<?=$val->album_id?>', 'formEdit_<?=$val->album_id?>','update_<?= $val->album_id;?>')"><?php echo $val->name;?></p>
                                <span id="view_name_<?php echo $val->album_id; ?>"></span>
                            </td>
                            <td>
                                <?php $img = str_replace("pro_", "", $val->thumb); $url = base_url('uploads/album/'.$val->album_id.'/wm_'.$img); ?>
                                <a class="album-image-link" href="<?= $url;?>" data-lightbox="album-set-<?= $val->album_id;?>">
                                <?php echo image_view('uploads/album',$val->album_id,'50_'.$val->thumb,'50_noimage.png','');?>
                                </a>

                            </td>
                            <td width="220">
                                <a href="<?php echo base_url('album_update/'.$val->album_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
                                <a href="<?php echo base_url('album_delete/'.$val->album_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
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
        </form>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>
        function allCheckedDemo(source) {
            var checkboxes = document.querySelectorAll('#example1 input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        function updateFunctionAlbum(id, input, value, viewId, formName,updateRow) {
            var formID = "'" + formName + "'"
            var data = '<form id="' + formName +
                '" action="<?php echo base_url('album_bulk_update_action') ?>" onkeydown="if(event.keyCode === 13) {return false;}" data-row="'+updateRow+'" method="post"><input type="text" name="' +
                input +
                '" class="form-control mb-2" value="' + value +
                '" ><input type="hidden" name="album_id" class="form-control mb-2" value="' + id +
                '" ><button type="button" onclick="submitFormBulk(' + formID +
                ')" class="btn btn-xs btn-primary mr-2">Update</button><a href="javascript:void(0)" onclick="hideInput(this)" class="btn btn-xs btn-danger">Cancel</button> </form>';

            $('#' + viewId).html(data);
        }

        function hideInput(data) {
            $(data).parent().remove();
        }
        function submitFormBulk(formID) {
            var form = document.getElementById(formID);
            var upRow = $(form).attr('data-row');

            var done = false;
            $.ajax({
                url: $(form).prop('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    // $("#message").html(data);
                    $("#mess").show();
                    var div = $("#"+upRow).html(data);
                    div.animate({opacity: '0.5'});
                    div.animate({opacity: '1'});
                    checkShowHideRow();

                }
            });

        }


    </script>
<?= $this->endSection() ?>