<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="card p-8">
            <div class="mb-8">
                <p class="text-sm uppercase tracking-[0.24em] text-brand-text-secondary">New product</p>
                <h1 class="mt-3 text-3xl font-semibold text-brand-text">Add a product to your store</h1>
                <p class="mt-3 text-brand-text-secondary">Create new items and keep your storefront fresh.</p>
            </div>

            <form action="{{ url('/products') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="name">Product Name</label>
                    <input id="name" type="text" name="name" class="input-field" placeholder="Example product" required>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="description">Description</label>
                    <textarea id="description" name="description" rows="5" class="input-field" placeholder="Describe the product..." required></textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="category">Category</label>
                    <input id="category" type="text" name="category" class="input-field" placeholder="hoodie, gym, oversized">
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="price">Price</label>
                        <input id="price" type="number" step="0.01" name="price" class="input-field" placeholder="₹0.00" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="stock">Stock</label>
                        <input id="stock" type="number" name="stock" class="input-field" placeholder="10" required>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="image">Product Image</label>
                    <input id="image" type="file" name="image" class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-brand-text-secondary" for="images">More Product Photos</label>
                    <input id="images" type="file" name="images[]" class="w-full rounded-lg border border-slate-700 bg-black px-3 py-2 text-brand-text-secondary" accept="image/*" multiple>
                    <p class="mt-2 text-xs text-brand-text-secondary">Upload extra angles, close-ups, or fit photos for the product detail gallery.</p>
                </div>

                <button type="submit" class="btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</x-app-layout>
