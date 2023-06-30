<section class="home-banner-area">
		<section id="banner">
			<video id="videobcg" preload="auto" autoplay="true" loop="loop" poster="uploads/system/home-banner.jpg" muted="muted" volume="0">
			<source src="uploads/system/fundo.mp4" type="video/mp4">
			</video>
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
					<h2>OPERANDO <strong>ATIVOS</strong></h2>
					<p><?php echo get_frontend_settings('banner_title'); ?></p>
					<p>CONTROLANDO RISCOS E SEGUINDO AS TENDÊNCIAS, <br>SIMPLESMENTE FUNCIONA.</p>
                    <p><?php echo get_frontend_settings('banner_sub_title'); ?></p>
				</div>
			</div>
		</div>
	</div>
	</section>
</section>
<section class="home-fact-area">
    <div class="container-lg">
        <div class="row">
            <?php $courses = $this->crud_model->get_courses(); ?>
            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fas fa-bullseye float-left"></i>
                    <div class="text-box">
                        <h4><?php
                        $status_wise_courses = $this->crud_model->get_status_wise_courses();
                        echo $number_of_courses.' '.site_phrase('Atualizações_constantes'); ?></h4>
                        <p><?php echo site_phrase('explore_a_variety_of_fresh_topics'); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fa fa-check float-left"></i>
                    <div class="text-box">
                        <h4><?php echo site_phrase('expert_instruction'); ?></h4>
                        <p><?php echo site_phrase('find_the_right_course_for_you'); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fa fa-clock float-left"></i>
                    <div class="text-box">
                        <h4><?php echo site_phrase('lifetime_access'); ?></h4>
                        <p><?php echo site_phrase('learn_on_your_schedule'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="course-carousel-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title"><?php echo site_phrase('Nosso_conteúdo'); ?></h2>
                <div class="course-carousel">
                    <?php $top_courses = $this->crud_model->get_top_courses()->result_array();
                    $cart_items = $this->session->userdata('cart_items');
                    foreach ($top_courses as $top_course):?>
                    <div class="course-box-wrap">
                        <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($top_course['title'])).'/'.$top_course['id']); ?>" class="has-popover">
                            <div class="course-box">
                                <!-- <div class="course-badge position best-seller">Best seller</div> -->
                                <div class="course-image">
                                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($top_course['id']); ?>" alt="" class="img-fluid">
                                </div>
                                <div class="course-details">
                                    <h5 class="title"><?php echo $top_course['title']; ?></h5>
                                    <p class="instructors"><?php echo $top_course['short_description']; ?></p>
                                    <div class="rating">
                                        <?php
                                        $total_rating =  $this->crud_model->get_ratings('course', $top_course['id'], true)->row()->rating;
                                        $number_of_ratings = $this->crud_model->get_ratings('course', $top_course['id'])->num_rows();
                                        if ($number_of_ratings > 0) {
                                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                        }else {
                                            $average_ceil_rating = 0;
                                        }

                                        for($i = 1; $i < 6; $i++):?>
                                        <?php if ($i <= $average_ceil_rating): ?>
                                            <i class="fas fa-star filled"></i>
                                        <?php else: ?>
                                            <i class="fas fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span>
                                </div>
                                <?php if ($top_course['is_free_course'] == 1): ?>
                                    <p class="price text-right"><?php echo site_phrase('free'); ?></p>
                                <?php else: ?>
                                    <?php if ($top_course['discount_flag'] == 1): ?>
                                        <p class="price text-right"><small><?php echo currency($top_course['price']); ?></small><?php echo currency($top_course['discounted_price']); ?></p>
                                    <?php else: ?>
                                        <p class="price text-right"><?php echo currency($top_course['price']); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>

                    <div class="webui-popover-content">
                        <div class="course-popover-content">
                            <?php if ($top_course['last_modified'] == ""): ?>
                                <div class="last-updated"><?php echo site_phrase('last_updater').' '.date('D, d-M-Y', $top_course['date_added']); ?></div>
                            <?php else: ?>
                                <div class="last-updated"><?php echo site_phrase('last_updater').' '.date('D, d-M-Y', $top_course['last_modified']); ?></div>
                            <?php endif; ?>

                            <div class="course-title">
                                <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($top_course['title'])).'/'.$top_course['id']); ?>"><?php echo $top_course['title']; ?></a>
                            </div>
                            <div class="course-meta">
                                <span class=""><i class="fas fa-play-circle"></i>
                                    <?php echo $this->crud_model->get_lessons('course', $top_course['id'])->num_rows().' '.site_phrase('lessons'); ?>
                                </span>
                                <span class=""><i class="far fa-clock"></i>
                                    <?php
                                    $total_duration = 0;
                                    $lessons = $this->crud_model->get_lessons('course', $top_course['id'])->result_array();
                                    foreach ($lessons as $lesson) {
                                        if ($lesson['lesson_type'] != "other") {
                                            $time_array = explode(':', $lesson['duration']);
                                            $hour_to_seconds = $time_array[0] * 60 * 60;
                                            $minute_to_seconds = $time_array[1] * 60;
                                            $seconds = $time_array[2];
                                            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
                                        }
                                    }
                                    echo gmdate("H:i:s", $total_duration).' '.site_phrase('hours');
                                    ?>
                                </span>
                                <span class=""><i class="fas fa-closed-captioning"></i><?php echo ucfirst($top_course['language']); ?></span>
                            </div>
                            <div class="course-subtitle"><?php echo $top_course['short_description']; ?></div>
                            <div class="what-will-learn">
                                <ul>
                                    <?php
                                    $outcomes = json_decode($top_course['outcomes']);
                                    foreach ($outcomes as $outcome):?>
                                    <li><?php echo $outcome; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="popover-btns">
                            <?php if (is_purchased($top_course['id'])): ?>
                                <div class="purchased">
                                    <a href="<?php echo site_url('home/my_courses'); ?>"><?php echo site_phrase('already_purchased'); ?></a>
                                </div>
                            <?php else: ?>
                                <?php if ($top_course['is_free_course'] == 1):
                                    if($this->session->userdata('user_login') != 1) {
                                        $url = "#";
                                    }else {
                                        $url = site_url('home/get_enrolled_to_free_course/'.$top_course['id']);
                                    }?>
                                    <a href="<?php echo $url; ?>" class="btn add-to-cart-btn big-cart-button" onclick="handleEnrolledButton()"><?php echo site_phrase('get_enrolled'); ?></a>
                                <?php else: ?>
                                    <button type="button" class="btn add-to-cart-btn <?php if(in_array($top_course['id'], $cart_items)) echo 'addedToCart'; ?> big-cart-button-<?php echo $top_course['id'];?>" id = "<?php echo $top_course['id']; ?>" onclick="handleCartItems(this)">
                                        <?php
                                        if(in_array($top_course['id'], $cart_items))
                                        echo site_phrase('added_to_cart');
                                        else
                                        echo site_phrase('add_to_cart');
                                        ?>
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="wishlist-btn <?php if($this->crud_model->is_added_to_wishlist($top_course['id'])) echo 'active'; ?>" title="Add to wishlist" onclick="handleWishList(this)" id = "<?php echo $top_course['id']; ?>"><i class="fas fa-heart"></i></button>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</section>

