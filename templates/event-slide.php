<?php
$id = get_the_ID();
$filds = get_fields($id);
$date=explode(' ',$filds['date']);
$date = $date[0].' '.pll__('in').' '.$date[1];
?>
 

<div class="events__slide swiper-slide event-item">
                  <div class="event-item__image">
                     <img src="<?php echo $filds['image']['sizes']['offer_prev']; ?>" class="ibg" alt="<?php the_title(); ?>"  loading="lazy">
                   
                  </div>
                  <div class="event-item__content">
                    <?php if ($filds['date']) { ?><div class="event-item__date"><?php echo $date; ?></div><?php } ?>
                    <a href="<?php the_permalink(); ?>" class="event-item__name"><?php the_title(); ?> </a>
                     <?php if ($filds['date']) { ?><div class="event-item__info"><?php echo $filds['text_mini']; ?></div><?php } ?>
                     <?php if ( strtotime($filds['date']) > time() ) {?>
                    <a href="<?php the_permalink(); ?>"><button type="button" class="event-item__button button button--gray">Подробнее</button></a>
                    <?php } ?>
                  </div>
                </div>