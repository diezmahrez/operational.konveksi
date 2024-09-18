@extends('layouts.master')

@section('content')
<div class="menu d-block text-center my-4">
    <h2 class="fw-normal">Input Potongan Bahan</h2>
</div>
<div class="menu mb-2">
    <!-- Button modal Tambah Data -->
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdata" id="btn-tambah-data">
        <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
    </button>

    <!-- Modal Tambah Data-->
    <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="box-inputdata">
                        @foreach ($orders as $no => $s)
                        <div class="card my-2">
                            <form action="{{ url('potonganbahan/post_potonganbahan')}}" method="post" id="form-input-data" data-flag="0">
                                <div class="card-body">
                                    <div class="header d-flex justify-content-between align-items-center">
                                        @csrf
                                        <input type="hidden" class="form-control-plaintext" value="{{$s->tanggal}}" name="tanggal" readonly>
                                        <input type="hidden" class="form-control-plaintext" value="{{$s->kode_order}}" name="kode_order" readonly>
                                        <small class="m-0 text-secondary">{{date_format(new DateTime($s->tanggal),"d F Y");}} - {{$s->kode_order}}</small>
                                        <p class="m-0   badge 
                                            @if($s->status == 'PROCESS') text-bg-warning
                                            @else
                                            text-bg-secondary
                                            @endif
                                            ">
                                            {{ $s->status }}
                                        </p>
                                    </div>
                                    <div class="detail d-flex justify-content-between align-items-start">
                                        <input type="hidden" class="form-control-plaintext" value="{{$s->kode_model}}" name="kode_model" readonly>
                                        <input type="hidden" class="form-control-plaintext" value="{{$s->kode_customer}}" name="kode_customer" readonly>
                                        <h6>{{$s->nama_brand}} - {{$s->nama_model}}</h6>
                                        <h6 class="m-0 badge text-bg-secondary">{{$s->detail_status}}</h6>
                                    </div>
                                    <div class="detail-2 d-flex justify-content-between align-items-center ">
                                        <input type="text" class="form-control-plaintext" value="{{$s->judul}}" name="judul" readonly>
                                        <!-- <p class="text-dark m-0"></p> -->
                                        <!-- <a href="{{url('/orders/'.$s->kode_order)}}" class="btn btn-outline-secondary btn-sm">Lihat Detail</a> -->
                                         <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<table id="example" class="table bg-white table-sm table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-start">Tanggal</th>
            <th>Kode</th>
            <th>Brand</th>
            <th>Model Pola</th>
            <th>Total QTY</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($potonganbahan as $no => $p)
        <tr>
            <td class="text-center">{{ $no+1}}</td>
            <td class="text-start">{{date_format(new DateTime($p->tanggal),"d-m-Y"); }}</td>
            <td>{{ $p->kode_potonganbahan}}</td>
            <td>{{ $p->nama_brand}}</td>
            <td>{{ $p->nama_model }}</td>
            <td>{{ $p->total_qty }}</td>
            <td>
                <p class="m-0   badge 
            @if($p->status == 'PROCESS') text-bg-warning
            @else
            text-bg-secondary
            @endif
            ">
                    {{ $p->status }}
                </p>
            </td>
            <td class="text-center">
                <a href="{{url('/potonganbahan/'.$p->kode_potonganbahan)}}" class="btn btn-secondary btn-sm"><i class="bi bi-eye-fill"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    new DataTable('#example', {
        dom: '<"top">t<"d-flex justify-content-between" i p>',
        stateSave: true,
        responsive: true,
        fixedHeader: true
        // scrollY: true
    });

    $('#form-input-data').submit(function(e) {
        $flag = $(this).attr('data-flag');

        if ($flag == 0) {

            e.preventDefault();
            var form = $(this);
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Simpan",
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.attr('data-flag', 1);
                    form.submit();
                }
            });;
        }
    })

    $(document).ready(function() {
        $('#kode_customer').change(function() {
            var kode_customer = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{url("potonganbahan/getkodemodel")}}',
                data: 'kode_customer=' + kode_customer,
                success: function(response) {
                    $('#kode_model').empty();
                    $.each(response, function(i, v) {
                        $('#kode_model').append('<option value="" selected>Pilih</option>');
                        for (var i in v) {
                            $('#kode_model').append('<option' + ' value="' + v[i].kode_model + '">' + v[i].nama_model + '</option>')
                        }
                    });

                }
            });
        });
    });
</script>
@endsection