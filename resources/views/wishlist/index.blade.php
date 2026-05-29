<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Wishlist</p>
                    <h1 class="mt-3 text-3xl font-black text-brand-text">Saved favorites</h1>
                    <p class="mt-3 text-sm text-brand-text-secondary">Keep products ready, then move them to cart when it is time to checkout.</p>
                </div>
                <a href="{{ url('/products') }}" class="btn-secondary">Continue Shopping</a>
            </header>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">
                    {{ session('success') }}
                </div>
            @endif

            @if($wishlistItems->count())
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($wishlistItems as $item)
                        @php
                            $product = $item->product;
                            $averageRating = round($product->reviews->avg('rating') ?? 0, 1);
                        @endphp
                        <article class="overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                            <div class="aspect-[4/3] bg-brand-dark">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                @else
                                    <div class="flex h-full items-center justify-center text-brand-text-secondary">No image</div>
                                @endif
                            </div>
                            <div class="p-5">
                                @if($product->category)
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-cyan">{{ $product->category }}</p>
                                @endif
                                <h2 class="mt-2 text-xl font-black text-brand-text">{{ $product->name }}</h2>
                                <p class="mt-2 text-sm text-brand-text-secondary">Rating: {{ $averageRating ?: 'No rating yet' }}</p>
                                <p class="mt-4 text-xl font-black text-brand-cyan">₹{{ number_format($product->price, 2) }}</p>
                                <div class="mt-5 flex flex-wrap gap-3">
                                    <form action="{{ route('wishlist.move-to-cart', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary">Move to Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-lg border border-slate-700 bg-brand-gray p-10 text-center">
                    <h2 class="text-2xl font-black text-brand-text">No saved products yet</h2>
                    <p class="mt-3 text-brand-text-secondary">Save products from the shop page to build your wishlist.</p>
                    <a href="{{ url('/products') }}" class="btn-primary mt-6 inline-flex">Browse Products</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
