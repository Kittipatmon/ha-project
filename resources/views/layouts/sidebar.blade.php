<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR System</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Prompt', sans-serif;
        }

        /* Custom Scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #121418;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #D71920;
        }

        /* Helper class to hide elements via JS */
        .hidden-force {
            display: none !important;
        }
        
        /* Smooth transition for sidebar width */
        #sidebar {
            transition: width 0.3s ease;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        kumwell: {
                            red: '#D71920',
                            dark: '#121418',
                            card: '#1E2129',
                            hover: '#2A2E38'
                        }
                    },
                    width: {
                        '62': '15.5rem', // Define w-62 to match original code
                    }
                }
            }
        }
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: @json(session('success')),
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        @endif
    </script>
</head>

<body class="bg-gray-50 dark:bg-kumwell-dark text-gray-800 dark:text-gray-200 antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside id="sidebar" class="w-62 flex-shrink-0 flex flex-col h-full bg-[#150f0f] text-white border-r border-gray-800 shadow-xl z-20 relative">

            <div class="h-20 flex items-center justify-between px-6 border-b border-gray-800 bg-gradient-to-r from-[#0F1115] to-[#1a1d24]">
                
                <div id="sidebar-logo" class="flex items-center gap-3 overflow-hidden whitespace-nowrap transition-opacity duration-300 opacity-100">
                    <div class="w-8 h-8 rounded-lg bg-kumwell-red flex items-center justify-center shadow-lg shadow-red-900/50 flex-shrink-0">
                        <span class="font-bold text-white text-sm">H</span>
                    </div>
                    <a href="#"> <div class="flex flex-col leading-none">
                            <span class="text-lg font-bold tracking-wide text-white">Kumwell</span>
                            <span class="text-[10px] text-kumwell-red font-bold uppercase tracking-widest">HA System</span>
                        </div>
                    </a>
                </div>

                <button id="sidebar-toggle-btn" class="p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition focus:outline-none">
                    <i id="icon-bars" class="fa-solid fa-bars text-sm hidden"></i>
                    <i id="icon-chevron" class="fa-solid fa-chevron-left text-sm"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto sidebar-scroll">

                <div class="sidebar-text px-2 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</div>

                <a href="#" class="group relative flex items-center px-3 py-1 rounded-xl text-gray-400 hover:bg-gradient-to-r hover:from-kumwell-red hover:to-red-700 hover:text-white hover:shadow-lg hover:shadow-red-900/30 transition-all duration-200">
                    <i id="dashboard-icon" class="fa-solid fa-chart-pie text-sm w-6 text-center group-hover:text-white transition-colors mr-3"></i>
                    <span class="sidebar-text">Dashboard</span>
                    
                    <div class="tooltip absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity pointer-events-none z-50 whitespace-nowrap ml-2 shadow-md border border-gray-700 hidden">
                        Dashboard
                    </div>
                </a>

                <div class="relative group">
                    <button onclick="toggleDropdown('dropdown-datapublic')" 
                            class="w-full flex items-center justify-between px-3 py-1 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-white transition-all duration-200"
                            id="btn-datapublic">
                        <div class="flex items-center">
                            <i id="icon-datapublic" class="fa-solid fa-database text-sm w-6 text-center mr-3"></i>
                            <span class="sidebar-text">ข้อมูลทั่วไป</span>
                        </div>
                        <i id="arrow-datapublic" class="sidebar-text fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                    </button>

                    <div id="dropdown-datapublic" class="hidden pl-10 pr-2 py-1 space-y-1 transition-all duration-300">
                        <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">
                            - ข้อมูลข่าวสาร
                        </a>
                    </div>
                    
                    <div class="tooltip absolute left-14 top-2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity pointer-events-none z-50 whitespace-nowrap ml-2 shadow-md border border-gray-700 hidden">
                        ข้อมูลทั่วไป
                    </div>
                </div>

                <div class="relative group">
                    <button onclick="toggleDropdown('dropdown-request')" 
                            class="w-full flex items-center justify-between px-3 py-1 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-white transition-all duration-200"
                            id="btn-request">
                        <div class="flex items-center">
                            <i id="icon-request" class="fa-solid fa-file-signature text-sm w-6 text-center mr-3"></i>
                            <span class="sidebar-text">Request Settings</span>
                        </div>
                        <i id="arrow-request" class="sidebar-text fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                    </button>

                    <div id="dropdown-request" class="hidden pl-10 pr-2 py-1 space-y-1 transition-all duration-300">
                        <a href="{{ route('request-categories.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">
                            - ประเภทคำร้อง
                        </a>
                        <a href="{{ route('request-types.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">
                            - ตัวเลือกการร้องขอ
                        </a>
                         <a href="{{ route('request-subtypes.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">
                            - ประเภทย่อย
                        </a>
                    </div>
                    
                    <div class="tooltip absolute left-14 top-2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity pointer-events-none z-50 whitespace-nowrap ml-2 shadow-md border border-gray-700 hidden">
                        Request Settings
                    </div>
                </div>

                <div class="relative group">
                    <button onclick="toggleDropdown('dropdown-hr')" 
                            class="w-full flex items-center justify-between px-3 py-1 rounded-xl text-gray-400 hover:bg-gray-800/50 hover:text-white transition-all duration-200"
                            id="btn-hr">
                        <div class="flex items-center">
                            <i id="icon-hr" class="fa-solid fa-users-gear text-sm w-6 text-center mr-3"></i>
                            <span class="sidebar-text">HR Settings</span>
                        </div>
                        <i id="arrow-hr" class="sidebar-text fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                    </button>

                    <div id="dropdown-hr" class="hidden pl-10 pr-2 py-1 space-y-1 transition-all duration-300">
                        <a href="#" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">- ข้อมูลพนักงาน</a>
                        <a href="#" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">- ข้อมูลสายงาน</a>
                        <a href="#" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">- ข้อมูลแผนก</a>
                        <a href="#" class="block px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-kumwell-red hover:bg-gray-800/50 transition-colors">- ข้อมูลฝ่าย</a>
                    </div>
                     <div class="tooltip absolute left-14 top-2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity pointer-events-none z-50 whitespace-nowrap ml-2 shadow-md border border-gray-700 hidden">
                        HR Settings
                    </div>
                </div>

            </nav>

            <div class="border-t border-gray-800 p-4 bg-[#0a0c10]">
                
                <div class="sidebar-text flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Preferences</span>
                </div>

                <div class="sidebar-text flex items-center justify-between px-3 py-2 rounded-lg bg-gray-900 border border-gray-800 mb-3">
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <i class="fa-solid fa-moon"></i>
                        <span>Dark Mode</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="dark-mode-toggle" class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-kumwell-red"></div>
                    </label>
                </div>

                <div id="user-profile" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 border border-gray-600 flex items-center justify-center text-white font-bold shadow-md shrink-0">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    
                    <div class="sidebar-text flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">
                            {{ Auth::user()->fullname }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ Auth::user()->employee_code }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 bg-gray-50 dark:bg-kumwell-dark text-gray-900 dark:text-gray-100 overflow-y-auto relative">
            <div class="p-4">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">
                        @yield('title', 'Dashboard')
                    </h1>
                    <div class="text-sm text-red-500">
                        <span id="current-date"></span>
                    </div>
                </div>
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // === 1. Sidebar Logic ===
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const iconBars = document.getElementById('icon-bars');
        const iconChevron = document.getElementById('icon-chevron');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarLogo = document.getElementById('sidebar-logo');
        const tooltips = document.querySelectorAll('.tooltip');
        const dropdownSubmenus = document.querySelectorAll('[id^="dropdown-"]');
        const userProfile = document.getElementById('user-profile');
        
        // Icons that need margin adjustments
        const dashboardIcon = document.getElementById('dashboard-icon');
        const requestIcon = document.getElementById('icon-request');
        const hrIcon = document.getElementById('icon-hr');
        const datapublicIcon = document.getElementById('icon-datapublic');
        

        let isSidebarOpen = true;

        toggleBtn.addEventListener('click', () => {
            isSidebarOpen = !isSidebarOpen;
            updateSidebarState();
        });

        function updateSidebarState() {
            if (isSidebarOpen) {
                // Expand Sidebar
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-62');

                // Show Icons
                iconBars.classList.add('hidden');
                iconChevron.classList.remove('hidden');

                // Show Text Elements
                sidebarLogo.classList.remove('opacity-0', 'w-0');
                sidebarLogo.classList.add('opacity-100');
                
                sidebarTexts.forEach(el => el.classList.remove('hidden'));

                // Adjust Icons Margins
                dashboardIcon.classList.add('mr-3');
                requestIcon.classList.add('mr-3'); // Add margin back
                requestIcon.classList.remove('text-kumwell-red'); // Remove red accent
                hrIcon.classList.add('mr-3');
                hrIcon.classList.remove('text-kumwell-red');
                datapublicIcon.classList.add('mr-3');
                datapublicIcon.classList.remove('text-kumwell-red');

                // Hide Tooltips (CSS group-hover will rely on parent class if needed, strictly hide here)
                tooltips.forEach(t => t.classList.add('hidden'));
                
                // User Profile Alignment
                userProfile.classList.remove('justify-center');

            } else {
                // Collapse Sidebar
                sidebar.classList.remove('w-62');
                sidebar.classList.add('w-20');

                // Swap Icons
                iconBars.classList.remove('hidden');
                iconChevron.classList.add('hidden');

                // Hide Text Elements
                sidebarLogo.classList.remove('opacity-100');
                sidebarLogo.classList.add('opacity-0', 'w-0');

                sidebarTexts.forEach(el => el.classList.add('hidden'));

                // Adjust Icons for Center View
                dashboardIcon.classList.remove('mr-3');
                requestIcon.classList.remove('mr-3');
                requestIcon.classList.add('text-kumwell-red'); // Add color accent when collapsed
                hrIcon.classList.remove('mr-3');
                hrIcon.classList.add('text-kumwell-red');
                datapublicIcon.classList.remove('mr-3');
                datapublicIcon.classList.add('text-kumwell-red');

                // Close all open dropdowns when collapsing sidebar
                dropdownSubmenus.forEach(d => d.classList.add('hidden'));
                document.querySelectorAll('.fa-chevron-down').forEach(i => i.classList.remove('rotate-180'));

                // Enable Tooltips logic (allow hover)
                tooltips.forEach(t => t.classList.remove('hidden'));
                // Note: The 'hidden' class on tooltips effectively disables them. 
                // Removing it allows the CSS opacity/hover transition to work.

                 // User Profile Alignment
                 userProfile.classList.add('justify-center');
            }
        }

        // === 2. Dropdown Logic ===
        function toggleDropdown(dropdownId) {
            // If sidebar is closed, open it first to show the menu
            if (!isSidebarOpen) {
                isSidebarOpen = true;
                updateSidebarState();
                
                // Small delay to let sidebar expand before opening menu
                setTimeout(() => {
                    performToggle(dropdownId);
                }, 150);
            } else {
                performToggle(dropdownId);
            }
        }

        function performToggle(dropdownId) {
            const content = document.getElementById(dropdownId);
            const btn = content.previousElementSibling; // The button trigger
            const arrow = btn.querySelector('.fa-chevron-down');

            // Toggle Hidden Class
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-180');
                btn.classList.add('bg-gray-800/50', 'text-white');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-180');
                btn.classList.remove('bg-gray-800/50', 'text-white');
            }
        }

        // === 3. Dark Mode Logic ===
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        
        // Check local storage on load
        if (localStorage.getItem('theme') === 'dark' || 
           (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            darkModeToggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark');
            darkModeToggle.checked = false;
        }

        // Event Listener
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });

        // === 4. Date Logic (Optional) ===
        const dateElement = document.getElementById('current-date');
        if(dateElement) {
            const now = new Date();
            dateElement.textContent = now.toDateString(); 
        }

    </script>
    
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
    
</body>
</html>