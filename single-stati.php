<?php
/**
 * Single template for 'stati' post type
 */

// ВРЕМЕННЫЙ КОД ДЛЯ ОТЛАДКИ - УДАЛИТЬ ПОСЛЕ ИСПРАВЛЕНИЯ
$post_type = get_post_type();
$post_status = get_post_status();
$post_id = get_the_ID();
$queried_object = get_queried_object();

// Логирование для отладки
error_log("=== SINGLE STATI DEBUG ===");
error_log("Post Type: " . $post_type);
error_log("Post Status: " . $post_status);  
error_log("Post ID: " . $post_id);
error_log("Queried Object: " . print_r($queried_object, true));
error_log("Template: single-stati.php");
error_log("Have Posts: " . (have_posts() ? 'YES' : 'NO'));

// Показываем отладочную информацию на экране (только для админов)
if (current_user_can('administrator')) {
    echo "<!-- DEBUG INFO:";
    echo " Post Type: $post_type";
    echo " | Post Status: $post_status"; 
    echo " | Post ID: $post_id";
    echo " | Have Posts: " . (have_posts() ? 'YES' : 'NO');
    echo " -->";
}

get_header();

// Проверяем существование поста
if (!have_posts()) {
    error_log("ERROR: No posts found in single-stati.php");
    // Если поста нет, показываем 404
    status_header(404);
    get_template_part('404');
    get_footer();
    exit;
}

// Устанавливаем данные поста
while (have_posts()) : the_post();

$page_id = get_the_ID();
$page_fields = get_fields($page_id);

error_log("Processing post ID: " . $page_id . " | Title: " . get_the_title());
?>

<section class="first">
    <div class="first__container">
        <div class="first__body">
            <div class="first__left">
                <div class="article">
                    <div class="crumbs">
                        <div class="crumbs__container">
                            <a href="<?= esc_url(home_url()); ?>" class="crumbs__link">Главная</a>
                            <a href="<?= esc_url(get_permalink(2072)); ?>" class="crumbs__link">Статьи</a>
                            <span class="crumbs__link"><?= esc_html(get_the_title()); ?></span>
                        </div>
                    </div>
                    <h1 class="article__title title"><?= esc_html(get_the_title()); ?></h1>
                    
                    <?php if (!empty($page_fields['text_list'])) : ?>
                        <div class="article__top">
                            <div class="article__toptitle">В данной статье</div>
                            <div class="article__toplinks">
                                <?php foreach ($page_fields['text_list'] as $key => $value) : ?>
                                    <a href="#section-<?= esc_attr($key); ?>" data-goto=".tab<?= esc_attr($key); ?>" class="article__toplink"><?= esc_html($value['title']); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="article__content">
                        <?= get_the_content(); ?>
                        
                        <?php if (!empty($page_fields['text_list'])) :
                            foreach ($page_fields['text_list'] as $key => $value) : ?>
                                <h2 id="section-<?= esc_attr($key); ?>" class="tab<?= esc_attr($key); ?>"><?= esc_html($value['title']); ?></h2>
                                <?= wp_kses_post($value['text']); ?>
                                <?php if (!empty($value['image'])) : ?>
                                    <img src="<?= esc_url($value['image']['sizes']['event_big']); ?>" alt="<?= esc_attr(get_the_title()); ?>" loading="lazy">
                                <?php endif; ?>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="first__right">
                <div class="first__rightitems adsitems">
                    <?php 
                    $banners = get_field('banners_left', 'options');
                    if ($banners) :
                        foreach ($banners as $banner) :
                            get_template_part('templates/banner', null, $banner);
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Похожие статьи
$related_stati = new WP_Query([
    'posts_per_page' => 4,
    'post__not_in' => [$page_id],
    'post_type' => 'stati',
    'post_status' => 'publish'
]);

if ($related_stati->have_posts()) : ?>
    <section class="news">
        <div class="news__container">
            <h2 class="news__title title">Похожие статьи</h2>
            
            <?php 
            $k = 0;
            while ($related_stati->have_posts()) : 
                $related_stati->the_post();
                $k++;
                
                if ($k == 1) {
                    get_template_part('templates/article_big', null, get_post());
                } else {
                    get_template_part('templates/null', null, get_post());
                }
            endwhile;
            wp_reset_postdata();
            ?>
            
            <div class="news__slidercont slidercont">
                <div class="news__slider swiper">
                    <div class="news__wrapper swiper-wrapper">
                        <?php
                        $k = 0;
                        $related_stati->rewind_posts();
                        while ($related_stati->have_posts()) :
                            $related_stati->the_post();
                            $k++;
                            
                            if ($k > 1) {
                                get_template_part('templates/article_prev', null, get_post());
                            } else {
                                get_template_part('templates/null', null, get_post());
                            }
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <button type="button" aria-label="Кнопка слайдера предыдущая" class="news__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
                <button type="button" aria-label="Кнопка слайдера следующая" class="news__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
// База знаний
$page_fields_home = get_fields(2);
if ($page_fields_home) : ?>
<section class="knowledge">
    <div class="knowledge__container">
        <div class="knowledge__left">
            <?php if (!empty($page_fields_home['baza_image'])) : ?>
                <img src="<?= esc_url($page_fields_home['baza_image']['sizes']['bazaimage']); ?>" alt="<?= esc_attr($page_fields_home['title'] ?? ''); ?>" title="<?= esc_attr($page_fields_home['title'] ?? ''); ?>" loading="lazy">
            <?php endif; ?>
            <div class="knowledge__lefttop">
                <h2 class="knowledge__lefttitle title"><?= esc_html($page_fields_home['baza_title'] ?? ''); ?></h2>
                <div class="knowledge__lefttext"><?= wp_kses_post($page_fields_home['baza_text'] ?? ''); ?></div>
            </div>
            <a href="<?= esc_url(get_permalink(177)); ?>" class="knowledge__leftbutton button button--gray button--fw">Больше о недвижимости</a>
        </div>
        <div class="knowledge__right">
            <?php 
            $knowledge_query = new WP_Query([
                'posts_per_page' => 4,
                'post_type' => 'knowledge',
                'post_status' => 'publish'
            ]);
            
            if ($knowledge_query->have_posts()) :
                while ($knowledge_query->have_posts()) :
                    $knowledge_query->the_post();
                    get_template_part('templates/baza_prev', null, get_post());
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
endwhile; // Закрываем цикл have_posts()
get_footer(); 
?>