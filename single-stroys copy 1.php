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
	$total_rev = gettotalrev($page_id);
	$rate = $page_fields['rating'];
	$lang= pll_current_language();
if ($lang=='en') { $catid=344;} else {$catid=132;}
if ($lang=='en') { $conf_id=460;} else {$conf_id=248;} 
if ($lang=='en') { $pers_id=464;} else {$pers_id=462;} 
 ?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?=get_home_url();?>" class="crumbs__link"><?php pll_e('Главная'); ?></a>
		<a href="<?=get_permalink($catid);?>" class="crumbs__link"><?=get_the_title($catid)?></a>
		<span class="crumbs__link"><?=the_title()?></span>
	</div>
</div>

 <section class="developer-page">
	<div class="developer-page__container">
		<div class="developer-page__top">
			<h1 class="developer-page__title title"><?= the_title(); ?>
			<?php if ($page_fields['verif']) : ?>
    			<span class="developer-page__icon developer-page__icon--check"></span>
  			<?php endif; ?>
  			<?php if ($page_fields['cup']) : ?>
    			<span class="developer-page__icon developer-page__icon--cup"></span>
  			<?php endif; ?>
			</h1>
			<? if ($rate>0) { ?>
			<div class="developer-page__rating">
				<span><?php pll_e('Рейтинг'); ?></span>
				<div data-rating="" data-rating-show data-rating-value="<?=$rate?>" class="rating"></div>
			</div>
		<? } ?>
		</div>
		<div class="developer-page__content">
			<div class="developer-page__image">
				<? if ($page_fields['f_logo']) { ?> 
					<img src="<?=$page_fields['f_logo']['url']?>" alt="<?=the_title()?>" loading="lazy">
				<? } ?>
			</div>
			<div class="developer-page__right">
				<? if ($page_fields['harr']) { ?>
					<div class="developer-page__infos">
						<? foreach ($page_fields['harr'] as $advantage ) { ?>
							<div class="developer-page__info"><?=$advantage['name']?></div>
						<? } ?>	
					</div>
				<? } ?>
				<div class="first-row__descs">
					<? if ($page_fields['advantages']) { ?>
						<div class="first-row__descsitems">
							<? foreach ($page_fields['advantages'] as $advantage ) { ?>
								<div class="first-row__descsitem"><?=$advantage['name']?></div>
							<? } ?>
						</div>
					<? } ?>
					
					<div class="first-row__descsrows">
						<? if (getMark($page_id,'mark1')>0) { ?>
						<div class="first-row__descsrow">
							<div class="first-row__descsrowleft">Срок сдачи</div>
							<div class="first-row__descsrowright">
								<div class="first-row__descsrowline">
									<div class="first-row__descsrowlinevalue" style="background: linear-gradient(92.21deg, #11E226 -5.36%, #9CEDA4 25.53%, #11E226 51.27%, #9CEDA4 69.52%, #5AE868 88.24%); width: <?=getMark($page_id,'mark1')/5*100?>%">
									</div>
								</div>
								<div class="first-row__descsrowrating"><?=getMark($page_id,'mark1')?>/5</div>
							</div>
						</div>
						<? } ?>
						<? if (getMark($page_id,'mark2')>0) { ?>
						<div class="first-row__descsrow">
							<div class="first-row__descsrowleft">Премиальность</div>
							<div class="first-row__descsrowright">
								<div class="first-row__descsrowline">
									<div class="first-row__descsrowlinevalue" style="background: linear-gradient(92.21deg, #11E226 -5.36%, #9CEDA4 25.53%, #11E226 51.27%, #9CEDA4 69.52%, #5AE868 88.24%); width: <?=getMark($page_id,'mark2')/5*100?>%">
									</div>
								</div>
								<div class="first-row__descsrowrating"><?=getMark($page_id,'mark2')?>/5</div>
							</div>
						</div>
						<? } ?>
						<? if (getMark($page_id,'mark3')>0) { ?>
						<div class="first-row__descsrow">
							<div class="first-row__descsrowleft">Поддержка</div>
							<div class="first-row__descsrowright">
								<div class="first-row__descsrowline">
									<div class="first-row__descsrowlinevalue" style="background: linear-gradient(92.21deg, #11E226 -5.36%, #9CEDA4 25.53%, #11E226 51.27%, #9CEDA4 69.52%, #5AE868 88.24%); width: <?=getMark($page_id,'mark3')/5*100?>%">
									</div>
								</div>
								<div class="first-row__descsrowrating"><?=getMark($page_id,'mark3')?>/5</div>
							</div>
						</div>
						<? } ?>
						<? if (getMark($page_id,'mark4')>0) { ?>
						<div class="first-row__descsrow">
							<div class="first-row__descsrowleft">Качество строительства</div>
							<div class="first-row__descsrowright">
								<div class="first-row__descsrowline">
									<div class="first-row__descsrowlinevalue" style="background: linear-gradient(92.21deg, #11E226 -5.36%, #9CEDA4 25.53%, #11E226 51.27%, #9CEDA4 69.52%, #5AE868 88.24%); width: <?=getMark($page_id,'mark4')/5*100?>%">
									</div>
								</div>
								<div class="first-row__descsrowrating"><?=getMark($page_id,'mark4')?>/5</div>
							</div>
						</div>
						<? } ?>
					</div>
					
				</div>
				<div class="first-row__bottominfos">
					<? if ($page_fields['sdano']) { ?>
					<div class="first-row__bottominfo">
						<span><?php the_field('text_submitted_'.$lang, 'options'); ?>:</span><span><?=$page_fields['sdano']?> <? echo num_word($page_fields['sdano'],  array(get_field('text_obj1_'.$lang, 'options'), get_field('text_obj2_'.$lang, 'options'), get_field('text_obj3_'.$lang, 'options')));?></span>
					</div>
						<? } ?>
						<? if ($page_fields['stroitsya']) { ?>
					<div class="first-row__bottominfo">
						<span><?php the_field('text_under_'.$lang, 'options'); ?>:</span><span><?=$page_fields['stroitsya']?> <? echo num_word($page_fields['stroitsya'],  array(get_field('text_obj1_'.$lang, 'options'), get_field('text_obj2_'.$lang, 'options'), get_field('text_obj3_'.$lang, 'options')));?></span>
					</div>
						<? } ?>
							<? if ($page_fields['sdano'] && $page_fields['stroitsya']) { ?>
					<div class="first-row__bottominfo">
						<span><?php the_field('text_total_'.$lang, 'options'); ?>:</span><span><?=$page_fields['sdano']+$page_fields['stroitsya']?> <? echo num_word($page_fields['sdano']+$page_fields['stroitsya'],  array(get_field('text_obj1_'.$lang, 'options'), get_field('text_obj2_'.$lang, 'options'), get_field('text_obj3_'.$lang, 'options')));?></span>
					</div>
						<? } ?>
				</div>
				<div class="developer-page__footer">
					<? if ( is_user_logged_in() ) { ?> 
					<button type="button" class="developer-page__popuplink icon-message" data-popup="#popup-comment"><span><?php the_field('text_sendrev_'.$lang, 'options'); ?></span></button>
					<? } else  { ?>
					<button type="button" class="developer-page__popuplink icon-message" data-popup="#popup"><span><?php the_field('text_sendrev_'.$lang, 'options'); ?></span></button>
					<? } ?>
                    <button type="button" class="object-page__popuplink2 button icon-message" data-popup="#popup-developer"><span>Скачать каталог</span></button>
					<? if ($page_fields['sait']) { ?>
					<a href="<?=$page_fields['sait']?>" class="developer-page__site icon-arrow-r-t" target="_blank" rel="nofollow"><?php the_field('text_sait_'.$lang, 'options'); ?></a>
					<? } ?>
				</div>
			</div>
		</div>
        
	</div>
