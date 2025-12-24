<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
<div class="main-container my-0">
    <div class="container">
        <div class=" bg-white  py-4  mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> <?php echo $page_title; ?></h3>
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
                <?php if (!empty($qcpicture)){ foreach ($qcpicture as $val){ if (!empty(idByShowPermission($val->album_id))){ ?>
                <div class="col-3 col-md-3 mt-4 text-center">
                    <?php if ($val->is_parent == 1){ ?>
                        <a href="<?= base_url('qc-picture-view-category/'.$val->album_id);?>">
                    <?php }else{ ?>
                        <a href="<?= base_url('qc-picture-view/'.$val->album_id);?>">
                    <?php }?>

                    <img data-sizes="auto"  id="" src="<?php echo product_image_view('uploads/album', $val->album_id, $val->thumb, 'noimage.png', '261', '261') ?>" alt="<?php echo $val->alt_name?>" class="img-fluid" loading="lazy">
                        <p class="text-capitalize text-black mt-3"><b><?php echo $val->name; ?></b></p>
                    </a>
                </div>
                <?php } } }else{ echo '<h4 class="text-center text-danger">Album not found</h4>'; } ?>

                <div class="row">
                <div class="col-lg-4 ">
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary mt-4" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
                <div class="col-lg-8 ">
                    <?php echo $links; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>