<?php
include "session.php";
include "config/koneksi.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT 
        t.id_transaksi,
        p.nama AS nama_pelanggan,
        m.nama_mobil,
        m.tipe,
        m.warna,
        m.tahun,
        t.jumlah,
        t.harga_satuan,
        t.harga_total,
        t.tanggal_pembelian,
        t.metode_pembayaran,
        t.status_pembayaran
    FROM 
        tbl_transaksi_pembelian t
    LEFT JOIN 
        tbl_pelanggan p ON t.id_pelanggan = p.id_pelanggan
    LEFT JOIN 
        tbl_mobil m ON t.id_mobil = m.id_mobil
    WHERE t.id_transaksi = '$id'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <title>Struk Transaksi - Mobil Biisapce<?php echo $data['id_transaksi']; ?></title>
            <link href="img/logo/image.jpg" rel="icon"> 
            <style>
                body {
                    font-family: 'Segoe UI', sans-serif;
                    margin: 0;
                    padding: 20mm;
                    font-size: 16px;
                    background: #0d47a1;
                    color: #fff;
                }
                .struk {
                    width: 80mm;
                    margin: 0 auto;
                    background: #ffffff;
                    color: #000000;
                    border: 2px solid #000;
                    border-radius: 6px;
                    padding: 25px;
                    box-shadow: 0 0 15px rgba(0,0,0,0.3);
                    position: relative;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header img {
                    max-width: 60px;
                    margin-bottom: 10px;
                }
                .header h2 {
                    margin: 0;
                    font-size: 24px;
                    text-transform: uppercase;
                    color: #0d47a1;
                }
                .header p {
                    font-size: 16px;
                    margin: 4px 0;
                }
                .details {
                    margin-bottom: 15px;
                }
                .details p {
                    margin: 6px 0;
                    font-size: 16px;
                }
                .total {
                    font-weight: bold;
                    font-size: 18px;
                    border-top: 1px dashed #000;
                    padding-top: 10px;
                    margin-top: 10px;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 15px;
                }
                .signature {
                    margin-top: 30px;
                    text-align: right;
                    font-size: 14px;
                }
                .signature img {
                    max-width: 100px;
                    margin-bottom: 5px;
                }
                .signature .nama {
                    font-weight: bold;
                    margin-top: -5px;
                }
                .qr-code {
                    text-align: center;
                    margin-top: 20px;
                }
                .qr-code img {
                    max-width: 100px;
                }
                @media print {
                    body {
                        padding: 0;
                        background: none;
                        color: #000;
                    }
                    .struk {
                        width: 80mm;
                        margin: 0 auto;
                        border: none;
                        box-shadow: none;
                        color: #000;
                    }
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>

        <body onload="window.print()">
            <div class="struk">
                <div class="header">
                    <img src="img/logo/image.jpg" alt="Logo">
                    <h2>Showroom Mobil Biispace</h2>
                    <p><strong>Struk Pembayaran</strong></p>
                    <p>Transaksi #<?php echo $data['id_transaksi']; ?></p>
                </div>
                <div class="details">
                    <p><strong>Tanggal:</strong> <?php echo $data['tanggal_pembelian']; ?></p>
                    <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($data['nama_pelanggan']); ?></p>
                    <p><strong>Mobil:</strong> <?php echo htmlspecialchars($data['nama_mobil'] . " (" . $data['tipe'] . ", " . $data['warna'] . ", " . $data['tahun'] . ")"); ?></p>
                    <p><strong>Jumlah:</strong> <?php echo $data['jumlah']; ?></p>
                    <p><strong>Harga Satuan:</strong> Rp <?php echo number_format($data['harga_satuan'], 0, ',', '.'); ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($data['metode_pembayaran']); ?></p>
                    <p><strong>Status Pembayaran:</strong> <?php echo htmlspecialchars($data['status_pembayaran']); ?></p>
                </div>
                <div class="total">
                    <p>Total Pembayaran: Rp <?php echo number_format($data['harga_total'], 0, ',', '.'); ?></p>
                </div>
                <div class="signature">
                    <p>Hormat Kami,</p>
                    <img src="img/logo/1.jpg" alt="Tanda Tangan Digital">
                    <p class="nama">Bagas Pramudita</p>
                    <p>CEO Biispace</p>
                </div>
                <div class="footer">
                    <p>Terima Kasih Atas Pembelian Anda!</p>
                    <p>Dicetak pada: <?php echo date('d-m-Y H:i:s'); ?></p>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "Transaksi tidak ditemukan.";
    }
}
?>
