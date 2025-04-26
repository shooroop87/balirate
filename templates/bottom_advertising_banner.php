
<? if ((isset($args['bottom_banner_pk'])) and (!empty($args['bottom_banner_pk']))) { ?>
    <?= $args['bottom_banner_url'] ? '<a href="' . $args['bottom_banner_url'] . '" class="w-100">' : '' ?>
        <img src="<?=$args['bottom_banner_pk']['sizes']['banner_desc']?>" class="banner-pk __bottom" alt="<?= $args['bottom_banner_pk']['alt'] ?>" title="<?= $args['bottom_banner_pk']['title'] ?>">
    <?= $args['bottom_banner_url'] ? '</a>' : '' ?>
<? } ?>

<? if (isset($args['bottom_banner_mob'])) { ?>
    <?= $args['bottom_banner_url'] ? '<a href="' . $args['bottom_banner_url'] . '" class="w-100>' : '' ?>
        <img src="<?=$args['bottom_banner_mob']['sizes']['banner-vertical']?>" class="banner-mob __bottom" alt="<?= $args['bottom_banner_mob']['alt'] ?>" title="<?= $args['bottom_banner_mob']['title'] ?>">
    <?= $args['bottom_banner_url'] ? '</a>' : '' ?>
<? } ?>