<a href="https://api.whatsapp.com/send?phone=+5566999955790&text=Olá!" class="float" target="_blank">
			<img src="data:image/png;base64,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" alt="" width="60px">
			</a>
		<div id="msg1" style="visibility: hidden">Fale conosco!</div>

<script type="text/javascript">
function handleWishList(elem) {

    $.ajax({
        url: '<?php echo site_url('home/handleWishList');?>',
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                if ($(elem).hasClass('active')) {
                    $(elem).removeClass('active')
                }else {
                    $(elem).addClass('active')
                }
                $('#wishlist_items').html(response);
            }
        }
    });
}

function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
            if ($(elem).hasClass('addedToCart')) {
                $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('add_to_cart'); ?>");
            }else {
                $('.big-cart-button-'+elem.id).addClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo site_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type : 'POST',
                success: function(response)
                {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

function handleEnrolledButton() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}
</script>

		<script type="text/javascript">
			// ativa o box de mensagem
			function showIt2() {
			  document.getElementById("msg1").style.visibility = "visible";
			}
			setTimeout("showIt2()", 5000); // Depois 5 segs
			// desativa o box de mensagem
			function hiddenIt() {
			  document.getElementById("msg1").style.visibility = "hidden";
			}
			setTimeout("hiddenIt()", 15000); // Depois 15 segs
			// ativa novamente o box de mensagem
			function showIt3() {
			  document.getElementById("msg1").style.visibility = "visible";
			}
			setTimeout("showIt3()", 35000); // Depois 35 segs
			// Clique para esconder o box de mensagem
			msg1.onclick = function() {
				document.getElementById('msg1').style.visibility = "hidden"; 
			};
		</script>