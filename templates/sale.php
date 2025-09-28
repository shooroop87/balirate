<?php
$id = get_the_ID();
$filds = get_fields($id);
$lang= pll_current_language();
?>
            <div class="sales-page__item">
              <?php if ($filds['image']) { ?><img src="<?=$filds['image']['sizes']['news_big']?>"  alt="<?php the_title(); ?>"  loading="lazy"><?php } ?>
              <div class="sales-page__content">
                <div class="sales-page__name"><?php the_title(); ?>
                </div>
                <div class="sales-page__text"><?=$filds['text_mini']?></div>
                <div class="sales-page__date"><?php the_field('text_specto_'.$lang, 'options'); ?> <?=$filds['date_end']?></div>
              </div>
            </div>