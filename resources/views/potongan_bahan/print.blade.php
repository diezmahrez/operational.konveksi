<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-in   secure-requests" /> -->
    <link rel="icon" type="image/x-icon" href="{{url('favicon.jpg')}}">
    <title>Trustme - Operational</title>
    @include('layouts.head')
</head>

<body>
    <div id="print" class="container">
        <div class="my-4">
            <div class="tabel_transaksi">
                <div class="menu-bar">
                    <div class="header row">
                        <div class="col-md">
                            <table class="table table-bordered table-sm table-responsive">
                                <tr>
                                    <th width=100>Nama Model</th>
                                    <th>:</th>
                                    <th>{{$header->nama_model}}</th>
                                </tr>
                                <tr>
                                    <th>Kode PB</th>
                                    <th width=20>:</th>
                                    <th>{{$header->kode_potonganbahan}}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md">
                            <table class="table table-bordered table-sm table-responsive">
                                <tr>
                                    <th width=20>Brand</th>
                                    <th width=20>:</th>
                                    <th>{{$header->nama_brand}}</th>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>:</th>
                                    <th>{{date_format(new DateTime($header->tanggal),'d F Y'); }} </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example" class="table bg-white table-sm table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Yards</th>
                                <th class="text-center">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_yards = 0 @endphp
                            @foreach ($detail as $no => $d)
                            <tr>
                                <td class="text-center">{{$no+1}}</td>
                                <td id="colorPickertable" class="colorPickerCell text-center" style='background-color: #{{$d->warna}};'></td>
                                <td class="text-center">{{$d->yards}}</td>
                                <td class="text-center">{{$d->qty}}</td>
                                @php $total_yards += $d->yards @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td class="text-center"><strong>Total</strong></td>
                                <td class="text-center"><strong>
                                        {{number_format((float)$total_yards, 2, '.', '')}}</strong></td>
                                <td class="text-center"><strong>{{$header->total_qty}}</strong></td>
                            </tr>
                        </tbody>

                    </table>


                </div>
            </div>
        </div>
    </div>

</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>