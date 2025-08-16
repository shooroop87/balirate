
<? if ($args['banner_pk']) { ?>
    <?= $args['banner_url'] ? '<a href="' . $args['banner_url'] . '" class="w-100">' : '' ?>
        <img src="<?=$args['banner_pk']['sizes']['banner_desc']?>" class="banner-pk" alt="<?= $args['banner_pk']['alt'] ?>">
    <?= $args['banner_url'] ? '</a>' : '' ?>
<? } ?>

<? if ($args['banner_mob']) { ?>
    <?= $args['banner_url'] ? '<a href="' . $args['banner_url'] . '" class="w-100>' : '' ?>
        <img src="<?=$args['banner_mob']['sizes']['banner-vertical']?>" class="banner-mob" alt="<?= $args['banner_mob']['alt'] ?>">
    <?= $args['banner_url'] ? '</a>' : '' ?>
<? } ?>