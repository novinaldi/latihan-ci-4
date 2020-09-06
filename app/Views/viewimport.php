<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<div class="col-sm-12">
    <div class="page-title-box">
        <h4 class="page-title">Import Data</h4>
    </div>
</div>

<div class="col-sm-12">
    <div class="card m-b-30">
        <div class="card-body">

            <div class="card-title">
            </div>

            <p class="card-text">

                <?= form_open_multipart('import/do') ?>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Upload File</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="ff" name="ff" accept=".xls,.xlsx">
                        <div class="invalid-feedback errorff">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>

                <?= form_close(); ?>

            </p>
        </div>
    </div>
</div>
<?= $this->endSection(''); ?>