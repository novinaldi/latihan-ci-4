<table class="table table-sm table-striped" id="datamahasiswa">
    <thead>
        <tr>
            <th>No</th>
            <th>No.BP</th>
            <th>Nama Mahasiswa</th>
            <th>Tempat Lahir</th>
            <th>Tgl.Lahir</th>
            <th>Jenkel</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $nomor = 0;
        foreach ($tampildata as $row) :
            $nomor++;
        ?>
        <tr>
            <td><?= $nomor ?></td>
            <td><?= $row['nobp'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['tmplahir'] ?></td>
            <td><?= $row['tgllahir'] ?></td>
            <td><?= $row['jenkel'] ?></td>
            <td>
                <button type="button" class="btn btn-info btn-sm" onclick="edit('<?= $row['nobp'] ?>')">
                    <i class="fa fa-tags"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $row['nobp'] ?>')">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#datamahasiswa').DataTable();
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