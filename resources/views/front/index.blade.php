@extends('layouts.front')

@section('content')
<section class="swiper-slider-hero relative block h-screen" id="home">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide flex items-center overflow-hidden">
                <div class="slide-inner slide-bg-image flex items-center bg-center;" data-background="{{ asset('user-uploads/sliders/' . $slider->image) }}">
                    <div class="absolute inset-0 bg-black/70"></div>
                    <div class="container">
                        <div class="grid grid-cols-1">
                            <div class="text-center">
                                <h1 class="font-semibold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-5">{{ $slider->title }}</h1>
                                <p class="text-white/70 text-lg max-w-xl mx-auto">{{ $slider->desc }}</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="swiper-slide flex items-center overflow-hidden">
                <div class="slide-inner slide-bg-image flex items-center bg-center;" data-background="{{ asset('user-uploads/sliders/' . $slider->image) }}">
                    <div class="absolute inset-0 bg-black/70"></div>
                    <div class="container">
                        <div class="grid grid-cols-1">
                            <div class="text-center">
                                <h1 class="font-semibold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-5">{{ $slider->title }}</h1>
                                <p class="text-white/70 text-lg max-w-xl mx-auto">{{ $slider->desc }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="swiper-button-next rounded-full text-center"></div>
        <div class="swiper-button-prev rounded-full text-center"></div>
    </div>
</section>
  
<section class="relative bg-gray-50 dark:bg-slate-800 md:py-24 py-16">
     
    <div class="container">
     
        <div class="grid grid-cols-1 justify-center">
          
            <div class="features-absolute">
               
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-[24px]">
                        @foreach($slidercards as $slidercard) 
                    <div class="group p-6 md:px-4 rounded-lg shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 bg-white dark:bg-slate-900 text-center transition-all duration-500 ease-in-out">
                        <div
                            class="w-16 h-16 bg-indigo-600/5 text-indigo-600 rounded-lg text-2xl flex align-middle justify-center items-center shadow-sm dark:shadow-gray-800 mx-auto">
                            <i class="material-icons text-2xl text-indigo-600">{{ $slidercard->icon }}</i>
                        </div>

                        <div class="content mt-7">
                            <a href="page-services.html" class="title h5 text-lg font-medium hover:text-indigo-600">{{ $slidercard->title }}</a>
                            <p class="text-slate-400 mt-3">{{ $slidercard->desc }}</p>

                            <div class="mt-5">
                                <a href=""
                                    class="btn btn-link text-indigo-600 hover:text-indigo-600 after:bg-indigo-600 duration-500 ease-in-out">Read
                                    More <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
  @endforeach
                    {{-- <div class="group p-6 md:px-4 rounded-lg shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 bg-white dark:bg-slate-900 text-center transition-all duration-500 ease-in-out">
                        <div
                            class="w-16 h-16 bg-indigo-600/5 text-indigo-600 rounded-lg text-2xl flex align-middle justify-center items-center shadow-sm dark:shadow-gray-800 mx-auto">
                            <i class="uil uil-bill"></i>
                        </div>

                        <div class="content mt-7">
                            <a href="page-services.html" class="title h5 text-lg font-medium hover:text-indigo-600">Authorised Finance Brand</a>
                            <p class="text-slate-400 mt-3">The most well-known which is said to have originated</p>

                            <div class="mt-5">
                                <a href=""
                                    class="btn btn-link text-indigo-600 hover:text-indigo-600 after:bg-indigo-600 duration-500 ease-in-out">Read
                                    More <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="group p-6 md:px-4 rounded-lg shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 bg-white dark:bg-slate-900 text-center transition-all duration-500 ease-in-out">
                        <div
                            class="w-16 h-16 bg-indigo-600/5 text-indigo-600 rounded-lg text-2xl flex align-middle justify-center items-center shadow-sm dark:shadow-gray-800 mx-auto">
                            <i class="uil uil-money-withdrawal"></i>
                        </div>

                        <div class="content mt-7">
                            <a href="page-services.html" class="title h5 text-lg font-medium hover:text-indigo-600">Compehensive Advices</a>
                            <p class="text-slate-400 mt-3">The most well-known which is said to have originated</p>

                            <div class="mt-5">
                                <a href=""
                                    class="btn btn-link text-indigo-600 hover:text-indigo-600 after:bg-indigo-600 duration-500 ease-in-out">Read
                                    More <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="group p-6 md:px-4 rounded-lg shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 bg-white dark:bg-slate-900 text-center transition-all duration-500 ease-in-out">
                        <div
                            class="w-16 h-16 bg-indigo-600/5 text-indigo-600 rounded-lg text-2xl flex align-middle justify-center items-center shadow-sm dark:shadow-gray-800 mx-auto">
                            <i class="uil uil-presentation-line"></i>
                        </div>

                        <div class="content mt-7">
                            <a href="page-services.html" class="title h5 text-lg font-medium hover:text-indigo-600">Best Tax Advantages</a>
                            <p class="text-slate-400 mt-3">The most well-known which is said to have originated</p>

                            <div class="mt-5">
                                <a href=""
                                    class="btn btn-link text-indigo-600 hover:text-indigo-600 after:bg-indigo-600 duration-500 ease-in-out">Read
                                    More <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div>
                    </div> --}}
                </div>
             
            
            </div>
         
        </div>
       
    </div>
               @foreach($overviews as $overview) 
    <div class="container md:mt-24 mt-16">
        <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-[30px]">
            <div class="md:col-span-12">
                <div class="lg:ml-4">
                    <h4 class="mb-6 md:text-3xl text-2xl lg:leading-normal leading-normal font-medium">We are the largest Business expert </h4>
                    <p class="text-slate-400">{{ $overview->desc }}</p>
                </div>
            </div>
           
        </div>
           
    </div>
  @endforeach
</section>
  
<section class="relative md:py-24 py-16">
   
    <div class="container">
          
        <div class="grid grid-cols-1 pb-8 text-center">
            <h3 class="mb-6 md:text-3xl text-2xl md:leading-normal leading-normal font-semibold">Features</h3>
        </div>
   
        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px] mt-8">
             @foreach($features as $feature) 
            <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="material-icons" class="material-icons materialh-5 w-5 rotate-45">{{ $feature->icon }}</i>
                           
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">{{ $feature->title }}</h4>
                    </div>
                </div>
            </div>
                  @endforeach
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="heart" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Browser Compatibility</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="eye" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Retina Ready</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="layout" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Based On Tailwindcss 3</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="feather" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Feather Icons</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="code" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Built With SASS</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="user-check" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">W3c Valid Code</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="globe" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Browsers Compatible</h4>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="lg:col-span-4 md:col-span-6">
                <div class="flex transition-all duration-500 hover:scale-105 shadow dark:shadow-gray-800 hover:shadow-md dark:hover:shadow-gray-700 ease-in-out items-center p-3 rounded-md bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-center h-[45px] min-w-[45px] -rotate-45 bg-gradient-to-r from-transparent to-indigo-600/10 text-indigo-600 text-center rounded-full mr-3">
                        <i data-feather="settings" class="h-5 w-5 rotate-45"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="mb-0 text-lg font-medium">Easy to customize</h4>
                    </div>
                </div>
            </div> --}}

        </div>
     
    </div>
   
