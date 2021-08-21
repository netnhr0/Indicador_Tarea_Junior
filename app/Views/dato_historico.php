<?= $this->extend('master/main') ?>

<?= $this->section('title') ?>
	<title>Datos Historicos UF</title>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <a href="<?= base_url() ?>/" class="btn btn-success">Inicio</a><br>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row g-2">
        <div class="col-4">
            <h5>Codigo</h5>
            <label class="form-check-label" >
                <?= $codigo ?>
            </label>
        </div>

        <div class="col-4">
            <h5>Nombre</h5>
            <label class="form-check-label" >
                <?= $nombre ?>
            </label>
        </div>

        <div class="col-4">
            <h5>Unidad Medida</h5>
            <label class="form-check-label" >
                <?= $unidad_medida ?>
            </label>
        </div>

        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Valor</th>
                <th scope="col">Configuracion</th>
                </tr>
            </thead>
            <tbody>
                <?php $contador = 0;?>
                <?php foreach ($serie as $key => $value): ?>
                    <?php $contador++?>
                    <tr>
                        <td><?= $contador?></td>
                        <td><?php $fecha = new DateTime($value->fecha); echo $fecha->format('d-m-Y') ?></td>
                        <td><?= $value->valor ?></td>
                        <td>
                            <a href="<?= base_url()?>/uf/editar/<?= $key?>" class="btn btn-outline-success btn-sm">Editar</a>
                            <a href="<?= base_url()?>/uf/delete/<?= $key?>" class="btn btn-outline-warning btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>

