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
	if ($page_fields['date']) {
$date=explode(' ',$page_fields['date']);
$date = $date[0].' '.pll__('in').' '.$date[1];
	}
 ?>
<section class="first">
				<div class="first__container">
					<div class="first__body">
						<div class="first__left">
							<div class="event-page">
								<div class="crumbs">
									<div class="crumbs__container">
										<a href="index.html" class="crumbs__link"><?php pll_e('Главная'); ?></a>
										<a href="<?=get_permalink(184);?>" class="crumbs__link">Мероприятия</a>
										<a href="#" class="crumbs__link"><?=the_title()?></a>
									</div>
								</div>
								<h1 class="event-page__title title"><?=the_title()?></h1>
								<div class="event-page__infos">
									<? if ($page_fields['date']) { ?>
									<div class="event-page__info">
										<span>Когда</span>
										<span><?=$date?></span>
									</div>
									<? } ?>
									<? if ($page_fields['where']) { ?>
									<div class="event-page__info">
										<span>Где</span>
										<span><?=$page_fields['where']?></span>
									</div>
									<? } ?>
								</div>
								<button type="button" class="event-page__button button button--blue">Забронировать
									место</button>
								<div class="event-page__content">
									<? if ($page_fields['image']) { ?> 
									<img src="<?=$value['image']['sizes']['event_big']?>"  alt="<?=$args->post_title?>" loading="lazy">
									<? } ?>
									<h2>Описание мероприятия</h2>
									<?=the_content()?>
									<? if ($page_fields['images']) { ?>
									<div class="event-page__imagerow" data-gallery>
										 <?php foreach($page_fields['images'] as $c_num => $slider) {?>
										 	<a href="<?=$slider['sizes']['event_big']?>" class="event-page__image">
											<img src="<?=$slider['sizes']['event_small']?>" alt="<?php the_title()?>" loading="lazy">
										</a>
								             
								          <? } ?>
									</div>
									<? } ?>
									<h2>Как добраться</h2>
									<div class="event-page__map">
										 <?=get_field('map')?> 
										 
									</div>
										<? if ($page_fields['where']) { ?>
									<div class="event-page__address"><?=$page_fields['where']?></div>
									<? } ?>
								</div>
							</div>
						</div>
						<div class="first__right">
							<div class="first__rightitems adsitems">
	<? foreach (get_field('banners_left', 'options') as $banner) { ?>
								   <? get_template_part( 'templates/banner',null,$banner ); ?>
				                 <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>

 
<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 4,
                'post__not_in' => [$page_id],
                'post_type' => array( 'events')
                  )); ?>
                   <? if (have_posts()) { ?>
        <section class="events">
        <div class="events__container">
        <h2 class="events__title title">Ближайшие мероприятия</h2> 
         <div class="events__slidercont slidercont">
			<div class="events__slider swiper">
				<div class="events__wrapper swiper-wrapper">
                <?php while (have_posts()) : ?>
                  <?  get_template_part( 'templates/event-slide',null,the_post() ); ?>
                   <?php endwhile; ?>
                </div>
            </div>
            <button type="button" aria-label="Кнопка слайдера предыдущая" class="events__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая" class="events__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
          </div>
        </div>
      </section>
      <? } ?>
 <?php endif; wp_reset_query(); ?>
 

<?php
get_footer();