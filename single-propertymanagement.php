<?php
/**
 * Шаблон страницы управляющей компании
 * single-propertymanagement.php
 */

get_header();

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
$rating = get_field('rating', $page_id) ?: 0;
$total_reviews = get_field('total_reviews', $page_id) ?: 0;
$lang = function_exists('pll_current_language') ? pll_current_language() : 'ru';
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?= esc_url(home_url('/')) ?>" class="crumbs__link">Главная</a>
        <a href="/uk-rating/" class="crumbs__link">Управляющие компании</a>
        <span class="crumbs__link"><?= esc_html(get_the_title()) ?></span>
    </div>
</div>

<section class="developer-page uk-page">
    <div class="developer-page__container">
        <!-- Шапка компании -->
        <div class="developer-page__top">
            <div class="company-header">
                <?php if (has_post_thumbnail()): ?>
                    <div class="company-logo">
                        <img src="<?= esc_url(get_the_post_thumbnail_url($page_id, 'logo_small')) ?>" 
                             alt="<?= esc_attr(get_the_title()) ?>" class="logo-img">
                    </div>
                <?php endif; ?>
                
                <div class="company-info">
                    <h1 class="developer-page__title title"><?= esc_html(get_the_title()) ?></h1>
                    
                    <?php if ($rating > 0): ?>
                        <div class="developer-page__rating">
                            <span class="rating-label">Рейтинг</span>
                            <div data-rating="" data-rating-show data-rating-value="<?= esc_attr($rating) ?>" class="rating"></div>
                            <span class="rating-value"><?= esc_html($rating) ?></span>
                            <?php if ($total_reviews > 0): ?>
                                <span class="reviews-count">(<?= esc_html($total_reviews) ?> отзывов)</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Основные характеристики -->
                    <div class="company-meta">
                        <?php 
                        $city = get_field('city');
                        $founded_year = get_field('founded_year');
                        $license_number = get_field('license_number');
                        $objects_count = get_field('objects_count');
                        ?>
                        
                        <?php if ($city): ?>
                            <div class="meta-item">
                                <strong>Город:</strong> <?= esc_html($city) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($founded_year): ?>
                            <div class="meta-item">
                                <strong>Год основания:</strong> <?= esc_html($founded_year) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($license_number): ?>
                            <div class="meta-item">
                                <strong>Лицензия:</strong> <?= esc_html($license_number) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($objects_count): ?>
                            <div class="meta-item">
                                <strong>Управляет объектами:</strong> <?= esc_html($objects_count) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Контент компании -->
        <div class="developer-page__body">
            <div class="developer-page__left">
                
                <!-- Описание компании -->
                <?php if (get_the_content()): ?>
                    <div class="company-description">
                        <h2>О компании</h2>
                        <div class="content">
                            <?= apply_filters('the_content', get_the_content()) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Услуги -->
                <?php 
                $services = get_field('services');
                if ($services): ?>
                    <div class="company-services">
                        <h2>Услуги компании</h2>
                        <div class="services-grid">
                            <?php foreach ($services as $service): ?>
                                <div class="service-item">
                                    <h4><?= esc_html($service['service_name']) ?></h4>
                                    <?php if ($service['service_description']): ?>
                                        <p><?= esc_html($service['service_description']) ?></p>
                                    <?php endif; ?>
                                    <?php if ($service['service_price']): ?>
                                        <div class="service-price"><?= esc_html($service['service_price']) ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Управляемые объекты -->
                <?php 
                $managed_objects = get_field('managed_objects');
                if ($managed_objects): ?>
                    <div class="managed-objects">
                        <h2>Управляемые объекты</h2>
                        <div class="objects-grid">
                            <?php foreach ($managed_objects as $object): ?>
                                <div class="object-item">
                                    <?php if ($object['object_image']): ?>
                                        <div class="object-image">
                                            <img src="<?= esc_url($object['object_image']['sizes']['obj_small']) ?>" 
                                                 alt="<?= esc_attr($object['object_name']) ?>" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <div class="object-info">
                                        <h4><?= esc_html($object['object_name']) ?></h4>
                                        <?php if ($object['object_address']): ?>
                                            <p class="object-address"><?= esc_html($object['object_address']) ?></p>
                                        <?php endif; ?>
                                        <?php if ($object['object_type']): ?>
                                            <div class="object-type"><?= esc_html($object['object_type']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>