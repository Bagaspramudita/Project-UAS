<?php
include "session.php";
include "config/koneksi.php";

// Ambil filter tanggal dari URL
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Validasi tanggal
if (!empty($tanggal)) {
    $tanggal = date('Y-m-d', strtotime($tanggal));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Penjualan</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }
        .transaction-table th, .transaction-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .transaction-table th {
            background-color: #f8f9fc;
            color: #4e73df;
        }
        .transaction-table td {
            color: #858796;
        }
        h3 {
            text-align: center;
            color: #2e6da4;
        }
        @media print {
            body { margin: 0; }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="container">
        <h3>Laporan Penjualan - <?php echo !empty($tanggal) ? "Tanggal: $tanggal" : "Semua Tanggal"; ?></h3>
        <div class="table-container">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Mobil</th>
                        <th>Jumlah</th>
                        <th>Harga Total</th>
                        <th>Tanggal</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = "SELECT 
                        t.id_transaksi,
                        p.nama AS nama_pelanggan,
                        m.nama_mobil AS nama_mobil,
                        t.jumlah,
                        t.harga_total,
                        DATE(t.tanggal_pembelian) AS tanggal_pembelian,
                        t.status_pembayaran
                    FROM 
                        tbl_transaksi_pembelian t
                        LEFT JOIN tbl_pelanggan p ON t.id_pelanggan = p.id_pelanggan
                        LEFT JOIN tbl_mobil m ON t.id_mobil = m.id_mobil
                    WHERE 1=1";
                    if (!empty($tanggal)) {
                        $query .= " AND DATE(t.tanggal_pembelian) = '$tanggal'";
                    }
                    $query .= " ORDER BY t.id_transaksi DESC";
                    $result = mysqli_query($koneksi, $query);
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($data['nama_pelanggan']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['nama_mobil']) . "</td>";
                        echo "<td>" . (int)$data['jumlah'] . "</td>";
                        echo "<td>Rp " . number_format($data['harga_total'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($data['tanggal_pembelian']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['status_pembayaran']) . "</td>";
                        echo "</tr>";
                    }
                    if (mysqli_num_rows($result) == 0) {
                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data penjualan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>