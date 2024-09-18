@extends('layouts.master')

@section('content')
<style>
    #colorPreview {
        height: 40px;
        display: block;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 632px;
    }

    input#warna {
        margin-bottom: 20px;
    }

    #preview {
        cursor: pointer;
    }

    video {
        max-width: 200px;
        margin-right: 10px;
    }

    .button-container {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
</style>
<div class="menu d-block text-center mt-4">
    <h2 class="fw-normal">Detail Potongan Bahan</h2>
    <hr>
</div>
<div class="menu-btn">
    <div class="row">
        <div class="col">
            <a href="{{url('historypotonganbahan')}}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left-circle me-2"></i>Kembali</a>
        </div>
        <div class="col text-end">
            <a href="{{url('potonganbahan/print/'.$header->kode_potonganbahan)}}" target="_blank" class="btn btn-warning btn-sm"><i class="bi bi-printer me-2"></i>Print</a>
            <a href="" class="btn btn-primary btn-sm"><i class="bi bi-image me-2"></i>Gambar</a>
        </div>
    </div>
</div>
<div class="header mb-2">
    <div class="row">
        <div class="col-md">
            <div class="mb-1">
                <label for="" class="fw-bold" class="fw-bold">Kode Potongan Bahan</label>
                <input type="text" class="form-control form-control-sm" value="{{$header->kode_potonganbahan}}" disabled>
            </div>
            <div class="mb-1">
                <label for="" class="fw-bold">Nama Model</label>
                <input type="text" class="form-control form-control-sm" value="{{$header->nama_model}}" disabled>
            </div>
        </div>
        <div class="col-md">
            <div class="row">
                <div class="col mb-1">
                    <label for="" class="fw-bold">Nama Brand</label>
                    <input type="text" class="form-control form-control-sm" value="{{$header->nama_brand}}" disabled>
                </div>
                <div class="col mb-1">
                    <label for="" class="fw-bold">Total Qty</label>
                    <input type="text" class="form-control form-control-sm" value="{{$header->total_qty}}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col mb-1">
                    <label for="" class="fw-bold">Tanggal</label>
                    <input type="text" class="form-control form-control-sm" value="{{date_format(new DateTime($header->tanggal),'d-m-Y'); }}" disabled>
                </div>
                <div class="col mb-1">
                    <label for="" class="fw-bold">Status</label>
                    <input type="text" class="form-control  form-control-sm" value="{{$header->status}}" disabled>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <label for="" class="fw-bold">Judul/Keterangan</label>
            <input type="text" class="form-control form-control-sm" value="{{$header->judul}}" disabled>
        </div>
    </div>
</div>
<div class="menu mb-2">

</div>
<div class="detail">
    <table id="example" class="table bg-white table-sm table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Warna</th>
                <th class="text-center">Yards</th>
                <th class="text-center">Qty</th>
                @if (session()->get('role') == 'ADMIN')
                <th class="text-center" style="width: 20%">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $no => $d)
            <tr>
                <td class="text-center">{{$no+1}}</td>
                <td id="colorPickertable" class="colorPickerCell text-center" style='background-color: #{{$d->warna}};'>{{$d->warna}}</td>
                <td class="text-center">{{$d->yards}}</td>
                <td class="text-center">{{$d->qty}}</td>
                @if (session()->get('role') == 'ADMIN')
                <td class="text-center">
                    <button class="btn btn-sm btn-warning btn-qrcode-print" data-id="{{$d->kode_potonganbahan_detail}}" data-bs-toggle="modal" data-bs-target="#auth_qr_print"><i class="bi bi-qr-code"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="{{$d->kode_potonganbahan_detail}}" data-bs-toggle="modal" data-bs-target="#auth_delete"><i class="bi bi-trash"></i></button>
                    <button class="btn btn-sm btn-success btn-edit" data-id="{{$d->kode_potonganbahan_detail}}" data-bs-toggle="modal" data-bs-target="#auth_edit"><i class="bi bi-pencil"></i></button>
                </td>
                @endif
            </tr>
            @endforeach
            <!-- <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdata" id="btn-tambah-data">
                        <i class="bi bi-plus-square-fill me-2"></i>Tambah
                    </button>
                </td>
            </tr> -->
        </tbody>
    </table>
