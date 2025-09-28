<?php
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
      <img src="<?php echo $fildsD['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain2" alt="<?php the_title() ?>"
        loading="lazy">
    </div>
    <div class="devscomment-item__topright">
      <div class="devscomment-item__name"><?php echo $developer->post_name ?></div>
      <?php if ($rate > 0): ?>
        <div class="devscomment-item__rating"><?php echo $filds['mark'] ?></div>
      <?php endif ?>
    </div>
  </div>
  <div data-showmore class="devscomment-item__show">
    <div data-showmore-content="167" class="devscomment-item__showcontent"><?php the_content(); ?>
    </div>
    <button hidden data-showmore-button type="button"
      class="devscomment-item__showmore"><span>Подробнее</span><span><?php the_field('text_hide_' . $lang, 'options'); ?></span></button>
  </div>
  <div class="devscomment-item__bottom">
    <div class="devscomment-item__bottomleft">
      <div class="devscomment-item__bottomimage">
        <?php if ($filds['image']) { ?>
          <img src="<?php echo $filds['image']['sizes']['logo_small'] ?>" class="ibg" alt="<?php the_title(); ?>" loading="lazy">
        <?php } ?>
      </div>
      <div class="devscomment-item__bottomname"><?php the_title(); ?></div>
      <?php if ($filds['verif']) { ?>
        <div class="devscomment-item__verified"><?php the_field('text_verif_' . $lang, 'options'); ?></div><?php } ?>
    </div>
    <div class="devscomment-item__date"><?php echo get_the_date(); ?></div>
  </div>
</div>
<?php endif ?>