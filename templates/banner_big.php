<?
$id = $args->ID;
$item = get_fields($id);
?>
<div class="adsitems__item adsitems-item" style="margin-bottom:20px;">
   <img src="<?= $item['image']['sizes']['news_big'] ?>" alt="<?= $args->post_title ?>" loading="lazy">
   <!-- <div class="adsitems-item__name"><?= $args->post_title ?></div>
   <? if ($item['link']) { ?><a href="<?= $item['link'] ?>" target="_blank" rel="nofollow"
         class="adsitems-item__button button button--gray"><?= $item['_button_text'] ?></a>
   <? } ?>
   <? if ($item['textbottom']) { ?>
      <div class="adsitems-item__info"><?= $item['textbottom'] ?></div><? } ?> -->
</div>