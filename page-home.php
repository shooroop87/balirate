<?php
/**
 * Главный шаблон страницы (page-home.php).
 * Используется для отображения главной страницы сайта.
 * Использует данные из ACF (Advanced Custom Fields).
 */

// Подключаем header
get_header(); 

// Получаем ID текущей страницы и все ACF-поля
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
?>

<?php 
// --- ВКЛАДКИ С РЕЙТИНГАМИ ---
if ($page_fields['tabs']) { ?>
<section class="first">
  <div class="first__container">

    <!-- Рекламный баннер сверху -->
    <?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

    <!-- Заголовок рейтинга -->
    <h1 class="first__title title"><?= $page_fields['rating_title'] ?></h1>

    <div class="first__body">
      <div class="first__left">
        <!-- Вкладки -->
        <div data-tabs class="first__tabs">
          <nav data-tabs-titles class="first__tabsnavigation">
            <!-- Заголовки вкладок -->
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if ($tab['list']) : ?>
                <button type="button" class="first__tabstitle <?= $num === 0 ? '_tab-active' : '' ?>">
                  <?= $tab['title'] ?>
                </button>
              <?php endif; ?>
            <?php endforeach; ?>
          </nav>

          <!-- Контент вкладок -->
          <div data-tabs-body class="first__tabscontent">
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if ($tab['list']) : ?>
                <div class="first__tabsbody">
                  <div class="first__rows">
                    <!-- Элементы внутри вкладки (девелоперы и т.п.) -->
                    <?php foreach ($tab['list'] as $item): ?>
                      <?php get_template_part('templates/item', null, $item); ?>
                    <?php endforeach; ?>
                  </div>

                  <!-- Кнопка "смотреть весь список" + подсказка -->
                  <div class="first__leftbottom">
                    <a href="<?= get_permalink(132); ?>" class="first__leftlink button button--gray">Смотреть весь список</a>
                    <div class="first__tippy"
                      data-tippy-content="<strong><?= $page_fields['rate_text'] ?></strong><br/><br/><p><?= $page_fields['rate_text2'] ?></p>"
                      data-tippy-allowhtml="true"
                      data-tippy-placement="bottom-end"
                      data-tippy-arrow="false">
                      <?= $page_fields['rate_text'] ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Рекламные баннеры справа -->
      <?php if ($page_fields['banners']) : ?>
        <div class="first__right first__right--mt">
          <div class="first__rightitems adsitems">
            <?php foreach ($page_fields['banners'] as $item): ?>
              <div class="adsitems__item adsitems-item">
                <a href="<?= $item['link'] ?>" target="_blank" rel="nofollow">
                  <img src="<?= $item['image']['sizes']['banner-vertical'] ?>" alt="<?= $item['name'] ?>" loading="lazy">
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Рекламный баннер внизу -->
    <?php get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
  </div>
</section>
<?php } ?>

<?php 
// --- СЕКЦИЯ "ПРЕДЛОЖЕНИЯ" (объекты) ---
if ($page_fields['offers']) { ?>
<section class="offers">
  <div class="offers__container">
    <h2 class="offers__title title"><?= $page_fields['offer_title'] ?></h2>
    <a href="<?= get_permalink(195); ?>" class="offers__link button button--gray">Смотреть все объекты</a>

    <div class="offers__slidercont slidercont">
      <div class="offers__slider swiper">
        <div class="offers__wrapper swiper-wrapper">
          <?php foreach ($page_fields['offers'] as $item): ?>
            <?php get_template_part('templates/offer', null, $item); ?>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- Кнопки навигации -->
      <button class="offers__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="offers__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php } ?>

<?php 
// --- СЕКЦИЯ "АГЕНТЫ" (пока закомментирована) ---
if ($page_fields['agent_list']) : ?>
  <!-- Тут выводятся агенты через шаблон templates/agent.php -->
<?php endif; ?>

