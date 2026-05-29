<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-brand-cyan">User Management</p>
                    <h1 class="mt-3 text-3xl font-black text-brand-text">Ban users, promote admins, remove fake accounts</h1>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Admin Dashboard</a>
            </header>

            @if(session('success'))
                <div class="rounded-lg border border-brand-cyan/50 bg-brand-cyan/10 px-5 py-4 text-sm font-semibold text-brand-cyan">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg border border-slate-700 bg-brand-gray">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-black">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">User</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Role</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Status</th>
                                <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.16em] text-brand-text-secondary">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-brand-text">{{ $user->name }}</p>
                                        <p class="text-sm text-brand-text-secondary">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-brand-text-secondary">{{ $user->is_admin ? 'Admin' : 'Customer' }}</td>
                                    <td class="px-5 py-4 text-sm {{ $user->is_banned ? 'text-red-200' : 'text-emerald-300' }}">{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-3">
                                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex flex-wrap items-center gap-3">
                                                @csrf
                                                @method('PATCH')
                                                <label class="flex items-center gap-2 text-sm text-brand-text-secondary">
                                                    <input type="checkbox" name="is_admin" value="1" @checked($user->is_admin)> Admin
                                                </label>
                                                <label class="flex items-center gap-2 text-sm text-brand-text-secondary">
                                                    <input type="checkbox" name="is_banned" value="1" @checked($user->is_banned)> Banned
                                                </label>
                                                <button class="btn-secondary">Save</button>
                                            </form>
                                            @unless(auth()->id() === $user->id)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="rounded-lg border border-red-400/70 px-4 py-2 text-sm font-semibold text-red-200 hover:bg-red-500 hover:text-white">Remove</button>
                                                </form>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
