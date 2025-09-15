<?php
/**
 * Template Name: Страница видео застройщиков
 */

get_header();

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
$lang = pll_current_language();

// Получаем видео только с этой страницы 
$all_videos = [];
if (!empty($page_fields['video_section_enable']) && !empty($page_fields['video_list'])) {
    foreach ($page_fields['video_list'] as $video) {
        if (!empty($video['video_url'])) {
            $all_videos[] = $video;
        }
    }
}

// Пагинация
$videos_per_page = 12;
$current_page = max(1, isset($_GET['pg']) ? intval($_GET['pg']) : 1);
$total_videos = count($all_videos);
$total_pages = ceil($total_videos / $videos_per_page);
$offset = ($current_page - 1) * $videos_per_page;
$current_videos = array_slice($all_videos, $offset, $videos_per_page);

// Заголовок страницы
$page_title = !empty($page_fields['video_title']) ? $page_fields['video_title'] : get_the_title();
?>

<section class="first">
    <div class="first__container">
        <div class="first__body">
            <div class="first__left">
                <div class="crumbs">
                    <div class="crumbs__container">
                        <a href="<?= esc_url(home_url()) ?>" class="crumbs__link">Главная</a>
                        <span class="crumbs__link"><?= esc_html(get_the_title()) ?></span>
                    </div>
                </div>
                
                <h1 class="first__title title"><?= esc_html($page_title) ?></h1>

                <?php if (!empty($current_videos)): ?>
                    <div class="news__content">
                        <div class="news__grid videos-grid">
                            <?php foreach ($current_videos as $video):
                                $video_id = function_exists('get_youtube_video_id') ? get_youtube_video_id($video['video_url']) : null;
                                if (!$video_id) continue;

                                $thumbnail = !empty($video['video_thumbnail']) 
                                    ? $video['video_thumbnail']['sizes']['news_prev'] 
                                    : (function_exists('get_youtube_thumbnail') ? get_youtube_thumbnail($video_id) : '');
                                
                                $developer = $video['video_developer'] ?? null;
                            ?>
                                <div class="news__slide news-item video-item-card">
                                    <div class="news-item__image video-item__thumbnail" data-video-id="<?= esc_attr($video_id) ?>">
                                        <img src="<?= esc_url($thumbnail) ?>" class="ibg" alt="<?= esc_attr($video['video_title']) ?>" loading="lazy">
                                        
                                        <div class="video-item__play-btn" aria-hidden="true">
                                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" aria-hidden="true" focusable="false">
                                                <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
                                                <path d="M25 20L40 30L25 40V20Z" fill="#007bff"/>
                                            </svg>
                                        </div>

                                        <div class="video-item__overlay" aria-hidden="true"></div>
                                    </div>

                                    <div class="news-item__content">
                                        <div class="news-item__name"><?= esc_html($video['video_title']) ?></div>
                                        
                                        <?php if ($developer): ?>
                                            <div class="news-item__info video-item__developer">
                                                <a href="<?= get_permalink($developer->ID) ?>" class="video-item__developer-link">
                                                    <?= esc_html($developer->post_title) ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($video['video_description'])): ?>
                                            <div class="news-item__info">
                                                <?= esc_html(wp_trim_words($video['video_description'], 15)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Пагинация -->
                        <?php if ($total_pages > 1): ?>
                            <div class="news__pagination">
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
                    </div>

                <?php else: ?>
                    <div class="videos-page__empty">
                        <h3>Видео пока не добавлены</h3>
                        <p>Добавьте видео в разделе "Список видео" в настройках этой страницы</p>
                    </div>
                <?php endif; ?>
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

<!-- Модальное окно для видео (такое же как на главной) -->
<div class="video-modal" id="videoModal" hidden>
    <div class="video-modal__overlay"></div>
    <div class="video-modal__content" role="dialog" aria-modal="true" aria-label="Видео">
        <button type="button" class="video-modal__close" id="closeVideoModal" aria-label="Закрыть видео">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
            </svg>
        </button>
        <div class="video-modal__video-container">
            <iframe id="videoFrame" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
/* Видео карточки используют стили новостей */
.video-item-card {
    cursor: pointer;
}

.video-item__thumbnail {
    position: relative;
    cursor: pointer;
}

.video-item__play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: transform 0.3s ease;
    z-index: 2;
}

.video-item__thumbnail:hover .video-item__play-btn {
    transform: translate(-50%, -50%) scale(1.1);
}

.video-item__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.video-item__thumbnail:hover .video-item__overlay {
    opacity: 1;
}

.video-item__developer-link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.video-item__developer-link:hover {
    text-decoration: underline;
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

/* Модальное окно (как на главной) */
.video-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
}

.video-modal[hidden] { 
    display: none !important; 
}

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

/* Пагинация */
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

/* ===== 2 видео в ряд ===== */
.videos-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

/* Если у .news__slide раньше был фиксированный width из слайдера — переопределим */
.videos-grid .news__slide {
    width: 100%;
}

@media (min-width: 768px) {
    .video-modal__content { 
        width: 95%; 
    }
    .video-modal__close { 
        top: -50px; 
    }

    .videos-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
/* Видео: фиксим мобильную вёрстку */
.video-item__thumbnail{
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  aspect-ratio: 16 / 9;     /* стабильная высота превью */
}

/* чтобы не было странностей с абсолютным .ibg в темах */
.video-item__thumbnail img.ibg{
  width:100%;
  height:100%;
  object-fit: cover;
  display:block;
}
.news-item__name {
    margin-top: 12px;
}
/* убираем наезды заголовка на картинку */
@media (max-width: 576px){        /* отступ под картинкой */
  .news-item__content{ margin-top: 0; }               /* на всякий случай */
  .news-item__name{
    position: static !important;                      /* снять возможный lift */
    margin-top: 4px;
    line-height: 1.2;
    word-break: break-word;                           /* длинные слова переносятся */
  }
}
</style>

<script>
// Тот же JavaScript что на главной странице
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');
    const closeBtn = document.getElementById('closeVideoModal');
    const overlay = modal ? modal.querySelector('.video-modal__overlay') : null;

    // Открытие видео
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.video-item__thumbnail[data-video-id]');
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
