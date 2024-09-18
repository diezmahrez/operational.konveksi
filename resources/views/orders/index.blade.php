@extends('layouts.master')

@section('content')
<div class="menu d-block text-center my-4">
    <h2 class="fw-normal">Data Orders</h2>
</div>
<div class="menu mb-2">
    <!-- Button modal Tambah Data -->
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdata" id="btn-tambah-data">
        <i class="bi bi-plus-square-fill me-2"></i>Tambah Order
    </button>

    <!-- Modal Tambah Data-->
    <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('orders/post_orders')}}" method="post" id="form-input-data" data-flag="0">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="box-inputdata">
                            @csrf
                            <div class="col mb-3">
                                <label class="form-label">Nama Brand</label>
                                <select class="form-select" name="kode_customer" id="kode_customer" required>
                                    <option value="">Pilih</option>
                                    @foreach ($customer as $c)
                                    <option value="{{$c->kode_customer}}">{{$c->nama_brand}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Nama Model</label>
                                <select class="form-select" name="kode_model" id="kode_model" required>

                                </select>
                            </div>
                            <p class="text-danger m-0">Pastikan harga dibawah ini sudah sesuai!*</p>
                            <div class="row">
                                <div class="col">
                                    <label for="">Harga Produksi</label>
                                    <input type="text" class="form-control " id="harga_produksi" disabled>
                                </div>
                                <div class="col">
                                    <label for="">Harga Penjahit</label>
                                    <input type="text" class="form-control" id="harga_penjahit" disabled>
                                </div>
                                <div class="col">
                                    <label for="">H Pemotong Bahan</label>
                                    <input type="text" class="form-control" id="harga_pemotongbahan" disabled>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label for="">Judul/Keterangan</label>
                                <textarea class="form-control" name="judul" id="" required></textarea>
                            </div>
                            <div class="col mb-3">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <input class="btn btn-primary btn-sm" type="submit" value="Tambah Data" id="input-data">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach ($orders as $no => $s)
<div class="card my-2">
    <div class="card-body">
        <div class="header d-flex justify-content-between align-items-center">
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
            <h6>{{$s->nama_brand}} - {{$s->nama_model}}</h6>
            <h6 class="m-0 badge text-bg-secondary">{{$s->detail_status}}</h6>
        </div>
        <div class="detail-2 d-flex justify-content-between align-items-center">
            <p class="text-dark m-0">{{$s->judul}}</p>
            <a href="{{url('/orders/'.$s->kode_order)}}" class="btn btn-outline-secondary btn-sm">Lihat Detail</a>
        </div>
    </div>
</div>
@endforeach

<script>
    new DataTable('#example', {
        dom: '<"top">t<"d-flex justify-content-between" i p>',
        stateSave: true,
        // responsive: true,
        fixedHeader: true,
        scrollY: true
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
                url: '{{url("orders/getkodemodel")}}',
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

    $(document).ready(function() {
        $('#kode_model').change(function() {
            var kode_model = $(this).val();
            $('#harga_produksi').empty();
            $('#harga_penjahit').empty();
            $('#harga_pemotongbahan').empty();
            $.ajax({
                type: 'GET',
                url: '{{url("orders/getdataharga")}}',
                data: 'kode_model=' + kode_model,
                success: function(response) {
                    $('#harga_produksi').val(response.data.harga_produksi);
                    $('#harga_penjahit').val(response.data.harga_penjahit);
                    $('#harga_pemotongbahan').val(response.data.harga_pemotongbahan);



                }
            });
        });
    });
</script>
@endsection