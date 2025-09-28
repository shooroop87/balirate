<?php
/**
 * Главный шаблон для страницы рейтинга агентств
 * С сохранённой структурой, wp_pagenavi и правильным порядком постов
 */

get_header();

$lang = pll_current_language();
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);

$filter = ['relation' => 'AND'];

if (!empty($_POST['special'])) {
    $filter[] = ['key' => 'special', 'compare' => '!=', 'value' => ''];
}
if (!empty($_POST['uk'])) {
    $filter[] = ['key' => 'uk', 'compare' => '!=', 'value' => ''];
}
if (!empty($_POST['vznos'])) {
    $filter[] = ['key' => 'vznos', 'compare' => '!=', 'value' => ''];
}

$nums_filter = ['relation' => 'OR'];
if (isset($_POST['total1'])) $nums_filter[] = ['key' => 'nums_rev', 'value' => 50, 'compare' => '<', 'type' => 'numeric'];
if (isset($_POST['total2'])) $nums_filter[] = ['key' => 'nums_rev', 'value' => [50, 100], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['total3'])) $nums_filter[] = ['key' => 'nums_rev', 'value' => [100, 500], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['total4'])) $nums_filter[] = ['key' => 'nums_rev', 'value' => [500, 1000], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['total5'])) $nums_filter[] = ['key' => 'nums_rev', 'value' => 1000, 'compare' => '>', 'type' => 'numeric'];
if (count($nums_filter) > 1) $filter[] = $nums_filter;

$offers_filter = ['relation' => 'OR'];
if (isset($_POST['offers1'])) $offers_filter[] = ['key' => 'sdano', 'value' => [10, 50], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['offers2'])) $offers_filter[] = ['key' => 'sdano', 'value' => [50, 250], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['offers3'])) $offers_filter[] = ['key' => 'sdano', 'value' => [250, 1000], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['offers4'])) $offers_filter[] = ['key' => 'sdano', 'value' => 1000, 'compare' => '>', 'type' => 'numeric'];
if (count($offers_filter) > 1) $filter[] = $offers_filter;

$rating_filter = ['relation' => 'OR'];
if (isset($_POST['rating1'])) $rating_filter[] = ['key' => 'rating', 'value' => [0.1, 1.4], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['rating2'])) $rating_filter[] = ['key' => 'rating', 'value' => [1.5, 2.5], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['rating3'])) $rating_filter[] = ['key' => 'rating', 'value' => [2.6, 3.5], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['rating4'])) $rating_filter[] = ['key' => 'rating', 'value' => [3.6, 4.5], 'compare' => 'BETWEEN', 'type' => 'numeric'];
if (isset($_POST['rating5'])) $rating_filter[] = ['key' => 'rating', 'value' => 4.5, 'compare' => '>', 'type' => 'numeric'];
if (count($rating_filter) > 1) $filter[] = $rating_filter;

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$ids = wp_list_pluck($page_fields['tabs'][0]['list'], 'ID'); // порядок из первой вкладки

$args = [
    'post_type'      => 'agencies',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'post__in'       => $ids,
    'orderby'        => 'post__in',
    'order'          => 'ASC',
    'meta_query'     => $filter
];

query_posts($args);
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?php echo get_home_url(); ?>" class="crumbs__link">Главная</a>
        <span class="crumbs__link"><?php echo get_the_title(); ?></span>
    </div>
</div>

<section class="first">
    <div class="first__container">
        <h1 class="first__title title"><?php echo get_the_title(); ?></h1>
        <?php get_template_part('templates/advertising_banner', null, $page_fields); ?>
        <div class="first__body">
            <div class="first__left">
                <div class="first__rows">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            get_template_part('templates/item-list', null, get_post());
                        endwhile; ?>
                </div>
                <div class="pagging">
                    <?php wp_pagenavi(); ?>
                </div>
                <?php else : ?>
                    <h3 class="norezult">Ничего не найдено</h3>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            </div>
            <?php get_template_part('templates/filters'); ?>
        </div>
    </div>
</section>
<?php
$reviews_query = new WP_Query([
    'post_type'      => 'review',
    'posts_per_page' => 200,
    'meta_query'     => [
        [
            'key'     => 'type_rec',
            'value'   => 1,
            'compare' => '='
        ]
    ]
]);

if ($reviews_query->have_posts()): ?>
    <section class="devscomments">
        <div class="devscomments__container">
            <div class="devscomments__top">
                <h2 class="devscomments__title title">Отзывы на девелоперов</h2>
                <div class="devscomments__toptiv"><?php echo wp_count_posts('review')->publish; ?></div>
            </div>

            <div class="devscomments__slidercont slidercont">
                <div class="devscomments__slider swiper">
                    <div class="devscomments__wrapper swiper-wrapper">
                        <?php while ($reviews_query->have_posts()): $reviews_query->the_post();
                            get_template_part('templates/review', null, get_post());
                        endwhile; ?>
                    </div>
                </div>
                <button type="button" class="devscomments__swiper-button-prev swiper-button-prev icon-arrow-d-b"></button>
                <button type="button" class="devscomments__swiper-button-next swiper-button-next icon-arrow-d-b"></button>
            </div>
        </div>
    </section>
<?php endif;
wp_reset_postdata();
?>

<?php
$page = get_post(get_queried_object_id());

if (!empty($page->post_content)) : ?>
    <section class="offers">
        <div class="offers__container">
            <?php echo apply_filters('the_content', $page->post_content); ?>
        </div>
    </section>
<?php endif; ?>

<?php
// === Нижний рекламный баннер ===
$bottom_banner_data = null;

if (!empty($page_fields['banners']) && is_array($page_fields['banners'])) {
    $bottom_banner_data = $page_fields['banners'][0]; // можно выбрать не первый, а нужный по фильтру
}

if ($bottom_banner_data && !empty($bottom_banner_data['image'])) {
    $args = [
        'bottom_banner_pk'  => $bottom_banner_data['image'],
        'bottom_banner_mob' => $bottom_banner_data['image'], // при необходимости сделай отдельное поле для моб
        'bottom_banner_url' => $bottom_banner_data['link'] ?? '',
    ];

    get_template_part('templates/bottom_advertising_banner', null, $args);
}
?>

<?php get_footer(); ?>