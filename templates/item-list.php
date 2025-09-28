<?php
// Получаем ID текущего поста
$id = is_object($args) ? $args->ID : get_the_ID();
$page_id = $id;

// Получаем все ACF-поля для этого поста
$filds = get_fields($id);

// Определяем тип поста
$post_type = get_post_type($id);

// Общее количество отзывов (кастомная функция)
$total_rev = gettotalrev($id);

// Рейтинг
$rate = $filds['rating'];

// Текущий язык сайта
$lang = pll_current_language();
?>

<!-- Обёртка одного элемента -->
<div class="first__row first-row <?php if ($filds['premium']) echo 'vipitem'; ?>">

    <!-- Логотип -->
    <?php if ($filds['f_logo']) : ?>
        <a href="<?= get_permalink($id); ?>" aria-label="Ссылка на страницу <?= $post_type === 'propertymanagement' ? 'управляющей компании' : 'застройщика' ?>" class="first-row__image">
            <img src="<?= $filds['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain" alt="<?= is_object($args) ? $args->post_title : get_the_title(); ?>" loading="lazy">
        </a>
    <?php endif; ?>

    <!-- Название с проверочными значками -->
    <a href="<?= get_permalink($id); ?>" class="first-row__name">
        <?= is_object($args) ? $args->post_title : get_the_title(); ?>
        <?php if ($filds['verif']) : ?>
            <span class="first-row__icon first-row__icon--check"></span>
        <?php endif; ?>
        <?php if ($filds['cup']) : ?>
            <span class="first-row__icon first-row__icon--cup"></span>
        <?php endif; ?>
    </a>

    <!-- Правая часть (рейтинг, сайт, кнопка) -->
    <div class="first-row__right">
        <!-- Виджет рейтинга -->
        <div data-rating data-rating-show data-rating-value="<?= $rate ?>" class="rating"></div>

        <!-- Ссылка на сайт -->
        <?php 
        $site_field = $post_type === 'propertymanagement' ? 'website' : 'sait';
        if ($filds[$site_field]) : ?>
            <a href="<?= $filds[$site_field] ?>" class="first-row__site first-row__site--top icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>

        <!-- Кнопка показа деталей -->
        <button type="button" aria-label="Кнопка раскрытия блока с показателями" class="first-row__arrow icon-arrow-d-b"></button>
    </div>

    <!-- Скрытый блок с преимуществами и оценками -->
    <div class="first-row__descs" hidden>

        <!-- Преимущества (список) -->
        <?php if ($filds['advantages']) : ?>
            <div class="first-row__descsitems">
                <?php foreach ($filds['advantages'] as $advantage) : ?>
                    <div class="first-row__descsitem"><?= $advantage['name'] ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Оценки по категориям -->
        <div class="first-row__descsrows">

            <?php if ($post_type === 'propertymanagement'): ?>
                <!-- Оценки для управляющих компаний -->
                <?php if (getMark($page_id, 'mark1') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Качество услуг</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue"
                                     style="width: <?= getMark($page_id, 'mark1') / 5 * 100 ?>%">
                                </div>
                            </div>
                            <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark1') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark2') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Скорость реагирования</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue"
                                     style="width: <?= getMark($page_id, 'mark2') / 5 * 100 ?>%">
                                </div>
                            </div>
                            <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark2') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark3') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Клиентский сервис</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue"
                                     style="width: <?= getMark($page_id, 'mark3') / 5 * 100 %>%">
                                </div>
                            </div>
                            <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark3') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark4') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Соотношение цена/качество</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue"
                                     style="width: <?= getMark($page_id, 'mark4') / 5 * 100 ?>%">
                                </div>
                            </div>
                            <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark4') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Оценки для застройщиков (как было раньше) -->
                <?php if (getMark($page_id, 'mark1') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Срок сдачи</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue"
                                     style="width: <?= getMark($page_id, 'mark1') / 5 * 100 ?>%">
                                </div>
                            </div>
                            <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark1') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Остальные оценки для застройщиков... -->
                
            <?php endif; ?>
        </div>
    </div>

    <!-- Нижний блок: количество объектов, отзывы, сайт -->
    <div class="first-row__bottom">
        <div class="first-row__bottominfos">

            <?php if ($post_type === 'propertymanagement'): ?>
                <!-- Информация для управляющих компаний -->
                <?php if ($filds['objects_count']) : ?>
                    <div class="first-row__bottominfo">
                        <span>Управляет объектами:</span>
                        <span><?= $filds['objects_count'] ?> <?= num_word($filds['objects_count'], [
                            get_field('text_obj1_' . $lang, 'options'),
                            get_field('text_obj2_' . $lang, 'options'),
                            get_field('text_obj3_' . $lang, 'options')
                        ]) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['founded_year']) : ?>
                    <div class="first-row__bottominfo">
                        <span>На рынке с:</span>
                        <span><?= $filds['founded_year'] ?> года</span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['city']) : ?>
                    <div class="first-row__bottominfo">
                        <span>Город:</span>
                        <span><?= $filds['city'] ?></span>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Информация для застройщиков (как было раньше) -->
                <?php if ($filds['sdano']) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_submitted_' . $lang, 'options'); ?>:</span>
                        <span><?= $filds['sdano'] ?> <?= num_word($filds['sdano'], [
                            get_field('text_obj1_' . $lang, 'options'),
                            get_field('text_obj2_' . $lang, 'options'),
                            get_field('text_obj3_' . $lang, 'options')
                        ]) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Остальная информация для застройщиков... -->
                
            <?php endif; ?>
        </div>

        <!-- Кол-во отзывов -->
        <?php if ($total_rev > 0) : ?>
            <a href="<?= get_permalink($id); ?>" target="_blank" rel="nofollow" class="first-row__comments icon-comments">
                <?= $total_rev ?> <?= num_word($total_rev, [
                    get_field('_text_rev1_' . $lang, 'options'),
                    get_field('_text_rev2_' . $lang, 'options'),
                    get_field('_text_rev3_' . $lang, 'options')
                ]) ?>
            </a>
        <?php endif; ?>

        <!-- Ссылка на сайт -->
        <?php if ($filds[$site_field]) : ?>
            <a href="<?= $filds[$site_field] ?>" class="first-row__site first-row__site--bottom icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>