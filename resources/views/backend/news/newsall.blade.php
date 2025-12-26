@extends('layouts.app')

@section('title', 'ข่าวสารและกิจกรรม')

@section('content')
{{-- Background: ใช้สีพื้นหลังที่นุ่มนวลขึ้นใน Light mode และเข้มลึกใน Dark mode --}}
<div class="min-h-screen py-16 transition-colors duration-300 font-sans">
    <div class="max-w-คxl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section: Modern Gradient Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-red-500/20 blur-3xl rounded-full pointer-events-none"></div>
            
            <h1 class="relative text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-6 tracking-tight leading-tight">
                ข่าวสารและ
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-500 dark:from-red-500 dark:to-rose-400">
                    กิจกรรม
                </span>
            </h1>
            <!-- <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                ติดตามความเคลื่อนไหว ประกาศสำคัญ และเรื่องราวดีๆ ที่เกิดขึ้นล่าสุดได้ที่นี่
            </p> -->
            {{-- Divider --}}
            <div class="mt-8 mx-auto w-24 h-1.5 bg-red-600 rounded-full"></div>
        </div>

        {{-- Grid Content --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($newsItems as $news)
                {{-- Card Item --}}
                <article class="group relative flex flex-col h-full bg-white dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-300 border border-gray-100 dark:border-gray-800 overflow-hidden ring-1 ring-transparent hover:ring-red-500/20">
                    
                    {{-- Image Section --}}
                    <a href="{{ route('news.detail', $news->news_id) }}" class="relative overflow-hidden aspect-[4/3] block">
                        {{-- Overlay Gradient on Hover --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                        
                        <img src="{{ $news->image_path ? asset(is_array($news->image_path) ? $news->image_path[0] : $news->image_path) : 'https://placehold.co/400x300/e2e8f0/ef4444?text=News' }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        
                        {{-- Date Badge: Modern Floating Style --}}
                        <div class="absolute top-3 left-3 z-20">
                            <div class="bg-white/95 dark:bg-gray-900/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-lg border-l-4 border-red-500 flex flex-col items-center min-w-[60px]">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ \Carbon\Carbon::parse($news->published_date)->translatedFormat('M') }}
                                </span>
                                <span class="text-xl font-bold text-gray-900 dark:text-white leading-none">
                                    {{ \Carbon\Carbon::parse($news->published_date)->format('d') }}
                                </span>
                            </div>
                        </div>
                    </a>

                    {{-- Content Section --}}
                    <div class="flex flex-col flex-grow p-6">
                        
                        {{-- Category Tag (Optional - ถ้ามี Category) --}}
                        {{-- <div class="mb-3">
                            <span class="inline-block px-2 py-1 text-xs font-medium text-red-600 bg-red-50 dark:text-red-400 dark:bg-red-900/20 rounded-md">
                                ประชาสัมพันธ์
                            </span>
                        </div> --}}

                        {{-- Title --}}
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 leading-snug group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-200">
                            <a href="{{ route('news.detail', $news->news_id) }}">
                                {{ $news->title }}
                            </a>
                        </h2>

                        {{-- Description --}}
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-5 line-clamp-3 leading-relaxed flex-grow">
                            {{ Str::limit(strip_tags($news->content), 120) }}
                        </p>

                        {{-- Footer / Action --}}
                        <div class="mt-auto pt-5 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            <a href="{{ route('news.detail', $news->news_id) }}" class="inline-flex items-center text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors group/btn">
                                อ่านเพิ่มเติม
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            
                            {{-- Share Icon (Optional decoration) --}}
                            <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                {{-- Empty State: Modern Styling --}}
                <div class="col-span-full py-20 text-center">
                    <div class="relative inline-block">
                        <div class="absolute inset-0 bg-red-100 dark:bg-red-900/30 rounded-full blur-xl"></div>
                        <div class="relative bg-white dark:bg-gray-800 p-6 rounded-full shadow-lg mb-6 mx-auto inline-flex">
                            <svg class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">ยังไม่มีข่าวสารในขณะนี้</h3>
                    <p class="text-gray-500 dark:text-gray-400">ข้อมูลจะถูกอัปเดตเร็วๆ นี้ โปรดกลับมาติดตามใหม่อีกครั้ง</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($newsItems, 'links'))
            <div class="mt-16 flex justify-center">
                {{-- 
                   หมายเหตุ: ถ้าต้องการเปลี่ยนสี Pagination ของ Laravel ต้องไปแก้ที่ 
                   vendor/laravel/framework/src/Illuminate/Pagination/resources/views/tailwind.blade.php 
                   หรือ publish views ออกมาแก้ 
                   
                   แต่เบื้องต้นสามารถ wrap ด้วย class นี้เพื่อให้ theme สีแดงทำงานได้ดีขึ้นหาก config tailwind ถูกต้อง
                --}}
                <div class="[&_.active]:bg-red-600 [&_.active]:border-red-600">
                    {{ $newsItems->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection