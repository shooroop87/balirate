<?php
// ИСПРАВЛЕНИЕ: Проверяем что $args существует и является объектом поста
if (!$args || !is_object($args)) {
    return;
}

$id = $args->ID;
$filds = get_fields($id);
?>
<div class="news__slide swiper-slide news-item">
    <div class="news-item__image">
        <a href="<?= get_permalink($id); ?>">
            <?php if ($filds['image']) { ?>
                <img src="<?= $filds['image']['sizes']['news_prev'] ?>" class="ibg" alt="<?= $args->post_title ?>" loading="lazy">
            <?php } ?>
        </a>
    </div>
    <div class="news-item__content">
        <div class="news-item__date"><?= get_the_date('', $id); ?></div>
        <a href="<?= get_permalink($id); ?>" class="news-item__name"><?= $args->post_title ?></a>
        <div class="news-item__info"><?= $filds['text_mini'] ?></div>
        <a href="<?= get_permalink($id); ?>" class="news-item__link icon-arrow-r-t"><?php pll_e('more_btn'); ?></a>
    </div>
</div>