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

<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?php echo get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?php the_title(); ?></span>
	</div>
</div>

<section class="news-page">
	<div class="news-page__container">
		<h1 class="news-page__title title"><?php the_title(); ?></h1>

		<?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<?php
		// Получаем текущую страницу для пагинации
		$current_page = max(1, isset($_GET['pg']) ? intval($_GET['pg']) : 1);

		// Запрос новостей с пагинацией (13 новостей: 1 большая + 12 маленьких)
		$news_query = new WP_Query([
		    'posts_per_page' => 13,
		    'post_type' => 'news',
		    'post_status' => 'publish',
		    'paged' => $current_page
		]);

		if ($news_query->have_posts()) : ?>
		    <div class="news-page__content">
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
		    
		<?php else : ?>
		    <h3>Ничего не найдено</h3>
		<?php endif; ?>

		<?php get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
	</div>
</section>

<style>
/* Стили для новой структуры новостей */
.news-page__content {
    margin-bottom: 40px;
}

.news__featured {
    margin-bottom: 30px;
}

.news__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
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

<?php get_footer(); ?>