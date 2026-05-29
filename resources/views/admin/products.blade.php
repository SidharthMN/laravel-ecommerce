<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">Product Management</p>
                    <h1 class="mt-3 text-3xl font-black text-brand-text">Edit products, images, price, category, and stock</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Admin Dashboard</a>
                </div>
            </header>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">{{ session('success') }}</div>
            @endif

            <section class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-cyan">Add Product</p>
                    <h2 class="mt-3 text-2xl font-black text-brand-text">Create a new product from admin</h2>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <input name="name" class="input-field" placeholder="Product name" required>
                        <select name="category" class="input-field">
                            <option value="">No category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <textarea name="description" rows="4" class="input-field" placeholder="Product description" required></textarea>
                    <div class="grid gap-4 md:grid-cols-2">
                        <input name="price" type="number" step="0.01" min="0" class="input-field" placeholder="Price" required>
                        <input name="stock" type="number" min="0" class="input-field" placeholder="Stock" required>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm text-brand-text-secondary">Main image</label>
                            <input name="image" type="file" class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm text-brand-text-secondary">Extra product photos</label>
                            <input name="images[]" type="file" multiple class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                        </div>
                    </div>
                    <button class="btn-primary w-full md:w-auto">Add Product</button>
                </form>
            </section>

            <div class="grid gap-6">
                @forelse($products as $product)
                    <article class="rounded-lg border border-slate-700 bg-brand-gray p-6">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[180px_1fr]">
                            @csrf
                            @method('PATCH')

                            <div>
                                <div class="aspect-square overflow-hidden rounded-lg border border-slate-700 bg-black">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center text-brand-text-secondary">No image</div>
                                    @endif
                                </div>
                                <p class="mt-3 text-sm font-semibold {{ $product->stock <= 5 ? 'text-amber-200' : 'text-brand-text-secondary' }}">
                                    {{ $product->stock }} left {{ $product->stock <= 5 ? '- Low stock' : '' }}
                                </p>
                            </div>

                            <div class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <input name="name" value="{{ $product->name }}" class="input-field" placeholder="Product name" required>
                                    <select name="category" class="input-field">
                                        <option value="">No category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}" @selected($product->category === $category->name)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <textarea name="description" rows="3" class="input-field" required>{{ $product->description }}</textarea>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <input name="price" type="number" step="0.01" value="{{ $product->price }}" class="input-field" placeholder="Price" required>
                                    <input name="stock" type="number" min="0" value="{{ $product->stock }}" class="input-field" placeholder="Stock" required>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm text-brand-text-secondary">Replace main image</label>
                                        <input name="image" type="file" class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm text-brand-text-secondary">Add more images</label>
                                        <input name="images[]" type="file" multiple class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <button class="btn-primary">Save Product</button>
                                    <a href="{{ route('products.show', $product) }}" class="btn-secondary">View Page</a>
                                </div>
                            </div>
                        </form>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-red-400/70 px-4 py-2 text-sm font-semibold text-red-200 hover:bg-red-500 hover:text-white">Delete Product</button>
                        </form>
                    </article>
                @empty
                    <div class="rounded-lg border border-slate-700 bg-brand-gray p-10 text-center text-brand-text-secondary">No products yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
