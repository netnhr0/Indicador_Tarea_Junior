<?= $this->extend('master/main') ?>

<?= $this->section('title') ?>
	<title>Indicador Economico - Junior</title>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
	<a href="<?= base_url() ?>/uf/dato_historico" class="btn btn-success">Datos Historio UF</a><br>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
	<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<div class="row">
		<?php 
			$contador = 0;
			foreach ($api as $key => $value) {
				$contador++;
				if ($contador>3) { ?>
					<div class="col-6 col-sm-3">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" onclick="indicador(this.value)" value="<?php echo $value->codigo ?>" id="<?php echo "ind".$value->codigo ?>">
							<label class="form-check-label" for="flexCheckDefault">
								<?php echo $value->codigo; ?>
							</label>
						</div>
					</div>
		<?php	}
			}
		?>
	</div><br>
	
	<canvas id="myChart" width="50"></canvas>
	
	<script>

		const MONTHS = [  'January',  'February',  'March',  'April',  'May',  'June',  'July',  'August',  'September',
		'October',  'November',  'December'];

		xLabels = [];
		title = [];
		var ctx = document.getElementById('myChart').getContext('2d');
		var data = {
			labels: xLabels,
			datasets: [{
				label: title,
				data: [],
				backgroundColor: 'transparent',
				borderColor: 'red',
				borderWidth: 1
			}]
		};
		myChart = new Chart(ctx, {
			type: 'line',
			data: data,
			options: {
				scales: {
					x: {
						title: {
							display: true,
							text: 'Tiempo'
						},
					},
					y: {
						title: {
							display: true,
							text: 'Value'
						}
					}
				}
			}
		});

		myChart.data.datasets.pop();
		myChart.update();

		function addData(chart, fecha, nombre, valor) {
			arr_valor = [];
			for (let i = 0; i < fecha.length; i++) {
				const element = fecha[i];
				xLabels.sort();
				if (!xLabels.includes(fecha[i])) {
					xLabels.push(element);
				}
			}
			
			for (let j = 0; j < xLabels.length; j++) {
				const element_2 = xLabels[j];
				const id_fecha = fecha.indexOf(element_2);
				if (id_fecha > -1) {
					arr_valor.push(valor[id_fecha]);
				}else{
					arr_valor.push('NaN');
				}
			}
							
			title.push(nombre);
			const data = {
				label: nombre,
				data: arr_valor,
				backgroundColor: 'transparent',
				borderColor: getRandomColor(),
				borderWidth: 1
			};
			chart.data.datasets.push(data);
			
			chart.update();
		}

		function removeData(chart, nombre) {
			var array = chart.data.datasets;
			for(x in array){
				var dele = array[x]['label'];
				if (dele == nombre) {
					chart.data.datasets.splice(x, 1);
				}
				chart.update();
		// const range = (start, stop, step) => Array.from({ length: (stop - start) / step + 1}, (_, i) => start + (i * step));
			}
		}

		function getRandomColor() {
			var letters = '0123456789ABCDEF';
			var color = '#';
			for (var i = 0; i < 6; i++) {
				color += letters[Math.floor(Math.random() * 16)];
			}
			return color;
		}


		function indicador(indica){
			$.ajax({
				url: "https://mindicador.cl/api/"+indica,
				type: "get",
				dataType: 'json',
				success: function(data){
					var dato = JSON.parse(JSON.stringify(data));
					var fecha = dato.serie.map(function(elem){
						return new Intl.DateTimeFormat('es-CL').format(new Date(elem.fecha));
					});
					var r_valor = dato.serie.map(function(elem){return elem.valor;});
					var isChecked = document.getElementById('ind'+indica);
					if (isChecked.checked) {
						if (dato['codigo'] == 'uf') {
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'ivp'){
							addData(myChart, fecha, dato['nombre'], r_valor);		
						}else if(dato['codigo'] == 'dolar'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'dolar_intercambio'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'euro'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'ipc'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'utm'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'imacec'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'tpm'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'libra_cobre'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'tasa_desempleo'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}else if(dato['codigo'] == 'bitcoin'){
							addData(myChart, fecha, dato['nombre'], r_valor);
						}
					}else{
						removeData(myChart, dato['nombre']);
					}
				}
			})
		};
	</script>
<?= $this->endSection() ?>