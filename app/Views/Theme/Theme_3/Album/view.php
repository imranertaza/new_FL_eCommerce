<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
<div class="main-container my-0">
    <div class="container">
        <div class=" bg-white  py-4 mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> <?= $album->name?></h3>
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                    <?php if (!isset(newSession()->isLoggedInCustomer)){ ?>
                    <button class="btn btn-sm btn-primary border-0 float-end" data-bs-toggle="modal" data-bs-target="#queryModal" style="background-color: #0594eb!important;">Enquiry Now!</button>
                    <?php }else{ ?>
                        <button class="btn btn-sm btn-primary border-0 float-end" onclick="submitQueryQcpictures('<?php echo newSession()->cusAll->email;?>','<?php echo $album->album_id;?>')" style="background-color: #0594eb!important;">Enquiry Now!</button>
                    <?php } ?>
                </div>
                <div class="col-4 col-md-3 mt-4 text-center position-relative">
                    <?php $img = str_replace("pro_", "", $album->thumb); $url = base_url('uploads/album/'.$album->album_id.'/600_wm_'.$img); ?>
                    <a class="example-image-link" href="<?= $url;?>" data-lightbox="example-set">
                        <img data-sizes="auto" data-albumId="<?php echo $album->album_id;?>" data-imageId=""  id="<?php echo $album->album_id.'_image';?>" src="<?php echo product_image_view('uploads/album', $album->album_id, $album->thumb, 'noimage.png',  '261', '261') ?>" alt="<?php echo $album->alt_name?>" class="<?php echo $album->album_id.'_image';?>" loading="lazy">
                    </a>

                    <div id="dowBtn">
                        <button class="btn btn-dow position-absolute" onclick="album_download_btn_show('<?= $album->album_id;?>')"  ><i class="fa-solid fa-download "></i></button>
                        <div class="album-btn-group_<?= $album->album_id;?> btn-group-al position-absolute"  >
                            <a href="javascript:void(0)"  onclick="album_watermark_image_download('watermark','<?= $album->album_id;?>_image')"  download class=" btn-w-2nd">Watermark Image</a><br>
                            <?php if (isset($_COOKIE['download_image'])){ ?>
                                <a href="javascript:void(0)" onclick="album_watermark_image_download('nowatermark','<?= $album->album_id;?>_image')" class=" btn-w-2nd">Without Watermark Image</a>
                            <?php }else{?>
                                <a href="javascript:void(0)" onclick="show_form_alb('<?= $album->album_id;?>')" class="btn-w-2nd">Without Watermark Image</a>
                            <?php } ?>
                        </div>
                        <div class="album-btn-group_form_<?= $album->album_id;?> dw-input-group_al position-absolute">
                            <input type="text" name="subs_email" placeholder="Input email" id="subs_email_<?= $album->album_id;?>" >
                            <button class="btn btn-email" onclick="subscribe_album('subs_email_','<?= $album->album_id;?>')" >Submit</button>
                        </div>
                    </div>
                </div>
                <?php foreach ($albumAll as $val){ $img2 = str_replace("pro_", "", $val->image); $url2 = base_url('uploads/album/'.$val->album_id.'/'.$val->album_details_id.'/600_wm_'.$img2); ?>
                <div class="col-4 col-md-3 mt-4 text-center position-relative">
                    <a class="example-image-link" href="<?= $url2;?>" data-lightbox="example-set" >
                        <img data-sizes="auto" data-albumId="<?php echo $val->album_id;?>" data-imageId="<?php echo $val->album_details_id;?>"  id="<?php echo $val->album_details_id.'_dt_image'?>" src="<?php echo product_multi_image_view('uploads/album', $val->album_id, $val->album_details_id,  $val->image, 'noimage.png', '261','261');?>" alt="<?php echo $val->alt_name?>" class="img-fluid" loading="lazy">
                    </a>
                    <div id="dowBtn">
                        <button class="btn btn-dow position-absolute" onclick="album_download_btn_show('det_<?= $val->album_details_id;?>')"  ><i class="fa-solid fa-download "></i></button>
                        <div class="album-btn-group_det_<?= $val->album_details_id;?> btn-group-al position-absolute"  >
                            <a href="javascript:void(0)"  onclick="album_watermark_image_download('watermark','<?= $val->album_details_id;?>_dt_image')"  download class=" btn-w-2nd">Watermark Image</a><br>
                            <?php if (isset($_COOKIE['download_image'])){ ?>
                                <a href="javascript:void(0)" onclick="album_watermark_image_download('nowatermark','<?= $val->album_details_id;?>_dt_image')" class=" btn-w-2nd">Without Watermark Image</a>
                            <?php }else{?>
                                <a href="javascript:void(0)" onclick="show_form_alb('det_<?= $val->album_details_id;?>')" class="btn-w-2nd">Without Watermark Image</a>
                            <?php } ?>
                        </div>
                        <div class="album-btn-group_form_det_<?= $val->album_details_id;?> dw-input-group_al position-absolute">
                            <input type="text" name="subs_email" placeholder="Input email" id="subs_email_det_<?= $val->album_details_id;?>" >
                            <button class="btn btn-email" onclick="subscribe_album('subs_email_','det_<?= $val->album_details_id;?>')" >Submit</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-12 mt-5">
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="queryModal" tabindex="-1" aria-labelledby="queryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">In Query</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="email"  class="form-label">Email address </label>
                    <input type="email"  class="form-control" id="email" placeholder="name@example.com">
                    <span class="text-danger" id="errMss" ></span>
                    <input type="hidden"  class="form-control" id="album_id" value="<?php echo $album->album_id;?>">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitQueryForm()">Send Request</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('java_script') ?>
<script>
    function download_btn_show(){
        $('.dw-btn-group').show();
    }
    function show_form(){
        $('.dw-input-group').show();
    }
    //QC Pictures query(start)
    function submitQueryForm(){
        var email = $('#email').val();
        var albumId = $('#album_id').val();
        if (email == ''){
            $('#errMss').html('Please input email');
        }else {
            if (validateEmail(email) == true ) {
                submitQueryQcpictures(email,albumId);
            }else {
                $('#errMss').html('Please input valid email');
            }
        }
    }

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }

    function submitQueryQcpictures(email,albumId){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('qc-picture-query') ?>",
            data: {
                [csrfName]: csrfHash,
                email: email,
                album_id: albumId,
            },
            success: function (response) {
                $('#email').val('');
                $('#queryModal').modal('hide');
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }
    //QC Pictures query(end)


    function album_download_btn_show(proId){
        $('.album-btn-group_'+proId).show();
    }

    function show_form_alb(proId){
        $('.album-btn-group_form_'+proId).show();
        $('.album-btn-group_'+proId).hide();
    }

    function album_watermark_image_download(condition,imgId){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');

        var albumId = $('#'+imgId).attr('data-albumId');
        var imageId = $('#'+imgId).attr('data-imageId');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('album-image-download') ?>",
            data: {
                [csrfName]: csrfHash,album_id: albumId,image_id:imageId,condition:condition
            },
            dataType: 'json',
            success: function(response) {
                var a = $("<a>").attr("href", response.downloadUrl).attr("download", "download_album_img.jpg").appendTo("body");
                a[0].click();
                a.remove();
                $('.btn-group-al').hide();

                if (response.unlinkUrl.trim() !== '') {
                    albumImageUnlink(response.unlinkUrl);
                }
            }
        });
    }

    function albumImageUnlink(unlinkUrl){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('album-image-unlink') ?>",
            data: {
                [csrfName]: csrfHash,
                url: unlinkUrl
            }
        });
    }

    function subscribe_album(emailID,proId) {
        var email = $('#'+emailID+proId).val();

        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailRegex.test(email)) {
            $('#mesVal').html('Email required');
            $('.message_alert').show();
            setTimeout(function() {
                $("#messAlt").fadeOut(1500);
            }, 600);
        } else {
            let csrfName = $('meta[name="csrf-name"]').attr('content');
            let csrfHash = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('user_subscribe') ?>",
                data: {
                    [csrfName]: csrfHash,
                    email: email
                },
                success: function(response) {
                    $('#'+emailID+proId).val('');
                    $('#mesVal').html(response);
                    $('.message_alert').show();
                    $('.album-btn-group_form_'+proId).hide();
                    $('.album-btn-group_'+proId).hide();
                    setTimeout(function() {
                        $("#messAlt").fadeOut(1500);
                    }, 600);
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>
