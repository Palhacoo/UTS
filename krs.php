<?php
require "config.php";

// Ambil data dari view KRS dan urutkan berdasarkan kode matakuliah
$sql = "SELECT * FROM krs ORDER BY kode_matakuliah";
$result = $conn->query($sql);

// Simpan data dalam array terstruktur berdasarkan kode mata kuliah
$data_krs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data_krs[$row['kode_matakuliah']]['nama_matakuliah'] = $row['nama_matakuliah'];
        $data_krs[$row['kode_matakuliah']]['hari_matkul'] = $row['hari_matkul'];
        $data_krs[$row['kode_matakuliah']]['dosen'] = [
            'nik' => $row['nik'],
            'nama_dosen' => $row['nama_dosen']
        ];
        $data_krs[$row['kode_matakuliah']]['mahasiswa'][] = [
            'nim' => $row['nim'],
            'nama_mahasiswa' => $row['nama_mahasiswa']
        ];
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi (KRS)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="krs.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Kartu Rencana Studi (KRS)</h2>
        <a href="tambah_krs.php" class="btn btn-primary mb-3">Tambah Data</a>
        <a href="index.php" class="btn btn-secondary mb-3">Home</a>
        
        <?php if (!empty($data_krs)): ?>
            <?php foreach ($data_krs as $kode_matkul => $info): ?>
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Kode: <?= htmlspecialchars($kode_matkul) ?> - <?= htmlspecialchars($info['nama_matakuliah']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Hari:</strong> <?= htmlspecialchars($info['hari_matkul']) ?></p>
                        <p><strong>Dosen:</strong> <?= htmlspecialchars($info['dosen']['nama_dosen']) ?> (NIK: <?= htmlspecialchars($info['dosen']['nik']) ?>)</p>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($info['mahasiswa'] as $mhs): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($mhs['nim']) ?></td>
                                        <td><?= htmlspecialchars($mhs['nama_mahasiswa']) ?></td>
                                        <td>
                                            <a href="hapus_krs.php?nim=<?= $mhs['nim'] ?>&kode_matakuliah=<?= $kode_matkul ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class='text-center'>Tidak ada data</p>
        <?php endif; ?>
    </div>
</body>
</html>
