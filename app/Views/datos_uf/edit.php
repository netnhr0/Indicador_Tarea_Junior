<?= $this->extend('master/main') ?>

<?= $this->section('title') ?>
	<title>Datos Historicos UF | Edit</title>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <a href="<?= base_url() ?>/" class="btn btn-success">Inicio</a>
    <a href="<?= base_url() ?>/uf/dato_historico" class="btn btn-success">Datos Historio UF</a><br>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <form action="<?= base_url()?>/uf/editar/<?= $id?>" method="post">
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input name="fecha" type="date" class="form-control" id="fecha" value="<?= $fecha?>">
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input name="valor" type="numeric" class="form-control" id="valor" value="<?= $valor?>">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
<?= $this->endSection() ?>

