<section class="main-container">
    <div class="container">

        <div class="product-category mb-5">


            <form action="<?php echo base_url('category_url_generate') ?>" method="post" id="searchForm">
                <input type="hidden" name="global_search" value="<?php echo $keywordSearch;?>">

                <div class="row">
                    <div class="col-md-3" id="side-data"></div>
                    <div class="col-md-9 " style="padding-left: 3px;">
                        <div class="top-bar border">
                            <div class="row">
                                <div class="col-4 col-md-4">
                                    <a href="javascript:void(0)" onclick="viewStyle('gird')" id="gird-btn"
                                       class="d-inline-block border p-2 active-view">
                                        <svg aria-hidden="true" focusable="false" width="20px" height="20px"
                                             data-prefix="fas" data-icon="grid" role="img"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                             class="svg-inline--fa fa-grid fa-lg icon-vart">
                                            <path fill="currentColor"
                                                  d="M0 72C0 49.9 17.9 32 40 32H88c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V72zM0 232c0-22.1 17.9-40 40-40H88c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V232zM128 392v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V392c0-22.1 17.9-40 40-40H88c22.1 0 40 17.9 40 40zM160 72c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V72zM288 232v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V232c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40zM160 392c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V392zM448 72v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V72c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40zM320 232c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V232zM448 392v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V392c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40z"
                                                  class=""></path>
                                        </svg>
                                    </a>

                                    <a href="javascript:void(0)" onclick="viewStyle('list')" id="list-btn"
                                       class="d-inline-block border p-2">
                                        <svg aria-hidden="true" focusable="false" width="20px" height="20px"
                                             data-prefix="fas" data-icon="list-ul" role="img"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                             class="svg-inline--fa fa-list-ul fa-lg icon-vart">
                                            <path fill="currentColor"
                                                  d="M64 144a48 48 0 1 0 0-96 48 48 0 1 0 0 96zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM64 464a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm48-208a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z"
                                                  class=""></path>
                                        </svg>
                                    </a>

                                    <!--                                        Items --><?php //echo count($products);?>
                                </div>

                                <div class="col-8 col-md-8">

                                    <div class="form-group float-end">
                                        <label class="d-none d-sm-inline">Sort By</label>
                                        <select name="shortBy" onchange="formSubmit()" class="shortBy border">
                                            <option value="" <?php echo ((isset($_GET['shortBy'])) && ($_GET['shortBy'] == '')) ? 'selected' : ''; ?>>
                                                Position
                                            </option>
                                            <option value="name" <?php echo ((isset($_GET['shortBy'])) && ($_GET['shortBy'] == 'name')) ? 'selected' : ''; ?> >
                                                Product Name
                                            </option>
                                            <option value="price_asc" <?php echo ((isset($_GET['shortBy'])) && ($_GET['shortBy'] == 'price_asc')) ? 'selected' : ''; ?>>
                                                Price(Low to High)
                                            </option>
                                            <option value="price_desc" <?php echo ((isset($_GET['shortBy'])) && ($_GET['shortBy'] == 'price_desc')) ? 'selected' : ''; ?>>
                                                Price(High to Low)
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group float-end me-2">
                                        <label class="d-none d-sm-inline">Show</label>
                                        <select name="show" onchange="formSubmit()" class="shortBy border">
                                            <option value="<?php echo get_lebel_by_value_in_settings('category_product_limit'); ?>" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == get_lebel_by_value_in_settings('category_product_limit'))) ? 'selected' : ''; ?>><?php echo get_lebel_by_value_in_settings('category_product_limit'); ?></option>
                                            <option value="10" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '10')) ? 'selected' : ''; ?>>
                                                10
                                            </option>
                                            <option value="20" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '20')) ? 'selected' : ''; ?>>
                                                20
                                            </option>
                                            <option value="25" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '25')) ? 'selected' : ''; ?>>
                                                25
                                            </option>
                                            <option value="50" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '50')) ? 'selected' : ''; ?>>
                                                50
                                            </option>
                                            <option value="75" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '75')) ? 'selected' : ''; ?>>
                                                75
                                            </option>
                                            <option value="100" <?php echo ((isset($_GET['show'])) && ($_GET['show'] == '100')) ? 'selected' : ''; ?>>
                                                100
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="products cat-pro-mob">
                            <div class="row gx-0 row-cols-1 row-cols-sm-2 row-cols-md-3 h-100 " id="grid-view">
                                <?php $modules = modules_access(); $symbol = get_lebel_by_value_in_settings('currency_symbol');
                                if (!empty($products)) {
                                    foreach ($products as $pro) { ?>
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

                                                        <a href="javascript:void(0)"
                                                           class="btn-wishlist position-absolute mt-2 ms-2"
                                                           onclick="addToWishlist(<?php echo $pro->product_id ?>)"><i
                                                                    class="fa-solid fa-heart"></i>
                                                            <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                                                        </a>

                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($modules['compare'] == 1) { ?>

                                                    <a href="javascript:void(0)"
                                                       onclick="addToCompare(<?php echo $pro->product_id ?>)"
                                                       class="btn-compare position-absolute  mt-5 ms-2"><i
                                                                class="fa-solid fa-code-compare"></i>
                                                        <span class="btn-compare-text position-absolute  mt-5 ms-2">Compare</span>
                                                    </a>

                                                <?php } ?>

                                                <div class="product-top text-center">
                                                    <a href="<?php echo base_url('detail/' . $pro->product_id) ?>"><?php echo image_view('uploads/products', $pro->product_id, '191_' . $pro->image, 'noimage.png', 'img-fluid ') ?></a>
                                                    <div class="rating text-center my-2">
                                                        <?php echo product_id_by_rating($pro->product_id); ?>
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


                            <div class="row gx-0 row-cols-1 row-cols-sm-2 row-cols-md-3 h-100 " id="list-view"
                                 style="display: none;">
                                <?php foreach ($products as $pro) { ?>
                                    <div class="col-md-12 border p-2 ">
                                        <div class="product-grid h-100 d-flex align-items-stretch  position-relative">
                                            <?php if ($modules['wishlist'] == 1) { ?>
                                                <?php if (!isset(newSession()->isLoggedInCustomer)) { ?>

                                                    <a href="<?php echo base_url('login'); ?>"
                                                       class="btn-wishlist position-absolute  mt-2 ms-2"
                                                       style="bottom:58%;"><i class="fa-solid fa-heart"></i>
                                                        <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                                                    </a>

                                                <?php } else { ?>

                                                    <a href="javascript:void(0)"
                                                       class="btn-wishlist position-absolute mt-2 ms-2"
                                                       style="bottom:57%;"
                                                       onclick="addToWishlist(<?php echo $pro->product_id ?>)"><i
                                                                class="fa-solid fa-heart"></i>
                                                        <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                                                    </a>

                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($modules['compare'] == 1) { ?>

                                                <a href="javascript:void(0)"
                                                   onclick="addToCompare(<?php echo $pro->product_id ?>)"
                                                   class="btn-compare position-absolute  mt-5 ms-2"><i
                                                            class="fa-solid fa-code-compare"></i>
                                                    <span class="btn-compare-text position-absolute  mt-5 ms-2">Compare</span>
                                                </a>

                                            <?php } ?>

                                            <div class="product-top text-center" style="width:40%;float:left; ">
                                                <a href="<?php echo base_url('detail/' . $pro->product_id) ?>"><?php echo image_view('uploads/products', $pro->product_id, '198_' . $pro->image, 'noimage.png', 'img-fluid ') ?></a>

                                            </div>


                                            <div class="product-bottom " style="width:60%;float:left; padding: 15px;">
                                                <div class="product-title mb-2">
                                                    <a href="<?php echo base_url('detail/' . $pro->product_id) ?>"><?php echo $pro->name; ?></a>
                                                </div>
                                                <div class="brand mb-3">
                                                    <strong>Brand:</strong> <?php echo get_data_by_id('name', 'cc_brand', 'brand_id', $pro->brand_id); ?>
                                                </div>

                                                <div class="rating my-2">
                                                    <?php echo product_id_by_rating($pro->product_id); ?>
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
                                <?php } ?>
                            </div>


                        </div>


                    </div>
                    <div class="col-lg-12">

                        <?php echo $links; ?>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
    if ($(window).width() > 767) {
        var sidebarDesktop = `<div class="d-none d-md-block">
                                        <div class="title bg-custom-color text-white">
                                        <span class="title-hot category"><?php
        if (!empty($prod_cat_id)){
        $par_id = get_data_by_id('parent_id', 'cc_product_category', 'prod_cat_id', $prod_cat_id);
        if (!empty($par_id)) {
            $url = base_url('category/' . $par_id);
            echo '<a href="' . $url . '">' . get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $par_id) . '</a> <i class="fa-solid fa-angle-right"></i>';
        } $url2 = base_url('category/' . $prod_cat_id);
        ?> <a href="<?php echo $url2;?>" >  <?php echo get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $prod_cat_id);?> </a><?php }else {
            echo 'Search Result';
        } ?></span>
                                </div>
                                    <div class="card p-3 rounded-0 ">
                                        <?php if (empty($keywordSearch)){ ?>
                                        <div class="product-filter">
                                        <input type="hidden" name="prod_cat_id" value="<?php echo $prod_cat_id?>">
                                            <input type="hidden" name="cat" value="<?php echo $prod_cat_id?>">
                                            <?php if(!empty($parent_Cat)){ ?>
                                                <p class="mb-2">Sub Category</p>
                                                    <ul class="list-unstyled lh-lg">
                                                        <?php $i = 1;$j = 1; foreach ($parent_Cat as $cat){ ?>
                                                        <li>
                                                            <div class="form-check d-flex flex-row align-items-center gap-1">
                                                                <input class="form-check-input" onclick="formSubmit()" <?php echo ((isset($_GET['category'])) && ($_GET['category'] == $cat->prod_cat_id)) ? 'checked' : ''; ?>  name="category" type="radio" value="<?php echo $cat->prod_cat_id;?>" id="flexCheck_<?php echo $i++;?>">
                                                                    <label class="form-check-label w-100 mb-0" for="flexCheck_<?php echo $j++;?>">
                                                                        <?php echo $cat->category_name;?> <span class="count"><?php echo category_id_by_product_count($cat->prod_cat_id)?></span>
                                                                    </label>
                                                            </div>


                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } else{ if (!empty($main_Cat)){?>
                                                    <p class="mb-2">Category</p>
                                                    <ul class="lh-lg text-capitalize">
                                                        <?php  foreach ($main_Cat as $cat) { ?>
                                                        <li><a href="<?php echo base_url('category/' . $cat->prod_cat_id);?>"><?php echo $cat->category_name;?></a></li>
                                                        <?php } ?>
                                                    </ul>

                                            <?php } }?>
                                        </div>
                                        <?php } ?>

                                        <?php echo $brandView;?>

                                        <?php if (!empty($productsArr)){ ?>
                                        <div class="product-filter">
                                            <p class="mb-2">Filter Price</p>
                                            <p>
                                                <input type="text" id="amount"  readonly style="border:0;">
                                                    <input type="hidden" name="price" id="price"  >
                                            </p>
                                            <div class="slider-range" ></div>
                                        </div>
                                        <?php } ?>

                                       <?php echo $optionView;?>


                                       <?php //echo $ratingView;?>

                                    </div>
                                </div>`;
        $('#side-data').html(sidebarDesktop);
    } else {
        var sidebarMobile = `<div class="d-block d-md-none">
                                <button type="button" class="filterModal btn btn-primary bg-custom-color border-0 mb-4 rounded-0" data-bs-toggle="modal" data-bs-target="#filterModal" data-bs-whatever="@mdo">
                                    <i class="fa-solid fa-filter"></i> Shop By
                                </button>
                                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModal" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Shopping Options</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="title bg-custom-color text-white">
                                            <span class="title-hot"><?php
        if (!empty($prod_cat_id)){
        $par_id = get_data_by_id('parent_id', 'cc_product_category', 'prod_cat_id', $prod_cat_id);
        if (!empty($par_id)) {
            $url = base_url('category/' . $par_id);
            echo '<a href="' . $url . '">' . get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $par_id) . '</a> <i class="fa-solid fa-angle-right"></i>';
        } $url2 = base_url('category/' . $prod_cat_id);
        ?> <a href="<?php echo $url2;?>" ><?php echo get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $prod_cat_id);?> </a><?php }else {
            echo 'Search Result';
        } ?></span>
                                        </div>
                                        <div class="card p-3 rounded-0 ">
                                            <?php if (empty($keywordSearch)){ ?>
                                            <div class="product-filter">
                                                <?php if(!empty($parent_Cat)){ ?>
                                                <p class="mb-2">Sub Category</p>
                                                <input type="hidden" name="prod_cat_id" value="<?php echo $prod_cat_id?>">
                                                <input type="hidden" name="cat" value="<?php echo $prod_cat_id?>">
                                                <ul class="list-unstyled lh-lg">
                                                    <?php $i = 1;$j = 1; foreach ($parent_Cat as $cat){ ?>
                                                    <li>
                                                        <div class="form-check d-flex flex-row align-items-center gap-1">
                                                            <input class="form-check-input" onclick="formSubmit()" <?php echo ((isset($_GET['category'])) && ($_GET['category'] == $cat->prod_cat_id)) ? 'checked' : ''; ?>  name="category" type="radio" value="<?php echo $cat->prod_cat_id;?>" id="flexCheck_<?php echo $i++;?>">
                                                            <label class="form-check-label w-100 mb-0" for="flexCheck_<?php echo $j++;?>">
                                                                <?php echo $cat->category_name;?> <span class="count"><?php echo category_id_by_product_count($cat->prod_cat_id)?></span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>

                                                <?php } else{ if (!empty($main_Cat)){?>
                                                <p class="mb-2">Category</p>
                                                    <ul class="lh-lg text-capitalize">
                                                        <?php  foreach ($main_Cat as $cat) { ?>
                                                        <li><a href="<?php echo base_url('category/' . $cat->prod_cat_id);?>"><?php echo $cat->category_name;?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } }?>
                                            </div>
                                            <?php } ?>

                                            <?php echo $brandView;?>

                                            <?php if (!empty($productsArr)){ ?>
                                            <div class="product-filter">
                                                <p class="mb-2">Filter Price</p>
                                                <p>
                                                    <input type="text" id="amount"  readonly style="border:0;">
                                                    <input type="hidden" name="price" id="price"  >
                                                </p>
                                                <div class="slider-range" ></div>
                                            </div>
                                            <?php } ?>


                                            <?php echo $optionView;?>

                                            <?php //echo $ratingView;?>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>`;
        $('#side-data').html(sidebarMobile);
    }

    <?php //$price = product_array_by_price_range($products); ?>
    jQuery(function($) {
        $(".slider-range").slider({
            range: true,
            min: <?php print $price['minPrice']; ?>,
            max: <?php print $price['maxPrice']; ?>,
            values: [<?php print isset($fstprice) ? $fstprice : $price['minPrice']; ?>,
                <?php print isset($lstPrice) ? $lstPrice : $price['maxPrice']; ?>
            ],
            slide: function(event, ui) {
                $("#amount").val("" + ui.values[0] + " - " + ui.values[1]);
                $("#price").val("" + ui.values[0] + "," + ui.values[1]);
                $("#searchForm").submit();
            }
        });
        $("#amount").val("" + $(".slider-range").slider("values", 0) +
            " - " + $(".slider-range").slider("values", 1));
        $("#price").val("" + $(".slider-range").slider("values", 0) +
            "," + $(".slider-range").slider("values", 1));
    });
</script>