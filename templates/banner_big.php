<?php
$id = $args->ID;
$item = get_fields($id);
?>
<div class="adsitems__item adsitems-item" style="margin-bottom:20px;">
   <img src="<?php echo $item['image']['sizes']['news_big']; ?>" alt="<?php echo $args->post_title; ?>" loading="lazy">
   <!-- <div class="adsitems-item__name"><?php echo $args->post_title; ?></div>
   <?php if ($item['link']) { ?><a href="<?php echo $item['link']; ?>" target="_blank" rel="nofollow"
         class="adsitems-item__button button button--gray"><?php echo $item['_button_text']; ?></a>
   <?php } ?>
   <?php if ($item['textbottom']) { ?>
      <div class="adsitems-item__info"><?php echo $item['textbottom']; ?></div><?php } ?> -->
</div>