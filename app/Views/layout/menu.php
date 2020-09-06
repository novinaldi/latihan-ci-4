<?= $this->extend('layout/main') ?>

<?= $this->section('menu') ?>

<li class="has-submenu">
    <a href="<?= site_url('layout/index') ?>"><i class="mdi mdi-airplay"></i>Beranda</a>
</li>

<?php
$session = \Config\Services::session();
if ($session->idlevel == 1) :
?>
<li class="has-submenu">
    <a href="<?= site_url('mahasiswa/index') ?>">Mahasiswa</a>
</li>
<?php endif; ?>


<?php if ($session->idlevel == 2) : ?>
<li class="has-submenu">
    <a href="<?= site_url('dataku/index') ?>">Data Ku</a>
</li>
<?php endif; ?>

<?= $this->endSection() ?>