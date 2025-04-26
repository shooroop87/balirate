jQuery(document).ready(function($) {
            $(".first-filter__form button.button--white").click(function () {
				var curr = $(location).attr('href');
				window.location.href =curr;
                //location.curr;
                
            });
        });