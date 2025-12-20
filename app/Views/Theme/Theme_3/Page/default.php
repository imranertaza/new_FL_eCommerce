<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
<div class="main-container my-0">
    <div class="container">
        <div class="contact-form bg-white  py-4  mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                   <h3 class="text-capitalize mb-4"><?php echo $pageData->page_title;?></h3>
                    <?php echo $pageData->page_description;?>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>