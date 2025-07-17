<div class="accordion">
    <?php foreach (getSideMenuArray() as $pcat) { ?>

        <!--single-->
        <div class="accordion-item border-0">
            <h2 class="accordion-header d-flex p-1" id=<?="panelsStayOpen-heading-".$pcat->prod_cat_id?> >
                <a href="<?php echo base_url('category/' . $pcat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2">
                                                <span>
                                                    <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="24" height="24" fill="white"/>
                                                    <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                                </span>
                    <span><?php echo $pcat->category_name; ?></span></a>
                    <?php $pCatAr = getCategoryBySubArray($pcat->prod_cat_id,$pcat->order_by,$pcat->order_type); if (!empty(count($pCatAr))) { ?>
                        <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                id="<?="accordionPanelsStayOpen-".$pcat->prod_cat_id?>" type="button" data-bs-toggle="collapse"
                                data-bs-target= <?="#panelsStayOpen-collapse-".$pcat->prod_cat_id?> aria-expanded="false"
                                aria-controls=<?="panelsStayOpen-collapse-".$pcat->prod_cat_id?>>
                        </button>
                    <?php }?>


            </h2>
            <div id="<?="panelsStayOpen-collapse-".$pcat->prod_cat_id?>" class="accordion-collapse collapse"
                 aria-labelledby=<?="panelsStayOpen-heading-".$pcat->prod_cat_id?> >

                <?php if (!empty(count($pCatAr))) { ?>
                    <div class="accordion-body p-0">
                        <?php foreach ($pCatAr as $sCat) { ?>
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header d-flex" id="<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>">
                                    <a href=<?php echo base_url('category/' . $sCat->prod_cat_id); ?> class="accordion-button collapsed py-2 px-2 pl-20">
                                    <span>
                                                                <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="24" height="24" fill="white"/>
                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </span>
                                    <span> <?php echo $sCat->category_name; ?></span></a>
                                    <?php $sCatAr = getCategoryBySubArray($sCat->prod_cat_id,$sCat->order_by,$sCat->order_type); if (!empty(count($sCatAr))) { ?>
                                        <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                id= "<?="accordionPanelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target=<?="#panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?> aria-expanded="false"
                                                aria-controls=<?="#panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?> >
                                        </button>
                                    <?php }?>

                                </h2>
                                <div id="<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?>" class="accordion-collapse collapse"
                                     aria-labelledby=<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>>
                                    <!-- Add your inner accordion content here -->
                                    <!-- Example: -->
                                    <?php if (!empty(count($sCatAr))) { ?>
                                        <div class="accordion-body p-0">
                                            <?php foreach ($sCatAr as $ssCat) { ?>
                                                <div class="accordion-item border-0 ">
                                                    <h2 class="accordion-header d-flex" id="panelsStayOpen-panelsStayOpen-heading-2-inner-heading-2">
                                                        <a href="<?php echo base_url('category/' . $ssCat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2 pl-34">
                                                                            <span>
                                                                                <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <rect width="24" height="24" fill="white"/>
                                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>
                                                                            </span>
                                                            <span><?php echo $ssCat->category_name; ?></span></a>
                                                            <?php if (!empty(count(getCategoryBySubArray($ssCat->prod_cat_id,$ssCat->order_by,$ssCat->order_type)))) { ?>
                                                                <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                                        id="accordionPanelsStayOpen-panelsStayOpen-heading-2-inner-2" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2" aria-expanded="false"
                                                                        aria-controls="panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2">
                                                                </button>
                                                            <?php }?>

                                                    </h2>
                                                    <div id="panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2" class="accordion-collapse collapse"
                                                         aria-labelledby="anelsStayOpen-panelsStayOpen-heading-2-inner-heading-2">
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
        <!--single end-->
    <?php } ?>
</div>