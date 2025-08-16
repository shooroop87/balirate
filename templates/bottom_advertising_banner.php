<?php if ((isset($args['bottom_banner_pk'])) && (!empty($args['bottom_banner_pk']))) { ?>
    <a href="#" data-popup="#popup-lead" class="w-100">
        <img src="<?=$args['bottom_banner_pk']['sizes']['banner_desc']?>" class="banner-pk __bottom" alt="<?= $args['bottom_banner_pk']['alt'] ?>" title="<?= $args['bottom_banner_pk']['title'] ?>">
    </a>
<?php } ?>

<?php if (isset($args['bottom_banner_mob'])) { ?>
    <a href="#" data-popup="#popup-lead" class="w-100">
        <img src="<?=$args['bottom_banner_mob']['sizes']['banner-vertical']?>" class="banner-mob __bottom" alt="<?= $args['bottom_banner_mob']['alt'] ?>" title="<?= $args['bottom_banner_mob']['title'] ?>">
    </a>
<?php } ?>