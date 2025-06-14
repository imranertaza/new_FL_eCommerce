<section class="main-container my-0">
    <div class="container">
        <div class=" bg-white  py-4  mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> <?= $offer->name;?></h3>
                </div>
                <div class="col-lg-12 text-center">
                    <?php echo common_image_view('uploads/offer', $offer->offer_id, $offer->banner, 'noimage.png', '', '', '880', '400');?>
                </div>

                <div class="col-lg-12 mt-4">
                    <p><?= $offer->description;?></p>
                </div>
                <div class="col-lg-12 mt-4">
                    <h4 class="text-capitalize"> Offer On Products</h4>
                    <ul>
                        <?php $i = 1; foreach ($products as $val){ ?>
                            <li><a href="<?= base_url('detail/'.$val->product_id)?>"><?= $i++;?>.  <?= get_data_by_id('name','cc_products','product_id',$val->product_id);?></a></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>