<?php
$id = $args->ID;
$filds = get_fields($id);
$developer = $filds['developer'];
$developerID = $developer->ID;
$fildsD = get_fields($developerID);
$rate = getRate($developerID);
$lang= pll_current_language();
?>
<div class="offers__slide swiper-slide offer-item">
                  <a href="<?php echo get_permalink($id);?>" class="offer-item__image">
                   <img src="<?php echo $filds['image']['sizes']['offer_prev']; ?>" class="ibg ibg--contain" alt="<?php the_title(); ?>"  loading="lazy">
                  </a>
                  <div class="offer-item__content">
                    <a href="<?php echo get_permalink($id);?>" class="offer-item__name"><?php the_title(); ?></a>
                    <div class="offer-item__info">
                      <div class="offer-item__infoname <?php if ($fildsD['verif']) { ?>offer-item__infoname--check<?php } ?>"><span><?php echo get_the_title( $developerID ); ?></span>
                      </div>
                      <?php if ($rate>0 ) {?><div class="offer-item__inforating"><?php echo $rate; ?></div><?php } ?>
                    </div>
                    <div class="offer-item__deadline">
                      <span><?php the_field('date_ob_'.$lang, 'options'); ?> <?php echo $filds['date']; ?></span>
                    </div>
                    <a href="<?php echo get_permalink($id);?>" class="offer-item__link icon-arrow-r-t">Подробнее</a>
                  </div>
                </div>