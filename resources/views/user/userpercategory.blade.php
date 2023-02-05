@extends('layouts.back')

@section('content')
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
@livewireStyles
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @livewire('user.userpercategory')
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
@endsection

<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script>

   window.addEventListener('swal:modal',function (e) {
     Swal.fire(e.detail);
   });
 </script>