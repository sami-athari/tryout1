<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Seilmu') }}</title>

    <!-- Prevent dark mode flicker -->
    <script>
        (function() {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: background-color 0.2s, color 0.2s; }
        .dark-mode { background: #1a1a1a; color: #e5e5e5; }
        .dark-mode .bg-white { background: #2a2a2a !important; }
        .dark-mode .text-gray-900 { color: #e5e5e5 !important; }
        .dark-mode .text-gray-800 { color: #d4d4d4 !important; }
        .dark-mode .text-gray-700 { color: #b0b0b0 !important; }
        .dark-mode .text-gray-600 { color: #9ca3af !important; }
        .dark-mode .text-gray-500 { color: #6b7280 !important; }
        .dark-mode .border-gray-200 { border-color: #3a3a3a !important; }
        .dark-mode .border { border-color: #3a3a3a !important; }
        .dark-mode .bg-gray-50 { background: #1f1f1f !important; }
        .dark-mode .bg-gray-100 { background: #2f2f2f !important; }
        .dark-mode .bg-gray-200 { background: #3a3a3a !important; }
        .dark-mode input, .dark-mode select, .dark-mode textarea { background: #2a2a2a !important; color: #e5e5e5 !important; border-color: #3a3a3a !important; }
        .dark-mode .hover\:bg-gray-50:hover { background: #2f2f2f !important; }
        .dark-mode .hover\:bg-gray-100:hover { background: #3a3a3a !important; }
        .dark-mode nav.bg-white { background: #1a1a1a !important; border-color: #3a3a3a !important; }
        .theme-switch { width: 50px; height: 26px; background: #e0e0e0; border-radius: 20px; cursor: pointer; position: relative; transition: 0.3s; }
        .dark-mode .theme-switch { background: #4a4a4a; }
        .theme-switch-slider { width: 20px; height: 20px; background: white; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: 0.3s; }
        .dark-mode .theme-switch-slider { left: 27px; }
        .suggestions-container { max-height: 400px; overflow-y: auto; }

        /* Fix profile photo in dark mode */
        .dark-mode .w-8.h-8.rounded-full.bg-gray-200,
        .dark-mode .w-10.h-10.rounded-full.bg-gray-200 {
            background: #4a5568 !important;
            color: #fff !important;
        }
    </style>
</head>

<body>
    @php
        use App\Models\Notification;
        $user = Auth::user();
        $isUser = Auth::check() && $user->role === 'user';
        $userNotifications = collect();
        $userNotifCount = 0;
        if ($isUser) {
            $userNotifications = Notification::where('receiver_id', $user->id)->where('is_read', false)->with('sender')->orderByDesc('created_at')->take(6)->get();
            $userNotifCount = $userNotifications->count();
        }
        $kategori = \App\Models\Kategori::all();
    @endphp

    <div id="app">
        <!-- Simple Navbar -->
        <nav class="bg-white border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-900">Seilmu</a>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center gap-6">
                        @auth
                            @if ($isUser)
                                <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-gray-900">Home</a>
                                <a href="{{ route('user.about') }}" class="text-gray-700 hover:text-gray-900">About</a>
                                <a href="{{ route('user.cart') }}" class="text-gray-700 hover:text-gray-900">Cart</a>
                                <a href="{{ route('user.transactions') }}" class="text-gray-700 hover:text-gray-900">Orders</a>
                            @endif
                        @endauth

                        <div class="relative group">
                            <a href="{{ route('chat.index') }}" class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                                Chat
                                @if ($userNotifCount > 0)
                                    <span class="bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $userNotifCount }}</span>
                                @endif
                            </a>

                            @if ($isUser)
                                <div class="invisible group-hover:visible opacity-0 group-hover:opacity-100 transition absolute right-0 mt-2 w-96 bg-white border rounded-lg shadow-lg">
                                    <div class="p-4 border-b font-semibold">Notifications</div>
                                    @if ($userNotifications->isEmpty())
                                        <div class="p-6 text-center text-gray-500">No new notifications</div>
                                    @else
                                        <ul class="max-h-80 overflow-y-auto">
                                            @foreach ($userNotifications as $notif)
                                                <li><a href="{{ route('chat.show', $notif->sender_id) }}" class="flex items-start p-4 hover:bg-gray-50">
                                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold">{{ strtoupper(substr($notif->sender->name ?? 'U', 0, 1)) }}</div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="font-semibold text-sm">{{ $notif->sender->name ?? 'User' }}</p>
                                                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($notif->message ?? 'New message', 100) }}</p>
                                                        <p class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </a></li>
                                            @endforeach
                                        </ul>
                                        <div class="p-3 border-t text-center"><a href="{{ route('chat.index') }}" class="text-blue-600 text-sm">View all</a></div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('user.dashboard') }}" class="hidden lg:flex items-center gap-4">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="ajax-search border rounded-lg px-4 py-2 w-64" autocomplete="off" data-suggest-url="{{ route('api.products.suggest') }}">
                            <div id="desktop-suggestions" class="suggestions-container hidden absolute mt-2 w-full bg-white border rounded-lg shadow-lg z-50"></div>
                        </div>

                        <div class="relative">
                            <button type="button" id="priceSortBtn" class="border rounded-lg px-4 py-2 bg-white hover:bg-gray-50">Filter</button>
                            <div id="priceSortPanel" class="hidden absolute right-0 mt-2 w-72 bg-white border rounded-lg shadow-lg p-4">
                                <div class="mb-4">
                                    <div class="text-sm font-semibold mb-2">Sort By</div>
                                    <label class="block"><input type="radio" name="sort" value="latest" {{ request('sort')=='latest'?'checked':'' }}> Newest</label>
                                    <label class="block"><input type="radio" name="sort" value="best" {{ request('sort')=='best'?'checked':'' }}> Best Seller</label>
                                    <label class="block"><input type="radio" name="sort_harga" value="asc" {{ request('sort_harga')=='asc'?'checked':'' }}> Lowest Price</label>
                                    <label class="block"><input type="radio" name="sort_harga" value="desc" {{ request('sort_harga')=='desc'?'checked':'' }}> Highest Price</label>
                                </div>
                                <div class="mb-4">
                                    <div class="text-sm font-semibold mb-2">Price Range</div>
                                    <div class="flex gap-2">
                                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min" class="w-1/2 border rounded px-2 py-1">
                                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max" class="w-1/2 border rounded px-2 py-1">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <div class="text-sm font-semibold mb-1">Rating</div>
                                        <select name="rating" class="w-full border rounded px-2 py-1">
                                            <option value="">All</option>
                                            <option value="5" {{ request('rating')==5?'selected':'' }}>5+</option>
                                            <option value="4" {{ request('rating')==4?'selected':'' }}>4+</option>
                                            <option value="3" {{ request('rating')==3?'selected':'' }}>3+</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold mb-1">Category</div>
                                        <select name="kategori" class="w-full border rounded px-2 py-1">
                                            <option value="">All</option>
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id }}" {{ request('kategori')==$k->id?'selected':'' }}>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="priceReset" class="text-sm text-gray-600">Reset</button>
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Apply</button>
                    </form>

                    <!-- Right Side -->
                    <div class="hidden lg:flex items-center gap-4">
                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>

                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Sign Up</a>
                        @else
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                </button>
                                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg">
                                    <div class="p-4 border-b">
                                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('user.wishlist') }}" class="block px-4 py-3 hover:bg-gray-50">Wishlist</a>
                                    <div class="border-t p-4">
                                        <div class="text-sm mb-2">Language</div>
                                        <div id="google_translate_element"></div>
                                    </div>
                                    <button onclick="confirmLogout(event)" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 border-t">Logout</button>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <button onclick="toggleMobileMenu()" class="lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="hidden lg:hidden mt-4 space-y-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="block py-2">Home</a>
                        <a href="{{ route('user.about') }}" class="block py-2">About</a>
                        <a href="{{ route('user.cart') }}" class="block py-2">Cart</a>
                        <a href="{{ route('user.transactions') }}" class="block py-2">Orders</a>
                        <a href="{{ route('chat.index') }}" class="block py-2">Chat @if($userNotifCount > 0)<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $userNotifCount }}</span>@endif</a>
                    @endauth

                    <input type="text" name="search" placeholder="Search..." class="ajax-search w-full border rounded-lg px-4 py-2" data-suggest-url="{{ route('api.products.suggest') }}">
                    <div id="mobile-suggestions" class="suggestions-container hidden mt-2 w-full bg-white border rounded-lg shadow-lg"></div>

                    <div class="flex items-center justify-between py-2 border-t">
                        <span>Dark Mode</span>
                        <div class="theme-switch" onclick="toggleDarkMode()"><div class="theme-switch-slider"></div></div>
                    </div>

                    @guest
                        <a href="{{ route('login') }}" class="block w-full text-center border py-2 rounded-lg">Login</a>
                        <a href="{{ route('register') }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg">Sign Up</a>
                    @else
                        <a href="{{ route('user.wishlist') }}" class="block py-2">Wishlist</a>
                        <div class="py-2"><div id="google_translate_element_mobile"></div></div>
                        <button onclick="confirmLogout(event)" class="w-full text-left py-2 text-red-600">Logout</button>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="w-full min-h-screen">@yield('content')</main>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
    </div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            if (document.getElementById('google_translate_element_mobile')) {
                new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'id,en,ja,ko,zh-CN,ar,fr,de,es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element_mobile');
            }
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                document.documentElement.classList.add('dark-mode');
            }
        });
        function toggleDropdown() { document.getElementById('dropdownMenu').classList.toggle('hidden'); }
        function toggleMobileMenu() { document.getElementById('mobileMenu').classList.toggle('hidden'); }
        function confirmLogout(e) {
            e.preventDefault();
            Swal.fire({title: 'Logout?', text: "Are you sure?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#3b82f6', cancelButtonColor: '#ef4444', confirmButtonText: 'Yes', cancelButtonText: 'Cancel'}).then((result) => {
                if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
            });
        }

        // Filter panel
        (function(){
            const btn = document.getElementById('priceSortBtn');
            const panel = document.getElementById('priceSortPanel');
            const reset = document.getElementById('priceReset');
            if (btn && panel) {
                btn.addEventListener('click', (e) => { e.stopPropagation(); panel.classList.toggle('hidden'); });
                if (reset) { reset.addEventListener('click', () => { panel.querySelectorAll('input').forEach(i => { if (i.type === 'radio') i.checked = false; else i.value = ''; }); }); }
                document.addEventListener('click', (e) => { if (!panel.contains(e.target) && !btn.contains(e.target)) panel.classList.add('hidden'); });
            }
        })();

        // Autosuggest
        (function(){
            const debounce = (fn, delay=300) => { let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), delay); }; };
            function createSuggestionItem(item) {
                const el = document.createElement('div');
                el.className = 'flex items-center gap-3 p-3 cursor-pointer hover:bg-gray-50';
                el.innerHTML = `<img src="${item.foto}" class="w-12 h-12 object-cover rounded" alt="${item.nama}"><div class="flex-1"><div class="font-semibold text-sm">${item.nama}</div><div class="text-sm text-blue-600">Rp ${Number(item.harga||0).toLocaleString('id-ID')}</div></div>`;
                el.dataset.url = item.url;
                return el;
            }
            function attachAutosuggest(input, container) {
                const suggestUrl = input.dataset.suggestUrl;
                if (!suggestUrl) return;
                const fetchSuggestions = debounce(async (q) => {
                    if (!q || q.trim().length < 1) { container.classList.add('hidden'); return; }
                    try {
                        const res = await fetch(`${suggestUrl}?q=${encodeURIComponent(q)}`);
                        if (!res.ok) { container.classList.add('hidden'); return; }
                        const json = await res.json();
                        container.innerHTML = '';
                        if (!Array.isArray(json) || json.length === 0) { container.classList.add('hidden'); return; }
                        json.forEach(it => { const item = createSuggestionItem(it); item.addEventListener('click', () => window.location.href = it.url); container.appendChild(item); });
                        container.classList.remove('hidden');
                    } catch (err) { container.classList.add('hidden'); }
                }, 250);
                input.addEventListener('input', (e) => fetchSuggestions(e.target.value));
                document.addEventListener('click', (ev) => { if (!container.contains(ev.target) && ev.target !== input) container.classList.add('hidden'); });
            }
            document.addEventListener('DOMContentLoaded', () => {
                const desktopInput = document.querySelector('.ajax-search:not(.w-full)');
                const desktopContainer = document.getElementById('desktop-suggestions');
                if (desktopInput && desktopContainer) attachAutosuggest(desktopInput, desktopContainer);
                const mobileInput = document.querySelector('.ajax-search.w-full');
                const mobileContainer = document.getElementById('mobile-suggestions');
                if (mobileInput && mobileContainer) attachAutosuggest(mobileInput, mobileContainer);
            });
        })();

        // Sort radio logic
        document.addEventListener("DOMContentLoaded", () => {
            const bestRadio = document.querySelector("input[name='sort'][value='best']");
            const priceRadios = document.querySelectorAll("input[name='sort_harga']");
            if (bestRadio) { bestRadio.addEventListener("change", () => { if (bestRadio.checked) priceRadios.forEach(r => r.checked = false); }); }
            priceRadios.forEach(r => { r.addEventListener("change", () => { if (r.checked && bestRadio) bestRadio.checked = false; }); });
        });
    </script>
</body>
</html>
