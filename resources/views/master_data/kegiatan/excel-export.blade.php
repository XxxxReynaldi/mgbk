<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="content">
        <table class="table">
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Tgl_transaksi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kegiatan as $item)
                    <tr>
                        <td>{{ $item->kegiatan }}</td>
                        <td>{{ date('Y-m-d') }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>