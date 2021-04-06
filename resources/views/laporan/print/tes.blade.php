<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian MGBK SMA Kota Malang</title>
    <style>
        .w-100 {
            width: 100%;
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

        .text-align-justify {
            text-align: justify;
        }

        /* @page { margin-top: 120px; margin-bottom: 300px } */
        /* header { position: fixed; left: 0px; top: -90px; right: 0px; height: 150px; text-align: center; } */
        @page { margin: 100px 25px; }
        header { 
            position: fixed; 
            top: -60px; 
            left: 0px; 
            right: 0px; 
            height: 50px; 
        }
        #footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px; 
            height: 50px; 
        }
        main { 
            page-break-after: always; 
        }
        main:last-child { page-break-after: never; }

        .main-content {
            margin-top: 120px;
        }
        /* main { 
            margin-top: 120px;
        }
        .main-content {
            page-break-after: always; 
        }
        .main-content:last-child { page-break-after: never; } */
        
    </style>
</head>

<body>

    {{-- <header>Header</header> --}}
    {{-- <main>
        <p>page1</p>
        <p>page2</p>
        <p>page3</p>
    </main> --}}

    <script type="text/php">
        if ( isset($pdf) ) {
            $y = $pdf->get_height() - 20; 
            $x = $pdf->get_width() - 15 - 50;
            $pdf->page_text($x, $y, "Page No: {PAGE_NUM} of {PAGE_COUNT}", '', 8, array(0,0,0));
        }
    </script> 

    <header>
        <table class="border w-100 p-max mb-max valign-middle">
            <tr>
                <th>
                    <img src="https://vidyagata.files.wordpress.com/2011/03/logo-sma-6-edit.jpg" width="80" height="80">
                </th>
                <th>
                    <span class="text-title">{{ $guru->sekolah->nama_sekolah }}</span><br>
                    <span class="text-regular">{{ $guru->user->profile->alamat_sekolah }}</span><br>
                    <span class="text-regular">{{ $guru->user->profile->tambahan_informasi }}</span><br>
                </th>
            </tr>
        </table>
    </header>
    <footer style="width: 100%;" id="footer">
        aaaa
    </footer>

    <main>
        
        <div class="main-content">
            @php

                function tgl_indo($tanggal){
                    $bulan = array (
                        1 =>   'Januari',
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
                    
                    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                }

                $kelas       = $guru->user->profile->kelas_pengampu;
                $eachkelas   = explode(";",$kelas);

            @endphp

            <table class="mb-max">
                <tr>
                    <th class="text-align-left">
                        Nama Guru
                    </th>
                    <td>
                        : {{ $guru->user->profile->nama_lengkap }}
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left">
                        Kelas yang diampuh
                    </th>
                    <td>
                        : 
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
                        Tanggal laporan
                    </th>
                    <td>
                        : {{ tgl_indo($guru->tgl_transaksi) }}
                    </td>
                </tr>
            </table>

            <p>
                Berikut detail laporan dari Guru BK yang bersangkutan :
            </p>
           
                <table class="border w-100 border-collapse">

                    <tr>
                        <th style="width: 10px;" class="text-align-left border-right border-bottom p-min">No</th>
                        <th style="width: 30%;" class="border-right border-bottom p-min">Jenis Kegiatan</th>
                        <th class="border-bottom p-min">Detail</th>
                    </tr>

                    @if (count($reports) == 0)
                        <tr>
                            <td>No data found</td>
                        </tr>
                    @else
                        @foreach($reports as $report)
                        <tr>
                            <td class="text-align-center border-right border-bottom p-min">{{ $loop->iteration }}</td>
                            <td class="text-align-left border-right border-bottom p-min">{{ $report->kegiatan->kegiatan }}</td>
                            <td class="text-align-justify border-right border-bottom p-min">{{ $report->detail }}</td>
                        </tr>
                        @endforeach
                    @endif

                </table>
            

        </div>
        
    </main>

    
    
</body>

</html>