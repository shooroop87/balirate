<?
$id = get_the_ID();
$filds = get_fields($id);
$lang= pll_current_language();
?>
<div class="news__top news-topitem">
             <? if ($filds['image']) { ?>
			 <a href="<?php the_permalink(); ?>"><img src="<?=$filds['image']['sizes']['news_big']?>" class="ibg" alt="<?php the_title(); ?>" loading="lazy"></a>
			 <? } ?>
            <div class="news-topitem__content">
              <div class="news-topitem__date"><?=get_the_date() ;?></div>
              <a href="<?php the_permalink(); ?>" class="news-topitem__name"><?php the_title(); ?></a>
              <? if ($filds['text_mini']) { ?><div class="news-topitem__text"><?=$filds['text_mini']?><? } ?>
              </div>
              <a href="<?php the_permalink(); ?>" class="news-topitem__link icon-arrow-r-t"><?php pll_e('more_btn'); ?></a>
            </div>
          </div>