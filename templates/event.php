<?php
$id = get_the_ID();
$filds = get_fields($id);
$lang= pll_current_language();
$date=explode(' ',$filds['date']);
$date = $date[0].' '.pll__('in').' '.$date[1];
 
?>
<div class="events__slide swiper-slide event-item">
<?php if ($filds['image']) { ?>
                  <div class="event-item__image">
                     <img src="<?=$filds['image']['sizes']['event_prev']?>" class="ibg" alt="<?php the_title(); ?>"  loading="lazy">
                   
                  </div>
<?php } ?>
                  <div class="event-item__content">
                    <?php if ($filds['date']) { ?><div class="event-item__date"><?=$date?></div><?php } ?>
                    <a href="<?php the_permalink(); ?>" class="event-item__name"><?php the_title(); ?> </a>
                     <?php if ($filds['text_mini']) { ?><div class="event-item__info"><?=$filds['text_mini']?></div><?php } ?>
                     <?php if ( strtotime($filds['date']) > time() ) {?>
                    <a href="<?php the_permalink(); ?>"><button type="button" class="event-item__button button button--gray">Подробнее</button></a>
                    <?php } ?>
                  </div>
                </div>