<section class="main-container" >
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="<?php echo base_url('blog');?>" class="btn btn-blog-category <?php echo ($catBtn == 'All') ? 'btn-selected' : '';?>">All</a>
                <?php foreach ($category as $item) { ?>
                    <a href="<?php echo base_url('blog-category/' . $item->cat_id);?>" class="btn btn-blog-category <?php echo ($catBtn == $item->cat_id) ? 'btn-selected' : '';?>"><?php echo $item->category_name;?></a>
                <?php } ?>
            </div>
            <div class="col-md-12 mt-5">
                <div class="row">
                    <?php if (!empty($blog)) { foreach ($blog as $val ){ ?>
                    <div class="col-md-6 mt-4 div-pad">
                        <div class="row class-border">
                            <div class="col-md-5 col-sm-12 position-relative mob-view-img">
                                <?php echo common_image_view('uploads/blog', $val->blog_id, $val->image, 'noimage.png', 'img-fluid img-redu', '', '214', '220');?>
                                <div class="date-box d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                                        <path d="M0.125 16.3125C0.125 17.2441 0.880859 18 1.8125 18H14.1875C15.1191 18 15.875 17.2441 15.875 16.3125V6.75H0.125V16.3125ZM11.375 9.42188C11.375 9.18984 11.5648 9 11.7969 9H13.2031C13.4352 9 13.625 9.18984 13.625 9.42188V10.8281C13.625 11.0602 13.4352 11.25 13.2031 11.25H11.7969C11.5648 11.25 11.375 11.0602 11.375 10.8281V9.42188ZM11.375 13.9219C11.375 13.6898 11.5648 13.5 11.7969 13.5H13.2031C13.4352 13.5 13.625 13.6898 13.625 13.9219V15.3281C13.625 15.5602 13.4352 15.75 13.2031 15.75H11.7969C11.5648 15.75 11.375 15.5602 11.375 15.3281V13.9219ZM6.875 9.42188C6.875 9.18984 7.06484 9 7.29688 9H8.70312C8.93516 9 9.125 9.18984 9.125 9.42188V10.8281C9.125 11.0602 8.93516 11.25 8.70312 11.25H7.29688C7.06484 11.25 6.875 11.0602 6.875 10.8281V9.42188ZM6.875 13.9219C6.875 13.6898 7.06484 13.5 7.29688 13.5H8.70312C8.93516 13.5 9.125 13.6898 9.125 13.9219V15.3281C9.125 15.5602 8.93516 15.75 8.70312 15.75H7.29688C7.06484 15.75 6.875 15.5602 6.875 15.3281V13.9219ZM2.375 9.42188C2.375 9.18984 2.56484 9 2.79688 9H4.20312C4.43516 9 4.625 9.18984 4.625 9.42188V10.8281C4.625 11.0602 4.43516 11.25 4.20312 11.25H2.79688C2.56484 11.25 2.375 11.0602 2.375 10.8281V9.42188ZM2.375 13.9219C2.375 13.6898 2.56484 13.5 2.79688 13.5H4.20312C4.43516 13.5 4.625 13.6898 4.625 13.9219V15.3281C4.625 15.5602 4.43516 15.75 4.20312 15.75H2.79688C2.56484 15.75 2.375 15.5602 2.375 15.3281V13.9219ZM14.1875 2.25H12.5V0.5625C12.5 0.253125 12.2469 0 11.9375 0H10.8125C10.5031 0 10.25 0.253125 10.25 0.5625V2.25H5.75V0.5625C5.75 0.253125 5.49687 0 5.1875 0H4.0625C3.75312 0 3.5 0.253125 3.5 0.5625V2.25H1.8125C0.880859 2.25 0.125 3.00586 0.125 3.9375V5.625H15.875V3.9375C15.875 3.00586 15.1191 2.25 14.1875 2.25Z" fill="white"/>
                                    </svg>
                                    <span class="date-text"><?php echo invoiceDateFormat($val->publish_date)?></span>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 mob-view-text">
                                <a href="<?php echo base_url('blog-view/'.$val->blog_id)?>" class="text-black"  >
                                <div class="top text-mo-title d-flex border-bottom pb-2">
                                    <div>
                                        <svg style="margin-bottom: 4px;" xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                            <path d="M9.13477 9C11.6203 9 13.6348 6.98555 13.6348 4.5C13.6348 2.01445 11.6203 0 9.13477 0C6.64922 0 4.63477 2.01445 4.63477 4.5C4.63477 6.98555 6.64922 9 9.13477 9ZM12.2848 10.125H11.6977C10.9172 10.4836 10.0488 10.6875 9.13477 10.6875C8.2207 10.6875 7.35586 10.4836 6.57188 10.125H5.98477C3.37617 10.125 1.25977 12.2414 1.25977 14.85V16.3125C1.25977 17.2441 2.01562 18 2.94727 18H15.3223C16.2539 18 17.0098 17.2441 17.0098 16.3125V14.85C17.0098 12.2414 14.8934 10.125 12.2848 10.125Z" fill="#2396E6"/>
                                        </svg>
                                        <span class="text-mr"><?php echo get_data_by_id('name','cc_users','user_id',$val->createdBy);?></span>
                                    </div>
                                    <div class="ms-4 ">
                                        <svg style="margin-bottom: 4px;" xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                            <g clip-path="url(#clip0_347_326)">
                                                <path d="M13.1348 7C13.1348 4.2375 10.2254 2 6.63477 2C3.04414 2 0.134766 4.2375 0.134766 7C0.134766 8.07187 0.575391 9.05937 1.32227 9.875C0.903516 10.8187 0.212891 11.5687 0.203516 11.5781C0.134766 11.65 0.116016 11.7562 0.156641 11.85C0.197266 11.9437 0.284766 12 0.384766 12C1.52852 12 2.47539 11.6156 3.15664 11.2187C4.16289 11.7094 5.35352 12 6.63477 12C10.2254 12 13.1348 9.7625 13.1348 7ZM16.9473 13.875C17.6941 13.0625 18.1348 12.0719 18.1348 11C18.1348 8.90937 16.4629 7.11875 14.0941 6.37187C14.1223 6.57812 14.1348 6.7875 14.1348 7C14.1348 10.3094 10.7691 13 6.63477 13C6.29727 13 5.96914 12.975 5.64414 12.9406C6.62852 14.7375 8.94102 16 11.6348 16C12.916 16 14.1066 15.7125 15.1129 15.2187C15.7941 15.6156 16.741 16 17.8848 16C17.9848 16 18.0754 15.9406 18.1129 15.85C18.1535 15.7594 18.1348 15.6531 18.066 15.5781C18.0566 15.5687 17.366 14.8219 16.9473 13.875Z" fill="#2396E6"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_347_326">
                                                    <rect width="18" height="18" fill="white" transform="translate(0.134766)"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span class="text-mr">(<?php echo count_comment_by_blog_id($val->blog_id);?>) Comments</span>
                                    </div>
                                </div>
                                <div class="title-b">
                                    <p class="b-title"><?php echo $val->blog_title;?></p>
                                    <p class="b-text mt-2"><?php echo substr_replace($val->short_des, "...", 70);?></p>
                                    <a href="<?php echo base_url('blog-view/'.$val->blog_id)?>">Read More</a>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } } else { echo '<p>No data available</p>'; }?>

                </div>
            </div>
        </div>
    </div>
</section>