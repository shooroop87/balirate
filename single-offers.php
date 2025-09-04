<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<?php 
	$page_id = get_queried_object_id();
	$page_fields = get_fields($page_id);
	$developer = $page_fields['developer'];
	$developer_ID=$developer->ID;
	$developer_fields = get_fields($developer_ID);
 $lang= pll_current_language();
$total_rev = gettotalrev($developer_ID);
$rate = getRate($developer_ID);
if ($lang=='en') { $catid=339;} else {$catid=195;}
 ?>
<div class="crumbs">
									<div class="crumbs__container">
										<a href="<?=get_home_url();?>" class="crumbs__link"><?php pll_e('Главная'); ?></a>
										<a href="<?=get_permalink($catid);?>" class="crumbs__link"><?=get_the_title($catid)?></a>
										<span class="crumbs__link"><?=the_title()?></span>
									</div>
								</div>
<section class="object-page">
				<div class="object-page__container">
					<h1 class="object-page__title title"><?=the_title()?></h1>
					<div class="object-page__body">
						<div class="object-page__left">
							<div class="object-page__rows">
								<? if ($page_fields['komleks']) { ?>
								<div class="object-page__row">
									<span>Жилой комплекс</span>
									<span><?=$page_fields['komleks']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['city']) { ?>
								<div class="object-page__row">
									<span>Город</span>
									<span><?=$page_fields['city']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['adress']) { ?>
								<div class="object-page__row">
									<span>Адрес</span>
									<span><?=$page_fields['adress']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['type']) { ?>
								<div class="object-page__row">
									<span>Тип жилья</span>
									<span><?=$page_fields['type']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['rooms']) { ?>
								<div class="object-page__row">
									<span>Комнат</span>
									<span><?=$page_fields['rooms']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['sq']) { ?>
								<div class="object-page__row">
									<span>
									<?php 
										$text_sq = get_field('text_sq_'.$lang, 'options'); 
										echo !empty($text_sq) ? $text_sq : 'Площадь'; 
									?>
									</span>
									<span><?=$page_fields['sq']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['okean']) { ?>
								<div class="object-page__row">
									<span><?php the_field('text_ocean_'.$lang, 'options'); ?></span>
									<span><?=$page_fields['okean']?></span>
								</div>
								<? } ?>
								<? if ($page_fields['date']) { ?>
								<div class="object-page__row">
									<span><?php the_field('date_ob_'.$lang, 'options'); ?></span>
									<span><?=$page_fields['date']?></span>
								</div>
								<? } ?>
							</div>
							<div class="object-page__bottom">
								<div class="object-page__bottomimage">
									<? if ($page_fields['image']) { ?> 
									<img src="<?=$page_fields['image']['sizes']['event_big']?>" class="ibg ibg--contain" alt="<?=the_title()?>">
									<? } ?>
								 
								</div>
								<? if ($developer) { ?>
								<div class="object-page__bottomcontent">

									<div class="object-page__name"><?=$developer->post_title;?></div>
									<button type="button" class="object-page__popuplink button icon-message" data-popup="#popup-feed"><span>Получить презентацию</span></button>
									<a href="<?=get_permalink($developer_ID);?>" class="object-page__link"><?php the_field('test_also_'.$lang, 'options'); ?> <?=$developer_fields['sdano']+$developer_fields['stroitsya']-1?> <?=get_field('text_obj3_'.$lang, 'options')?></a>
								</div>
									<? } ?>
							</div>
						</div>
						<div class="object-page__right">
							<div class="object-page__bigslider swiper">
								<div class="object-page__bigwrapper swiper-wrapper" data-gallery>
									<a href="<?=$page_fields['image']['sizes']['event_big']?>" class="object-page__bigslide swiper-slide">
										<? if ($page_fields['image']) { ?> 
									<img src="<?=$page_fields['image']['sizes']['event_big']?>" class="ibg ibg--contain" alt="<?=the_title()?>">
									<? } ?>
									</a>
								 
									 <?php foreach($page_fields['images'] as $c_num => $slider) {?>
										 	<a href="<?=$slider['sizes']['event_big']?>" class="object-page__bigslide swiper-slide">
											<img src="<?=$slider['sizes']['event_big']?>" alt="<?php the_title()?>" class="ibg ibg--contain">
										</a> 
									<? } ?>
								</div>
							</div>
							<div class="object-page__smallslidercont">
								<button type="button" aria-label="Кнопка слайдера предыдущая" class="object-page__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
								<div class="object-page__smallslider swiper">
								<div class="object-page__smallwrapper swiper-wrapper">
    <div class="object-page__smallslide swiper-slide">
        <?php if ($page_fields['image']) { ?>
            <img src="<?=$page_fields['image']['url']?>" class="ibg" alt="<?=the_title()?>" loading="lazy">
        <?php } ?>
    </div>
    
    <?php foreach($page_fields['images'] as $c_num => $slider) { ?>
        <div class="object-page__smallslide swiper-slide">
            <img src="<?=$slider['url']?>" alt="<?php the_title()?>" class="ibg" loading="lazy">
        </div>
    <?php } ?>
