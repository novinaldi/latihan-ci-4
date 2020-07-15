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

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#datamahasiswa').DataTable();
});
</script>