</section>

<?php if ( have_posts() ) : query_posts(array(
                'posts_per_page' => 200,
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
	  <? global $wp_query;
	  //print_r($wp_query->posts);
         $totalrev = $wp_query->found_posts;?>
      <section class="devscomments">
				<div class="devscomments__container">
					<div class="devscomments__top">
						<h2 class="devscomments__title title"><?php the_field('text_revs_'.$lang, 'options'); ?></h2>
						<div class="devscomments__toptiv"><? $totalrev?></div>
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
		'meta_query'    => array(
							'relation'      => 'AND',
							array(
								'key'       => 'developer',
								'value'     => $page_id,
								'compare'   => '=',
							)
						)
		)); ?>
	<? if (have_posts()) { ?>
	<section class="offers">
				<div class="offers__container">
					<h2 class="offers__title title"><?php the_field('text_pred_'.$lang, 'options'); ?></h2>
					<a href="<?=get_permalink(195);?>" class="offers__link button button--gray"><?php the_field('text_seeall_'.$lang, 'options'); ?></a>
					<div class="offers__slidercont slidercont">
						<div class="offers__slider swiper">
							<div class="offers__wrapper swiper-wrapper">
								<?php while (have_posts()) : ?>
                  <? get_template_part( 'templates/offer-list',null,the_post() ); ?>
                <?php endwhile; ?>
							</div>
						</div>
						<button type="button" aria-label="Кнопка слайдера предыдущая" class="offers__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
						<button type="button" aria-label="Кнопка слайдера следующая" class="offers__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
					</div>
				</div>
			</section>
    <?  } ?>

	<?php
