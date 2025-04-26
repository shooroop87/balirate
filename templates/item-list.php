<?php
// Получаем ID текущего поста
$id = get_the_ID();
$page_id = $id;

// Получаем все ACF-поля для этого поста (девелопера)
$filds = get_fields($id);

// Общее количество отзывов (кастомная функция)
$total_rev = gettotalrev($id);

// Рейтинг девелопера
$rate = $filds['rating'];

// Текущий язык сайта (используется для многоязычности через Polylang)
$lang = pll_current_language();
?>

<!-- Обёртка одного элемента девелопера -->
<div class="first__row first-row <?php if ($filds['premium']) echo 'vipitem'; ?>">

    <!-- Логотип девелопера -->
    <?php if ($filds['f_logo']) : ?>
        <a href="<?= get_permalink($id); ?>" aria-label="Ссылка на страницу застройщика" class="first-row__image">
            <img src="<?= $filds['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain" alt="<?php the_title(); ?>" loading="lazy">
        </a>
    <?php endif; ?>

    <!-- Название девелопера -->
    <a href="<?= get_permalink($id); ?>" class="first-row__name <?php if ($filds['verif']) echo 'first-row__name--check'; ?>">
        <?php the_title(); ?>
    </a>

    <!-- Правая часть (рейтинг, сайт, кнопка открытия подробностей) -->
    <div class="first-row__right">
        <!-- Виджет рейтинга -->
        <div data-rating data-rating-show data-rating-value="<?= $rate ?>" class="rating"></div>

        <!-- Ссылка на сайт девелопера -->
        <?php if ($filds['sait']) : ?>
            <a href="<?= $filds['sait'] ?>" class="first-row__site first-row__site--top icon-arrow-r-t" target="_blank" rel="nofollow">
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

            <!-- Оценка: срок сдачи -->
            <?php if (getMark($page_id, 'mark1') > 0) : ?>
                <div class="first-row__descsrow">
                    <div class="first-row__descsrowleft"><?= pll_e('srok') ?></div>
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

            <!-- Оценка: премиальность -->
            <?php if (getMark($page_id, 'mark2') > 0) : ?>
                <div class="first-row__descsrow">
                    <div class="first-row__descsrowleft"><?= pll_e('premi') ?></div>
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

            <!-- Оценка: поддержка -->
            <?php if (getMark($page_id, 'mark3') > 0) : ?>
                <div class="first-row__descsrow">
                    <div class="first-row__descsrowleft"><?= pll_e('supp') ?></div>
                    <div class="first-row__descsrowright">
                        <div class="first-row__descsrowline">
                            <div class="first-row__descsrowlinevalue"
                                 style="width: <?= getMark($page_id, 'mark3') / 5 * 100 ?>%">
                            </div>
                        </div>
                        <div class="first-row__descsrowrating"><?= getMark($page_id, 'mark3') ?>/5</div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Оценка: качество строительства -->
            <?php if (getMark($page_id, 'mark4') > 0) : ?>
                <div class="first-row__descsrow">
                    <div class="first-row__descsrowleft"><?= pll_e('quality') ?></div>
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
        </div>
    </div>

    <!-- Нижний блок: количество объектов, отзывы, сайт -->
    <div class="first-row__bottom">
        <div class="first-row__bottominfos">

            <!-- Объекты: сдано -->
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

            <!-- Объекты: строится -->
            <?php if ($filds['stroitsya']) : ?>
                <div class="first-row__bottominfo">
                    <span><?php the_field('text_under_' . $lang, 'options'); ?>:</span>
                    <span><?= $filds['stroitsya'] ?> <?= num_word($filds['stroitsya'], [
                        get_field('text_obj1_' . $lang, 'options'),
                        get_field('text_obj2_' . $lang, 'options'),
                        get_field('text_obj3_' . $lang, 'options')
                    ]) ?></span>
                </div>
            <?php endif; ?>

            <!-- Объекты: всего -->
            <?php if ($filds['sdano'] && $filds['stroitsya']) : ?>
                <div class="first-row__bottominfo">
                    <span><?php the_field('text_total_' . $lang, 'options'); ?>:</span>
                    <span><?= $filds['sdano'] + $filds['stroitsya'] ?> <?= num_word($filds['sdano'] + $filds['stroitsya'], [
                        get_field('text_obj1_' . $lang, 'options'),
                        get_field('text_obj2_' . $lang, 'options'),
                        get_field('text_obj3_' . $lang, 'options')
                    ]) ?></span>
                </div>
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
        <?php if ($filds['sait']) : ?>
            <a href="<?= $filds['sait'] ?>" class="first-row__site first-row__site--bottom icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>