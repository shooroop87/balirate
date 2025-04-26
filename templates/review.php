<?

$id = $args->ID;
$filds = get_fields($id);
$developer = $filds['object'];
$developerID = $developer->ID;
$fildsD = get_fields($developerID);
$rate = getRate($developerID);
$lang = pll_current_language();
if (!empty($developer->post_name) and isset($developer->post_name)) :
?> 

<div class="devscomments__slide swiper-slide devscomment-item">
  <div class="devscomment-item__top">
    <div class="devscomment-item__image">
      <img src="<?= $fildsD['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain" alt="<? the_title() ?>"
        loading="lazy">
    </div>
    <div class="devscomment-item__topright">
      <div class="devscomment-item__name"><?= $developer->post_name ?></div>
      <? if ($rate > 0): ?>
        <div class="devscomment-item__rating"><?= $filds['mark'] ?></div>
      <? endif ?>
    </div>
  </div>
  <div data-showmore class="devscomment-item__show">
    <div data-showmore-content="167" class="devscomment-item__showcontent"><? the_content(); ?>
    </div>
    <button hidden data-showmore-button type="button"
      class="devscomment-item__showmore"><span><?php pll_e('more_btn'); ?></span><span><?php the_field('text_hide_' . $lang, 'options'); ?></span></button>
  </div>
  <div class="devscomment-item__bottom">
    <div class="devscomment-item__bottomleft">
      <div class="devscomment-item__bottomimage">
        <? if ($filds['image']) { ?>
          <img src="<?= $filds['image']['sizes']['logo_small'] ?>" class="ibg" alt="<?php the_title(); ?>" loading="lazy">
        <? } ?>
      </div>
      <div class="devscomment-item__bottomname"><?php the_title(); ?></div>
      <? if ($filds['verif']) { ?>
        <div class="devscomment-item__verified"><?php the_field('text_verif_' . $lang, 'options'); ?></div><? } ?>
    </div>
    <div class="devscomment-item__date"><?= get_the_date(); ?></div>
  </div>
</div>
<? endif ?>