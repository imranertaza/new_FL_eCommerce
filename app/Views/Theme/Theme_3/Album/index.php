<section class="main-container my-0">
    <div class="container">
        <div class="contact-form bg-white  py-4  mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> Qc Picture</h3>
                </div>
                <?php if (!empty($qcpicture)){ foreach ($qcpicture as $val){ ?>
                <div class="col-3 col-md-3 mt-4 text-center">
                    <?php if ($val->is_parent == 1){ ?>
                        <a href="<?= base_url('qc-picture-view-category/'.$val->album_id);?>">
                    <?php }else{ ?>
                        <a href="<?= base_url('qc-picture-view/'.$val->album_id);?>">
                    <?php }?>
                        <?php echo image_view('uploads/album',$val->album_id,'261_wm_'.$val->thumb,'noimage.png','');?>
                        <p class="text-capitalize text-black mt-3"><b><?php echo $val->name; ?></b></p>
                    </a>
                </div>
                <?php } }else{ echo '<h4 class="text-center text-danger">Album not found</h4>'; } ?>

                <div class="col-lg-12">
                    <?php echo $links; ?>
                </div>
            </div>
        </div>
    </div>
</section>