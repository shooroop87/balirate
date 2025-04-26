<?
$id = get_the_ID();
$filds = get_fields($id);
$date=explode(' ',$filds['date']);
$date = $date[0].' '.pll__('in').' '.$date[1];
?>
 

<div class="events__slide swiper-slide event-item">
                  <div class="event-item__image">
                     <img src="<?=$filds['image']['sizes']['offer_prev']?>" class="ibg" alt="<?php the_title(); ?>"  loading="lazy">
                   
                  </div>
                  <div class="event-item__content">
                    <? if ($filds['date']) { ?><div class="event-item__date"><?=$date?></div><? } ?>
                    <a href="<?php the_permalink(); ?>" class="event-item__name"><?php the_title(); ?> </a>
                     <? if ($filds['date']) { ?><div class="event-item__info"><?=$filds['text_mini']?></div><? } ?>
                     <? if ( strtotime($filds['date']) > time() ) {?>
                    <a href="<?php the_permalink(); ?>"><button type="button" class="event-item__button button button--gray"><?php pll_e('more_btn'); ?></button></a>
                    <? } ?>
                  </div>
                </div>
