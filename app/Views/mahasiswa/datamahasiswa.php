<?= form_open('mahasiswa/hapusbanyak', ['class' => 'formhapusbanyak']) ?>
<p>
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash-o"></i> Hapus Banyak
    </button>
</p>
<table class="table table-sm table-striped" id="datamahasiswa">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="centangSemua">
            </th>
            <th>No</th>
            <th>No.BP</th>
            <th>Nama Mahasiswa</th>
            <th>Tempat Lahir</th>
            <th>Tgl.Lahir</th>
            <th>Jenkel</th>
            <th>Prodi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    </tbody>
</table>
<?= form_close(); ?>
<script>
function listdatamahasiswa() {
    var table = $('#datamahasiswa').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('mahasiswa/listdata') ?>",
            "type": "POST"
        },
        //optional
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    })
}
$(document).ready(function() {
    // $('#datamahasiswa').DataTable();
    listdatamahasiswa();

    $('#centangSemua').click(function(e) {

        if ($(this).is(':checked')) {
            $('.centangNobp').prop('checked', true);
        } else {
            $('.centangNobp').prop('checked', false);
        }
    });

    $('.formhapusbanyak').submit(function(e) {
        e.preventDefault();
        let jmldata = $('.centangNobp:checked');

        if (jmldata.length === 0) {

            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: 'Maaf silahkan pilih data yang mau dihapus !'
            });

        } else {

            Swal.fire({
                title: 'Hapus Data Banyak',
                text: `Yakin data mahasiswa dihapus sebanyak ${jmldata.length} data ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya,Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.sukses
                                });
                                datamahasiswa();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    });
                }


            })

        }
        return false;
    });
});

function edit(nobp) {
    $.ajax({
        type: "post",
        url: "<?= site_url('mahasiswa/formedit') ?>",
        data: {
            nobp: nobp
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.viewmodal').html(response.sukses).show();
                $('#modaledit').modal('show');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                thrownError);
        }
    });
}

function hapus(nobp) {
    Swal.fire({
        title: 'Hapus',
        text: `Yakin menghapus data mahasiswa ini dengan nobp ${nobp} ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'tidak',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "<?= site_url('mahasiswa/hapus') ?>",
                data: {
                    nobp: nobp
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });
                        datamahasiswa();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
        }
    })
}
</script>