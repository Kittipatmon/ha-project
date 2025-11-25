@extends('layouts.app')
@section('title', 'รายละเอียดข่าวสาร')

@section('content')
@php
    use Illuminate\Support\Str;
    
    // ==========================================
    // ส่วนที่ 1: จัดการรูปภาพ (Gallery Logic)
    // ==========================================
    $galleryImages = [];
    
    // ดึงค่า path ออกมาก่อน และเช็คว่าเป็น array หรือไม่
    $rawPath = $news->image_path;
    if (is_array($rawPath)) {
        $rawPath = !empty($rawPath) ? $rawPath[0] : null;
    }

    $mainImage = $rawPath ? asset($rawPath) : null;
    $imageDir = $rawPath ? public_path(dirname($rawPath)) : null;

    // ค้นหารูปอื่นๆ ในโฟลเดอร์เดียวกัน
    if ($imageDir && is_dir($imageDir)) {
        $files = glob($imageDir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        if ($files) {
            foreach ($files as $file) {
                $rel = Str::after($file, public_path());
                $rel = str_replace('\\', '/', $rel); // แก้ Path สำหรับ Windows
                $galleryImages[] = asset($rel);
            }
        }
    }
    
    // เอารูปหลักไว้รูปแรกเสมอ
    if ($mainImage && !in_array($mainImage, $galleryImages)) {
        array_unshift($galleryImages, $mainImage);
    }

    // ==========================================
    // ส่วนที่ 2: จัดการไฟล์แนบ (Fix Error trim())
    // ==========================================
    $attachmentFiles = [];
    $rawFiles = $news->file_news; // ดึงค่าออกมาก่อน

    if (!empty($rawFiles)) {
        // กรณีที่ 1: เป็น Array อยู่แล้ว (เพราะ Model cast มาให้) -> ใช้ได้เลย
        if (is_array($rawFiles)) {
            $attachmentFiles = array_filter($rawFiles);
        } 
        // กรณีที่ 2: เป็น String -> ต้องมา trim และ decode เอง
        elseif (is_string($rawFiles)) {
            $raw = trim($rawFiles);
            if (Str::startsWith($raw, '[')) { // เป็น JSON String
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    $attachmentFiles = array_filter($decoded);
                }
            } else { // เป็นข้อความคั่นด้วยคอมม่า
                $attachmentFiles = array_filter(array_map('trim', explode(',', $raw)));
            }
        }
    }
@endphp

