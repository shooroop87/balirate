<?php
/**
 * Шаблон фильтров для страницы рейтингов застройщиков.
 * Отображает форму с фильтрами в правой колонке.
 */

$lang = pll_current_language();
?>

<div class="first__right">
	<!-- Кнопка вызова фильтров на мобилках -->
	<button type="button" class="first__popuplink icon-filter" data-popup="#popup-filter">Фильтры</button>

	<!-- Блок фильтров -->
	<div class="first-filter" data-da=".popup-filter__body, 767.92, 0">
		<div class="first-filter__title">Фильтры</div>
		<form action="" class="first-filter__form" method="post">
			<div class="first-filter__blocks">
				<!-- Рейтинг -->
				<div class="first-filter__block">
					<div class="first-filter__blockname">Рейтинг</div>
					<div class="first-filter__checks">
						<?php for ($i = 5; $i >= 1; $i--): ?>
							<label class="checkbox__label">
								<input class="checkbox__input" type="checkbox" value="1" name="rating<?php echo $i; ?>" <?php if (isset($_POST['rating' . $i])) echo 'checked'; ?>>
								<span class="checkbox__text checkbox__rating">
									<img src="/img/rating-<?php echo $i; ?>.svg" alt="Rating <?php echo $i; ?>">
								</span>
							</label>
						<?php endfor; ?>
					</div>
				</div>

				<!-- Кол-во отзывов -->
				<div class="first-filter__block">
					<div class="first-filter__blockname">Количество отзывов</div>
					<div class="first-filter__checks">
						<?php
						$reviews = [
							['total1', 'До 50'],
							['total2', 'от 50 до 100'],
							['total3', 'от 100 до 500'],
							['total4', 'от 500 до 1 000'],
							['total5', 'более 1 000']
						];
						foreach ($reviews as $review):
							[$name, $label] = $review;
							?>
							<label class="checkbox__label">
								<input class="checkbox__input" type="checkbox" name="<?php echo $name; ?>" <?php if (isset($_POST[$name])) echo 'checked'; ?>>
								<span class="checkbox__text"><?php echo $label; ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Кол-во сданных объектов -->
				<div class="first-filter__block">
					<div class="first-filter__blockname">Количество сданных объектов</div>
					<div class="first-filter__checks">
						<?php
						$offers = [
							['offers1', 'от 10 до 50'],
							['offers2', 'от 50 до 250'],
							['offers3', 'от 250 до 1 000'],
							['offers4', 'более 1 000']
						];
						foreach ($offers as $offer):
							[$name, $label] = $offer;
							?>
							<label class="checkbox__label">
								<input class="checkbox__input" type="checkbox" name="<?php echo $name; ?>" <?php if (isset($_POST[$name])) echo 'checked'; ?>>
								<span class="checkbox__text"><?php echo $label; ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Дополнительно -->
				<div class="first-filter__block">
					<div class="first-filter__blockname">Дополнительно</div>
					<div class="first-filter__checks">
						<?php
						$extras = [
							['special', 'Наличие акций'],
							['uk', 'Своя УК'],
							['vznos', 'Первый взнос 20%']
						];
						foreach ($extras as $extra):
							[$name, $label] = $extra;
							?>
							<label class="checkbox__label">
								<input class="checkbox__input" type="checkbox" name="<?php echo $name; ?>" <?php if (isset($_POST[$name])) echo 'checked'; ?>>
								<span class="checkbox__text"><?php echo $label; ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<!-- Кнопки -->
			<button type="submit" class="button button--blue first-filter__button button--fw">Применить</button>
			<button type="reset" class="button button--white first-filter__button button--fw">Сбросить фильтры</button>
		</form>
	</div>
</div>