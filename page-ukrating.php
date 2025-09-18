<?php
/**
 * Шаблон страницы рейтинга управляющих компаний
 * page-ukrating.php
 */

get_header();

$lang = function_exists('pll_current_language') ? pll_current_language() : 'ru';
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;

// Базовые параметры запроса
$args = [
    'post_type'      => 'propertymanagement',
    'posts_per_page' => 12,
    'paged'          => $current_page,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
];

// Применяем фильтры если есть
$meta_query = [];

// Фильтр по рейтингу
if (!empty($_GET['rating'])) {
    $rating = sanitize_text_field($_GET['rating']);
    $meta_query[] = [
        'key'     => 'rating',
        'value'   => floatval($rating),
        'compare' => '>='
    ];
}

// Фильтр по городу
if (!empty($_GET['city'])) {
    $city = sanitize_text_field($_GET['city']);
    $meta_query[] = [
        'key'     => 'city',
        'value'   => $city,
        'compare' => 'LIKE'
    ];
}

// Применяем мета-запросы если есть
if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
}

$uk_query = new WP_Query($args);
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?= esc_url(home_url('/')) ?>" class="crumbs__link">Главная</a>
        <span class="crumbs__link">Управляющие компании</span>
    </div>
</div>

<section class="first">
    <div class="first__container">
        <h1 class="first__title title">Рейтинг управляющих компаний</h1>
        
        <!-- Фильтры -->
        <div class="filters-section">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="rating-filter">Минимальный рейтинг:</label>
                    <select name="rating" id="rating-filter">
                        <option value="">Любой</option>
                        <option value="4.5" <?= selected($_GET['rating'] ?? '', '4.5', false) ?>>4.5+</option>
                        <option value="4.0" <?= selected($_GET['rating'] ?? '', '4.0', false) ?>>4.0+</option>
                        <option value="3.5" <?= selected($_GET['rating'] ?? '', '3.5', false) ?>>3.5+</option>
                        <option value="3.0" <?= selected($_GET['rating'] ?? '', '3.0', false) ?>>3.0+</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="city-filter">Город:</label>
                    <select name="city" id="city-filter">
                        <option value="">Все города</option>
                        <option value="Москва" <?= selected($_GET['city'] ?? '', 'Москва', false) ?>>Москва</option>
                        <option value="СПб" <?= selected($_GET['city'] ?? '', 'СПб', false) ?>>Санкт-Петербург</option>
                        <option value="Екатеринбург" <?= selected($_GET['city'] ?? '', 'Екатеринбург', false) ?>>Екатеринбург</option>
                    </select>
                </div>
                
                <button type="submit" class="filter-button">Применить фильтры</button>
                <?php if (!empty($_GET['rating']) || !empty($_GET['city'])): ?>
                    <a href="<?= esc_url(remove_query_arg(['rating', 'city'])) ?>" class="reset-filters">Сбросить</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="first__body">
            <div class="first__left">
                <?php if ($uk_query->have_posts()): ?>
                    <div class="first__rows">
                        <?php while ($uk_query->have_posts()) : $uk_query->the_post(); ?>
                            <div class="first__row first__row--white item">
                                <div class="item__left">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="item__image">
                                            <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'logo_small')) ?>" 
                                                 alt="<?= esc_attr(get_the_title()) ?>" 
                                                 class="ibg" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="item__body">
                                    <h3 class="item__title">
                                        <a href="<?= esc_url(get_permalink()) ?>"><?= esc_html(get_the_title()) ?></a>
                                    </h3>
                                    
                                    <?php 
                                    $rating = get_field('rating');
                                    $total_reviews = get_field('total_reviews') ?: 0;
                                    if ($rating): ?>
                                        <div class="item__rating">
                                            <div data-rating="" data-rating-show data-rating-value="<?= esc_attr($rating) ?>" class="rating"></div>
                                            <span class="rating-text"><?= esc_html($rating) ?></span>
                                            <?php if ($total_reviews > 0): ?>
                                                <span class="reviews-count">(<?= esc_html($total_reviews) ?> отзывов)</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    $city = get_field('city');
                                    $founded_year = get_field('founded_year');
                                    ?>
                                    <div class="item__meta">
                                        <?php if ($city): ?>
                                            <span class="item__city">📍 <?= esc_html($city) ?></span>
                                        <?php endif; ?>
                                        <?php if ($founded_year): ?>
                                            <span class="item__year">📅 с <?= esc_html($founded_year) ?> г.</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (get_the_excerpt()): ?>
                                        <div class="item__excerpt">
                                            <?= wp_kses_post(get_the_excerpt()) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="item__right">
                                    <a href="<?= esc_url(get_permalink()) ?>" class="item__button button button--primary">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Пагинация -->
                    <?php if ($uk_query->max_num_pages > 1): ?>
                        <div class="pagination-wrapper">
                            <?php
                            $pagination = paginate_links([
                                'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'format'    => '?paged=%#%',
                                'current'   => max(1, $current_page),
                                'total'     => $uk_query->max_num_pages,
                                'type'      => 'list',
                                'prev_text' => '«',
                                'next_text' => '»',
                            ]);
                            
                            if ($pagination) {
                                echo str_replace('page-numbers', 'pagination', $pagination);
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="no-results">
                        <h3>Управляющие компании не найдены</h3>
                        <p>По заданным критериям управляющие компании не найдены. Попробуйте изменить параметры поиска.</p>
                        <a href="<?= esc_url(remove_query_arg(['rating', 'city'])) ?>" class="button">Показать все</a>
                    </div>
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
            </div>
            
            <!-- Боковая колонка -->
            <div class="first__right">
                <div class="sidebar-widget">
                    <h3>Популярные УК</h3>
                    <?php
                    $popular_uk = new WP_Query([
                        'post_type' => 'propertymanagement',
                        'posts_per_page' => 5,
                        'meta_key' => 'rating',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                    ]);
                    
                    if ($popular_uk->have_posts()): ?>
                        <div class="popular-list">
                            <?php while ($popular_uk->have_posts()): $popular_uk->the_post(); ?>
                                <div class="popular-item">
                                    <a href="<?= esc_url(get_permalink()) ?>" class="popular-link">
                                        <?= esc_html(get_the_title()) ?>
                                        <?php 
                                        $rating = get_field('rating');
                                        if ($rating): ?>
                                            <span class="popular-rating"><?= esc_html($rating) ?>★</span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                
                <!-- Рекламный блок -->
                <div class="ad-widget">
                    <a href="#" data-popup="#popup-lead">
                        <img src="<?= esc_url(get_template_directory_uri()) ?>/images/banner-sidebar.jpg" 
                             alt="Реклама" loading="lazy">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.filters-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.filters-form {
    display: flex;
    gap: 1rem;
    align-items: end;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 500;
    color: #333;
}

.filter-group select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.filter-button {
    padding: 0.5rem 1rem;
    background: #007cba;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.filter-button:hover {
    background: #005a87;
}

.reset-filters {
    padding: 0.5rem 1rem;
    color: #666;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.reset-filters:hover {
    background: #f0f0f0;
}

.item__rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.5rem 0;
}

.rating-text {
    font-weight: 600;
    color: #333;
}

.reviews-count {
    color: #666;
    font-size: 14px;
}

.item__meta {
    display: flex;
    gap: 1rem;
    margin: 0.5rem 0;
    font-size: 14px;
    color: #666;
}

.item__excerpt {
    color: #555;
    font-size: 14px;
    line-height: 1.4;
    margin-top: 0.5rem;
}

.no-results {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.sidebar-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.sidebar-widget h3 {
    margin-bottom: 1rem;
    color: #333;
}

.popular-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.popular-item {
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eee;
}

.popular-item:last-child {
    border-bottom: none;
}

.popular-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-decoration: none;
    color: #333;
}

.popular-link:hover {
    color: #007cba;
}

.popular-rating {
    color: #f39c12;
    font-weight: 600;
}

.ad-widget {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
}

.ad-widget img {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .filters-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        width: 100%;
    }
}
</style>

<?php get_footer(); ?>