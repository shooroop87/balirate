<?php if ($args['banner_pk']) { ?>
    <a href="#" data-popup="#popup-lead" class="w-100">
        <img src="<?php echo $args['banner_pk']['sizes']['banner_desc']; ?>" class="banner-pk" alt="<?php echo $args['banner_pk']['alt']; ?>">
    </a>
<?php } ?>

<?php if ($args['banner_mob']) { ?>
    <a href="#" data-popup="#popup-lead" class="w-100">
        <img src="<?php echo $args['banner_mob']['sizes']['banner-vertical']; ?>" class="banner-mob" alt="<?php echo $args['banner_mob']['alt']; ?>">
    </a>
<?php } ?>