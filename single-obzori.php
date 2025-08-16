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

 ?>
 <section class="first">
				<div class="first__container">
					<div class="first__body">
						<div class="first__left">
							<div class="article">
								<div class="crumbs">
									<div class="crumbs__container">
										<a href="<?=get_home_url();?>" class="crumbs__link">Главная</a>
										<a href="<?=get_permalink(2110);?>" class="crumbs__link">Обзоры</a>
										<span class="crumbs__link"><?=the_title()?></span>
									</div>
								</div>
								<h1 class="article__title title"><?=the_title()?></h1>
								<? if ($page_fields['text_list']) { ?>
								<div class="article__top">
									<div class="article__toptitle">В данном обзоре</div>
									<div class="article__toplinks">
										<? foreach ($page_fields['text_list'] as $key => $value) { ?>
										<a href="#" data-goto=".tab<?=$key?>" class="article__toplink"><?=$value['title']?></a>
										<? } ?>
									</div>
								</div>
								<? } ?>
								<div class="article__content">
									<?=the_content()?>
									<? foreach ($page_fields['text_list'] as $key => $value) { ?>
									<h2 class="tab<?=$key?>"><?=$value['title']?></h2>
									<?=$value['text']?>
									<? if ($value['image']) { ?><img src="<?=$value['image']['sizes']['event_big']?>"  alt="<?=$args->post_title?>" loading="lazy"><? } ?>
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
                'post_type' => array( 'obzori')
                  )); ?>
        <section class="news">
        <div class="news__container">
          <h2 class="news__title title">Статьи</h2>
          <? $k=0;?>
                <?php while (have_posts()) : ?>
                  <? $k++; if ($k==1) {  get_template_part( 'templates/obzor_big',null,the_post() ); }  else  { get_template_part( 'templates/null',null,the_post() ); }?>
                   <?php endwhile; ?>
           <? $k=0;?>
           <div class="news__slidercont slidercont">
            <div class="news__slider swiper">
              <div class="news__wrapper swiper-wrapper">
                <?php while (have_posts()) : ?>
                  <? $k++; if ($k>1) {  get_template_part( 'templates/obzor_prev',null,the_post() ); }  else  { get_template_part( 'templates/null',null,the_post() ); }?>
                   <?php endwhile; ?>
                </div>
            </div>
            <button type="button" aria-label="Кнопка слайдера предыдущая" class="news__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая" class="news__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
          </div>
        </div>
      </section>
 <?php endif; wp_reset_query(); ?>

<?$page_fields_home= get_fields(2);?>
<section class="knowledge">
        <div class="knowledge__container">
          <div class="knowledge__left">
          <img src="<?=$page_fields_home['baza_image']['sizes']['bazaimage']?>"  alt="<?=$page_fields_home['title']?>" title="<?=$page_fields_home['title']?>" loading="lazy">
            <div class="knowledge__lefttop">
              <h2 class="knowledge__lefttitle title"><?=$page_fields_home['baza_title']?></h2>
              <div class="knowledge__lefttext"><?=$page_fields_home['baza_text']?></div>
            </div>
            <a href="<?=get_permalink(177);?>" class="knowledge__leftbutton button button--gray button--fw">Больше о
              недвижимости</a>
          </div>
          <div class="knowledge__right">
            <?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 4,
                'post_type' => array( 'knowledge')
                  )); ?>
                   <?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/baza_prev',null,the_post() ); ?>
                   <?php endwhile; ?>
             <?php endif; wp_reset_query(); ?>
          </div>
        </div>
      </section>

<?php
get_footer();