<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <section class="space-y-8">
            <div class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Product Search</p>
                        <h1 class="mt-3 text-3xl font-black text-brand-text">Find your next fit</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-brand-text-secondary">Search by product name, category, or style keywords like hoodie, gym, or oversized.</p>
                    </div>
                    <a href="{{ route('wishlist.index') }}" class="btn-secondary">View Wishlist</a>
                </div>

                <form action="{{ url('/products') }}" method="GET" class="mt-8 grid gap-4 md:grid-cols-[1fr_auto]">
                    <label for="search" class="sr-only">Search products</label>
                    <input id="search" name="search" value="{{ $search }}" type="search" class="input-field" placeholder="Search hoodie, gym, oversized..." />
                    <button type="submit" class="btn-primary">Search</button>
                </form>

                @if($search)
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="text-sm text-brand-text-secondary">Showing results for "{{ $search }}"</span>
                        <a href="{{ url('/products') }}" class="text-sm font-semibold text-brand-cyan hover:text-white">Clear search</a>
                    </div>
                @endif
            </div>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" id="products">
                @forelse($products as $product)
                    @php
                        $averageRating = round($product->reviews_avg_rating ?? 0, 1);
                        $isWishlisted = in_array($product->id, $wishlistProductIds);
                    @endphp

                    <article class="flex h-full flex-col overflow-hidden rounded-lg border border-slate-700 bg-brand-gray shadow-[0_20px_70px_rgba(15,23,42,0.35)] transition hover:border-brand-cyan hover:shadow-brand-glow-cyan">
                        <a href="{{ route('products.show', $product) }}" class="block aspect-[4/3] bg-brand-dark">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full items-center justify-center text-brand-text-secondary">No image</div>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    @if($product->category)
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-cyan">{{ $product->category }}</p>
                                    @endif
                                    <a href="{{ route('products.show', $product) }}" class="group">
                                        <h2 class="mt-2 text-xl font-black text-brand-text transition group-hover:text-brand-cyan">{{ $product->name }}</h2>
                                    </a>
                                </div>
                                <form action="{{ $isWishlisted ? route('wishlist.destroy', $product) : route('wishlist.store', $product) }}" method="POST">
                                    @csrf
                                    @if($isWishlisted)
                                        @method('DELETE')
                                    @endif
                                    <button type="submit" class="rounded-lg border border-slate-600 px-3 py-2 text-sm font-black text-white transition hover:border-red-300 hover:text-red-200" title="Wishlist">
                                        {{ $isWishlisted ? 'Saved' : 'Save' }}
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('products.show', $product) }}" class="mt-3 block text-sm leading-6 text-brand-text-secondary transition hover:text-brand-text">{{ Str::limit($product->description, 110) }}</a>

                            <div class="mt-4 flex items-center gap-2 text-sm">
                                <span class="font-black text-amber-300">{{ str_repeat('★', (int) round($averageRating)) }}{{ str_repeat('☆', 5 - (int) round($averageRating)) }}</span>
                                <span class="text-brand-text-secondary">{{ $averageRating ?: 'No' }} rating</span>
                                <span class="text-brand-text-secondary">({{ $product->reviews_count }})</span>
                            </div>

                            <div class="mt-4 rounded-lg border border-slate-700 bg-black/45 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Reviews</p>
                                    <span class="text-xs font-semibold text-brand-cyan">{{ $product->reviews_count }} total</span>
                                </div>

                                @if($product->reviews->count())
                                    <div class="mt-3 space-y-3">
                                        @foreach($product->reviews->take(3) as $review)
                                            <div class="border-t border-slate-800 pt-3 first:border-t-0 first:pt-0">
                                                <div class="flex items-center justify-between gap-3">
                                                    <p class="text-sm font-semibold text-brand-text">{{ $review->user->name }}</p>
                                                    <p class="text-xs font-black text-amber-300">{{ $review->rating }}/5</p>
                                                </div>
                                                @if($review->comment)
                                                    <p class="mt-1 text-sm leading-5 text-brand-text-secondary">{{ $review->comment }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-sm text-brand-text-secondary">No reviews yet. Be the first to review this product.</p>
                                @endif
                            </div>

                            <div class="mt-auto space-y-5 pt-6">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-xl font-black text-brand-cyan">₹{{ number_format($product->price, 2) }}</p>
                                        <p class="text-xs text-brand-text-secondary">Stock: {{ $product->stock }}</p>
                                    </div>
                                    <form action="{{ url('/cart/add/' . $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary">Add to Cart</button>
                                    </form>
                                </div>

                                <form action="{{ route('reviews.store', $product) }}" method="POST" class="rounded-lg border border-slate-700 bg-slate-950/40 p-4">
                                    @csrf
                                    <div class="grid gap-3 sm:grid-cols-[120px_1fr]">
                                        <div>
                                            <label for="rating-{{ $product->id }}" class="mb-2 block text-xs font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Rating</label>
                                            <select id="rating-{{ $product->id }}" name="rating" class="input-field py-2 text-sm">
                                                @for($rating = 5; $rating >= 1; $rating--)
                                                    <option value="{{ $rating }}">{{ $rating }} star</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div>
                                            <label for="comment-{{ $product->id }}" class="mb-2 block text-xs font-bold uppercase tracking-[0.16em] text-brand-text-secondary">Comment</label>
                                            <input id="comment-{{ $product->id }}" name="comment" type="text" class="input-field py-2 text-sm" placeholder="Share a quick review">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-secondary mt-3 w-full">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg border border-slate-700 bg-brand-gray p-10 text-center sm:col-span-2 lg:col-span-3">
                        <h2 class="text-2xl font-black text-brand-text">No products found</h2>
                        <p class="mt-3 text-brand-text-secondary">Try another search or add new products.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
