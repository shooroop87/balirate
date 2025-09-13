<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<?php 
	$page_id = get_queried_object_id();
	$page_fields = get_fields($page_id);
 ?>
 <section class="first">
	<div class="first__container">
		<div class="first__body">
			<div class="first__left">
				<div class="article">
					<div class="crumbs">
						<div class="crumbs__container">
							<a href="<?=get_home_url();?>" class="crumbs__link">Главная</a>
							<a href="<?=get_permalink(186);?>" class="crumbs__link">Новости</a>
							<span class="crumbs__link"><?=the_title()?></span>
						</div>
					</div>
					<h1 class="article__title title"><?=the_title()?></h1>
					<? if ($page_fields['text_list']) { ?>
					<div class="article__top">
						<div class="article__toptitle">В данной статье</div>
						<div class="article__toplinks">
							<? foreach ($page_fields['text_list'] as $key => $value) { ?>
							<a href="#" data-goto=".tab<?=$key?>" class="article__toplink"><?=$value['title']?></a>
							<? } ?>
						</div>
					</div>
					<? } ?>
					<div class="article__content">
						<?=the_content()?>
						<? if (!empty($page_fields['text_list'])) {
							foreach ($page_fields['text_list'] as $key => $value) { ?>
						<h2 class="tab<?=$key?>"><?=$value['title']?></h2>
						<?=$value['text']?>
						<? if ($value['image']) { ?><img src="<?=$value['image']['sizes']['event_big']?>"  alt="<?=$args->post_title?>" loading="lazy"><? } ?>
							<? } 
						} ?>
					</div>
				</div>
			</div>
			<div class="first__right">
				<div class="first__rightitems adsitems">
					<? 
					$banners = get_field('banners_left', 'options');
					if ($banners) {
						foreach ($banners as $banner) { ?>
						   <? get_template_part( 'templates/banner',null,$banner ); ?>
					   <? }
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>
 
<?php
// Получаем текущую страницу для пагинации
$current_page = max(1, isset($_GET['pg']) ? intval($_GET['pg']) : 1);

// Запрос новостей с пагинацией
$news_query = new WP_Query([
    'posts_per_page' => 13, // 1 большая + 12 маленьких
    'post__not_in' => [$page_id],
    'post_type' => 'news',
    'post_status' => 'publish',
    'paged' => $current_page
]);

if ($news_query->have_posts()) : ?>
    <section class="news">
        <div class="news__container">
            <h2 class="news__title title">Новости</h2>
            
            <div class="news__content">
                <?php 
                $k = 0;
                while ($news_query->have_posts()) : 
                    $news_query->the_post();
                    $k++;
                    
                    if ($k == 1) {
                        // Первая новость - большая
                        ?>
                        <div class="news__featured">
                            <?php get_template_part('templates/newbig', null, get_post()); ?>
                        </div>
                        <?php
                    } else {
                        if ($k == 2) {
                            // Начинаем контейнер для маленьких новостей
                            echo '<div class="news__grid">';
                        }
                        
                        // Маленькие новости
                        get_template_part('templates/new_prev', null, get_post());
                    }
                endwhile;
                
                // Закрываем контейнер для маленьких новостей, если он был открыт
                if ($k > 1) {
                    echo '</div>';
                }
                
                wp_reset_postdata();
                ?>
            </div>
            
            <?php
            // Пагинация для новостей
            if ($news_query->max_num_pages > 1) : ?>
                <div class="news__pagination">
                    <?php
                    // Создаем базовый URL для пагинации
                    $base_url = get_permalink();
                    
                    echo '<div class="pagination-links">';
                    
                    // Предыдущая страница
                    if ($current_page > 1) {
                        echo '<a href="' . $base_url . '?pg=' . ($current_page - 1) . '" class="prev-page">← Предыдущая</a>';
                    }
                    
                    // Номера страниц
                    for ($i = 1; $i <= $news_query->max_num_pages; $i++) {
                        if ($i == $current_page) {
                            echo '<span class="current">' . $i . '</span>';
                        } else {
                            echo '<a href="' . $base_url . '?pg=' . $i . '">' . $i . '</a>';
                        }
                    }
                    
                    // Следующая страница
                    if ($current_page < $news_query->max_num_pages) {
                        echo '<a href="' . $base_url . '?pg=' . ($current_page + 1) . '" class="next-page">Следующая →</a>';
                    }
                    
                    echo '</div>';
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php
$page_fields_home = get_fields(2);
if ($page_fields_home) : ?>
<section class="knowledge">
    <div class="knowledge__container">
        <div class="knowledge__left">
            <?php if (!empty($page_fields_home['baza_image'])) : ?>
                <img src="<?=$page_fields_home['baza_image']['sizes']['bazaimage']?>" alt="<?=$page_fields_home['title']?>" title="<?=$page_fields_home['title']?>" loading="lazy">
            <?php endif; ?>
            <div class="knowledge__lefttop">
                <h2 class="knowledge__lefttitle title"><?=$page_fields_home['baza_title']?></h2>
                <div class="knowledge__lefttext"><?=$page_fields_home['baza_text']?></div>
            </div>
            <a href="<?=get_permalink(177);?>" class="knowledge__leftbutton button button--gray button--fw">Больше о недвижимости</a>
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

<style>
/* Стили для новой структуры новостей */
.news__content {
    margin-bottom: 40px;
}

.news__featured {
    margin-bottom: 30px;
}

.news__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

@media (max-width: 1200px) {
    .news__grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .news__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .news__grid {
        grid-template-columns: 1fr;
    }
}

/* Стили пагинации */
.news__pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
}

.pagination-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.pagination-links a,
.pagination-links span {
    display: inline-block;
    padding: 10px 15px;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 5px;
    color: #333;
    transition: all 0.3s ease;
}

.pagination-links a:hover {
    background-color: #f5f5f5;
    border-color: #bbb;
}

.pagination-links .current {
    background-color: #007cba;
    color: white;
    border-color: #007cba;
}

.pagination-links .prev-page,
.pagination-links .next-page {
    font-weight: bold;
}
</style>

<?php
get_footer();
?>