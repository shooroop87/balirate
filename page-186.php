<?php
/**
 * Шаблон страницы новостей (page-186.php)
 * 
 * Выводит 1 большую новость и 3 обычных новости,
 * остальные переносятся через пагинацию на следующие страницы.
 */

get_header(); ?>

<?php
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
        <span class="crumbs__link"><?= the_title() ?></span>
    </div>
</div>

<section class="news-page">
    <div class="news-page__container">
        <h1 class="news-page__title title"><?= the_title() ?></h1>

        <?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if (have_posts()):
            query_posts(array(
                'posts_per_page' => 4, // Выводим 4 новости на страницу (1 большая + 3 обычных)
                'post_type' => array('news'),
                'paged' => $paged
            )); ?>
            
            <?php if (have_posts()) { ?>
                <div class="news-page__row">
                    <?php 
                    $post_count = 0;
                    while (have_posts()): the_post();
                        $post_count++;
                        if ($post_count == 1) {
                            // Первая новость выводится как большая
                            get_template_part('templates/newbig', null, get_post());
                        } else {
                            // Остальные 3 новости выводятся как обычные превью
                            get_template_part('templates/new_prev', null, get_post());
                        }
                    endwhile; 
                    ?>
                </div>

                <div class="pagging">
                    <?php wp_pagenavi(); ?>
                </div>
            <?php } else { ?>
                <h3>Ничего не найдено</h3>
            <?php } ?>
        <?php endif;
        wp_reset_query(); ?>

        <?php get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
    </div>
</section>

<?php get_footer(); ?>