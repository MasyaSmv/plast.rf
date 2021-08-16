<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php
    include ('../../../header.php');
    include ('../left_menu.html');
    include ('../../../dbconnect.php');

	// Запросы в бд для списка городов и стран
	$city = "SELECT city
			FROM `city_id`";
	$state = "SELECT state_ru
			FROM `state_id`";
	$resCity = $mysqli -> query($city);
	$resState = $mysqli -> query($state);


    ?>

	<!-- Скрипты жквери для списка городов и стран -->
	<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://snipp.ru/cdn/chosen/1.8.7/chosen.jquery.min.js"></script>
	<script>
		$(document).ready(function () {
			$('.js-chosen-city').chosen({
				width: '100%',
				no_resCitys_text: 'Совпадений не найдено',
				placeholder_text_single: 'Выберите город'
			});
		});
		$(document).ready(function () {
			$('.js-chosen-state').chosen({
				width: '100%',
				no_resCitys_text: 'Совпадений не найдено',
				placeholder_text_single: 'Выберите страну'
			});
		});
	</script>
</head>

<body>
	<!-- Блок с номером телефона -->
	<div class="accordion dW35KL" id="accordionExample">
		<div class="card G5n7T">
			<div class="card-header list-group-item list-group-item-action active U8iN4" id="headingOne">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-left pHFe3 " type="button" data-toggle="collapse"
						data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Номер телефона
					</button>
				</h2>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				<div class="card-body">
					<form method="POST" action="action.php" name="compPhone">
						<label">Номер телефона</label>
						<div class="G9o7T">
							<div class="Yt9N8">
								<input type="text" class="form-control U30lM" name="compPhone" minlength="2" maxlength="255"
									required placeholder="8"/>
							</div>
							<div class="form-group"><br />
								<input class="btn btn-outline-primary Lo6MV" type="submit" name="btn_comp_phone"
									value="Отправить">
							</div>
							</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Блок с адресными данными -->
		<div class="card G5n7T">
			<div class="card-header U8iN4" id="headingTwo">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-left collapsed pHFe3" type="button"
						data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
						aria-controls="collapseTwo">
						Адрес
					</button>
				</h2>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				<div class="card-body">
					<form>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputCity">Страна</label>
								<select class="form-control js-chosen-state" id="inputState" name="state">
									<!-- Выпадающий список со странами из бд -->
									<?
		if (!$resState) {
			die('Неверный запрос: ' . mysqli_error($link));
		}
		else {
			while ($pow = mysqli_fetch_array($resState)) {?>
									<option></option>
									<option>
										<tr>
											<td>
												<?echo $pow['state_ru'] ;?>
											</td>
										</tr>
										<?}
		}
			?>
									</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="inputState">Город</label>
								<select class="form-control js-chosen-city" id="inputCity" name="city">
									<!-- Выпадающий список с городами из бд -->
									<?
		if (!$resCity) {
			die('Неверный запрос: ' . mysqli_error($link));
		}
		else {
			while ($pow = mysqli_fetch_array($resCity)) {?>
									<option></option>
									<option>
										<tr>
											<td>
												<?echo $pow['city'] ;?>
											</td>
										</tr>
										<?}
		}
			?>
									</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label for="inputZip">Индекс</label>
								<input type="text" class="form-control" id="inputZip">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-8">
								<label for="inputAddress">Улица</label>
								<input type="text" class="form-control" id="inputStreet">
							</div>
							<div class="form-group col-md-2">
								<label for="inputHome">Дом</label>
								<input type="text" class="form-control" id="inputHome">
							</div>
							<div class="form-group col-md-2">
								<label for="inputOffice">кв/офис</label>
								<input type="text" class="form-control" id="inputOffice">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Отправить</button>
					</form>
				</div>
			</div>
		</div>
		<!-- Блок с сайтом -->
		<div class="card G5n7T">
			<div class="card-header U8iN4" id="headingThree">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-left collapsed pHFe3" type="button"
						data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
						aria-controls="collapseThree">
						Вебсайт
					</button>
				</h2>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				<div class="card-body">
					<form method="POST" action="action.php" name="site">
						<label">Сайт</label>
							<div class="3Eg4M">
								<input type="text" class="form-control" name="site" minlength="2" maxlength="255"
									required />
							</div>
							<div class="form-group"><br />
								<input class="btn btn-outline-primary" type="submit" name="btn_submit_site"
									value="Отправить">
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#myList a').on('click', function (event) {
			event.preventDefault()
			$(this).tab('show')
		})
	</script>
	<?echo '<pre>';
            print_r($_SESSION);
            ?>
</body>

</html>
