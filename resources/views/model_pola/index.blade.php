@extends('layouts.master')

@section('content')
<div class="menu d-block text-center py-2">
    <h2 class="fw-normal">Model Pola</h2>
</div>
<div class="">
    @if (session('primary'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <div class="fw-semibold"><i class="bi bi-check-circle-fill"></i> {{ session('primary') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="mb-3">
        <div class="menu mb-2">
            <!-- Button modal Tambah Data -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdata" id="btn-tambah-data">
                <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
            </button>

            <!-- Modal Tambah Data-->
            <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ url('Model_pola/post_modelpola')}}" method="post" id="form-input-data" data-flag="0">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="box-inputdata">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Jenis Model/Pola</label>
                                            <select class="form-select select2" name="jenis_model" required>
                                                <option value="">Pilih</option>
                                                @foreach ($jenismodel as $jmodel)
                                                <option value="{{$jmodel->nama_jenismodel}}" {{  old('jenis_model')  === $jmodel->nama_jenismodel ? 'selected' : '' }}>{{$jmodel->nama_jenismodel}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Jenis Bahan</label>
                                            <select class="form-select" name="jenis_bahan" required>
                                                <option value="">Pilih</option>
                                                @foreach ($jenisbahan as $jbahan)
                                                <option value="{{$jbahan->nama_jenisbahan}}" {{  old('jenis_bahan')  === $jbahan->nama_jenisbahan ? 'selected' : '' }}>{{$jbahan->nama_jenisbahan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Ukuran</label>
                                            <select class="form-select" name="jenis_ukuran" required>
                                                <option value="">Pilih</option>
                                                @foreach ($jenisukuran as $jukuran)
                                                <option value="{{$jukuran->nama_jenisukuran}}" {{  old('jenis_ukuran')  === $jukuran->nama_jenisukuran ? 'selected' : '' }}>{{$jukuran->nama_jenisukuran}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Kategori</label>
                                            <select class="form-select" name="jenis_kategori" required>
                                                <option value="">Pilih</option>
                                                @foreach ($jeniskategori as $jkategori)
                                                <option value="{{$jkategori->nama_jeniskategori}}" {{  old('jenis_kategori')  === $jkategori->nama_jeniskategori ? 'selected' : '' }}>{{$jkategori->nama_jeniskategori}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Aksesoris</label>
                                            <select class="form-select" name="jenis_aksesoris">
                                                <option value="">Pilih</option>
                                                @foreach ($jenisaksesoris as $jaksesoris)
                                                <option value="{{$jaksesoris->nama_jenisaksesoris}}" {{  old('jenis_aksesoris')  === $jaksesoris->nama_jenisaksesoris ? 'selected' : '' }}>{{$jaksesoris->nama_jenisaksesoris}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Harga Produksi</label>
                                        <input type="text" class="form-control rupiah" name="harga_produksi" value="{{ old('harga_produksi') }}" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Harga Penjahit</label>
                                        <input type="text" class="form-control rupiah" name="harga_penjahit" value="{{ old('harga_penjahit') }}" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">H Pemotong Bahan</label>
                                        <input type="text" class="form-control rupiah" name="harga_pemotongbahan" value="{{ old('harga_pemotongbahan') }}" required>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Nama Customer</label>
                                    <select class="form-select" name="kode_customer" required>
                                        <option value="">Pilih</option>
                                        @foreach ($customer as $c)
                                        <option value="{{$c->kode_customer}}" {{  old('kode_customer')  === $c->kode_customer ? 'selected' : '' }}>{{$c->nama_customer.' - '.$c->nama_brand}}</option>
                                        @endforeach
                                    </select>
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
        <table id="example" class="table bg-white table-sm table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width=40>Kode</th>
                    <th>Brand</th>
                    <th>Nama Model</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modelpola as $no => $m)
                <tr>
                    <td>{{ $m->kode_model }}</td>
                    <td>{{ $m->nama_brand}}</td>
                    <td>{{ $m->nama_model }}</td>
                    <td class="text-center">
                        <btn id="lihat-data" data-id="{{ $m->kode_model }}" class="lihat-data btn btn-secondary btn-sm"><i class="bi bi-eye-fill"></i></btn>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <button id="btn-modal-lihat-data" class="btn btn-sm btn-primary d-none">Show Modal</button>

    <!-- Modal Body-->
    <div class="modal fade" id="modal-lihat-data" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat Data</h1>
                    <div class="d-block">
                        <button type="button" id="btn-update-data" class="btn btn-warning btn-sm col">Update Data</button>
                        <button type="button" class="btn btn-danger btn-sm col" id="close-modal-lihat-data" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <form action="{{ url('Model_pola/update_model')}}" method="post" id="form_update" data-flag="0">
                    <div class="modal-body">
                        <div class="box-inputdata">
                            @csrf
                            <fieldset id="fieldset-dt" disabled="disabled">
                                <div class="col mb-3">
                                    <input type="hidden" name="kode_model" id="updt_kode_model">
                                    <label for="formGroupExampleInput2" class="form-label">Nama Model</label>
                                    <input type="text" class="form-control" id="nama_model" disabled>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Jenis Model/Pola</label>
                                        <select class="form-select select2"  id="jenis_model" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($jenismodel as $jmodel)
                                            <option value="{{$jmodel->nama_jenismodel}}" {{  old('jenis_model')  === $jmodel->nama_jenismodel ? 'selected' : '' }}>{{$jmodel->nama_jenismodel}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Jenis Bahan</label>
                                        <select class="form-select" id="jenis_bahan" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($jenisbahan as $jbahan)
                                            <option value="{{$jbahan->nama_jenisbahan}}" {{  old('jenis_bahan')  === $jbahan->nama_jenisbahan ? 'selected' : '' }}>{{$jbahan->nama_jenisbahan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Ukuran</label>
                                        <select class="form-select" id="jenis_ukuran" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($jenisukuran as $jukuran)
                                            <option value="{{$jukuran->nama_jenisukuran}}" {{  old('jenis_ukuran')  === $jukuran->nama_jenisukuran ? 'selected' : '' }}>{{$jukuran->nama_jenisukuran}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Kategori</label>
                                        <select class="form-select"  id="jenis_kategori" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($jeniskategori as $jkategori)
                                            <option value="{{$jkategori->nama_jeniskategori}}" {{  old('jenis_kategori')  === $jkategori->nama_jeniskategori ? 'selected' : '' }}>{{$jkategori->nama_jeniskategori}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Aksesoris</label>
                                        <select class="form-select" id="jenis_aksesoris" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($jenisaksesoris as $jaksesoris)
                                            <option value="{{$jaksesoris->nama_jenisaksesoris}}" {{  old('jenis_aksesoris')  === $jaksesoris->nama_jenisaksesoris ? 'selected' : '' }}>{{$jaksesoris->nama_jenisaksesoris}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ old('keterangan') }}">
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Harga Produksi</label>
                                        <input type="text" class="form-control rupiah" name="harga_produksi" id="harga_produksi" value="{{ old('harga_produksi') }}" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Harga Penjahit</label>
                                        <input type="text" class="form-control rupiah" name="harga_penjahit" id="harga_penjahit" value="{{ old('harga_penjahit') }}" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">H Pemotong Bahan</label>
                                        <input type="text" class="form-control rupiah" name="harga_pemotongbahan" id="harga_pemotongbahan" value="{{ old('harga_pemotongbahan') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Nama Customer</label>
                                        <select class="form-select" id="kode_customer" disabled>
                                            <option value="">Pilih</option>
                                            @foreach ($customer as $c)
                                            <option value="{{$c->kode_customer}}" {{  old('kode_customer')  === $c->kode_customer ? 'selected' : '' }}>{{$c->nama_customer.' - '.$c->nama_brand}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="formGroupExampleInput2" class="form-label">Status</label>
                                        <select select class="form-select" name="aktif" id="aktif">
                                            <option value="Y">AKTIF</option>
                                            <option value="N">NON AKTIF</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer" id="modal-footer-update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        new DataTable('#example', {
            dom: '<"top">t<"d-flex justify-content-between" i p>',
            stateSave: true,
            responsive: true,
            fixedHeader: true
            // scrollY: true
        });
    </script>
    <script>
        //     $('.select2').select2({
        //     dropdownParent: $('#tambahdata')
        // });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.lihat-data').click(function() {
                var dataId = $(this).data('id');
                // console.log(dataId);
                $.ajax({
                    url: "{{url('Model_pola/lihat-detail-data')}}",
                    type: 'GET',
                    data: {
                        id: dataId
                    },
                    success: function(response) {
                        // console.log(response.data);
                        $('#updt_kode_model').val(response.data.kode_model)
                        $('#nama_model').val(response.data.nama_model)
                        $('#jenis_bahan').val(response.data.jenis_bahan)
                        $('#jenis_model').val(response.data.jenis_model)
                        $('#jenis_ukuran').val(response.data.ukuran)
                        $('#jenis_kategori').val(response.data.kategori)
                        $('#jenis_aksesoris').val(response.data.aksesoris)
                        $('#keterangan').val(response.data.keterangan)
                        $('#harga_produksi').val(response.data.harga_produksi)
                        $('#harga_penjahit').val(response.data.harga_penjahit)
                        $('#harga_pemotongbahan').val(response.data.harga_pemotongbahan)
                        $("#kode_customer").val(response.data.kode_customer)
                        $('#aktif').val(response.data.aktif)

                        document.getElementById('btn-modal-lihat-data').addEventListener('click', function() {
                            $('#modal-lihat-data').modal('show');
                        });

                        document.getElementById('btn-modal-lihat-data').click();

                    },
                    error: function(xhr) {
                        console.log("An error occurred: " + xhr.status + " " + xhr.statusText);
                    }
                });
            });
        });

        document.getElementById('btn-update-data').addEventListener('click', function() {
            $("#fieldset-dt").removeAttr("disabled", 'true');
            $("#modal-footer-update").append(" <button type='submit'  id='simpan-update' class='btn btn-primary btn-sm'>Simpan Data</button>")
            $("#modal-footer-update").append(" <button type='button' id='batal-update' onclick='btl_update()' class='btn btn-secondary btn-sm'>Batal</button>")
            $("#btn-update-data").hide();
            $("#form_update").submit( function(e) {
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
        });

        $('#form-input-data').submit( function(e) {
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

        function btl_update() {
            var kode_model = $("#updt_kode_model").val();
            $(".lihat-data").filter("[data-id='" + kode_model + "']").click();
        }
        $(".lihat-data").on('click', function() {
            $("#fieldset-dt").attr("disabled", 'true');
            $("#batal-update").remove();
            $('#simpan-update').remove();
            $("#btn-update-data").show();
        });
    </script>

    @if (session('error'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Maaf...",
            text: "{{ session('error') }}",
            confirmButtonText: "Oke",
        }).then((result) => {
            if (result.isConfirmed) {
                // console.log('a');
                $(document).ready(function() {
                    $("#btn-tambah-data").trigger("click");
                });
            }
        })
    </script>
    @endif

</div>
</div>
@endsection