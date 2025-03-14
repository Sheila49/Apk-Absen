<?php
$file = 'data_absensi.csv';

// Cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $status = $_POST["status"];
    $keterangan = $_POST["keterangan"] ?? '';

    // Simpan data ke dalam file CSV
    $data = [$nama, $status, $keterangan];
    $fp = fopen($file, 'a');
    fputcsv($fp, $data);
    fclose($fp);

    echo "<p>Data absensi berhasil disimpan!</p>";
}

// Baca data absensi dari CSV
$absensi = [];
if (file_exists($file)) {
    $fp = fopen($file, "r");
    while ($row = fgetcsv($fp)) {
        $absensi[] = $row;
    }
    fclose($fp);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Absensi Siswa</h1>
    <form method="POST">
        <label>Nama Siswa:</label>
        <input type="text" name="nama" required><br>
        <label>Status:</label>
        <select name="status" id="status" onchange="toggleKeterangan()">
            <option value="Hadir">Hadir</option>
            <option value="Tidak Hadir">Tidak Hadir</option>
        </select><br>
        <div id="keteranganField" style="display: none;">
            <label>Keterangan:</label>
            <input type="text" name="keterangan"><br>
        </div>
        <button type="submit">Simpan</button>
    </form>

    <h2>Data Absensi</h2>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
        <?php foreach ($absensi as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row[0]) ?></td>
                <td><?= htmlspecialchars($row[1]) ?></td>
                <td><?= htmlspecialchars($row[2] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        function toggleKeterangan() {
            var status = document.getElementById("status").value;
            var keteranganField = document.getElementById("keteranganField");
            keteranganField.style.display = status === "Tidak Hadir" ? "block" : "none";
        }
    </script>
</body>
</html>
