<section class="banner">
    <div class="container">
        <div class="row gx-0">
            <div class="col-xl-3 col-lg-3 col-sm-3 col-12 mb-2 mb-sm-0 cat-m-d">
                <div class="border cat-menu-static accordion-cat" >
                    <?= view('Theme/Theme_3/category_menu') ?>
                </div>
            </div>
            <div class="col-xl-9 col-sm-12 d-flex flex-column flex-lg-row">
                <div class="swiper bannerSlide me-1">
                    <div class="swiper-wrapper">
                        <?php $sli_1 = get_lebel_by_value_in_theme_settings('slider_1'); ?>
                        <div class="swiper-slide">
                            <?php echo common_image_view('uploads/slider', '', $sli_1, 'noimage.png', 'img-fluid w-100', '', '605', '401');?>
                        </div>
                        <?php $sli_2 = get_lebel_by_value_in_theme_settings('slider_2'); ?>
                        <div class="swiper-slide">
                            <?php echo common_image_view('uploads/slider', '', $sli_2, 'noimage.png', 'img-fluid w-100', '', '605', '401');?>
                        </div>
                        <?php $sli_3 = get_lebel_by_value_in_theme_settings('slider_3'); ?>
                        <div class="swiper-slide">
                            <?php echo common_image_view('uploads/slider', '', $sli_3, 'noimage.png', 'img-fluid w-100', '', '605', '401');?>
                        </div>
                        <?php $sli_4 = get_lebel_by_value_in_theme_settings('slider_4'); ?>
                        <div class="swiper-slide">
                            <?php echo common_image_view('uploads/slider', '', $sli_4, 'noimage.png', 'img-fluid w-100', '', '605', '401');?>
                        </div>
                        <?php $sli_5 = get_lebel_by_value_in_theme_settings('slider_5'); ?>
                        <div class="swiper-slide">
                            <?php echo common_image_view('uploads/slider', '', $sli_5, 'noimage.png', 'img-fluid w-100', '', '605', '401');?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <?php $theme_settings = get_theme_settings();?>
                <div class="side-banner d-flex flex-column flex-sm-row flex-sm-row flex-lg-column gap-1" id="bannerSiderParent">
                    <div class="side-banner-box position-relative text-center custom-d-50 w-100">
                        <a href="<?php echo !empty($theme_settings['head_side_url_1'])?$theme_settings['head_side_url_1']:base_url('category/'.$theme_settings['head_side_category_1']); ?>">
                            <?php
                                $side_baner_1 = $theme_settings['head_side_baner_1'];
                            ?>
                            <?php echo common_image_view('uploads/top_side_baner', '', $side_baner_1, 'noimage.png', 'img-fluid ', '', '228', '199');?>
                            <div class="position-absolute sid-text-n top-0 p-3">
                                <h4><?php echo $theme_settings['head_side_title_1'];?></h4>
                            </div>
                        </a>
                    </div>
                    <div class="side-banner-box position-relative text-center custom-d-50 w-100">
                        <a   href="<?php echo !empty($theme_settings['head_side_url_2'])?$theme_settings['head_side_url_2']:base_url('category/'.$theme_settings['head_side_category_2']); ?>" >
                            <?php
                                $side_baner_2 = $theme_settings['head_side_baner_2'];
                            ?>
                            <?php echo common_image_view('uploads/top_side_baner', '', $side_baner_2, 'noimage.png', 'img-fluid ', '', '228', '199');?>

                            <div class="position-absolute sid-text-n top-0 p-3">
                                <h4><?php echo $theme_settings['head_side_title_2'];?></h4>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-container">
    <div class="container">
        <div class="featured-category mb-5">
            <a href="<?php echo !empty($theme_settings['banner_top_category_url'])?$theme_settings['banner_top_category_url']:base_url('category/'.$theme_settings['banner_top_category']); ?>">
            <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-3 row-cols-2 row-cols-1">

                <?php $banner_top = $theme_settings['banner_top']; ?>
                <?php echo common_image_view('uploads/banner_top', '', $banner_top, 'noimage.png', 'w-100', '', '1116', '211');?>
            </div>
            </a>
        </div>
        <a href="<?php echo !empty($theme_settings['banner_featured_category_url'])?$theme_settings['banner_featured_category_url']:base_url('category/'.$theme_settings['banner_featured_category_category']); ?>">
        <div class="home-banner mb-5">
            <?php $banner_bottom = $theme_settings['banner_featured_category'];  ?>
            <?php echo common_image_view('uploads/banner_featured_category', '', $banner_bottom, 'noimage.png', 'w-100', '', '1116', '211');?>
        </div>
        </a>

        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo $theme_settings['home_category_title_1'];?></h3>
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
                    <a href="<?php echo !empty($theme_settings['home_category_url_1'])?$theme_settings['home_category_url_1']:base_url('category/'.$theme_settings['home_category_1']); ?>">
                    <?php $category_baner_1 = $theme_settings['home_category_baner_1']; ?>
                    <?php echo common_image_view('uploads/home_category', '', $category_baner_1, 'noimage.png', 'w-100 h-cat-ban', '', '261', '522');?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper apparelsSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_1 = $theme_settings['home_category_1'];
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
                        <h3 class="title-header"><?php echo $theme_settings['home_category_title_2'];?></h3>
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
                    <a href="<?php echo !empty($theme_settings['home_category_url_2'])?$theme_settings['home_category_url_2']:base_url('category/'.$theme_settings['home_category_2']); ?>">
                    <?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_2'], 'noimage.png', 'w-100 h-cat-ban', '', '261', '522');?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper treasuresSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_2 = $theme_settings['home_category_2'];
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
                        <h3 class="title-header"><?php echo $theme_settings['home_category_title_3'];?></h3>
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
                    <a href="<?php echo !empty($theme_settings['home_category_url_3'])?$theme_settings['home_category_url_3']:base_url('category/'.$theme_settings['home_category_3']); ?>">
                    <?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_3'], 'noimage.png', 'w-100 h-cat-ban', '', '261', '522');?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper bagSlide">
                            <div class="swiper-wrapper">
                                <?php 
                                    $home_category_3 = $theme_settings['home_category_3'];
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
                        <h3 class="title-header"><?php echo $theme_settings['home_category_title_4'];?></h3>
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
                    <a href="<?php echo !empty($theme_settings['home_category_url_4'])?$theme_settings['home_category_url_4']:base_url('category/'.$theme_settings['home_category_4']); ?>">
                    <?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_4'], 'noimage.png', 'w-100 h-cat-ban', '', '261', '522');?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper jewelrySlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_4 = $theme_settings['home_category_4'];
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
                        <h3 class="title-header"><?php echo $theme_settings['home_category_title_5'];?></h3>
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
                    <a href="<?php echo !empty($theme_settings['home_category_url_5'])?$theme_settings['home_category_url_5']:base_url('category/'.$theme_settings['home_category_5']); ?>">
                    <?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_5'], 'noimage.png', 'w-100 h-cat-ban', '', '261', '522');?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper shoesSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_5 = $theme_settings['home_category_5'];
                                echo get_category_id_by_product_show_home_slide($home_category_5);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-banner mb-5">
            <a href="<?php echo !empty($theme_settings['banner_bottom_url'])?$theme_settings['banner_bottom_url']:base_url('category/'.$theme_settings['banner_bottom_category']); ?>">
            <?php echo common_image_view('uploads/banner_bottom', '', $theme_settings['banner_bottom'], 'noimage.png', 'w-100', '', '1116', '422');?>
            </a>
        </div>
    </div>
</section>