<?php 
// --- СЕКЦИЯ "МЕРОПРИЯТИЯ" (events) ---
query_posts([
  'posts_per_page' => 6,
  'post_type'      => 'events',
  'meta_key'       => 'date',
  'orderby'        => 'meta_value',
  'order'          => 'DESC',
  'meta_query'     => [[
    'key'     => 'date',
    'value'   => date('Y/m/d'),
    'type'    => 'date',
    'compare' => '>',
  ]]
]);
if (have_posts()) { ?>
<section class="events">
  <div class="events__container">
    <h2 class="events__title title">Мероприятия</h2>
    <div class="events__slidercont slidercont">
      <div class="events__slider swiper">
        <div class="events__wrapper swiper-wrapper">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/event'); ?>
          <?php endwhile; ?>
        </div>
      </div>
      <button class="events__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="events__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>





<?php
// --- СЕКЦИЯ "ОТЗЫВЫ" ---
$reviews_query = new WP_Query([
	'posts_per_page' => 200,
	'post_type'      => 'review'
]);

if ($reviews_query->have_posts()): ?>
	<section class="devscomments">
		<div class="devscomments__container">
			<div class="devscomments__top">
				<h2 class="devscomments__title title">Отзывы на девелоперов</h2>
				<div class="devscomments__toptiv"><?= wp_count_posts('review')->publish ?></div>
			</div>

			<div class="devscomments__slidercont slidercont">
				<div class="devscomments__slider swiper">
					<div class="devscomments__wrapper swiper-wrapper">
						<?php while ($reviews_query->have_posts()): $reviews_query->the_post(); ?>
							<?php get_template_part('templates/review', null, get_post()); ?>
						<?php endwhile; ?>
					</div>
				</div>

				<!-- Кнопки слайдера -->
				<button type="button" aria-label="Кнопка слайдера предыдущая"
					class="devscomments__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
				<button type="button" aria-label="Кнопка слайдера следующая"
					class="devscomments__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_postdata(); ?>


<?php 
// --- СЕКЦИЯ "НОВОСТИ" ---
query_posts([
  'posts_per_page' => 4,
  'post_type'      => 'news',
]);
if (have_posts()) { ?>
<section class="news">
  <div class="news__container">
    <h2 class="news__title title">Новости</h2>
    <?php $k = 0; ?>
    <?php while (have_posts()) : the_post(); $k++; ?>
      <?php
      if ($k == 1) {
        get_template_part('templates/newbig');
      } else {
        get_template_part('templates/null');
      }
      ?>
    <?php endwhile; ?>

    <!-- Слайдер новостей -->
    <div class="news__slidercont slidercont">
      <div class="news__slider swiper">
        <div class="news__wrapper swiper-wrapper">
          <?php
          $k = 0;
          while (have_posts()) : the_post(); $k++;
            if ($k > 1) {
              get_template_part('templates/new_prev');
            } else {
              get_template_part('templates/null');
            }
          endwhile;
          ?>
        </div>
      </div>
      <button class="news__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="news__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>

<?php 
// --- СЕКЦИЯ "БАЗА ЗНАНИЙ" ---
query_posts([
  'posts_per_page' => 4,
  'post_type'      => 'knowledge',
]);
if (have_posts()) { ?>
<section class="knowledge">
  <div class="knowledge__container">
    <div class="knowledge__left">
      <img src="<?= $page_fields['baza_image']['sizes']['bazaimage'] ?>" alt="<?= $page_fields['title'] ?>" loading="lazy">
      <div class="knowledge__lefttop">
        <h2 class="knowledge__lefttitle title"><?= $page_fields['baza_title'] ?></h2>
        <div class="knowledge__lefttext"><?= $page_fields['baza_text'] ?></div>
      </div>
      <a href="<?= get_permalink(177); ?>" class="knowledge__leftbutton button button--gray button--fw">Больше о недвижимости</a>
    </div>
    <div class="knowledge__right">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('templates/baza_prev'); ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>

<?php
// Подключаем footer
get_footer();
