<section class="banner">
    <div class="container">
        <div class="row gx-0">
            <div class="col-xl-9 offset-xl-3 d-flex flex-column flex-lg-row">
                <div class="swiper bannerSlide me-1">
                    <div class="swiper-wrapper">
                    <?php $sli_1 = get_lebel_by_value_in_theme_settings('slider_1'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_1, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                        <?php $sli_2 = get_lebel_by_value_in_theme_settings('slider_2'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_2, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                        <?php $sli_3 = get_lebel_by_value_in_theme_settings('slider_3'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_3, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="side-banner d-flex flex-column flex-sm-row flex-lg-column gap-1">
                    <div class="side-banner-box position-relative h-50">                        
                        <?php
                            $side_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_1',$theme);
                            echo image_view('uploads/top_side_baner', '', $side_baner_1, 'noimage.png', 'img-fluid w-100 h-100');
                        ?>
                        <div class="position-absolute top-0 p-3">
                            <h4><?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_1',$theme);?></h4>
                            <a class="btn btn-sidebanner" href="<?php echo base_url('category/'.get_lebel_by_value_in_theme_settings_with_theme('head_side_category_1',$theme)); ?>">
                                Shop Now                                
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L17.25 12L12 6.75L12.66 6L19.16 12.5L12.66 19L12 18.25L17.25 13L5 13L5 12Z" fill="#818181"/>
                                </svg>    
                            </a>
                        </div>
                    </div>
                    <div class="side-banner-box position-relative h-50">
                        <?php
                            $side_baner_2 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_2',$theme);
                            echo image_view('uploads/top_side_baner', '', $side_baner_2, 'noimage.png', 'img-fluid w-100 h-100');
                        ?>

                        <div class="position-absolute top-0 p-3">
                            <h4><?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_2',$theme);?></h4>
                            <a class="btn btn-sidebanner" href="<?php echo base_url('category/'.get_lebel_by_value_in_theme_settings_with_theme('head_side_category_2',$theme)); ?>" >
                                Shop Now                                
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L17.25 12L12 6.75L12.66 6L19.16 12.5L12.66 19L12 18.25L17.25 13L5 13L5 12Z" fill="#818181"/>
                                </svg>    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-container">
    <div class="container">
        <div class="featured-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header">Featured Category</h3>
                    </div>
                </div>
            </div>
            <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-3 row-cols-2 row-cols-1">
            <?php
                    foreach ($populerCat as $key => $catPop) {
                    $icon_id = get_data_by_id('icon_id', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id);
                    $icon = get_data_by_id('code', 'cc_icons', 'icon_id', $icon_id);
                    $imageCat = get_data_by_id('image', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id);
                ?>
                <div class="col">
                    <a href="<?php echo base_url('category/'.$catPop->prod_cat_id) ?>">   
                    <?php echo image_view('uploads/category', '', $imageCat, 'noimage.png', 'w-100'); ?>
                    <div class="category-title"><?php echo get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id); ?></div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_1',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="apparels-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="apparels-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_1',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_1, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper apparelsSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_1',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_1);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_2',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="treasures-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="treasures-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_2 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_2',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_2, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper treasuresSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_2 = get_lebel_by_value_in_theme_settings_with_theme('home_category_2',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_2);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_3',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="bag-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="bag-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_3 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_3',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_3, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper bagSlide">
                            <div class="swiper-wrapper">
                                <?php 
                                    $home_category_3 = get_lebel_by_value_in_theme_settings_with_theme('home_category_3',$theme); 
                                    echo get_category_id_by_product_show_home_slide($home_category_3);                                  
                                        
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_4',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="jewelry-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="jewelry-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_4 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_4',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_4, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper jewelrySlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_4 = get_lebel_by_value_in_theme_settings_with_theme('home_category_4',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_4);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_5',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="shoes-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="shoes-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_5 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_5',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_5, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper shoesSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_5 = get_lebel_by_value_in_theme_settings_with_theme('home_category_5',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_5);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-banner mb-5">
            <?php
                $banner_bottom = get_lebel_by_value_in_theme_settings_with_theme('banner_bottom',$theme);
                echo image_view('uploads/banner_bottom', '', $banner_bottom, 'noimage.png', 'w-100');
            ?>
        </div>

        <div class="brands-slide mb-5">
            <div class="brands-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header">Brands</h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="brands-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="brands-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="border p-4">
                <div class="swiper brandsSlide">
                    <div class="swiper-wrapper">
                    <?php foreach($brand as $br){ ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/brand', '', $br->image, 'noimage.png', 'w-100') ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>                
        </div>
    </div>
    
    <div class="popular-category">
        <div class="container">
            <div class="text-center mb-5">
                <h5>Category</h5>
                <h2>Shop by Category</h2>
            </div>
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5">
                <?php foreach($shop_by as $valShop){ ?>        
                <div class="col mb-5">
                    <a href="<?php echo base_url('category/' . $valShop->prod_cat_id);?>" >
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center brand-icon">                                
                            
                            <?php 
                                $icon_id = get_data_by_id('icon_id','cc_product_category','prod_cat_id',$valShop->prod_cat_id);
                                echo get_data_by_id('code','cc_icons','icon_id',$icon_id);  
                            ?>
                            <h4><?php echo get_data_by_id('category_name','cc_product_category','prod_cat_id',$valShop->prod_cat_id)  ?></h4>
                        </div>
                    </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>