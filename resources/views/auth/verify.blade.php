@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Harap Verifikasi Alamat Email Anda') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Email Verifikasi Terbaru Telah Terkirim Ke Email Anda.') }}
                        </div>
                    @endif

                    {{ __('Sebelum Mulai, mohon cek verifikasi email di alamat email yang anda daftarkan.') }}
                    {{ __('Jika anda tidak menerimanya') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik Disini Untuk Mengirim Ulang') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
