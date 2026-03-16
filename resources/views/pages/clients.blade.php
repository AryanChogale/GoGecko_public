<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-16">
        <div class="max-w-6xl mx-auto px-6">

            <h1 class="text-3xl font-bold text-center text-gray-600 mb-12">Clients</h1>

            @php
                $clients = [
                    1  => 'Crowne Plaza',
                    2  => 'Old Rao',
                    3  => 'Massive',
                    4  => 'Housing',
                    5  => 'The Burger Club',
                    6  => 'Enviro',
                    7  => 'Hyatt Centric',
                    8  => 'Hyatt Regency',
                    9  => 'Fortune',
                    10 => 'Aloft',
                    11 => 'ITC',
                    12 => 'Emaar',
                    13 => 'Toyota',
                    14 => 'Meridien',
                    15 => 'Leela',
                    16 => 'Hyundai',
                    17 => 'Westin',
                    18 => 'Vivanta',
                    19 => 'WNS',
                ];
            @endphp

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-8">
                @foreach ($clients as $num => $name)
                    <div class="flex flex-col items-center gap-3">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 w-full flex items-center justify-center h-24 hover:shadow-md transition">
                            <img src="{{ asset('storage/clients/' . $num . '.jpg') }}"
                                 alt="{{ $name }}"
                                 class="max-h-16 max-w-full object-contain">
                        </div>
                        <p class="text-xs text-gray-600 text-center font-medium">{{ $name }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</x-app-layout>
