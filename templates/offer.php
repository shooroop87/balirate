<?

if(!$args) return;

$lang = pll_current_language();
$id = $args->ID;
$filds = get_fields($id);

if(!isset($filds['developer']) || empty($filds['developer'])) return;

$fildsD = get_fields($filds['developer']->ID);
$rate = getRate($filds['developer']->ID);

?>

<div class="offers__slide swiper-slide offer-item">
  <a href="<?= get_permalink($id) ?>" class="offer-item__image">
    <img 
  src="<?= $filds['image']['url'] ?>"
  class="ibg ibg--contain"
  alt="<?= $args->post_title ?>"
  loading="lazy">
  </a>
  <div class="offer-item__content">
    <a href="<?= get_permalink($id) ?>" class="offer-item__name"><?= $args->post_title ?></a>
    <div class="offer-item__info">
      <div class="offer-item__infoname <? if ($fildsD['verif']): ?> offer-item__infoname--check <? endif ?>">
        <span><?= get_the_title($filds['developer']->ID) ?></span>
      </div>
      <? if ($rate > 0): ?>
        <div class="offer-item__inforating"><?= $rate ?></div>
      <? endif ?>
    </div>
    <div class="offer-item__deadline">
      <span><? the_field('date_ob_' . $lang, 'options') ?></span>
      <span><?= $filds['date'] ?></span>
    </div>
    <a href="<?= get_permalink($id) ?>" class="offer-item__link icon-arrow-r-t">Подробнее</a>
  </div>
</div>