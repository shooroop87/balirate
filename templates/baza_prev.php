<?
$id = get_the_ID();
$filds = get_fields($id);
?>

<div class="knowledge__rightitem">
              <a href="<?php the_permalink(); ?>" class="knowledge__rightimage">
                <? if ($filds['image']) { ?><img src="<?=$filds['image']['sizes']['baza_prev']?>" class="ibg" alt="<?php the_title(); ?>"  loading="lazy"><? } ?>
              </a>
              <div class="knowledge__rightcontent">
                <a href="<?php the_permalink(); ?>" class="knowledge__rightname"><?php the_title(); ?></a>
                <div class="knowledge__rightdate"><?=get_the_date() ;?></div>
              </div>
</div>

