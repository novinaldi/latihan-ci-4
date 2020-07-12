<?= $this->extend('layout/main') ?>

<?= $this->section('menu') ?>

<li class="has-submenu">
    <a href="<?= site_url('layout/index') ?>"><i class="mdi mdi-airplay"></i>Beranda</a>
</li>

<li class="has-submenu">
    <a href="<?= site_url('mahasiswa/index') ?>">Mahasiswa</a>
</li>

<?= $this->endSection() ?>