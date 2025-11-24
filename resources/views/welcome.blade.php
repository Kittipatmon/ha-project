@extends('layouts.app')

@section('content')
    <title>Welcome to Human Assetment</title>
    
    <!-- External Resources (Ensure FontAwesome is loaded) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /*  */
        body {
            /* font-family: 'Prompt', sans-serif; */
            background-color: #17191F; 
            /* Main Dark Background */
        }
        
        /* Custom Colors */
        .text-custom-red { color: #FF2D37; }
        .bg-custom-red { background-color: #FF2D37; }
        .border-custom-red { border-color: #FF2D37; }
        .bg-custom-dark { background-color: #17191F; }
        .bg-custom-darker { background-color: #121418; }
        
        /* Effects */
        .btn-outline:hover {
            background-color: rgba(255, 45, 55, 0.1);
        }
        
        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
            border-color: rgba(255, 45, 55, 0.5);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        /* Utilities */
        .mask-image-gradient {
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
        }
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Line Clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ================= SERVICE CARDS ================= */
        .service-card {
            background: #FFFFFF10;
            border: 1px solid #FFFFFF12;
            backdrop-filter: blur(6px);
            transition: all .35s ease;
        }
        .service-card:hover {
            border-color: #FF2D37;
            background: #FFFFFF18;
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,.6);
        }
        .service-badge {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 6px;
            background: linear-gradient(90deg,#2563eb,#3b82f6);
            color:#fff;
            font-weight:600;
            letter-spacing:.5px;
        }
        .soon-label { font-size: 11px; color:#60A5FA; font-weight:500; }
        .service-title { font-weight:600; }
        .service-btn {
            font-size: 12px;
            padding: 6px 18px;
            border-radius: 9999px;
            background:#FF2D37;
            color:#fff;
            font-weight:500;
            transition:background .3s;
        }
        .service-btn:hover { background:#e11d27; }
        .service-image-wrapper {
            width:100%;
            aspect-ratio: 16/9;
            overflow:hidden;
            border-radius:14px;
            background:#121418;
        }
        .service-image-wrapper img {
            width:100%;
            height:100%;
            object-fit:cover;
            transition: transform .6s ease, opacity .6s ease;
        }
        .service-card:hover .service-image-wrapper img {
            transform:scale(1.08);
            opacity:.9;
        }
        .service-desc { font-size:11px; line-height:1.35; }
    </style>

    <div class="min-h-screen bg-custom-dark overflow-x-hidden text-white">
        
        <!-- ================= HERO SECTION ================= -->
        <div class="relative pt-12 pb-20 lg:pt-20">
            <!-- Background Elements (Optional Glow) -->
            <div class="absolute top-0 right-0 w-1/2 h-full bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12">
                    
                    <!-- Left: Image (Uncomment to use) -->
                    <div class="relative h-[400px] lg:h-[500px] hidden lg:block rounded-2xl overflow-hidden">
                       <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop" 
                            alt="Human Connection" 
                            class="w-full h-full object-cover opacity-60 hover:opacity-80 transition duration-700">
                       <div class="absolute inset-0 bg-gradient-to-t from-[#17191F] via-transparent to-transparent"></div>
                       <div class="absolute inset-0 bg-gradient-to-r from-[#17191F] via-transparent to-transparent"></div>
                    </div>

                    <!-- Right: Content -->
                    <div class="flex flex-col items-center lg:items-center text-center z-10">
                        
                        <!-- <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-700 bg-gray-800/40 mb-6 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.8)]"></span>
                            <span class="text-gray-300 text-xs font-light tracking-wide">ระบบ HR พร้อมใช้งาน — เวอร์ชันล่าสุด</span>
                        </div> -->

                        <h1 class="text-5xl lg:text-5xl font-bold mb-6 leading-tight">
                            <span>Welcome to</span> <span class="text-custom-red">Human</span>
                            <br>
                            <span class="text-custom-red">Assetment</span>
                        </h1>

                        <p class="text-gray-400 text-sm lg:text-base max-w-2xl mb-10 font-light leading-relaxed">
                            การกำกับ ส่งเสริม คุณค่าทรัพยากรบุคคล มุ่งเน้นการประเมินที่มีประสิทธิภาพประสิทธิผล 
                            ตลอดจนจัดทำหลักสูตรฝึกอบรมให้ครอบคลุมบุคลากรทั่วทั้งองค์กร 
                            รวมทั้งการสร้างวัฒนธรรมการเรียนรู้ตลอดชีวิต (Life Long learning)
                        </p>

                        <div class="flex flex-wrap justify-center lg:justify-end gap-3">
                            <a href="#" class="px-6 py-2.5 bg-custom-red text-white text-sm font-medium rounded-lg shadow-lg hover:bg-red-600 transition-colors duration-300 shadow-red-900/20">
                                นโยบาย (Policy)
                            </a>
                            <a href="#" class="px-6 py-2.5 border border-custom-red text-custom-red text-sm font-medium rounded-lg btn-outline transition-colors duration-300">
                                พันธกิจ (Mission)
                            </a>
                            <a href="#" class="px-6 py-2.5 border border-custom-red text-custom-red text-sm font-medium rounded-lg btn-outline transition-colors duration-300">
                                วัฒนธรรมองค์กร
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= FEATURES / SERVICES ================= -->
        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-8 w-1 bg-custom-red rounded-full"></div>
                    <h2 class="text-2xl font-bold text-white">ระบบบริการ</h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Card 1: HR Requests -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                      <a href="{{ route('request.hr') }}">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/reporting.jpg" alt="Reporting System" onerror="this.src='https://source.unsplash.com/600x400?report,data';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-regular fa-file-lines text-custom-red"></i> HR Requests</span>
                            <span class="service-badge">OPEN</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">HR Request System</h3>
                        <p class="service-desc text-gray-400 mb-3">คำร้องทุกประเภท (แก้ไขเวลา, ใบรับรองเงินเดือน, สวัสดิการ ฯลฯ) พร้อมติดตามสถานะ</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                      </a>
                    </div>

                    <!-- Card 2: Manpower -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/manpower.jpg" alt="Manpower System" onerror="this.src='https://source.unsplash.com/600x400?people,team';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-briefcase text-custom-red"></i> Manpower</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Manpower System</h3>
                        <p class="service-desc text-gray-400 mb-3">การจัดการทรัพยากรบุคคลอย่างมีประสิทธิภาพ</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>

                    <!-- Card 3: Training -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/training.jpg" alt="Training" onerror="this.src='https://source.unsplash.com/600x400?training,skills';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-chalkboard-user text-custom-red"></i> Training</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Training Module</h3>
                        <p class="service-desc text-gray-400 mb-3">ระบบฝึกอบรมพัฒนาบุคลากรและการพัฒนาทักษะ</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>

                    <!-- Card 4: Job Hiring -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/job-hiring.jpg" alt="Job Hiring" onerror="this.src='https://source.unsplash.com/600x400?hiring,career';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-clipboard-check text-custom-red"></i> ตำแหน่งงานว่าง</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Job Hiring</h3>
                        <p class="service-desc text-gray-400 mb-3">ค้นหาตำแหน่งงานว่างภายในองค์กร พร้อมรายละเอียดและวิธีการสมัคร</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">ดูตำแหน่งงาน <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>

                    <!-- Card 5: Safety & Environment -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/safety.jpg" alt="Safety & Environment" onerror="this.src='https://source.unsplash.com/600x400?safety,work';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-helmet-safety text-custom-red"></i> Safety & Environment</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Safety At Work</h3>
                        <p class="service-desc text-gray-400 mb-3">ระบบบริหารจัดการความปลอดภัยและสิ่งแวดล้อมในองค์กร</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>

                    <!-- Card 6: Suggestion / Complaints -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/suggestion.png" alt="Suggestion" onerror="this.src='https://source.unsplash.com/600x400?suggestion,feedback';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-regular fa-comment-dots text-custom-red"></i> ข้อร้องเรียนต่างๆ</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Suggestion Box</h3>
                        <p class="service-desc text-gray-400 mb-3">ระบบจัดการร้องเรียนจากพนักงานและผู้บริหาร</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>

                    <!-- Card 7: Data Management -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                      <a href="{{ route('request.data') }}">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/data-management.jpg" alt="Data Management" onerror="this.src='https://source.unsplash.com/600x400?data,management';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-database text-custom-red"></i> Data Management</span>
                            <span class="service-badge">OPEN</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Data Management</h3>
                        <p class="service-desc text-gray-400 mb-3">จัดการข้อมูลพนักงานต่างๆ (เพิ่ม แก้ไข ลบ) และข้อมูลสถิติฐานข้อมูล</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1">Open <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div></a>
                    </div>

                    <!-- Card 8: Analytics Dashboard -->
                    <div class="service-card rounded-2xl p-4 flex flex-col">
                        <div class="service-image-wrapper mb-3">
                            <img src="/images/welcome/analytics.png" alt="Analytics Dashboard" onerror="this.src='https://source.unsplash.com/600x400?analytics,dashboard';">
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-gray-300 flex items-center gap-1"><i class="fa-solid fa-chart-line text-custom-red"></i> Analytics Dashboard</span>
                            <span class="soon-label">Soon</span>
                        </div>
                        <h3 class="service-title text-white text-sm mb-1">Analytic Dashboard</h3>
                        <p class="service-desc text-gray-400 mb-3">ภาพรวมสถิติ HR แบบเรียลไทม์ (Chart.js พร้อมฟิลเตอร์)</p>
                        <div class="mt-auto"><a href="#" class="service-btn inline-flex items-center gap-1 opacity-40 cursor-not-allowed">ดูรายละเอียด <i class="fa-solid fa-arrow-right text-[10px]"></i></a></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= NEWS & PR SECTION ================= -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-1 bg-custom-red rounded-full"></div>
                        <h2 class="text-2xl font-bold text-white">ข่าวสาร & ประชาสัมพันธ์</h2>
                    </div>
                    <a href="#" class="text-gray-400 hover:text-white text-xs transition duration-300 flex items-center gap-2">
                        ดูทั้งหมด <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Main Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
                    
                    <!-- Hero Card (Left) -->
                    <div class="lg:col-span-7 relative h-[350px] lg:h-[420px] rounded-2xl overflow-hidden group cursor-pointer shadow-lg shadow-black/50 border border-gray-800">
                        <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=2000&auto=format&fit=crop" 
                             alt="Main News" 
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-80">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#121418] via-black/60 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-6 lg:p-8 w-full">
                            <span class="bg-red-600/90 text-white text-[10px] font-bold px-2 py-1 rounded mb-3 inline-block uppercase tracking-wider">
                                Highlight
                            </span>
                            <div class="text-gray-400 text-xs mb-1">03 Oct 2025</div>
                            <h1 class="text-2xl lg:text-4xl font-bold text-white mb-2 leading-tight">ICTroadToAi</h1>
                            <p class="text-gray-300 text-sm mb-4 line-clamp-2 lg:w-3/4 font-light opacity-80">
                                การนำ AI มาปรับใช้ภายในองค์กร เพื่อให้เกิดประโยชน์สูงสุด ในการลดกระบวนการในการทำงาน...
                            </p>
                            <button class="bg-custom-red hover:bg-red-700 text-white text-sm px-6 py-2 rounded-lg transition duration-300 flex items-center gap-2 shadow-lg shadow-red-900/50">
                                อ่านรายละเอียด <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Side List (Right) -->
                    <div class="lg:col-span-5 flex flex-col gap-4 h-[420px] overflow-y-auto no-scrollbar">
                        <!-- Item 1 -->
                        <div class="bg-[#1E2129] hover:bg-[#252933] p-4 rounded-xl flex gap-4 transition duration-300 cursor-pointer border border-gray-800/50 group">
                            <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?q=80" class="w-full h-full object-cover group-hover:scale-110 transition">
                            </div>
                            <div class="flex flex-col justify-between py-1">
                                <div>
                                    <div class="text-gray-500 text-[10px] mb-1">29 Sep 2025</div>
                                    <h3 class="text-white font-medium text-sm mb-1 line-clamp-1 group-hover:text-custom-red transition">หลักการทำงานและการใช้งาน API</h3>
                                    <p class="text-gray-400 text-xs line-clamp-2 font-light">API คือตัวกลางระหว่าง client และ server เพื่อทำหน้าที่เชื่อมต่อ...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="bg-[#1E2129] hover:bg-[#252933] p-4 rounded-xl flex gap-4 transition duration-300 cursor-pointer border border-gray-800/50 group">
                            <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80" class="w-full h-full object-cover group-hover:scale-110 transition">
                            </div>
                            <div class="flex flex-col justify-between py-1">
                                <div>
                                    <div class="text-gray-500 text-[10px] mb-1">26 Sep 2025</div>
                                    <h3 class="text-white font-medium text-sm mb-1 line-clamp-1 group-hover:text-custom-red transition">ICTKumwellxICTTGI</h3>
                                    <p class="text-gray-400 text-xs line-clamp-2 font-light">แลกเปลี่ยนความคิดเห็นเกี่ยวกับการนำ AI มาใช้ภายในองค์กร</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="bg-[#1E2129] hover:bg-[#252933] p-4 rounded-xl flex gap-4 transition duration-300 cursor-pointer border border-gray-800/50 group">
                            <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80" class="w-full h-full object-cover group-hover:scale-110 transition">
                            </div>
                            <div class="flex flex-col justify-between py-1">
                                <div>
                                    <div class="text-gray-500 text-[10px] mb-1">05 Sep 2025</div>
                                    <h3 class="text-white font-medium text-sm mb-1 line-clamp-1 group-hover:text-custom-red transition">daisyUI comes</h3>
                                    <p class="text-gray-400 text-xs line-clamp-2 font-light">daisyUI comes with 35 built-in themes...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Slider (Horizontal Scroll) -->
                <div class="flex gap-4 overflow-x-auto no-scrollbar pb-4">
                    @for ($i = 1; $i <= 6; $i++)
                    <div class="min-w-[180px] cursor-pointer group">
                        <div class="h-[120px] rounded-xl overflow-hidden mb-2 border border-gray-800 relative">
                            <img src="https://source.unsplash.com/random/300x200?tech,office&sig={{ $i }}" class="w-full h-full object-cover transition group-hover:scale-110 opacity-70 group-hover:opacity-100">
                        </div>
                        <p class="text-gray-400 text-xs group-hover:text-white transition">Update News Item {{ $i }}...</p>
                    </div>
                    @endfor
                </div>

            </div>
        </div>

    </div>

@endsection