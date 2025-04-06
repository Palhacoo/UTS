<?php
require 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM dosen";
$result = $conn->query($sql);

$updateData = null;
if (isset($_GET['update_id'])) {
    $updateId = $_GET['update_id'];
    $updateSql = "SELECT * FROM dosen WHERE id = '$updateId'";
    $updateResult = $conn->query($updateSql);
    $updateData = $updateResult->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dosen.css">
    <script>
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('update_id')) {
                document.getElementById('updateForm').style.display = 'block';
            }
        };

        function toggleUpdateForm() {
            const form = document.getElementById('updateForm');
            if (form) {
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            }
        }

        function toggleTambahForm() {
            const form = document.getElementById('tambahForm');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
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
        <h2 class="my-4">Data Dosen</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-warning">
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gelar</th>
                    <th>Lulusan</th>
                    <th>No Telp</th>
                    <th>User Input</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['nik']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['gelar']; ?></td>
                    <td><?php echo $row['lulusan']; ?></td>
                    <td><?php echo $row['no_telp']; ?></td>
                    <td><?php echo $row['user_input']; ?></td>
                    <td><?php echo $row['tanggal_input']; ?></td>
                    <td>
                        <?php if ($username == 'admin') : ?>
                            <div class="btn-group" role="group">
                                <a href="?update_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="toggleUpdateForm()">Update</a>
                                <form action="hapus_dosen.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data dosen ini?')">Hapus</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button class="btn btn-primary mb-3" onclick="toggleTambahForm()">Tambah Dosen</button>

        <!-- Form Update -->
        <div id="updateForm" style="display: none; margin-top: 20px;">
            <h3>Update Dosen</h3>
            <?php if ($updateData): ?>
            <form action="update_dosen.php" method="post" class="mb-4">
                <input type="hidden" name="id" value="<?php echo $updateData['id']; ?>">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nik" value="<?php echo $updateData['nik']; ?>" placeholder="NIK" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nama" value="<?php echo $updateData['nama']; ?>" placeholder="Nama" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="gelar" value="<?php echo $updateData['gelar']; ?>" placeholder="Gelar" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="lulusan" value="<?php echo $updateData['lulusan']; ?>" placeholder="Lulusan" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="no_telp" value="<?php echo $updateData['no_telp']; ?>" placeholder="No Telp" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>

        <!-- Form Tambah -->
        <div id="tambahForm" style="display: none;">
            <h3>Tambah Dosen</h3>
            <form action="tambah_dosen.php" method="post">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nik" placeholder="NIK" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="gelar" placeholder="Gelar" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="lulusan" placeholder="Lulusan" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="no_telp" placeholder="No Telp" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-warning">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
