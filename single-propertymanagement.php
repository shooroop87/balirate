<?php
get_header();

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
$total_rev = gettotalrev($page_id);
$rate = $page_fields['rating'];
$lang = pll_current_language();
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?=get_home_url();?>" class="crumbs__link">Главная</a>
        <a href="/uk-rating/" class="crumbs__link">Управляющие компании</a>
        <span class="crumbs__link"><?=the_title()?></span>
    </div>
</div>

<section class="developer-page">
    <div class="developer-page__container">
        <div class="developer-page__top">
            <h1 class="developer-page__title title"><?= the_title(); ?></h1>
            <?php if ($rate > 0) : ?>
                <div class="developer-page__rating">
                    <span>Рейтинг</span>
                    <div data-rating="" data-rating-show data-rating-value="<?=$rate?>" class="rating"></div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Остальная разметка как в single-stroys.php -->
    </div>
</section>

<?php get_footer(); ?>