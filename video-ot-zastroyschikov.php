<?php
/**
 * Template Name: Страница видео застройщиков
 */

get_header();

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
$lang = pll_current_language();

// Получаем все видео
$all_videos = [];

// 1. Сначала проверяем, есть ли видео на самой странице (из ACF)
if (!empty($page_fields['video_list'])) {
    foreach ($page_fields['video_list'] as $video) {
        if (!empty($video['video_url'])) {
            $all_videos[] = $video;
        }
    }
}

// 2. Если на странице нет видео, получаем с главной страницы
if (empty($all_videos)) {
    $home_page_fields = get_fields(2);
    if (!empty($home_page_fields['video_list'])) {
        foreach ($home_page_fields['video_list'] as $video) {
            if (!empty($video['video_url'])) {
                $all_videos[] = $video;
            }
        }
    }
}

// 3. Получаем видео от всех застройщиков
$developers_query = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'stroys',
    'post_status' => 'publish'
]);

if ($developers_query->have_posts()) {
    while ($developers_query->have_posts()) {
        $developers_query->the_post();
        $developer_videos = get_field('company_videos');
        
        if (!empty($developer_videos)) {
            foreach ($developer_videos as $video) {
                if (!empty($video['video_url'])) {
                    // Добавляем информацию о застройщике
                    $video['video_developer'] = get_post();
                    $all_videos[] = $video;
                }
            }
        }
    }
}
wp_reset_postdata();

// Пагинация
$videos_per_page = 12;
$current_page = max(1, isset($_GET['pg']) ? intval($_GET['pg']) : 1);
$total_videos = count($all_videos);
$total_pages = ceil($total_videos / $videos_per_page);
$offset = ($current_page - 1) * $videos_per_page;
$current_videos = array_slice($all_videos, $offset, $videos_per_page);

// Заголовок страницы - берем из ACF или по умолчанию
$page_title = !empty($page_fields['video_title']) ? $page_fields['video_title'] : get_the_title();
?>

<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
        <span class="crumbs__link"><?= get_the_title() ?></span>
    </div>
</div>

<section class="videos-page">
    <div class="videos-page__container">
        <h1 class="videos-page__title title"><?= $page_title ?></h1>

        <?php 
        // Показываем баннер если есть
        if (!empty($page_fields['banner_pk']) || !empty($page_fields['banner_mob'])) {
            get_template_part('templates/advertising_banner', null, $page_fields); 
        }
        ?>

        <?php if (!empty($current_videos)): ?>
            <div class="videos-page__grid">
                <?php foreach ($current_videos as $video):
                    $video_id = function_exists('get_youtube_video_id') ? get_youtube_video_id($video['video_url']) : null;
                    if (!$video_id) continue;

                    $thumbnail = !empty($video['video_thumbnail']) 
                        ? $video['video_thumbnail']['sizes']['offer_prev'] 
                        : (function_exists('get_youtube_thumbnail') ? get_youtube_thumbnail($video_id) : '');
                    
                    $developer = $video['video_developer'] ?? null;
                ?>
                    <div class="video-grid-item">
                        <div class="video-grid-item__thumbnail" data-video-id="<?= esc_attr($video_id) ?>">
                            <img src="<?= esc_url($thumbnail) ?>" class="ibg" alt="<?= esc_attr($video['video_title']) ?>" loading="lazy">
                            
                            <div class="video-grid-item__play-btn">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                    <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
                                    <path d="M25 20L40 30L25 40V20Z" fill="#007bff"/>
                                </svg>
                            </div>
                            
                            <div class="video-grid-item__overlay"></div>
                        </div>
                        
                        <div class="video-grid-item__content">
                            <h3 class="video-grid-item__title"><?= esc_html($video['video_title']) ?></h3>
                            
                            <?php if ($developer): ?>
                                <div class="video-grid-item__developer">
                                    <a href="<?= get_permalink($developer->ID) ?>" class="video-grid-item__developer-link">
                                        <?= esc_html($developer->post_title) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($video['video_description'])): ?>
                                <p class="video-grid-item__description">
                                    <?= esc_html(wp_trim_words($video['video_description'], 20)) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Пагинация -->
            <?php if ($total_pages > 1): ?>
                <div class="videos-page__pagination">
                    <div class="pagination-links">
                        <?php if ($current_page > 1): ?>
                            <a href="<?= get_permalink() ?>?pg=<?= $current_page - 1 ?>" class="prev-page">← Предыдущая</a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if ($i == $current_page): ?>
                                <span class="current"><?= $i ?></span>
                            <?php else: ?>
                                <a href="<?= get_permalink() ?>?pg=<?= $i ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <a href="<?= get_permalink() ?>?pg=<?= $current_page + 1 ?>" class="next-page">Следующая →</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="videos-page__empty">
                <h3>Видео пока не добавлены</h3>
                <p>Скоро здесь появятся видео от лучших застройщиков Бали!</p>
                <p><strong>Администратор:</strong> добавьте видео через "Произвольные поля" → "Список видео" в этой странице или на главной странице</p>
            </div>
        <?php endif; ?>

        <?php 
        // Показываем нижний баннер если есть
        if (!empty($page_fields['bottom_banner_pk']) || !empty($page_fields['bottom_banner_mob'])) {
            get_template_part('templates/bottom_advertising_banner', null, $page_fields);
        }
        ?>
    </div>
