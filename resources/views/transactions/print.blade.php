<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f3f3f3; }
    </style>
</head>
<body>

    <h2>Bukti Transaksi</h2>
    <table>
        <tr>
            <th>ID Transaksi</th>
            <td>{{ $transaction->id }}</td>
        </tr>
        <tr>
            <th>Nama Game</th>
            <td>{{ $transaction->game->name }}</td>
        </tr>
        <tr>
            <th>Harga</th>
            <td>Rp {{ number_format($transaction->game->price, 2) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($transaction->status) }}</td>
        </tr>
        <tr>
            <th>Tanggal Pembelian</th>
            <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
        </tr>
    </table>

</body>
</html>