if (!empty($page_fields['bottom_banner_pk'])) {
    $args = [
        'bottom_banner_pk'  => $page_fields['bottom_banner_pk'],
        'bottom_banner_mob' => $page_fields['bottom_banner_mob'] ?? $page_fields['bottom_banner_pk'],
        'bottom_banner_url' => $page_fields['bottom_banner_url'] ?? '',
    ];
    ?>
    <section class="first">
        <div class="first__container">
            <!-- Рекламный баннер внизу -->
            <?php get_template_part('templates/bottom_advertising_banner', null, $args); ?>
        </div>
    </section>
    <?php
}
?>

 <?php endif; wp_reset_query(); ?>

	<div id="popup-comment" aria-hidden="true" class="popup popup-comment">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup__title"><?php the_field('text_sendrev_'.$lang, 'options'); ?></div>
					<? if ( is_user_logged_in() ) { ?> 
					<form class="popup__form"  method="POST" id="add_review">
						 <input type="hidden" name="post_id" value="<?=get_the_ID();?>">
						  <input type="hidden" name="type_rec" value="2">
						<div class="popup__lines">
							<div class="popup__line">
								<div class="popup__linetop"><?php pll_e('Ваше имя'); ?></div>
								<input type="text" name="name" placeholder="<?php pll_e('Введите ваше имя'); ?>" class="input popup__input" required>
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Срок строительства</div>
								<div data-rating="set" data-rating-value="0" class="mark1"></div>
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Премиальность</div>
								<div data-rating="set" data-rating-value="0" class="mark2"></div>
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Поддержка</div>
								<div data-rating="set" data-rating-value="0" class="mark3"></div>
							</div>
							<div class="popup__line">
								<div class="popup__linetop">Качество строительства</div>
								<div data-rating="set" data-rating-value="0" class="mark4"></div>
							</div>
							<div class="popup__line">
								<div class="popup__linetop"><?php pll_e('Ваш отзыв'); ?></div>
								<textarea data-autoheight name="message" placeholder="<?php pll_e('Введите ваш отзыв'); ?>" class="input popup__input"></textarea>
							</div>
						</div>
						<button type="submit" class="popup__submit"><?php pll_e('Отправить отзыв'); ?></button>
						<div class="popup__info"><?php pll_e('Нажимая кнопку вы даете согласие на обработку'); ?> <a href="<?=get_permalink($pers_id);?>"><?php pll_e('персональных	данных'); ?></a> <?php pll_e('в соответствии с'); ?> <a href="<?=get_permalink($conf_id);?>"><?php pll_e('политикой конфиденциальности'); ?></a></div>
					</form>
					<? } else { ?>
					<div class="popup__linetop"><?php pll_e('Авторизуйтесь чтобы оставить отзыв'); ?></div>
					<? } ?>
				</div>
			</div>
		</div>
	</div>
	<? if (get_the_content()) { ?>
	<section class="offers">
		<div class="offers__container2">
			<?= get_the_content() ?>
		</div>
	</section>
	<? } ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#add_review").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/balirate/includes/add-review.php",
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