</section>

<!-- Модальное окно для видео -->
<div class="video-modal" id="videosPageModal" hidden>
    <div class="video-modal__overlay"></div>
    <div class="video-modal__content" role="dialog" aria-modal="true" aria-label="Видео">
        <button type="button" class="video-modal__close" id="closeVideosPageModal" aria-label="Закрыть видео">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
            </svg>
        </button>
        <div class="video-modal__video-container">
            <iframe id="videosPageFrame" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
/* Основные стили страницы видео */
.videos-page { padding: 40px 0; }

/* Сетка видео */
.videos-page__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

@media (max-width: 1200px) { .videos-page__grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .videos-page__grid { grid-template-columns: repeat(2, 1fr); gap: 20px; } }
@media (max-width: 480px) { .videos-page__grid { grid-template-columns: 1fr; } }

/* Карточка видео */
.video-grid-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.video-grid-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.video-grid-item__thumbnail {
    position: relative;
    height: 200px;
    cursor: pointer;
    overflow: hidden;
}

.video-grid-item__play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: transform 0.3s ease;
}

.video-grid-item__thumbnail:hover .video-grid-item__play-btn {
    transform: translate(-50%, -50%) scale(1.1);
}

.video-grid-item__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-grid-item__thumbnail:hover .video-grid-item__overlay {
    opacity: 1;
}

.video-grid-item__content {
    padding: 20px;
}

.video-grid-item__title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    line-height: 1.4;
}

.video-grid-item__developer {
    margin-bottom: 10px;
}

.video-grid-item__developer-link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.video-grid-item__developer-link:hover {
    text-decoration: underline;
}

.video-grid-item__description {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
}

/* Пустое состояние */
.videos-page__empty {
    text-align: center;
    padding: 80px 20px;
    background: #f8f9fa;
    border-radius: 12px;
    margin: 40px 0;
}

.videos-page__empty h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
}

.videos-page__empty p {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}

/* Пагинация */
.videos-page__pagination {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination-links {
    display: flex;
    gap: 10px;
    align-items: center;
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

/* Модальное окно */
.video-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
}

.video-modal[hidden] { display: none !important; }

.video-modal__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.8);
}

.video-modal__content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 900px;
    aspect-ratio: 16/9;
    background: #000;
    border-radius: 8px;
    overflow: hidden;
}

.video-modal__close {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: 0;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    z-index: 1;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-modal__video-container {
    width: 100%;
    height: 100%;
}

@media (max-width: 768px) {
    .video-modal__content { width: 95%; }
    .video-modal__close { top: -50px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videosPageModal');
    const frame = document.getElementById('videosPageFrame');
    const closeBtn = document.getElementById('closeVideosPageModal');
    const overlay = modal ? modal.querySelector('.video-modal__overlay') : null;

    // Открытие видео
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.video-grid-item__thumbnail[data-video-id]');
        if (!trigger) return;

        e.preventDefault();
        const videoId = trigger.getAttribute('data-video-id');
        const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0`;

        frame.src = embedUrl;
        modal.hidden = false;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });

    function closeModal() {
        modal.style.display = 'none';
        modal.hidden = true;
        frame.src = '';
        document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
});
</script>

<?php get_footer(); ?>