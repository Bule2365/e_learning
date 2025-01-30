@extends('guru.layouts.app')

@section('title', 'User Index')

@section('content')
<div>
    <h1>Selamat Datang, {{Auth::user()->name}}</h1>
    <p>Ini platform e_learning untuk kelas online.</p>
</div>
@endsection