</div>
								</div>
								<button type="button" aria-label="Кнопка слайдера следующая" class="object-page__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
							</div>
						</div>
					</div>
					<? if (get_the_content()) { ?>
					<div class="object-page__block">
						<h2 class="object-page__blocktitle title-s"><?=get_field('text_descob_'.$lang, 'options')?></h2>
						<div class="object-page__blocktext">
							<? the_content();?>
						</div>
					</div>
					<? } ?>
						<? if ($page_fields['adress']) { ?>
					<div class="object-page__block">
						<h2 class="object-page__blocktitle title-s"><?=get_field('text_map_'.$lang, 'options')?></h2>
						<? if ($page_fields['map']) { ?>
						<div class="object-page__blockmap">
							 <?=get_field('map')?> 
						</div>
						<? } ?>
						<div class="object-page__blockaddress"><?=$page_fields['adress'];?></div>
					</div>
					<? } ?>
				</div>
			</section>


<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 20,
                'post_type' => array( 'review'),
								'meta_query'    => array(
												  'relation'      => 'AND',
												  array(
													  'key'       => 'object',
													  'value'     => $page_id,
													  'compare'   => '=',
												  )
											  )
                  )); ?>
      <? if (have_posts()) { ?>
      <section class="devscomments">
				<div class="devscomments__container">
					<div class="devscomments__top">
						<h2 class="devscomments__title title">Отзывы</h2>
						<div class="devscomments__toptiv"><?=$total_rev?></div>
					</div>
					<div class="devscomments__slidercont slidercont">
						<div class="devscomments__slider swiper">
							<div class="devscomments__wrapper swiper-wrapper">
              
                <?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/review',null,the_post() ); ?>
                <?php endwhile; ?>
               
             </div>
            </div>
            <button type="button" aria-label="Кнопка слайдера предыдущая" class="devscomments__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая" class="devscomments__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
          </div>
        </div>
      </section>
    <?  } ?>
 <?php endif; wp_reset_query(); ?>

<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 20,
                'post_type' => array( 'offers'),
                'post__not_in' => [$page_id],
								'meta_query'    => array(
												  'relation'      => 'AND',
												  array(
													  'key'       => 'developer',
													  'value'     => $developer_ID,
													  'compare'   => '=',
												  )
											  )
                  )); ?>
      <? if (have_posts()) { ?>
<section class="offers">
				<div class="offers__container">
					<h2 class="offers__title title">Другие предложения</h2>
					<a href="<?=get_permalink(195);?>" class="offers__link button button--gray">Смотреть предложения</a>
					<div class="offers__slidercont slidercont">
						<div class="offers__slider swiper">
							<div class="offers__wrapper swiper-wrapper">
								<?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/offer',null,the_post() ); ?>
                <?php endwhile; ?>
							</div>
						</div>
						<button type="button" aria-label="Кнопка слайдера предыдущая" class="offers__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
						<button type="button" aria-label="Кнопка слайдера следующая" class="offers__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
					</div>
				</div>
			</section>
    <?  } ?>
 <?php endif; wp_reset_query(); ?>

	<div id="popup-comment" aria-hidden="true" class="popup popup-comment">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup__title">Написать отзыв</div>
					<? if ( is_user_logged_in() ) { ?> 
					<form class="popup__form"  method="POST" id="add_review">
						 <input type="hidden" name="post_id" value="<?=get_the_ID();?>">
						<div class="popup__lines">
							<div class="popup__line">
								<div class="popup__linetop">Ваше имя</div>
								<input type="text" name="name" placeholder="Введите ваше имя" class="input popup__input">
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Поставьте оценку</div>
								<div data-rating="set" data-rating-value="2" class="rating"></div>
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Ваш отзыв</div>
								<textarea data-autoheight name="message" placeholder="Введите ваш отзыв" class="input popup__input"></textarea>
							</div>
						</div>
						<button type="submit" class="popup__submit">Отправить отзыв</button>
						<div class="popup__info">Нажимая кнопку вы даете согласие на обработку <a href="#">персональных
								данных</a> в
							соответствии с <a href="#">политикой конфиденциальности</a></div>
					</form>
					<? } else { ?>
					<div class="popup__linetop">Авторизуйтесь чтобы оставить отзыв</div>
					<? } ?>
				</div>
			</div>
		</div>
	</div>
	<style> #postname { display:none;}
	.object-page__smallslidercont {  opacity:0;}
	.object-page__bigwrapper {width: 100%;
    height: 100%;
    box-sizing: content-box;
    display: flex;
    position: relative;}
	.object-page__bigslide {
    width:100%;
}
.object-page__bigslider .object-page__bigslide , .object-page__smallslide  {flex-shrink: 0;}
.object-page__smallslide { margin-right: 20px; width:calc(25% – 10px);;}
@media (max-width:768px) {
	.object-page__smallslide { margin-right: 10px; width:calc(50% – 50px);;}
}
	</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	setTimeout(function(){
   //$('.object-page__bigslider').css('opacity', 1); 
   $('.object-page__smallslidercont').css('opacity', 1); 
}, 1500);
	$('#postname').val('<?=the_title()?>');
	$("#add_review").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/actions/includes/add-review.php",
        data: $(this).serialize(),
        success: () => {
            console.log("Спасибо. Ваш отзыв отправлен.");
            $(this).trigger("reset"); // очищаем поля формы
            $('#popup-comment form').replaceWith( '<h3 class="success">Ваш отзыв принят</h3>');
        },
        error: () => { console.log("Ошибка отправки.");
    }
    });
});
});
</script>

<?php
get_footer();