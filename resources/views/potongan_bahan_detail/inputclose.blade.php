@extends('layouts.master')

@section('content')
<div class="menu d-block text-center my-4">
    <h2 class="fw-normal">Input Selesai Jahit</h2>
    <hr>
</div>
<div class="">
    <p class="text-center">Silahkan Masukan Kode Potongan Bahan dibawah ini<br />
        dan setelah menginput kode, pastikan data yang tampil sesuai dengan tertera pada kertas
    </p>
    <div class="form m-auto" style="max-width: 350px;">
        <form action="" method="post">
            @csrf
            <div class="mb-2">
                <label for="kode_potonganbahan_detail"></label>
                <input type="text" class="form-control border-danger" id="kode_potonganbahan_detail" name="kode_potonganbahan_detail" placeholder="Masukan Kode Potongan Bahan Detail" required>
            </div>
            <div id="input" style="display: none;">
                <div class="mb-2">
                    <div
                        class="border border-dark bg-white p-3">
                        <div class="card-body">
                            <div class="head">
                                <div class="card-text text-center text-dark mb-0" id="nama_model">Nama Model</div>
                                <hr class="my-2">
                                <div class="card-text text-center text-dark mb-0" id="nama_brand">Nama Brand</div>
                                <hr class="my-2">
                            </div>
                            <div class="body row text-center">
                                <div class="col">No: <text id="no"></text></div>
                                <div class="col">Qty: <text id="qty"></text></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="mb-2">
                    <label for="nik" class="">Nama Karyawan</label>
                    <select name="nik" class="form-control" id="nik" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach($karyawan as $k)
                        <option value="{{$k->nik}}">{{$k->nik}} - {{$k->nama}}</option>
                        @endforeach
                    </select>
                </div> -->
                <div class="mb-2 text-center">
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" name="qty_end" id="qty_end" placeholder="Total Qty Yang Selesai" required>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#kode_potonganbahan_detail').change(function() {
            // console.log('a');
            var kode_potonganbahan_detail = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{url("potonganbahandetail/getkode_potonganbahan_detail")}}',
                data: 'kode_potonganbahan_detail=' + kode_potonganbahan_detail,
                success: function(response) {
                    console.log(response.data);

                    if (response.data == null) {
                        Swal.fire({
                            icon: "error",
                            title: "Maaf...",
                            text: "Kode Tersebut Tidak ditemukan",
                            confirmButtonText: "Oke",
                        })
                        $('#input').hide();

                    } else {
                        $('#nama_model').html(response.data.nama_model);
                        $('#nama_brand').html(response.data.nama_brand);
                        $('#no').html(response.data.NO);
                        $('#qty').html(response.data.qty);
                        $('#input').show();
                    }
                }
            });
        });
    });
    $(document).ready(function() {
        $('#nik').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
@endsection