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
$lang= pll_current_language();
$page_id = get_queried_object_id();

// Очистка кэша ACF (на случай, если поля не обновляются)
if (function_exists('acf_delete_cache')) {
    acf_delete_cache();
}

$page_fields = get_fields($page_id);
$total_rev = gettotalrev($page_id);
$rate = $page_fields['rating'];
if ($lang=='en') { $catid=342;} else {$catid=191;}
if ($lang=='en') { $conf_id=460;} else {$conf_id=248;} 
if ($lang=='en') { $pers_id=464;} else {$pers_id=462;} 
 ?>

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
						<h1 class="developer-page__title <? if ($page_fields['verif']) {?>developer-page__title--check<? } ?> title"><?=the_title()?></h1>
						<? if ($rate>0) { ?>
						<div class="developer-page__rating">
							<span><?php pll_e('Рейтинг'); ?></span>
							<div data-rating="" data-rating-show data-rating-value="<?=$rate?>" class="rating"></div>
						</div>
					<? } ?>
					</div>
					<div class="developer-page__content">
						<div class="developer-page__image">
  <?php if ($page_fields['f_logo']) { ?> 
    <img 
      src="<?= $page_fields['f_logo']['url'] ?>"
      alt="<?= the_title() ?>" 
      loading="lazy">
  <?php } ?>
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
										<div class="first-row__descsrowleft">Сроки сдачи</div>
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
							<div class="first-