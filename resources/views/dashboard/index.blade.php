@extends('layouts.master')

@section('content')
@echo <pre>
{{var_dump(session()->all());}}
@eho </pre>
@endsection