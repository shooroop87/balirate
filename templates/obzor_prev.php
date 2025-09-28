<?php
$id = get_the_ID();
$fields = get_fields($id);
$lang = pll_current_language();
?>

<div class="news__slide swiper-slide news-item">
  <div class="news-item__image">
    <a href="<?php the_permalink(); ?>">
      <?php if (!empty($fields['image'])) : ?>
        <img src="<?php echo esc_url($fields['image']['sizes']['news_prev']); ?>" class="ibg" alt="<?php the_title(); ?>" loading="lazy">
      <?php endif; ?>
    </a>
  </div>

  <div class="news-item__content">
    <div class="news-item__date"><?php echo get_the_date(); ?></div>
    <a href="<?php the_permalink(); ?>" class="news-item__name"><?php the_title(); ?></a>
    
    <?php if (!empty($fields['text_mini'])) : ?>
      <div class="news-item__info"><?php echo $fields['text_mini']; ?></div>
    <?php endif; ?>

    <a href="<?php the_permalink(); ?>" class="news-item__link icon-arrow-r-t">
      <?php the_field('text_more_' . $lang, 'options'); ?>
    </a>
  </div>
</div>