</section>

<section class="relative md:py-24 py-16">
   
    <div class="grid grid-cols-1 pb-8 text-center">
    
        <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">What Our Clients Say</h3>
    </div>
 
    <div class="grid grid-cols-1 mt-8">
             
        <div class="tiny-three-item">
            @foreach($clientsoverview as $clientsoverviews)
            <div class="tiny-slide text-center">
                  
                <div class="customer-testi">
                    
                    <div class="content relative rounded shadow dark:shadow-gray-800 m-2 p-6 bg-white dark:bg-slate-900">
                        
                        <i class="mdi mdi-format-quote-open mdi-48px text-indigo-600"></i>
                        <p class="text-slate-400">{{$clientsoverviews->desc}}</p>
                        <ul class="list-none mb-0 text-amber-400 mt-3">
                             @php
        $rating = $clientsoverviews->rating_star;
    @endphp
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rating)
            <li class="inline"><i class="mdi mdi-star text-amber-400"></i></li>
        @else
            <li class="inline"><i class="mdi mdi-star-outline text-amber-400"></i></li>
        @endif
    @endfor
                            
                        </ul>
                       
                    </div>
                
                    <div class="text-center mt-5">
                        <img src="{{ asset('user-uploads/clientsoverview/' . $clientsoverviews->image) }}" class="h-14 w-14 rounded-full shadow-md mx-auto" alt="">
                        <h6 class="mt-2 font-semibold">{{$clientsoverviews->name}}</h6>
                        <span class="text-slate-400 text-sm">{{$clientsoverviews->designation}}</span>
                    </div>
                </div>
                 
            </div>

            @endforeach
        </div>

    </div>
           
</section>
@endsection

@push('footer-script')

@endpush