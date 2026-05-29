<x-app-layout>
    @php
        $gallery = collect();

        if ($product->image) {
            $gallery->push($product->image);
        }

        foreach ($product->images as $image) {
            $gallery->push($image->image);
        }

        $averageRating = round($product->reviews_avg_rating ?? 0, 1);
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ url('/products') }}" class="text-sm font-semibold text-brand-cyan hover:text-white">Back to products</a>
            <a href="{{ route('wishlist.index') }}" class="btn-secondary">View Wishlist</a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">
                {{ session('success') }}
            </div>
        @endif

        <section class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-4">
                <div x-data="{ active: '{{ $gallery->first() }}' }" class="space-y-4">
                    <div class="aspect-[4/3] overflow-hidden rounded-lg border border-slate-700 bg-black">
                        @if($gallery->count())
                            <img :src="'{{ asset('storage') }}/' + active" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                        @else
                            <div class="flex h-full items-center justify-center text-brand-text-secondary">No product photos</div>
                        @endif
                    </div>

                    @if($gallery->count() > 1)
                        <div class="grid grid-cols-4 gap-3 sm:grid-cols-5">
                            @foreach($gallery as $image)
                                <button type="button" @click="active = '{{ $image }}'" class="aspect-square overflow-hidden rounded-lg border border-slate-700 bg-black transition hover:border-brand-cyan">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }} photo {{ $loop->iteration }}" class="h-full w-full object-cover" />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                @if($product->category)
                    <p class="text-sm font-bold uppercase tracking-[0.22em] text-brand-cyan">{{ $product->category }}</p>
                @endif

                <h1 class="mt-3 text-4xl font-black text-brand-text">{{ $product->name }}</h1>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                    <span class="font-black text-amber-300">{{ str_repeat('★', (int) round($averageRating)) }}{{ str_repeat('☆', 5 - (int) round($averageRating)) }}</span>
                    <span class="text-brand-text-secondary">{{ $averageRating ?: 'No' }} rating</span>
                    <span class="text-brand-text-secondary">{{ $product->reviews_count }} reviews</span>
                </div>

                <p class="mt-6 text-3xl font-black text-brand-cyan">₹{{ number_format($product->price, 2) }}</p>
                <p class="mt-2 text-sm font-semibold text-brand-text-secondary">Available stock: {{ $product->stock }}</p>

                <div class="mt-6 rounded-lg border border-slate-700 bg-black/45 p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-text-secondary">Description</p>
                    <p class="mt-3 leading-7 text-brand-text">{{ $product->description }}</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <form action="{{ url('/cart/add/' . $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary">Add to Cart</button>
                    </form>

                    <form action="{{ $isWishlisted ? route('wishlist.destroy', $product) : route('wishlist.store', $product) }}" method="POST">
                        @csrf
                        @if($isWishlisted)
                            @method('DELETE')
                        @endif
                        <button type="submit" class="btn-secondary">{{ $isWishlisted ? 'Remove Wishlist' : 'Save Wishlist' }}</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="mt-8 grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <form action="{{ route('reviews.store', $product) }}" method="POST" class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                @csrf
                <p class="text-sm font-bold uppercase tracking-[0.22em] text-brand-cyan">Write Review</p>
                <h2 class="mt-3 text-2xl font-black text-brand-text">Rate this product</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <label for="rating" class="mb-2 block text-sm font-semibold text-brand-text-secondary">Rating</label>
                        <select id="rating" name="rating" class="input-field">
                            @for($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}">{{ $rating }} star</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="comment" class="mb-2 block text-sm font-semibold text-brand-text-secondary">Comment</label>
                        <textarea id="comment" name="comment" rows="5" class="input-field" placeholder="Share what you liked, fit notes, quality, or comfort."></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Submit Review</button>
                </div>
            </form>

            <div class="rounded-lg border border-slate-700 bg-brand-gray p-6 sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-brand-cyan">Customer Reviews</p>
                        <h2 class="mt-3 text-2xl font-black text-brand-text">What people say</h2>
                    </div>
                    <span class="text-sm font-semibold text-brand-text-secondary">{{ $product->reviews_count }} total</span>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse($product->reviews as $review)
                        <article class="rounded-lg border border-slate-700 bg-black/45 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-brand-text">{{ $review->user->name }}</p>
                                <p class="text-sm font-black text-amber-300">{{ $review->rating }}/5</p>
                            </div>
                            @if($review->comment)
                                <p class="mt-2 leading-6 text-brand-text-secondary">{{ $review->comment }}</p>
                            @endif
                            <p class="mt-3 text-xs text-brand-text-secondary">{{ $review->created_at->format('M d, Y') }}</p>
                        </article>
                    @empty
                        <p class="rounded-lg border border-slate-700 bg-black/45 p-5 text-brand-text-secondary">No reviews yet. Be the first to review this product.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
