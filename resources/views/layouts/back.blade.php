@extends('layouts.base')
@yield('css')

    @section('body') 
 <header class="app-header fixed-top">	 
    {{-- <x-layouts.sidebar></x-layouts.sidebar> --}}
    <x-layouts.navigation></x-layouts.navigation>
 </header> 
 
<div class="content-wrap">
     <div class="main">
        <div class="app-wrapper">
                <div class="app-content pt-3 p-md-3 p-lg-4">
                            {{-- <div class="container-fluid">
                                            <div class="page-header">
                                                <div class="page-title">
                                                    <h6>Hello {{ Auth::user()->name }},
                                                    <span>Selamat Datang di Menu @yield('menu')</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div> --}}

         
                                        <section id="main-content">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="user-profile">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="container p-20">
                                                                        @yield('content')
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>

		    {{-- <div class="container-xl">

                 @yield('content')

            </div> --}}
                </div>

        <footer class="app-footer">
		    <div class="container text-center py-3">
		         <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            {{-- <small class="copyright">Designed with <i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small> --}}
		       
		    </div>
	    </footer><!--//app-footer-->
     </div>
     </div>
</div>



    @endsection