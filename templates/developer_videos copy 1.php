<?php
/**
 * Шаблон видео для карточек застройщиков
 * Файл: templates/developer_videos.php
 */

if (!$args || empty($args['company_videos'])) return;

$lang = function_exists('pll_current_language') ? pll_current_language() : null;
?>

<section class="developer-videos">
  <div class="developer-videos__container">
    <h2 class="developer-videos__title title">Видео компании</h2>

    <!-- Всегда показываем сетку -->
    <div class="developer-videos__grid">
      <?php foreach ($args['company_videos'] as $video):
        $video_id = function_exists('get_youtube_video_id') ? get_youtube_video_id($video['video_url']) : null;
        if (!$video_id) continue;

        // эскиз с YouTube, как на главной
        $thumbnail = function_exists('get_youtube_thumbnail') ? get_youtube_thumbnail($video_id) : '';
      ?>
        <div class="developer-video-item">
          <div class="developer-video-item__thumbnail" data-video-id="<?= esc_attr($video_id) ?>">
            <img src="<?= esc_url($thumbnail) ?>" class="ibg" alt="<?= esc_attr($video['video_title']) ?>" loading="lazy">

            <div class="developer-video-item__play-btn" aria-hidden="true">
              <svg width="60" height="60" viewBox="0 0 60 60" fill="none" aria-hidden="true" focusable="false">
                <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
                <path d="M25 20L40 30L25 40V20Z" fill="#007bff"/>
              </svg>
            </div>

            <div class="developer-video-item__overlay" aria-hidden="true"></div>
          </div>

          <div class="developer-video-item__content">
            <h3 class="developer-video-item__title"><?= esc_html($video['video_title']) ?></h3>
            <?php if (!empty($video['video_description'])): ?>
              <p class="developer-video-item__description">
                <?= esc_html(wp_trim_words($video['video_description'], 15)) ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Модальное окно для видео (аналог главной, но с уникальными id) -->
<div class="video-modal" id="developerVideoModal" hidden>
  <div class="video-modal__overlay"></div>
  <div class="video-modal__content" role="dialog" aria-modal="true" aria-label="Видео">
    <button type="button" class="video-modal__close" id="closeDeveloperVideoModal" aria-label="Закрыть видео">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
      </svg>
    </button>
    <div class="video-modal__video-container">
      <iframe id="developerVideoFrame" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
  </div>
</div>

<style>
/* Блок секции (как на главной) */
.developer-videos { padding: 60px 0; background: #f8f9fa; }
.developer-videos__title { margin-bottom: 30px; text-align: left; }

/* Сетка карточек: 4 -> 3 -> 2 -> 1 */
.developer-videos__grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 25px;
}
@media (max-width: 1200px) { .developer-videos__grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 992px)  { .developer-videos__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .developer-videos__grid { grid-template-columns: 1fr; } }

/* Карточка видео — стилистика как на главной */
.developer-video-item {
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 4px 20px rgba(0,0,0,0.1);
  transition:transform .3s ease, box-shadow .3s ease;
}
.developer-video-item:hover { transform:translateY(-5px); box-shadow:0 8px 30px rgba(0,0,0,0.15); }

.developer-video-item__thumbnail {
  position:relative; height:200px; cursor:pointer; overflow:hidden;
}
.developer-video-item__overlay {
  position:absolute; inset:0; background:rgba(0,0,0,0.3); opacity:0; transition:opacity .3s ease;
}
.developer-video-item__thumbnail:hover .developer-video-item__overlay { opacity:1; }
.developer-video-item__play-btn {
  position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); transition:transform .3s ease;
}
.developer-video-item__thumbnail:hover .developer-video-item__play-btn { transform:translate(-50%,-50%) scale(1.05); }

.developer-video-item__content { padding:20px; }
.developer-video-item__title { font-size:16px; font-weight:600; margin-bottom:10px; color:#333; line-height:1.4; }
.developer-video-item__description { font-size:14px; color:#666; }

/* Модалка — как на главной */
.video-modal { position:fixed; inset:0; z-index:10000; display:none; }
.video-modal[hidden] { display:none !important; }
.video-modal__overlay { position:absolute; inset:0; background:rgba(0,0,0,0.8); }
.video-modal__content {
  position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
  width:90%; max-width:900px; aspect-ratio:16/9; background:#000; border-radius:8px; overflow:hidden;
}
.video-modal__close {
  position:absolute; top:-40px; right:0; background:none; border:0; color:#fff;
  font-size:24px; cursor:pointer; z-index:1; width:40px; height:40px; display:flex; align-items:center; justify-content:center;
}
.video-modal__video-container { width:100%; height:100%; }

@media (max-width: 768px) {
  .video-modal__content { width:95%; }
  .video-modal__close { top:-50px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal  = document.getElementById('developerVideoModal');
  const frame  = document.getElementById('developerVideoFrame');
  const close  = document.getElementById('closeDeveloperVideoModal');
  const overlay = modal ? modal.querySelector('.video-modal__overlay') : null;

  // Открытие по клику на миниатюру с data-video-id
  document.addEventListener('click', function(e) {
    const trigger = e.target.closest('.developer-video-item__thumbnail[data-video-id]');
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

  if (close)   close.addEventListener('click', closeModal);
  if (overlay) overlay.addEventListener('click', closeModal);

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.style.display === 'block') closeModal();
  });
});
</script>