<div class="text-white p-4 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 text-sm">
        <div class="flex items-center space-x-2 text-gray-400 mb-4 md:mb-0">
            <a href="{{ route('welcome') }}" class="hover:text-white transition">หน้าแรก</a>
            <span class="text-gray-600">></span>
            <span class="text-red-500 font-medium">{{ $news->title }}</span>
        </div>
        <div class="flex items-center bg-[#1c1f26] px-4 py-1.5 rounded-full border border-gray-800">
            <span class="text-gray-400 mr-2">วันที่เผยแพร่ :</span>
            <span class="text-red-500 font-bold">{{ \Carbon\Carbon::parse($news->published_date)->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white">ข่าวสาร & ประชาสัมพันธ์</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <!-- Gallery / Slider -->
            <div class="w-full">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-800/50 relative">
                    <div id="slider" class="relative">
                        @foreach($galleryImages as $idx => $img)
                            <div class="slide {{ $idx === 0 ? 'opacity-100' : 'opacity-0 absolute inset-0' }} transition-opacity duration-500">
                                <img src="{{ $img }}" alt="{{ $news->title }}" class="w-full h-auto object-cover" />
                            </div>
                        @endforeach
                    </div>
                    @if(count($galleryImages) > 1)
                        <button type="button" class="prev absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white px-3 py-2 rounded-full text-xs">‹</button>
                        <button type="button" class="next absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white px-3 py-2 rounded-full text-xs">›</button>
                        <div class="flex space-x-1 justify-center py-3 bg-[#13161c]">
                            @foreach($galleryImages as $i => $img)
                                <button class="dot w-2 h-2 rounded-full {{ $i===0 ? 'bg-red-500' : 'bg-gray-600' }}" data-index="{{ $i }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(count($galleryImages) > 1)
                    <div class="mt-4">
                        <p class="text-xs text-red-400 mb-2">* ป้องกันเรื่องภาพที่ผิดรูปภาพเล็ก โปรดคลิกที่รูปขนาดใหญ่</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach($galleryImages as $i => $img)
                                <button class="thumb group relative border border-gray-700 rounded-lg overflow-hidden" data-index="{{ $i }}">
                                    <img src="{{ $img }}" class="w-32 h-20 object-cover group-hover:opacity-75" alt="thumb {{ $i+1 }}" />
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="flex flex-col h-full">
                <h2 class="text-xl md:text-3xl font-bold mb-4 text-red-600">{{ $news->title }}</h2>
                <p class="text-gray-300 leading-loose text-base md:text-lg font-light mb-6">{!! nl2br(e($news->content)) !!}</p>

                @if(!empty($news->link_news))
                    <div class="bg-[#12151a] border border-blue-700/50 rounded-xl px-5 py-4 mb-6 text-sm">
                        <span class="block font-semibold text-blue-400 mb-1">ลิงก์ที่แนะนำ :</span>
                        <a href="{{ $news->link_news }}" target="_blank" class="break-all text-blue-300 hover:text-blue-200 underline">{{ $news->link_news }}</a>
                    </div>
                @endif

                @if(count($attachmentFiles))
                    <div class="bg-[#181c22] border border-gray-700 rounded-xl px-5 py-4 mb-6">
                        <div class="flex items-center mb-3 text-gray-200 font-semibold text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L21 9.828M8 7l-3.586 3.586a2 2 0 102.828 2.828L12 8" /></svg>
                            โพสต์แนบ
                        </div>
                        <ul class="space-y-2 text-sm">
                            @foreach($attachmentFiles as $file)
                                @php
                                    $fileLabel = basename($file);
                                    $fileUrl = Str::startsWith($file, ['http://','https://']) ? $file : asset($file);
                                @endphp
                                <li class="flex items-center justify-between bg-[#1f232a] border border-gray-700 rounded-lg px-3 py-2">
                                    <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        <span class="text-gray-300 font-mono">{{ $fileLabel }}</span>
                                    </div>
                                    <a href="{{ $fileUrl }}" target="_blank" class="text-red-400 hover:text-red-300 text-xs font-medium">ดาวน์โหลด</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Share Section -->
        <div class="mt-10 border-t border-gray-800/50 pt-8">
            <div class="flex flex-col space-y-4">
                <div class="flex items-center text-blue-400 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                    <span class="font-medium">แชร์ข่าวนี้</span>
                </div>
                <div class="relative w-full max-w-3xl">
                    <div class="flex items-center bg-[#1c1f26] border border-gray-600 rounded-xl overflow-hidden p-1">
                        <div class="pl-4 pr-3 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                        <input type="text" value="{{ request()->getSchemeAndHttpHost() . request()->getRequestUri() }}" id="shareLink" readonly class="bg-transparent border-none text-gray-300 w-full focus:ring-0 px-2 py-2 font-mono text-sm sm:text-base truncate">
                        <button onclick="copyToClipboard()" class="bg-[#ef4444] hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200 flex-shrink-0 ml-2">คัดลอก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple slider logic
    (function() {
        const slides = Array.from(document.querySelectorAll('#slider .slide'));
        const dots = Array.from(document.querySelectorAll('.dot'));
        const thumbs = Array.from(document.querySelectorAll('.thumb'));
        let current = 0;
        function show(index) {
            slides.forEach((s,i)=>{
                if(i===index){
                    s.classList.remove('opacity-0','absolute');
                    s.classList.add('opacity-100');
                } else {
                    s.classList.add('opacity-0','absolute');
                    s.classList.remove('opacity-100');
                }
            });
            dots.forEach((d,i)=>d.classList.toggle('bg-red-500', i===index));
            current = index;
        }
        document.querySelector('.prev')?.addEventListener('click',()=>{ show((current-1+slides.length)%slides.length); });
        document.querySelector('.next')?.addEventListener('click',()=>{ show((current+1)%slides.length); });
        dots.forEach(d=>d.addEventListener('click',()=>show(parseInt(d.dataset.index))));
        thumbs.forEach(t=>t.addEventListener('click',()=>show(parseInt(t.dataset.index))));
    })();

    function copyToClipboard() {
        var copyText = document.getElementById('shareLink');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value).then(() => {
            const btn = document.querySelector('button[onclick="copyToClipboard()"]');
            const originalText = btn.innerText;
            btn.innerText = 'คัดลอกแล้ว!';
            btn.classList.replace('bg-[#ef4444]', 'bg-green-600');
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.replace('bg-green-600', 'bg-[#ef4444]');
            }, 2000);
        });
    }
</script>
@endsection