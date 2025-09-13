@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Lokasi Baru</h2>
    @if(session('success'))
        <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.lokasi.tambah') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_lokasi">Nama Lokasi</label>
            <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="biaya_jemput">Biaya Jemput</label>
            <input type="number" name="biaya_jemput" id="biaya_jemput" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Lokasi</button>
    </form>
</div>
@endsection