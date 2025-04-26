<?
$id = $args->ID;
$filds = get_fields($id);
$lang = pll_current_language();
?>
<div class="bestagents__slide swiper-slide bestagent-item">
  <? if ($filds['image']) { ?>
    <div class="bestagent-item__image">
	 <? if ($filds['link']) { ?><a href="<?= $filds['link'] ?>" target="_blank" rel="nofollow">
      <img src="<?= $filds['image']['sizes']['agent_prev'] ?>" class="ibg" alt="<?= $args->post_title ?>" loading="lazy">
	  </a>
	 <? } else { ?>
	 <img src="<?= $filds['image']['sizes']['agent_prev'] ?>" class="ibg" alt="<?= $args->post_title ?>" loading="lazy">
	 <? } ?>
    </div>
  <? } else { ?>
    <div class="bestagent-item__image _placeholder">
      <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#e5e5e5" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
      </svg>
    </div>
  <? } ?>
  <div class="bestagent-item__name"><?= $args->post_title ?></div>
  <? if ($filds['link']) { ?><a href="<?= $filds['link'] ?>" target="_blank" rel="nofollow"><button type="button"
        class="bestagent-item__button button button--gray"><?php the_field('text_subscribe_' . $lang, 'options'); ?></button></a><? } ?>
</div>