<!DOCTYPE html>
<html>
<head>
    <title>Data Pesanan</title>
    <style>
        /* Base */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            background: #f8fafc;
            color: #222;
            margin: 0;
            padding: 8px;
        }

        h2 {
            text-align: center;
            color: #37cd00;
            margin: 8px 0 14px 0;
            letter-spacing: 1px;
            font-size: 16px;
        }

        /* Container to limit table width so it fits paper */
        .table-wrap {
            width: 100%;
            max-width: 720px; /* safe for A4 margins */
            margin: 0 auto;
            overflow: hidden;
        }

        table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            margin: 0;
            box-shadow: 0 2px 8px #e0e0e0;
            table-layout: fixed; /* important to keep width */
            word-wrap: break-word;
            word-break: break-word;
        }

        th, td {
            border: 1px solid #b5e564;
            padding: 6px 8px; /* reduced padding */
            text-align: left;
            vertical-align: top;
            font-size: 10.5px;
        }

        th {
            background: #eaffc7;
            color: #305e03;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.4px;
        }

        /* Make long text wrap instead of expanding table */
        td {
            white-space: normal;
        }

        /* Give more room to specific wide columns by using percent widths */
        th.col-name { width: 10%; }
        th.col-lokasi { width: 12%; }
        th.col-merk { width: 8%; }
        th.col-plat { width: 8%; }
        th.col-status { width: 8%; }
        th.col-biaya { width: 10%; }
        th.col-tanggal { width: 12%; }
        th.col-alamat { width: 20%; }
        th.col-patokan { width: 6%; }
        th.col-instruksi { width: 16%; }

        tr:nth-child(even) {
            background: #f7f7f7;
        }
        tr:hover td {
            background: #f3f3f3;
        }

        .status-completed {
            color: #37cd00;
            font-weight: bold;
        }
        .status-pending {
            color: #f59e42;
            font-weight: bold;
        }
        .status-cancelled {
            color: #ef4444;
            font-weight: bold;
        }

        /* If generating PDF, ensure no unexpected page overflow */
        @page { margin: 18mm 12mm; }
        @media print {
            body { margin: 0; padding: 0; }
            .table-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>
    <h2>Data Pesanan AutoSafe</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="col-name">Nama Kontak</th>
                    <th class="col-lokasi">Lokasi</th>
                    <th class="col-merk">Merk</th>
                    <th class="col-plat">Plat Nomor</th>
                    <th class="col-status">Status</th>
                    <th class="col-biaya">Biaya</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-alamat">Alamat Customer</th>
                    <th class="col-patokan">Patokan</th>
                    <th class="col-instruksi">Instruksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datapesanan as $p)
                <tr>
                    <td>{{ $p->nama_kontak }}</td>
                    <td>{{ $p->nama_lokasi ?? $p->pilihlokasi }}</td>
                    <td>{{ $p->merk }}</td>
                    <td>{{ $p->plat_nomor }}</td>
                    <td>
                        <span class="
                            @if($p->status_pesanan == 'completed') status-completed
                            @elseif($p->status_pesanan == 'pending') status-pending
                            @elseif($p->status_pesanan == 'cancelled') status-cancelled
                            @endif
                        ">
                            {{ ucfirst($p->status_pesanan) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($p->biaya_layanan,0,',','.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $p->alamat_jemput ?? $p->alamat_penjemputan }}</td>
                    <td>{{ $p->patokan }}</td>
                    <td>{{ $p->instruksi ?? $p->instruksi_penjemputan ?? ($p->note ?? '-') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>