<?php
require 'config.php';

$sql = "SELECT * FROM jadwal";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) : ?>
<tr>
    <td><?php echo $row['kode_matakuliah']; ?></td>
    <td><?php echo $row['nama_matakuliah']; ?></td>
    <td><?php echo $row['sks']; ?></td>
    <td><?php echo $row['semester']; ?></td>
    <td><?php echo $row['user_input']; ?></td>
    <td><?php echo $row['tanggal_input']; ?></td>
    <td>
        <form class="form-update">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="kode_matakuliah" value="<?php echo $row['kode_matakuliah']; ?>" required>
            <input type="text" name="nama_matakuliah" value="<?php echo $row['nama_matakuliah']; ?>" required>
            <input type="number" name="sks" value="<?php echo $row['sks']; ?>" required>
            <input type="number" name="semester" value="<?php echo $row['semester']; ?>" required>
            <button type="submit">Update</button>
        </form>
        <button class="hapus-btn" data-id="<?php echo $row['id']; ?>">Hapus</button>
    </td>
</tr>
<?php endwhile; ?>