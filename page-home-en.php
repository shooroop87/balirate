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
 <? if ($page_fields['tabs']) { ?>
<section class="first">
  <div class="first__container">

    <? get_template_part( 'templates/advertising_banner', null, $page_fields ); ?>

    <h1 class="first__title title"><?=$page_fields['rating_title']?></h1>
    <div class="first__body">
      <div class="first__left">
        <div data-tabs class="first__tabs">
          <nav data-tabs-titles class="first__tabsnavigation">
            <? foreach ($page_fields['tabs'] as $num=>$tab) { ?>
			<? if ($tab['list']) { ?>
			<button type="button" class="first__tabstitle <? if ($num==0) { ?>_tab-active<? } ?>"><?=$tab['title']?></button>
			<? } }?>
          </nav>
          <div data-tabs-body class="first__tabscontent">
            <? foreach ($page_fields['tabs'] as $num=>$tab) { ?>
			<? if ($tab['list']) { ?>
            <div class="first__tabsbody">
              <div class="first__rows">
              <?php foreach($tab['list'] as $c_num => $item) {?>
              <? get_template_part( 'templates/item',null,$item ); ?>
              <? } ?>
              </div>
              <div class="first__leftbottom">
                <a href="<?=get_permalink(132);?>" class="first__leftlink button button--gray">See the whole list</a>
                <div class="first__tippy" data-tippy-content="<strong> <?=$page_fields['rate_text']?></strong><br/><br/><p><?=$page_fields['rate_text2']?></p>" data-tippy-allowhtml="true" data-tippy-placement="bottom-end" data-tippy-arrow="false">
                  <?=$page_fields['rate_text']?>
                </div>
              </div>
            </div>
			<? } }?>
        </div>
      </div>
    </div>
    <? if ($page_fields['banners']) { ?>
    <div class="first__right first__right--mt">
      <div class="first__rightitems adsitems">
        <?php foreach($page_fields['banners'] as $c_num => $item) {?>
        <div class="adsitems__item adsitems-item">
          <img src="<?=$item['image']['sizes']['banner-vertical']?>" alt="<?=$item['name']?>"  loading="lazy">
          <div class="adsitems-item__name"><?=$item['name']?></div>
          <? if ($item['link']) { ?><a href="<?=$item['link']?>" target="_blank" rel="nofollow" class="adsitems-item__button button button--gray"><?=$item['button_text']?></a>
          <? } ?>
          <? if ($item['textbottom']) { ?><div class="adsitems-item__info"><?=$item['textbottom']?></div><? } ?>
        </div>
        <? } ?>
      </div>
    </div>
    <? } ?>
  </div>

  <? get_template_part( 'templates/bottom_advertising_banner', null, $page_fields ); ?>

</div>
</section>
<? } ?>
<? if ($page_fields['offers']) { ?>
<section class="offers">
  <div class="offers__container">
    <h2 class="offers__title title"><?=$page_fields['offer_title']?></h2>
    <a href="<?php the_permalink(195); ?>" class="offers__link button button--gray">View all objects</a>
    <div class="offers__slidercont slidercont">
      <div class="offers__slider swiper">
        <div class="offers__wrapper swiper-wrapper">
    
                  <?php foreach($page_fields['offers'] as $c_num => $item) {?>
                  <? get_template_part( 'templates/offer',null,$item ); ?>
                  <? } ?>
          </div>
      </div>
      <button type="button" aria-label="Кнопка слайдера предыдущая" class="offers__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
      <button type="button" aria-label="Кнопка слайдера следующая" class="offers__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<? } ?>
<? if ($page_fields['agent_list']) { ?>
<!-- <section class="bestagents">
  <div class="bestagents__container">
    <? if ($page_fields['agent_title']) { ?><h2 class="bestagents__title title"><?=$page_fields['agent_title']?></h2><? } ?>
    <? if ($page_fields['agent_text']) {?><div class="bestagents__text"><?=$page_fields['agent_text']?></div><? } ?>
    <div class="bestagents__slidercont slidercont">
      <div class="bestagents__slider swiper">
        <div class="bestagents__wrapper swiper-wrapper">
          <?php foreach($page_fields['agent_list'] as $c_num => $item) {?>
                  <? get_template_part( 'templates/agent',null,$item ); ?>
            <? } ?>
        </div>
      </div>
      <button type="button" aria-label="Кнопка слайдера предыдущая" class="bestagents__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
      <button type="button" aria-label="Кнопка слайдера следующая" class="bestagents__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
    </div>
  </div>
</section> -->
<? } ?>
<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 6,
                'post_type' => array( 'events'),
                 'meta_key'          => 'date',
                'orderby'           => 'meta_value',
                'order'             => 'DESC'
                  )); ?>
      <section class="events">
        <div class="events__container">
          <h2 class="events__title title">Events</h2>
          <div class="events__slidercont slidercont">
            <div class="events__slider swiper">
              <div class="events__wrapper swiper-wrapper">
              
                <?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/event',null,the_post() ); ?>
                   <?php endwhile; ?>
               
              </div>
            </div>
            <button type="button" aria-label="Кнопка слайдера предыдущая" class="events__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая" class="events__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
          </div>
        </div>
      </section>
 <?php endif; wp_reset_query(); ?>

