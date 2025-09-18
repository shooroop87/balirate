<?php
get_header();

$lang = pll_current_language();
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);

// Аналогичные фильтры как в page-191.php но для УК
$args = [
    'post_type'      => 'propertymanagement',
    'posts_per_page' => 10,
    'paged'          => get_query_var('paged') ?: 1,
    'meta_query'     => $filter ?? []
];

query_posts($args);
?>

<!-- Аналогичная разметка как в page-191.php -->
<section class="first">
    <div class="first__container">
        <h1 class="first__title title">Управляющие компании</h1>
        
        <div class="first__body">
            <div class="first__left">
                <div class="first__rows">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('templates/item-list', null, get_post()); ?>
                    <?php endwhile; ?>
                </div>
                <?php wp_pagenavi(); ?>
            </div>
            <?php get_template_part('templates/filters'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>