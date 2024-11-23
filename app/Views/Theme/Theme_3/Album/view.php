<section class="main-container my-0">
    <div class="container">
        <div class="contact-form bg-white  py-4 mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> <?= $album->name?></h3>
                </div>
                <div class="col-4 col-md-3 mt-4 text-center ">
                    <?php $img = str_replace("pro_", "", $album->thumb); $url = base_url('uploads/album/'.$album->album_id.'/wm_'.$img); ?>
                    <a class="example-image-link" href="<?= $url;?>" data-lightbox="example-set">
                    <?php echo image_view('uploads/album',$album->album_id,'261_wm_'.$album->thumb,'noimage.png','');?>
                    </a>
                </div>
                <?php foreach ($albumAll as $val){ $img2 = str_replace("pro_", "", $val->image); $url2 = base_url('uploads/album/'.$val->album_id.'/'.$val->album_details_id.'/wm_'.$img2); ?>
                <div class="col-4 col-md-4 mt-4 text-center ">
                    <a class="example-image-link" href="<?= $url2;?>" data-lightbox="example-set" >
                    <?php echo multi_image_view('uploads/album', $val->album_id, $val->album_details_id, '261_wm_' . $val->image, 'noimage.png', 'img-fluid');?>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>