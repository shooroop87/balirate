<?
$id = $args->ID;
$filds = get_fields($id);
$developer = $filds['developer'];
$developerID = $developer->ID;
$fildsD = get_fields($developerID);
$rate = getRate($developerID);
$lang= pll_current_language();
?>
<div class="offers__slide swiper-slide offer-item">
                  <a href="<?=get_permalink($id);?>" class="offer-item__image">
                   <img src="<?=$filds['image']['sizes']['offer_prev']?>" class="ibg ibg--contain" alt="<?php the_title(); ?>"  loading="lazy">
                  </a>
                  <div class="offer-item__content">
                    <a href="<?=get_permalink($id);?>" class="offer-item__name"><?php the_title(); ?></a>
                    <div class="offer-item__info">
                      <div class="offer-item__infoname <?if ($fildsD['verif']) { ?>offer-item__infoname--check<? } ?>"><span><?php echo get_the_title( $developerID ); ?></span>
                      </div>
                      <? if ($rate>0 ) {?><div class="offer-item__inforating"><?=$rate?></div><? } ?>
                    </div>
                    <div class="offer-item__deadline">
                      <span><?php the_field('date_ob_'.$lang, 'options'); ?></span>
                      <span><?=$filds['date']?></span>
                    </div>
                    <a href="<?=get_permalink($id);?>" class="offer-item__link icon-arrow-r-t"><?php pll_e('more_btn'); ?></a>
                  </div>
                </div>