<?php
/**
 * Шаблон секции видео для главной страницы
 * Файл: templates/video_section.php
 */

if (!$args || !$args['video_list']) return;

$lang = pll_current_language();
?>

<section class="videos">
    <div class="videos__container">
        
        <!-- Заголовок и кнопки в одной строке -->
        <div class="videos__header-row">
            <h2 class="videos__title title"><?= $args['video_title'] ?: 'Видео от застройщиков' ?></h2>
        </div>

        <!-- Слайдер видео -->
        <div class="videos__slidercont slidercont">
            <div class="videos__slider swiper">
                <div class="videos__wrapper swiper-wrapper">
                    <?php foreach ($args['video_list'] as $video): 
                        $video_id = get_youtube_video_id($video['video_url']);
                        if (!$video_id) continue;
                        
                        $thumbnail = $video['video_thumbnail'] 
                            ? $video['video_thumbnail']['sizes']['offer_prev'] 
                            : get_youtube_thumbnail($video_id);
                        
                        $developer = $video['video_developer'];
                        ?>
                        
                        <div class="videos__slide swiper-slide video-item">
                            <div class="video-item__thumbnail" data-video-id="<?= $video_id ?>">
                                <img src="<?= $thumbnail ?>" class="ibg" alt="<?= esc_attr($video['video_title']) ?>" loading="lazy">
                                
                                <!-- Play кнопка -->
                                <div class="video-item__play-btn">
                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                        <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
                                        <path d="M25 20L40 30L25 40V20Z" fill="#007bff"/>
                                    </svg>
                                </div>
                                
                                <!-- Overlay при наведении -->
                                <div class="video-item__overlay"></div>
                            </div>
                            
                            <div class="video-item__content">
                                <h3 class="video-item__title"><?= $video['video_title'] ?></h3>
                                
                                <?php if ($developer): ?>
                                <div class="offer-item__info">
                                    <div class="offer-item__infoname  offer-item__infoname--check ">
                                        <a href="<?= get_permalink($developer->ID) ?>" class="video-item__developer-link">
                                            <?= $developer->post_title ?>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Кнопки слайдера как в секции отзывов -->
            <button type="button" aria-label="Кнопка слайдера предыдущая"
              class="videos__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
            <button type="button" aria-label="Кнопка слайдера следующая"
              class="videos__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
        </div>
    </div>
</section>

<!-- Модальное окно для видео -->
<div class="video-modal" id="videoModal">
    <div class="video-modal__overlay"></div>
    <div class="video-modal__content">
        <button type="button" class="video-modal__close" id="closeVideoModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
            </svg>
        </button>
        <div class="video-modal__video-container">
            <iframe id="videoFrame" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
/* Стили для видео секции */
.videos {
    padding: 60px 0;
    background: #f8f9fa;
}

.videos__header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.videos__buttons {
    display: flex;
    gap: 15px;
}

.video-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.video-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.video-item__thumbnail {
    position: relative;
    height: 200px;
    cursor: pointer;
    overflow: hidden;
}

.video-item__play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: transform 0.3s ease;
}

.video-item__thumbnail:hover .video-item__play-btn {
    transform: translate(-50%, -50%) scale(1.1);
}

.video-item__overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-item__thumbnail:hover .video-item__overlay {
    opacity: 1;
}

.video-item__content {
    padding: 20px;
}

.video-item__title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    line-height: 1.4;
}

.video-item__developer {
    margin-bottom: 10px;
}

.video-item__developer-link {
    text-decoration: none;
    font-size: 14px;
}

.video-item__developer-link:hover {
    text-decoration: underline;
}

/* Модальное окно видео */
.video-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: none;
}

.video-modal__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
    border: none;
    color: white;
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

/* --- Кнопки навигации (позиционирование); сама иконка берётся из icon-arrow-d-b --- */
.videos__swiper-button-prev,
.videos__swiper-button-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border: none;
    background: transparent;
    cursor: pointer;
    z-index: 10;
}

.videos__swiper-button-prev { left: 10px; }
.videos__swiper-button-next { right: 10px; }

/* (Важно) Удалены кастомные стрелки и запрет на ::before, чтобы работала icon-arrow-d-b */
/* БЫЛО РАНЬШЕ — удалено:
.videos__swiper-button-prev::after,
.videos__swiper-button-next::after { ... }

.videos__swiper-button-prev.swiper-button::before,
.videos__swiper-button-next.swiper-button::before { display: none; }
*/

@media (max-width: 768px) {
    .videos__header-row {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .videos__buttons {
        justify-content: center;
    }
    
    .video-modal__content {
        width: 95%;
    }
    
    .video-modal__close {
        top: -50px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const closeBtn = document.getElementById('closeVideoModal');
    const overlay = document.querySelector('.video-modal__overlay');
    
    // Открытие видео
    document.addEventListener('click', function(e) {
        const videoTrigger = e.target.closest('[data-video-id]');
        if (videoTrigger) {
            e.preventDefault();
            const videoId = videoTrigger.getAttribute('data-video-id');
            const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0`;
            
            videoFrame.src = embedUrl;
            videoModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    });
    
    // Закрытие модального окна
    function closeModal() {
        videoModal.style.display = 'none';
        videoFrame.src = '';
        document.body.style.overflow = '';
    }
    
    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.style.display === 'block') {
            closeModal();
        }
    });
});
</script>