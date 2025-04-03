<section class="main-container my-0">
    <div class="container">
        <div class=" bg-white  py-4  mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> Offers</h3>
                </div>
                <div class="col-lg-12 ">
                    <ul>
                        <?php $i = 1; foreach ($offers as $val){ ?>
                        <li><a href="<?= base_url('offers-view/'.$val->slug)?>"><?= $i++;?>.  <?= $val->name;?></a></li>
                        <?php } ?>
                    </ul>
                </div>



            </div>
        </div>
    </div>
</section>