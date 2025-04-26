<?
$id = get_the_ID();
$filds = get_fields($id);
$lang= pll_current_language();
?>
                <div class="news__slide swiper-slide news-item">
                  <div class="news-item__image">
				    <a href="<?php the_permalink(); ?>">
                    <? if ($filds['image']) { ?><img src="<?=$filds['image']['sizes']['news_prev']?>" class="ibg" alt="<?php the_title(); ?>" loading="lazy"><? } ?>
					<a>
                  </div>
                  <div class="news-item__content">
                    <div class="news-item__date"><?=get_the_date() ;?></div>
                    <a href="<?php the_permalink(); ?>" class="news-item__name"><?php the_title(); ?></a>
                     <? if ($filds['text_mini']) { ?><div class="news-item__info"><?=$filds['text_mini']?></div><? } ?>
                    <a href="<?php the_permalink(); ?>" class="news-item__link icon-arrow-r-t"><?php the_field('text_more_'.$lang, 'options'); ?></a>
                  </div>
                </div>


