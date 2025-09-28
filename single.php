<?php
get_header(); 

    do_action( 'actions_before_content_wrapper' );
	
	    do_action( 'actions_before_single' );
		
            do_action( 'actions_single_post_elements' ); // Give your elements priorities so that they hook in the right place.
			
		    do_action( 'actions_single_post_comments' );
			
        do_action( 'actions_after_single' );
		
    do_action( 'actions_after_content_wrapper' );	
?>
<form id="add_review">
    <h3>Добавление отзыва</h3>
    <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
    <input type="text" name="name" placeholder="Ваше Имя" required>
    <textarea name="message" placeholder="Ваше сообщение" required></textarea>
    <div class="rating__group">
        <input class="rating__star" type="radio" name="rating" value="1" aria-label="Ужасно">
        <input class="rating__star" type="radio" name="rating" value="2" aria-label="Сносно">
        <input class="rating__star" type="radio" name="rating" value="3" aria-label="Нормально">
        <input class="rating__star" type="radio" name="rating" value="4" aria-label="Хорошо">
        <input class="rating__star" type="radio" name="rating" value="5" aria-label="Отлично" checked>
    </div>
    <input type="submit" value="Отправить">
</form>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#add_review").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/wp-content/themes/actions/includes/add-review.php",
        data: $(this).serialize(),
        success: () => {
            console.log("Спасибо. Ваш отзыв отправлен.");
            $(this).trigger("reset"); // очищаем поля формы
        },
        error: () => { console.log("Ошибка отправки.");
    }
    });
});
});
</script>
<?php
get_footer();