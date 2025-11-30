<section class="banner">
    <div class="container">
        <div class="row gx-0">
            <div class="col-xl-3 col-lg-3 col-sm-3 col-12 mb-2 mb-sm-0 cat-m-d">
                <div class="border cat-menu-static accordion-cat" >
                    <?= view('Theme/Theme_3/category_menu') ?>
                </div>
            </div>
            <div class="col-xl-9 col-sm-12 d-flex flex-column flex-lg-row">
                <?php if (empty($sliders)){ ?>
                <div class="swiper bannerSlide me-1">
                    <div class="swiper-wrapper">
                        <?php $sli_1 = get_lebel_by_value_in_theme_settings('slider_1'); ?>
                        <div class="swiper-slide">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $sli_1->value, 'noimage.png', '605', '401');?>" alt="<?php echo $sli_1->alt_name?>" class="img-fluid w-100" loading="lazy">
                        </div>
                        <?php $sli_2 = get_lebel_by_value_in_theme_settings('slider_2'); ?>
                        <div class="swiper-slide">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $sli_2->value, 'noimage.png', '605', '401');?>" alt="<?php echo $sli_2->alt_name?>" class="img-fluid w-100" loading="lazy">
                        </div>
                        <?php $sli_3 = get_lebel_by_value_in_theme_settings('slider_3'); ?>
                        <div class="swiper-slide">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $sli_3->value, 'noimage.png', '605', '401');?>" alt="<?php echo $sli_3->alt_name?>" class="img-fluid w-100" loading="lazy">
                        </div>
                        <?php $sli_4 = get_lebel_by_value_in_theme_settings('slider_4'); ?>
                        <div class="swiper-slide">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $sli_4->value, 'noimage.png', '605', '401');?>" alt="<?php echo $sli_4->alt_name?>" class="img-fluid w-100" loading="lazy">
                        </div>
                        <?php $sli_5 = get_lebel_by_value_in_theme_settings('slider_5'); ?>
                        <div class="swiper-slide">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $sli_5->value, 'noimage.png', '605', '401');?>" alt="<?php echo $sli_5->alt_name?>" class="img-fluid w-100" loading="lazy">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <?php }else{ ?>
                    <div class="swiper bannerSlide me-1">
                        <div class="swiper-wrapper">
                            <?php foreach ($sliders as $slider){ ?>
                            <div class="swiper-slide">
                                <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/slider', '', $slider->image, 'noimage.png', '605', '401');?>" alt="<?php echo $slider->alt_name?>" class="img-fluid w-100" loading="lazy">
                            </div>
                            <?php } ?>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                <?php }?>

                <?php $theme_settings = get_theme_settings();?>
                <div class="side-banner d-flex flex-column flex-sm-row flex-sm-row flex-lg-column gap-1" id="bannerSiderParent">
                    <?php if (empty($slidersBanner)){ ?>
                    <div class="side-banner-box position-relative text-center custom-d-50 w-100">
                        <a href="<?php echo !empty($theme_settings['head_side_url_1']['value'])?$theme_settings['head_side_url_1']['value']:base_url('category/'.$theme_settings['head_side_category_1']['value']); ?>">
                            <?php
                                $side_baner_1 = $theme_settings['head_side_baner_1']['value'];
                            ?>
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/top_side_baner', '', $side_baner_1, 'noimage.png', '228', '199');?>" alt="<?php echo $theme_settings['head_side_baner_1']['alt_name']?>" class="img-fluid" loading="lazy">
                            <div class="position-absolute sid-text-n top-0 p-3">
                                <h4><?php echo $theme_settings['head_side_title_1']['value'];?></h4>
                            </div>
                        </a>
                    </div>
                    <div class="side-banner-box position-relative text-center custom-d-50 w-100">
                        <a   href="<?php echo !empty($theme_settings['head_side_url_2']['value'])?$theme_settings['head_side_url_2']['value']:base_url('category/'.$theme_settings['head_side_category_2']['value']); ?>" >
                            <?php
                                $side_baner_2 = $theme_settings['head_side_baner_2']['value'];
                            ?>
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/top_side_baner', '', $side_baner_2, 'noimage.png', '228', '199');?>" alt="<?php echo $theme_settings['head_side_baner_2']['alt_name']?>" class="img-fluid" loading="lazy">
                            <div class="position-absolute sid-text-n top-0 p-3">
                                <h4><?php echo $theme_settings['head_side_title_2']['value'];?></h4>

                            </div>
                        </a>
                    </div>
                    <?php }else{ ?>
                        <?php foreach ($slidersBanner as $sbanner ){ ?>
                        <div class="side-banner-box position-relative text-center custom-d-50 w-100">
                            <a href="<?php echo !empty($sbanner->url)?$sbanner->url:base_url('category/'.$sbanner->prod_cat_id); ?>">
                                <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/top_side_baner', '', $sbanner->image, 'noimage.png', '228', '199');?>" alt="<?php echo $sbanner->alt_name?>" class="img-fluid" loading="lazy">
                                <div class="position-absolute sid-text-n top-0 p-3">
                                    <h4><?php echo $sbanner->title?></h4>
                                </div>
                            </a>
                        </div>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-container">
    <div class="container">
        <?php if (empty($categoryBanner)){ ?>
        <div class="featured-category mb-5">
            <a href="<?php echo !empty($theme_settings['banner_top_category_url']['value'])?$theme_settings['banner_top_category_url']['value']:base_url('category/'.$theme_settings['banner_top_category']['value']); ?>">

            <?php $banner_top = $theme_settings['banner_top']['value']; ?>
            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/banner_top', '', $banner_top, 'noimage.png', '1116', '211');?>" alt="<?php echo $theme_settings['banner_top']['alt_name']?>" class="img-fluid " loading="lazy">

            </a>
        </div>
        <a href="<?php echo !empty($theme_settings['banner_featured_category_url']['value'])?$theme_settings['banner_featured_category_url']['value']:base_url('category/'.$theme_settings['banner_featured_category_category']['value']); ?>">
        <div class="home-banner mb-5">
            <?php $banner_bottom = $theme_settings['banner_featured_category']['value'];  ?>
            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/banner_featured_category', '', $banner_bottom, 'noimage.png', '1116', '211');?>" alt="<?php echo $theme_settings['banner_featured_category']['alt_name']?>" class="img-fluid" loading="lazy">
        </div>
        </a>
        <?php }else{ ?>
            <?php foreach ($categoryBanner as $key => $banner){ if ($key != 2){?>
                <div class="featured-category mb-5">
                    <a href="<?= !empty($banner->url)?$banner->url:base_url('category/'.$banner->prod_cat_id); ?>">
                        <img data-sizes="auto"  id="" src="<?= common_image_view('uploads/banner_bottom', '', $banner->image, 'noimage.png', '1116', '211');?>" alt="<?= $banner->alt_name ?>" class="img-fluid " loading="lazy">
                    </a>
                </div>
            <?php } } ?>
        <?php }?>

        <div class="product-category mb-5 section-one">
            <?php $scheduleOne = getScheduleBySectionId($schedules,'1');?>
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <?php if (!empty($scheduleOne)){ ?>
                            <h3 class="title-header"><?= $scheduleOne->section_name;?></h3>
                        <?php }else{?>
                            <h3 class="title-header"><?php echo $theme_settings['home_category_title_1']['value'];?></h3>
                        <?php } ?>
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
                <div class="col-sm-3 left-img">
                    <?php if (!empty($scheduleOne)){ ?>
                        <a href="<?= $scheduleOne->url; ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/sections', '', $scheduleOne->image, 'noimage.png', '261', '522');?>" alt="<?= $scheduleOne->alt_name;?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php }else{?>
                        <a href="<?php echo !empty($theme_settings['home_category_url_1']['value'])?$theme_settings['home_category_url_1']['value']:base_url('category/'.$theme_settings['home_category_1']['value']); ?>">
                        <?php $category_baner_1 = $theme_settings['home_category_baner_1']['value']; ?>
                        <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/home_category', '', $category_baner_1, 'noimage.png', '261', '522');?>" alt="<?php echo $theme_settings['home_category_baner_1']['alt_name']?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php } ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper apparelsSlide">
                            <div class="swiper-wrapper">
                                <?php if (!empty($scheduleOne)){ ?>
                                    <?php echo getProductByScheduleIdShowHomeSlider($scheduleOne->featured_schedule_id);?>
                                <?php }else{ ?>
                                    <?php  $home_category_1 = $theme_settings['home_category_1']['value'];
                                        echo get_category_id_by_product_show_home_slide($home_category_1);
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-category mb-5 section-two">
            <?php $scheduleTwo = getScheduleBySectionId($schedules,'2');?>
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <?php if (!empty($scheduleTwo)){ ?>
                            <h3 class="title-header"><?= $scheduleTwo->section_name;?></h3>
                        <?php }else{ ?>
                            <h3 class="title-header"><?php echo $theme_settings['home_category_title_2']['value'];?></h3>
                        <?php } ?>
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
                <div class="col-sm-3 left-img">
                    <?php if (!empty($scheduleTwo)){ ?>
                        <a href="<?= $scheduleTwo->url;?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/sections', '', $scheduleTwo->image, 'noimage.png', '261', '522');?>" alt="<?= $scheduleTwo->alt_name;?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php }else{ ?>
                        <a href="<?php echo !empty($theme_settings['home_category_url_2']['value'])?$theme_settings['home_category_url_2']['value']:base_url('category/'.$theme_settings['home_category_2']['value']); ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_2']['value'], 'noimage.png', '261', '522');?>" alt="<?php echo $theme_settings['home_category_baner_2']['alt_name']?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php } ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper treasuresSlide">
                            <div class="swiper-wrapper">
                                <?php if (!empty($scheduleTwo)){ ?>
                                    <?php echo getProductByScheduleIdShowHomeSlider($scheduleTwo->featured_schedule_id);?>
                                <?php }else{ ?>
                                    <?php $home_category_2 = $theme_settings['home_category_2']['value'];
                                        echo get_category_id_by_product_show_home_slide($home_category_2); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-category mb-5 section-three">
            <?php $scheduleThree = getScheduleBySectionId($schedules,'3');?>
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <?php if (!empty($scheduleThree)){ ?>
                            <h3 class="title-header"><?= $scheduleThree->section_name?></h3>
                        <?php }else{ ?>
                            <h3 class="title-header"><?php echo $theme_settings['home_category_title_3']['value'];?></h3>
                        <?php } ?>
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
                <div class="col-sm-3 left-img">
                    <?php if (!empty($scheduleThree)){ ?>
                        <a href="<?= $scheduleThree->url;?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/sections', '', $scheduleThree->image, 'noimage.png', '261', '522');?>" alt="<?= $scheduleThree->alt_name;?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php }else{ ?>
                        <a href="<?php echo !empty($theme_settings['home_category_url_3']['value'])?$theme_settings['home_category_url_3']['value']:base_url('category/'.$theme_settings['home_category_3']['value']); ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_3']['value'], 'noimage.png', '261', '522');?>" alt="<?php echo $theme_settings['home_category_baner_3']['alt_name']?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php } ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper bagSlide">
                            <div class="swiper-wrapper">
                                <?php if (!empty($scheduleThree)){ ?>
                                    <?php echo getProductByScheduleIdShowHomeSlider($scheduleThree->featured_schedule_id);?>
                                <?php }else{ ?>
                                    <?php $home_category_3 = $theme_settings['home_category_3']['value'];
                                    echo get_category_id_by_product_show_home_slide($home_category_3);  ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-category mb-5 section-four">
            <?php $scheduleFour = getScheduleBySectionId($schedules,'4');?>
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <?php if (!empty($scheduleFour)){ ?>
                            <h3 class="title-header"><?= $scheduleFour->section_name?></h3>
                        <?php }else{ ?>
                            <h3 class="title-header"><?php echo $theme_settings['home_category_title_4']['value'];?></h3>
                        <?php } ?>
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
                <div class="col-sm-3 left-img">
                    <?php if (!empty($scheduleFour)){ ?>
                        <a href="<?= $scheduleFour->url ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/sections', '', $scheduleFour->image, 'noimage.png', '261', '522');?>" alt="<?= $scheduleFour->alt_name;?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php }else{ ?>
                        <a href="<?php echo !empty($theme_settings['home_category_url_4']['value'])?$theme_settings['home_category_url_4']['value']:base_url('category/'.$theme_settings['home_category_4']['value']); ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_4']['value'], 'noimage.png', '261', '522');?>" alt="<?php echo $theme_settings['home_category_baner_4']['alt_name']?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php } ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper jewelrySlide">
                            <div class="swiper-wrapper">
                                <?php if (!empty($scheduleFour)){ ?>
                                    <?php echo getProductByScheduleIdShowHomeSlider($scheduleFour->featured_schedule_id);?>
                                <?php }else{ ?>
                                    <?php $home_category_4 = $theme_settings['home_category_4']['value'];
                                    echo get_category_id_by_product_show_home_slide($home_category_4); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-category mb-5 section-five">
            <?php $scheduleFive = getScheduleBySectionId($schedules,'5');?>
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <?php if (!empty($scheduleFive)){ ?>
                            <h3 class="title-header"><?= $scheduleFive->section_name?></h3>
                        <?php }else{ ?>
                            <h3 class="title-header"><?php echo $theme_settings['home_category_title_5']['value'];?></h3>
                        <?php } ?>
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
                <div class="col-sm-3 left-img">
                    <?php if (!empty($scheduleFive)){ ?>
                        <a href="<?= $scheduleFive->url ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/sections', '', $scheduleFive->image, 'noimage.png', '261', '522');?>" alt="<?= $scheduleFive->alt_name;?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php }else{ ?>
                        <a href="<?php echo !empty($theme_settings['home_category_url_5']['value'])?$theme_settings['home_category_url_5']['value']:base_url('category/'.$theme_settings['home_category_5']['value']); ?>">
                            <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/home_category', '', $theme_settings['home_category_baner_5']['value'], 'noimage.png', '261', '522');?>" alt="<?php echo $theme_settings['home_category_baner_5']['alt_name']?>" class=" h-cat-ban" loading="lazy">
                        </a>
                    <?php } ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper shoesSlide">
                            <div class="swiper-wrapper">
                                <?php if (!empty($scheduleFive)){ ?>
                                    <?php echo getProductByScheduleIdShowHomeSlider($scheduleFive->featured_schedule_id);?>
                                <?php }else{ ?>
                                    <?php $home_category_5 = $theme_settings['home_category_5']['value'];
                                        echo get_category_id_by_product_show_home_slide($home_category_5); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-banner mb-5">
            <?php if (empty($categoryBanner)){ ?>
            <a href="<?php echo !empty($theme_settings['banner_bottom_url']['value'])?$theme_settings['banner_bottom_url']['value']:base_url('category/'.$theme_settings['banner_bottom_category']['value']); ?>">
                <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/banner_bottom', '', $theme_settings['banner_bottom']['value'], 'noimage.png', '1116', '422');?>" alt="<?php echo $theme_settings['banner_bottom']['alt_name']?>" class="" loading="lazy">
            </a>
            <?php }else{ ?>
            <?php foreach ($categoryBanner as $index => $banner){ if ($index == 2){?>
                <a href="<?php echo !empty($banner->url)?$banner->url:base_url('category/'.$banner->prod_cat_id); ?>">
                    <img data-sizes="auto"  id="" src="<?php echo common_image_view('uploads/banner_bottom', '', $banner->image, 'noimage.png', '1116', '211');?>" alt="<?= $banner->alt_name;?>" class="" loading="lazy">
                </a>
            <?php } }?>
            <?php }?>
        </div>
    </div>
</section>