<?
$id = $args->ID;
$filds = get_fields($id);

?>
 <div class="bestagents__slide swiper-slide bestagent-item">
 <? if ($filds['image']) { ?>
                  <div class="bestagent-item__image">
                    <img src="<?=$filds['image']['sizes']['agent_prev']?>" class="ibg" alt="<?=$args->post_title?>"  loading="lazy">
                  </div>
 <? } ?>
                  <div class="bestagent-item__name"><?=$args->post_title?></div>
                  <? if ($filds['link']) { ?><a href="<?=$filds['link']?>" target="_blank" rel="nofollow"><button type="button" class="bestagent-item__button button button--gray"><?php pll_e('subscribe_btn'); ?></button></a><? } ?>
                </div>
