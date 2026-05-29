<x-app-layout>
    @php
        $heroImage = 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?auto=format&fit=crop&w=1800&q=85';
        $categories = [
            ['name' => 'Hoodies', 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=900&q=80', 'accent' => 'bg-violet-500'],
            ['name' => 'Sneakers', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80', 'accent' => 'bg-cyan-400'],
            ['name' => 'Gym Wear', 'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=900&q=80', 'accent' => 'bg-emerald-400'],
            ['name' => 'Oversized Tees', 'image' => 'https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=900&q=80', 'accent' => 'bg-pink-400'],
            ['name' => 'Accessories', 'image' => 'https://images.unsplash.com/photo-1506629905607-d405d7d3b0d2?auto=format&fit=crop&w=900&q=80', 'accent' => 'bg-amber-300'],
        ];
        $brands = ['Nike', 'Adidas', 'Puma', 'H&M', 'Zara'];
        $fallbackProducts = [
            ['name' => 'Nike Oversized Tee', 'price' => 1499, 'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Gym Compression Fit', 'price' => 1899, 'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Urban Cargo Pants', 'price' => 2299, 'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=900&q=80'],
        ];
    @endphp

    <section class="relative min-h-[calc(100vh-4rem)] overflow-hidden bg-black">
        <img src="{{ $heroImage }}" alt="Streetwear model in dark outfit" class="absolute inset-0 h-full w-full object-cover opacity-70" />
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/75 to-slate-950/20"></div>
        <div class="relative mx-auto flex min-h-[calc(100vh-4rem)] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-cyan-300">Streetwear Collection 2026</p>
                <h1 class="mt-5 text-5xl font-black uppercase leading-none text-white sm:text-7xl lg:text-8xl">Drop The Ordinary</h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-slate-200 sm:text-lg">Oversized fits, fresh sneakers, gym-ready layers, and street essentials built for everyday movement.</p>
                <div class="mt-9 flex flex-wrap gap-4">
                    <a href="{{ url('/products') }}" class="btn-primary">Shop Now</a>
                    <a href="#trending" class="btn-secondary">New Arrivals</a>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-brand-dark">
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">Featured Categories</p>
                    <h2 class="mt-3 text-3xl font-black text-brand-text">Shop By Style</h2>
                </div>
                <a href="{{ url('/products') }}" class="text-sm font-semibold text-brand-cyan hover:text-white">View all products</a>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach($categories as $category)
                    <a href="{{ url('/products') }}" class="group relative min-h-64 overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                        <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/35 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-5">
                            <span class="mb-3 block h-1 w-10 rounded-full {{ $category['accent'] }}"></span>
                            <h3 class="text-xl font-black text-white">{{ $category['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="trending" class="border-y border-slate-800 bg-slate-950/60">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">Trending Products</p>
                        <h2 class="mt-3 text-3xl font-black text-brand-text">Fresh From The Database</h2>
                    </div>
                    <a href="{{ url('/products') }}" class="btn-secondary">Browse More</a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($trendingProducts as $product)
                        <article class="flex h-full flex-col overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                            <div class="aspect-[4/3] bg-slate-900">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                @else
                                    <div class="flex h-full items-center justify-center px-6 text-center text-brand-text-secondary">No image added</div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="text-lg font-black text-brand-text">{{ $product->name }}</h3>
                                <p class="mt-2 text-sm leading-6 text-brand-text-secondary">{{ Str::limit($product->description, 95) }}</p>
                                <div class="mt-auto flex items-center justify-between gap-3 pt-6">
                                    <p class="text-xl font-black text-brand-cyan">₹{{ number_format($product->price, 2) }}</p>
                                    <form action="{{ url('/cart/add/' . $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        @foreach($fallbackProducts as $product)
                            <article class="overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                                <div class="aspect-[4/3] bg-slate-900">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover" />
                                </div>
                                <div class="p-5">
                                    <h3 class="text-lg font-black text-brand-text">{{ $product['name'] }}</h3>
                                    <div class="mt-5 flex items-center justify-between gap-3">
                                        <p class="text-xl font-black text-brand-cyan">₹{{ number_format($product['price'], 2) }}</p>
                                        <a href="{{ url('/products') }}" class="btn-primary">Add to Cart</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">Popular Youth Brands</p>
            <div class="mt-6 grid gap-3 sm:grid-cols-5">
                @foreach($brands as $brand)
                    <div class="rounded-lg border border-slate-700 bg-brand-gray px-5 py-6 text-center text-xl font-black text-brand-text transition hover:border-brand-cyan hover:text-brand-cyan">
                        {{ $brand }}
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-white text-slate-950">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
                <div class="flex flex-col justify-center">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-violet-700">Fitness Collection</p>
                    <h2 class="mt-4 text-4xl font-black uppercase leading-tight">Train Hard Collection</h2>
                    <p class="mt-5 max-w-xl text-slate-600">Compression wear, joggers, tanks, and breathable gym layers made for heavy sessions and clean post-workout fits.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach(['Gym Wear', 'Compression Wear', 'Joggers', 'Tanks'] as $item)
                            <span class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-bold">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1517964603305-11c0f6f66012?auto=format&fit=crop&w=900&q=80" alt="Gym clothing and training gear" class="h-72 w-full rounded-lg object-cover sm:h-96" />
                    <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?auto=format&fit=crop&w=900&q=80" alt="Athlete training in fitness wear" class="mt-10 h-72 w-full rounded-lg object-cover sm:h-96" />
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div x-data="dropCountdown()" x-init="start()" class="rounded-lg border border-slate-700 bg-gradient-to-r from-slate-950 via-brand-gray to-slate-900 p-8 text-center shadow-2xl sm:p-12">
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Next Drop In</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-4">
                    <div class="rounded-lg border border-slate-700 bg-black/40 px-5 py-6">
                        <p class="text-4xl font-black text-white sm:text-5xl" x-text="days"></p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Days</p>
                    </div>
                    <div class="rounded-lg border border-slate-700 bg-black/40 px-5 py-6">
                        <p class="text-4xl font-black text-white sm:text-5xl" x-text="hours"></p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Hours</p>
                    </div>
                    <div class="rounded-lg border border-slate-700 bg-black/40 px-5 py-6">
                        <p class="text-4xl font-black text-white sm:text-5xl" x-text="minutes"></p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Minutes</p>
                    </div>
                    <div class="rounded-lg border border-slate-700 bg-black/40 px-5 py-6">
                        <p class="text-4xl font-black text-white sm:text-5xl" x-text="seconds"></p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Seconds</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-5 rounded-lg border border-slate-700 bg-brand-gray p-6 sm:flex-row">
                <div>
                    <h2 class="text-2xl font-black text-brand-text">Ready to step out?</h2>
                    <p class="mt-2 text-sm text-brand-text-secondary">Edit your details any time or safely log out from this home page.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}" class="btn-secondary">Edit User Details</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-red-400/70 px-5 py-2.5 font-semibold text-red-200 transition hover:bg-red-500 hover:text-white">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropCountdown', () => ({
                remaining: 0,
                total: ((2 * 24) + 11) * 60 * 60,
                interval: null,
                days: '02',
                hours: '11',
                minutes: '00',
                seconds: '00',
                start() {
                    this.remaining = this.total;
                    this.render();
                    this.interval = setInterval(() => {
                        this.remaining -= 1;

                        if (this.remaining <= 0) {
                            this.remaining = this.total;
                        }

                        this.render();
                    }, 1000);
                },
                render() {
                    const days = Math.floor(this.remaining / 86400);
                    const hours = Math.floor((this.remaining % 86400) / 3600);
                    const minutes = Math.floor((this.remaining % 3600) / 60);
                    const seconds = this.remaining % 60;

                    this.days = String(days).padStart(2, '0');
                    this.hours = String(hours).padStart(2, '0');
                    this.minutes = String(minutes).padStart(2, '0');
                    this.seconds = String(seconds).padStart(2, '0');
                },
            }));
        });
    </script>
</x-app-layout>
