<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounting App</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk dropdown & mobile sidebar -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="bg-gray-100" 
      x-data="{ 
          sidebarOpen: window.innerWidth >= 1024, 
          masterOpen: false 
      }" 
      @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <div class="min-h-screen flex">

   
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-200 z-50"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Brand -->
            <div class="p-4 font-bold text-xl text-blue-600 border-b flex justify-between items-center">
                Accounting App
                <!-- Tombol close di mobile -->
                <button class="lg:hidden text-gray-500" @click="sidebarOpen = false">✖</button>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 space-y-1">
                <a href="{{ route('dashboard.index') }}" 
                class="block px-6 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                Dashboard
                </a>

                <!-- Master Data Dropdown -->
                <div x-data="{ open: masterOpen }" class="space-y-1">
                    <button @click="open = !open" 
                        class="w-full flex justify-between items-center px-6 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                        <span>Master Data</span>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transform transition-transform text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="ml-6 mt-1 space-y-1" x-transition>
                        <a href="{{ route('kategori.index') }}" 
                        class="block px-4 py-2 text-gray-600 rounded hover:bg-blue-50 hover:text-blue-600">
                        Kategori COA
                        </a>
                        <a href="{{ route('coa.index') }}" 
                        class="block px-4 py-2 text-gray-600 rounded hover:bg-blue-50 hover:text-blue-600">
                        Chart of Account
                        </a>
                    </div>
                </div>

                <a href="{{ route('transaksi.index') }}" 
                class="block px-6 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                Transaksi
                </a>

                <!-- Laporan -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-gray-400 uppercase">Laporan</p>
                    <a href="{{ route('laporan.index') }}" 
                    class="block px-6 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Profit & Loss
                    </a>
                </div>

                <!-- Pengaturan -->
                <div class="mt-4">
                    <p class="px-6 text-xs font-semibold text-gray-400 uppercase">Pengaturan</p>
                    <a href="#" 
                    class="block px-6 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                    Manajemen User
                    </a>
                </div>
            </nav>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64 transition-all">
            <!-- Header -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <!-- Burger button di mobile -->
                    <button class="lg:hidden text-gray-600" @click="sidebarOpen = true">☰</button>
                    <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
