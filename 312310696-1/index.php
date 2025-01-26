<?php
$toko_online = [
    "P001" => ["nama" => "Kemeja", "harga" => 150000, "stok" => 10],
    "P002" => ["nama" => "Celana", "harga" => 200000, "stok" => 5],
    "P003" => ["nama" => "Sepatu", "harga" => 500000, "stok" => 7]
];
function cetakStruk($nama_produk, $jumlah, $total_harga, $diskon, $pajak, $total_bayar)
{
    echo "<h2 style='color:red; text-align: left; text-decoration: underline;'>STRUK TRANSAKSI</h2>";
    echo "<hr style= 'border-top: 3px dashed red; width: 100%;'>";
    echo "<p>Nama Produk: $nama_produk</p>";
    echo "<p>Jumlah: $jumlah</p>";
    echo "<p>Total Harga: Rp" . number_format($total_harga, 0, ',', '.') . "</p>";
    echo "<p>Diskon: Rp" . number_format($diskon, 0, ',', '.') . "</p>";
    echo "<p>Pajak: Rp" . number_format($pajak, 0, ',', '.') . "</p>";
    echo "<p style='color: red;'><strong>Total yang Harus Dibayar: Rp" . number_format($total_bayar, 0, ',', '.') . "</strong></p>";
    echo "<hr style='border-top: 2px dashed red; margin-top: 10px;'>";
}
echo "<h2>Daftar Produk Tersedia</h2>";
echo "<table border='1'>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>";

foreach ($toko_online as $id => $produk) {
    echo "<tr>
            <td>$id</td>
            <td>{$produk['nama']}</td>
            <td>Rp" . number_format($produk['harga'], 0, ',', '.') . "</td>
            <td>{$produk['stok']}</td>
          </tr>";
}

echo "</table><br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST["id_produk"];
    $jumlah_beli = intval($_POST["jumlah_beli"]);


    if (array_key_exists($id_produk, $toko_online)) {
        $produk = $toko_online[$id_produk];
        if ($jumlah_beli > $produk["stok"]) {
            echo "<p style='color:red;>Maaf, stok untuk {$produk['nama']} tidak mencukupi.</p>";
        } else {

            $total_harga = $jumlah_beli * $produk["harga"];


            if ($total_harga > 500000) {
                $diskon = $total_harga * 0.10;
            } elseif ($total_harga > 250000) {
                $diskon = $total_harga * 0.05;
            } else {
                $diskon = 0;
            }

            $harga_setelah_diskon = $total_harga - $diskon;


            $pajak = $harga_setelah_diskon * 0.10;


            $total_bayar = $harga_setelah_diskon + $pajak;


            $toko_online[$id_produk]["stok"] -= $jumlah_beli;


            cetakStruk($produk["nama"], $jumlah_beli, $total_harga, $diskon, $pajak, $total_bayar);
        }
    } else {
        echo "<p style='color:red;'>ID produk tidak ditemukan.</p>";
    }
} else {
    ?>

    <form method="post" action="">
        <label for="id_produk">ID Produk:</label>
        <input type="text" id="id_produk" name="id_produk" required><br><br>
        <label for="jumlah_beli">Jumlah Pembelian:</label>
        <input type="number" id="jumlah_beli" name="jumlah_beli" required><br><br>
        <button type="submit">Proses Transaksi</button>
    </form>

    <?php
}
?>