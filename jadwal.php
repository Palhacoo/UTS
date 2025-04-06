<?php
require 'config.php'; // Ganti dengan path yang sesuai
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data jadwal dari database
$sql = "SELECT * FROM jadwal";
$result = $conn->query($sql);

// Variabel untuk data yang akan diupdate
$updateData = null;
if (isset($_GET['update_id'])) {
    $updateId = $_GET['update_id'];
    $updateSql = "SELECT * FROM jadwal WHERE id = '$updateId'";
    $updateResult = $conn->query($updateSql);
    $updateData = $updateResult->fetch_assoc();
}

// Ambil pesan error dari URL parameter
$error_message = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="jadwal.css">
    <script>
        function toggleUpdateForm() {
            const form = document.getElementById('updateForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        function toggleTambahForm() {
            const form = document.getElementById('tambahForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4">Jadwal Kuliah</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <!-- Tabel Jadwal -->
        <table class="table table-bordered table-striped">
            <thead class="table-warning">
                <tr>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Hari Matakuliah</th>
                    <th>NIK</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['kode_matakuliah']; ?></td>
                    <td><?php echo $row['nama_matakuliah']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td><?php echo $row['hari_matkul']; ?></td>
                    <td><?php echo $row['nik']; ?></td>
                    <td><?php echo $row['user_input']; ?></td>
                    <td><?php echo $row['tanggal_input']; ?></td>
                    <td>
                        <?php if ($username == 'admin') : ?>
                            <div class="btn-group" role="group">
                                <a href="?update_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="toggleUpdateForm()">Update</a>
                                <form action="hapus_jadwal.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br/>

        <button class="btn btn-primary mb-3" onclick="toggleTambahForm()">Tambah Mata Kuliah</button>

        <!-- Form Update -->
        <?php if ($updateData): ?>
        <div id="updateForm" style="margin-top: 20px;">
            <h3>Update Mata Kuliah</h3>
            <form action="update_jadwal.php" method="post" class="mb-4">
                <input type="hidden" name="id" value="<?php echo $updateData['id']; ?>">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="kode_matakuliah" value="<?php echo $updateData['kode_matakuliah']; ?>" placeholder="Kode" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nama_matakuliah" value="<?php echo $updateData['nama_matakuliah']; ?>" placeholder="Nama Mata Kuliah" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" class="form-control" name="sks" value="<?php echo $updateData['sks']; ?>" placeholder="SKS" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" class="form-control" name="semester" value="<?php echo $updateData['semester']; ?>" placeholder="Semester" required>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="hari_matkul" required>
                            <option value="">Pilih Hari</option>
                            <option value="Senin" <?php echo ($updateData['hari_matkul'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                            <option value="Selasa" <?php echo ($updateData['hari_matkul'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                            <option value="Rabu" <?php echo ($updateData['hari_matkul'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                            <option value="Kamis" <?php echo ($updateData['hari_matkul'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                            <option value="Jumat" <?php echo ($updateData['hari_matkul'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                            <option value="Sabtu" <?php echo ($updateData['hari_matkul'] == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nik" value="<?php echo $updateData['nik']; ?>" placeholder="NIK Dosen" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- Form Tambah -->
        <?php if ($username == 'admin') : ?>
        <div id="tambahForm" style="display: none;">
            <h3>Tambah Mata Kuliah</h3>
            <form action="tambah_jadwal.php" method="post">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="kode_matakuliah" placeholder="Kode" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nama_matakuliah" placeholder="Nama Mata Kuliah" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" class="form-control" name="sks" placeholder="SKS" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" class="form-control" name="semester" placeholder="Semester" required>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="hari_matkul" required>
                            <option value="">Pilih Hari</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nik" placeholder="NIK Dosen" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-warning">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>