</div>
<!-- Modal Print Qr-->
<div class="modal fade" id="auth_qr_print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak QR Code</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('potonganbahan/qrcode_print') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <p class="fw-normal text-warning m-0">Silahkan Masukan Password Sebelum Print QR Code</p>
                    <input type="hidden" name="kode_potonganbahan_detail" id="kode_detail">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="" required placeholder="Masukan Password Anda">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Hapus Data-->
<div class="modal fade" id="auth_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('potonganbahan/delete_detaildata') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <p class="fw-normal text-danger m-0">Silahkan Masukan Password Sebelum Hapus Data</p>
                    <input type="hidden" name="kode_potonganbahan_detail" id="kode_detail_fordelete">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="" required placeholder="Masukan Password Anda">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data-->
<div class="modal fade" id="auth_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('potonganbahan/edit_detaildata') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <label for="">Perubahan Qty</label>
                    <input type="number" class="form-control" name="qty" required>
                    <p class="fw-normal text-danger m-0">Silahkan Masukan Password Sebelum Edit Data</p>
                    <input type="hidden" name="kode_potonganbahan_detail" id="kode_detail_foredit">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="" required placeholder="Masukan Password Anda">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-qrcode-print').click(function() {
            var dataId = $(this).data('id');
            $('#kode_detail').val(dataId);
        })
        $('.btn-delete').click(function() {
            var dataId = $(this).data('id');

            $('#kode_detail_fordelete').val(dataId);
        })
        $('.btn-edit').click(function() {
            var dataId = $(this).data('id');

            $('#kode_detail_foredit').val(dataId);
        })

    })
</script>

@if (session('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "Maaf...",
        text: "{{ session('error') }}",
        confirmButtonText: "Oke",
    })
</script>
@endif

<script>
    var gambarData; // Variabel untuk menyimpan data gambar yang diambil

    function ambilGambar() {
        var videoContainer = document.getElementById('video'); // Ambil elemen div dengan id 'video'
        videoContainer.innerHTML = ''; // Kosongkan konten sebelumnya
        document.getElementById('tangkap-button').style.display = 'inline-block'; // Tampilkan tombol tangkap

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                video: true
            }).then(function(stream) {

                var video = document.createElement('video');
                $('#video').empty();
                videoContainer.appendChild(video); // Tambahkan elemen video sebagai anak dari elemen div

                video.srcObject = stream;
                video.play();

                var captureButton = document.getElementById('tangkap-button');
                captureButton.addEventListener('click', function() {
                    var canvas = document.createElement('canvas');
                    var newWidth = 200;
                    var newHeight = 150;

                    canvas.width = newWidth;
                    canvas.height = newHeight;

                    var context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    gambarData = context.getImageData(0, 0, canvas.width, canvas.height);

                    document.getElementById('preview').src = canvas.toDataURL('image/png');
                    document.getElementById('preview').style.display = 'block';
                    document.getElementById('preview').addEventListener('click', ambilWarna);
                });
            }).catch(function(err) {
                alert('Gagal mengakses kamera: ' + err.message);
            });
        } else {
            alert('Browser tidak mendukung akses kamera.');
        }
    }

    function updateWarna() {
        // Fungsi ini dipanggil saat nilai warna diubah
        var hexWarna = document.getElementById('colorPicker').value;
        document.getElementById('warna').value = hexWarna;
        document.getElementById('colorPreview').style.backgroundColor = '#' + hexWarna;
    }

    function ambilWarna(event) {
        // Fungsi ini dipanggil saat gambar diklik untuk mengambil warna dari gambar
        var canvas = document.createElement('canvas');
        canvas.width = gambarData.width;
        canvas.height = gambarData.height;
        var context = canvas.getContext('2d');
        context.putImageData(gambarData, 0, 0);
        var x = event.offsetX; // Gunakan offsetX dan offsetY
        var y = event.offsetY;
        var piksel = context.getImageData(x, y, 1, 1).data;

        // Ubah nilai warna RGB menjadi format hex
        var hexWarna = rgbToHex(piksel[0], piksel[1], piksel[2]);
        document.getElementById('colorPicker').value = hexWarna;
        document.getElementById('warna').value = hexWarna;
        document.getElementById('colorPreview').style.backgroundColor = '#' + hexWarna;
    }

    function rgbToHex(r, g, b) {
        return ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
    }

    document.getElementById('preview').addEventListener('click', ambilWarna);
    document.getElementById('colorPicker').addEventListener('input', updateWarna);

    // Menambahkan event listener ke tombol ambil gambar
    document.getElementById('ambil-gambar-button').addEventListener('click', ambilGambar);
</script>
@endsection