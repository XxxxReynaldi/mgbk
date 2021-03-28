<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Semesteran</title>
    <style>
        .w-100 {
            min-width: 100vw;
        }

        .p-min {
            padding: .2em;
        }

        .valign-middle {
            vertical-align: middle;
        }

        .p-max {
            padding: 2em;
        }

        .mb-max {
            margin-bottom: 3em;
        }

        .border-collapse {
            border-collapse: collapse;
        }

        .border {
            border: 1px solid black;
        }

        .border-right {
            border-right: 1px solid black;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .text-title {
            font-size: 24px;
        }

        .text-regular {
            font-weight: 400;
        }

        .text-align-left {
            text-align: left;
        }

        .text-align-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="border w-100 p-max mb-max valign-middle">
        <tr>
            <th>
                <img src="https://vidyagata.files.wordpress.com/2011/03/logo-sma-6-edit.jpg" width="80" height="80">
            </th>
            <th>
                <span class="text-title">{{ $guru->nama_sekolah }}</span><br>
                <span class="text-regular">{{ $guru->alamat_sekolah }}</span><br>
                <span class="text-regular">{{ $guru->tambahan_informasi }}</span><br>
                {{-- <span class="text-regular">Website: https://sman6malang.sch.id; E-mail: kontak@sman6malang.sch.id</span><br> --}}
            </th>
        </tr>
    </table>

    @php

        function tgl_indo($tanggal){
            $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
            return $bulan[ (int)$pecahkan[1] ];
        }

        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";",$kelas);
        $totalJam   = 0;

    @endphp

    <table class="mb-max">
        <tr>
            <th class="text-align-left">
                Nama Guru
            </th>
            <td>
                : {{ $guru->nama_lengkap }}
            </td>
        </tr>
        <tr>
            <th class="text-align-left">
                Kelas yang diampuh
            </th>
            <td>
                : ...
            </td>
        </tr>
        <tr>
			<td> 
				<ol>
                    @foreach ($eachkelas as $item)
                        <li>{{ $item }}</li> 
                    @endforeach 
				</ol> 
            </td>
		</tr>
        <tr>
            <th class="text-align-left">
                Semester
            </th>
            <td>
                : {{ semester }}
            </td>
        </tr>
    </table>

    <p>
        Berikut detail laporan dari Guru BK yang bersangkutan :
    </p>

    <table class="border w-100 border-collapse">
        <tr>
            <th style="width: 10px;" class="border-right border-bottom p-min">No</th>
            <th style="width: 40%;" class="border-right border-bottom p-min">Jenis Kegiatan</th>
            <th style="width: 20%;" class="border-right border-bottom p-min">Summary</th>
            <th class="border-bottom p-min">Ekivalensi</th>
        </tr>
        @if (count($reports) == 0)
            <tr>
                <td colspan="4" class="text-align-center">Data tidak ada.</td>
            </tr>
        @else

            @foreach($reports as $report)
            @php
                $totalJam += $report->jumlah_ekuivalen;
            @endphp
            <tr>
                <td class="text-align-center border-right border-bottom p-min">{{ $loop->iteration }}</td>
                <td class="text-align-left border-right border-bottom p-min">{{ $report->kegiatan }}</td>
                <td class="text-align-center border-right border-bottom p-min">{{ $report->jumlah_kegiatan }}</td>
                <td class="text-align-center border-right border-bottom p-min">{{ $report->jumlah_ekuivalen }}</td>
            </tr>
            @endforeach

            <tr>
                <th colspan="3" class="border-right border-bottom p-min">
                    Total Jam
                </th>
                <td class="text-align-center border-right border-bottom p-min">
                    {{ $totalJam }}
                </td>
            </tr>

        @endif
    </table>
</body>

</html>