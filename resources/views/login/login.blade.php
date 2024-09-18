@extends('layouts.master')

@section('content')
<div class="card mt-5 mx-auto" style="max-width: 350px;">
    <div class="card-header bg-success text-light py-4">
        <h2 class="text-center"><strong>OPERATIONAL APP</strong></h2>
    </div>
    <div class="card-body p-4">
        @if (session('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="fw-semibold">{{ session('status') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{ url('/auth')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="" aria-describedby="helpId" placeholder="Masukan Nik" value="{{ old('nik') }}" />
                @error('nik')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="" aria-describedby="helpId" placeholder="Masukan Password" />
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="d-grid">
                <input name="sign" id="" class="btn btn-primary" type="submit" value="Login" />
            </div>
        </form>
    </div>
</div>


@endsection('content')