@extends('layouts.master')

@section('content')
<div class="menu d-block text-center py-2">
    <h2 class="fw-normal">Karyawan</h2>
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
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdata">
                <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
            </button>

            <!-- Modal Tambah Data-->
            <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="box-inputdata">
                                <form action="{{ url('karyawan/post_karyawan')}}" method="post" id="form-input-data" data-flag="0">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="nama" required placeholder="Contoh: Husein">
                                    </div>
                                    <div class="row mb-3 gx-3 align-items-center">
                                        <div class="col-sm-4">
                                            <label for="formGroupExampleInput2" class="form-label">Jenis Kelamin</label>
                                            <select select class="form-select" name="jenis_kelamin" required>
                                                <option value="">Pilih</option>
                                                <option value="L">Laki - Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <label for="formGroupExampleInput2" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="formGroupExampleInput2" class="form-label">Posisi</label>
                                            <select select class="form-select" name="posisi" required>
                                                <option value="">Pilih</option>
                                                <option value="PENJAHIT">Penjahit</option>
                                                <option value="PEMOTONG BAHAN">Pemotong Bahan</option>
                                                <option value="FINISHING">Finishing</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <label for="formGroupExampleInput2" class="form-label">Tanggal Masuk</label>
                                            <input type="date" class="form-control" name="tanggal_masuk" value="{{ date('Y-m-d')  }}" required>
                                        </div>
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
        <table id="example" class="table bg-white table-sm table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width=50>No</th>
                    <th class="text-start">NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Posisi</th>
                    <th>Status</th>
                    <th class="text-center" width=50>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $no => $c)
                <tr>
                    <td>{{ $no+1 }}</td>
                    <td class="text-start">{{ $c->nik }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->posisi }}</td>
                    <td>{{ $c->aktif }}</td>
                    <td class="text-center">
                        <btn id="lihat-data" data-id="{{ $c->nik }}" class="lihat-data btn btn-secondary btn-sm"><i class="bi bi-eye-fill"></i></btn>
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
                <form action="{{ url('karyawan/update_karyawan')}}" method="post" id="form_update" data-flag="0">
                    <div class="modal-body">
                        <div class="box-inputdata">
                            @csrf
                            <fieldset id="fieldset-dt" disabled="disabled">
                                <input type="hidden" id="nik_karyawan" name="nik" required>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" id="nama_karyawan" name="nama" required placeholder="Contoh: Husein">
                                </div>
                                <div class="row mb-3 gx-3 align-items-center">
                                    <div class="col-sm-4">
                                        <label for="formGroupExampleInput2" class="form-label">Jenis Kelamin</label>
                                        <select select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih</option>
                                            <option value="L">Laki - Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="formGroupExampleInput2" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="formGroupExampleInput2" class="form-label">Posisi</label>
                                        <select select class="form-select" id="posisi" name="posisi" required>
                                            <option value="">Pilih</option>
                                            <option value="PENJAHIT">Penjahit</option>
                                            <option value="PEMOTONG BAHAN">Pemotong Bahan</option>
                                            <option value="FINISHING">Finishing</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="formGroupExampleInput2" class="form-label">Tanggal Masuk</label>
                                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"  required>
                                    </div>
                                </div>
                                <div class="row">
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
            // responsive: true
            fixedHeader: true,
            scrollY: true
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.lihat-data').click(function() {
                var dataId = $(this).data('id');
                // console.log(dataId);
                $.ajax({
                    url: "{{url('karyawan/lihat-detail-data')}}",
                    type: 'GET',
                    data: {
                        id: dataId
                    },
                    success: function(response) {
                        // console.log(response.data);
                        $('#nik_karyawan').val(response.data.nik)
                        $('#nama_karyawan').val(response.data.nama)
                        $('#jenis_kelamin').val(response.data.jenis_kelamin)
                        $('#tanggal_lahir').val(response.data.tanggal_lahir)
                        $('#posisi').val(response.data.posisi)
                        $('#tanggal_masuk').val(response.data.tanggal_masuk)
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
            $('#form_update').submit(function(e) {
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

        function btl_update() {
            var kode_customer = $("#updt_kode_customer").val();
            $(".lihat-data").filter("[data-id='" + kode_customer + "']").click();
        }
        $(".lihat-data").on('click', function() {
            $("#fieldset-dt").attr("disabled", 'true');
            $("#batal-update").remove();
            $('#simpan-update').remove();
            $("#btn-update-data").show();
        });
    </script>
</div>
</div>
@endsection