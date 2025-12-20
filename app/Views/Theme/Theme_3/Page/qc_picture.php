<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
<div class="main-container my-0">
    <div class="container">
        <div class="contact-form bg-white  py-4 mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12  ">
                    <h3 class="text-capitalize mb-4"><?php echo $pageData->page_title;?></h3>
                    <ul>
                        <?php foreach (parent_qc_picture() as $val){ if (!empty(idByShowPermission($val->album_id))){ ?>
                            <li>
                                <?php if ($val->is_parent == 1){ ?>
                                <a href="<?= base_url('qc-picture-view-category/'.$val->album_id);?>">
                                <?php }else{ ?>
                                <a href="<?= base_url('qc-picture-view/'.$val->album_id);?>">
                                <?php }?>
                                <?php echo $val->name; ?>
                            </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>