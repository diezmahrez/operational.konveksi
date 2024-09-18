@extends('layouts.master')

@section('content')
<div class="menu d-block text-center my-4">
    <h2 class="fw-normal">History Potongan Bahan</h2>
</div>
<div class="menu mb-2">
    
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
            <td class="text-start">{{ date_format(new DateTime($p->tanggal),"d-m-Y");  }}</td>
            <td>{{ $p->kode_potonganbahan}}</td>
            <td>{{ $p->nama_brand}}</td>
            <td>{{ $p->nama_model }}</td>
            <td>{{ $p->total_qty }}</td>
            <td> <p class="m-0   badge 
            @if($p->status == 'PROCESS') text-bg-warning
            @else
            text-bg-secondary
            @endif
            ">
            {{ $p->status }}</p></td>
            <td class="text-center">
                <a href="{{url('/historypotonganbahan/'.$p->kode_potonganbahan)}}" class="btn btn-secondary btn-sm"><i class="bi bi-eye-fill"></i></a>
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
</script>
@endsection