<div class="modal fade" id="modalupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field(); ?>
            <input type="hidden" value="<?= $nobp ?>" name="nobp">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Upload Foto</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="foto" name="foto">
                        <div class="invalid-feedback errorfoto">

                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Ambil Gambar (WebCam)</label>
                    <div class="col-sm-6">
                        <div id="my_camera">

                        </div>
                        <p>
                            <button type="button" class="btn btn-sm btn-info" onclick="take_picture();">Ambil
                                Gambar</button>
                        </p>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Capture</label>
                    <div class="col-sm-6" id="results">

                    </div>
                    <input type="hidden" name="imagecam" class="image-tag">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.btnupload').click(function(e) {
        e.preventDefault();

        let form = $('.formupload')[0];

        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= site_url('mahasiswa/doupload') ?>",
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function(e) {
                $('.btnupload').prop('disabled', 'disabled');
                $('.btnupload').html(`<i class="fa fa-spin fa-spinner"></i>`);
            },
            complete: function(e) {
                $('.btnupload').removeAttr('disabled');
                $('.btnupload').html(`Upload`);
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.foto) {
                        $('#foto').addClass('is-invalid');
                        $('.errorfoto').html(response.error.foto);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: response.error,
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses,
                    });
                    $('#modalupload').modal('hide');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                    thrownError);
            }
        });
    });
});
</script>


<script>
Webcam.set({
    width: 320,
    height: 240,
    image_format: 'jpeg',
    jpeg_quality: 100
});
Webcam.attach('#my_camera');

function take_picture() {
    Webcam.snap(function(data_uri) {
        $(".image-tag").val(data_uri);

        document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';

    });
}
</script>