<?
$id = get_the_ID();
$filds = get_fields($id);
?>
<div class="news__slide swiper-slide news-item">
                      <div class="news-item__image">
                       <? if ($filds['image']) { ?><img src="<?=$filds['image']['sizes']['news_prev']?>" class="ibg" alt="<?php the_title(); ?>"  loading="lazy"><? } ?>
                      </div>
                      <div class="news-item__content">
                        <div class="news-item__date"><?=get_the_date() ;?></div>
                        <a href="<?php the_permalink(); ?>" class="news-item__name"><?php the_title(); ?></a>
                        <div class="news-item__info"><?=$filds['text_mini']?></div>
                        <a href="<?php the_permalink(); ?>" class="news-item__link icon-arrow-r-t"><?php pll_e('more_btn'); ?></a>
                      </div>
                    </div>