<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 8,
                'post_type' => array( 'review')
                  )); ?>
				   <? global $wp_query;
         $totalrev = $wp_query->found_posts;?>
		 <? if ($totalrev>0) { ?>
      <section class="devscomments">
        <div class="devscomments__container">
          <div class="devscomments__top">
            <h2 class="devscomments__title title">Reviews of developers</h2>
            <div class="devscomments__toptiv"><?=$totalrev?></div>
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
		 <? } ?>
 <?php endif; wp_reset_query(); ?>


<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 4,
                'post_type' => array( 'news')
                  )); ?>
		<?php if ( have_posts() ) { ?>
       <section class="news">
        <div class="news__container">
          <h2 class="news__title title">News</h2>
          <? $k=0;?>
                <?php while (have_posts()) : ?>
                  <? $k++; if ($k==1) {  get_template_part( 'templates/newbig',null,the_post() ); }  else  { get_template_part( 'templates/null',null,the_post() ); }?>
                   <?php endwhile; ?>
           <? $k=0;?>
           <div class="news__slidercont slidercont">
            <div class="news__slider swiper">
              <div class="news__wrapper swiper-wrapper">
                <?php while (have_posts()) : ?>
                  <? $k++; if ($k>1) {  get_template_part( 'templates/new_prev',null,the_post() ); }  else  { get_template_part( 'templates/null',null,the_post() ); }?>
                   <?php endwhile; ?>
                </div>
            </div>
            <button type="button" aria-label="Кнопка слайдера предыдущая" class="news__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая" class="news__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
          </div>
        </div>
      </section>
	   <? } ?>
 <?php endif; wp_reset_query(); ?>
 <?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 4,
                'post_type' => array( 'knowledge')
                  )); ?>
<?php if ( have_posts() ) { ?>	
<section class="knowledge">
        <div class="knowledge__container">
          <div class="knowledge__left">
          <img src="<?=$page_fields['baza_image']['sizes']['bazaimage']?>"  alt="<?=$page_fields['title']?>" title="<?=$page_fields['title']?>"  loading="lazy">
            <div class="knowledge__lefttop">
              <h2 class="knowledge__lefttitle title"><?=$page_fields['baza_title']?></h2>
              <div class="knowledge__lefttext"><?=$page_fields['baza_text']?></div>
            </div>
            <a href="<?=get_permalink(177);?>" class="knowledge__leftbutton button button--gray button--fw">More about real estate</a>
          </div>
          <div class="knowledge__right">
           
                   <?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/baza_prev',null,the_post() ); ?>
                   <?php endwhile; ?>
          </div>
        </div>
      </section>
	  <? } ?>
	   <?php endif; wp_reset_query(); ?>
<?php


get_footer();
