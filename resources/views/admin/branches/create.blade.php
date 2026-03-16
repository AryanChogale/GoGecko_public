<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('admin.branches.index') }}"
                   class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                    ← Back to Branches
                </a>
                <h1 class="text-2xl font-bold text-[#076807]">Add Branch</h1>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.branches.store') }}">
                @csrf

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Branch Info --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Branch Info</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Branch Name <span class="text-red-500">*</span>
                                        <span class="text-xs text-gray-400 font-normal">(State name)</span>
                                    </label>
                                    <input type="text" name="name"
                                           value="{{ old('name') }}" required
                                           placeholder="e.g. Maharashtra"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                            <input type="text" name="city" id="city" required
                                                   value="{{ old('city') }}"
                                                   placeholder="e.g. Mumbai"
                                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="e.g. +91 98765 43210"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea name="address" rows="2"
                                              placeholder="Full branch address..."
                                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Login Credentials --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Login Credentials</h2>
                            <p class="text-xs text-gray-400 mb-4">These will be used by the branch staff to log in.</p>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email"
                                           value="{{ old('email') }}" required
                                           placeholder="branch@example.com"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="password" required
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="password_confirmation" required
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Info card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Note</h2>
                            <div class="space-y-3 text-xs text-gray-500 leading-relaxed">
                                <p>🗺️ The city will be automatically geocoded to get coordinates for order routing.</p>
                                <p>📦 Orders from customers in this state will be assigned to the nearest branch by distance.</p>
                                <p>🔑 A login account will be created for the branch using the email and password provided.</p>
                            </div>
                        </div>

                        {{-- Save card --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">Branch will be geocoded automatically on save</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Create Branch
                            </button>
                            <a href="{{ route('admin.branches.index') }}"
                               class="block text-green-300 hover:text-white text-xs mt-3 transition">
                                Cancel
                            </a>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
