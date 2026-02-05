<?= $this->extend('Theme/Theme_3/layout') ?>
<?= $this->section('content') ?>
    <div class="main-container" id="tableReload2">
        <div class="container">
            <div class="cart">
                <div class="row">
                    <?php if (!empty($schedule)){ ?>
                    <div class="col-md-12 px-0">
                        <img data-sizes="auto"   src="<?= common_image_view('uploads/sections', '', $schedule->banner, 'noimageBn.png', '1140', '211');?>" alt="<?= $schedule->banner_alt_name?>" class="img-fluid" loading="lazy">
                    </div>
                    <?php }?>

                    <div class="row gx-0 row-cols-1 row-cols-sm-2 row-cols-md-4 h-100 mt-5 " >
                        <?php $modules = modules_access();
                        $symbol = get_lebel_by_value_in_settings('currency_symbol');
                        if (!empty($result)) {
                            foreach ($result as $pro) { ?>
                                <div class="col border p-2">
                                    <div class="product-grid h-100 d-flex align-items-stretch flex-column position-relative">
                                        <?php if ($modules['wishlist'] == 1) { ?>
                                            <?php if (!isset(newSession()->isLoggedInCustomer)) { ?>

                                                <a href="<?php echo base_url('login'); ?>"
                                                   class="btn-wishlist position-absolute  mt-2 ms-2"><i
                                                            class="fa-solid fa-heart"></i>
                                                    <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                                                </a>

                                            <?php } else { ?>

                                                <button type="button"
                                                        class="border-0 btn-wishlist position-absolute mt-2 ms-2"
                                                        onclick="addToWishlist(<?php echo $pro->product_id ?>)"><i
                                                            class="fa-solid fa-heart"></i>
                                                    <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                                                </button>

                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($modules['compare'] == 1) { ?>

                                            <button type="button"
                                                    onclick="addToCompare(<?php echo $pro->product_id ?>)"
                                                    class="border-0 btn-compare position-absolute  mt-5 ms-2"><i
                                                        class="fa-solid fa-code-compare"></i>
                                                <span class="btn-compare-text position-absolute  mt-5 ms-2">Compare</span>
                                            </button>

                                        <?php } ?>

                                        <div class="product-top text-center">
                                            <a href="<?php echo base_url('detail/' . $pro->product_id) ?>">
                                                <img data-sizes="auto"   src="<?php echo product_image_view('uploads/products', $pro->product_id, $pro->image, 'noimage.png', '191', '191');?>" alt="<?php echo $pro->alt_name?>" class="img-fluid " loading="lazy">
                                            </a>
                                            <div class="rating text-center my-2">
                                                <?php //echo product_id_by_rating($pro->product_id); ?>
                                            </div>
                                        </div>
                                        <div class="product-bottom mt-auto">
                                            <div class="product-title mb-2">
                                                <a href="<?php echo base_url('detail/' . $pro->product_id) ?>"><?php echo substr($pro->name, 0, 60); ?></a>
                                            </div>
                                            <div class="price mb-3">
                                                <?php $spPric = get_data_by_id('special_price', 'cc_product_special', 'product_id', $pro->product_id);
                                                if (empty($spPric)) { ?>
                                                    <?php echo currency_symbol_with_symbol($pro->price,$symbol); ?>
                                                <?php } else { ?>
                                                    <small class="off-price">
                                                        <del><?php echo currency_symbol_with_symbol($pro->price,$symbol); ?></del>
                                                    </small> <?php echo currency_symbol_with_symbol($spPric,$symbol); ?>
                                                <?php } ?>
                                            </div>
                                            <?php echo addToCartBtn($pro->product_id); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            echo 'No product available';
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>