<x-admin-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-700">Profit & Loss Report</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('laporan.export') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Export Excel
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-center border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-yellow-200 to-yellow-400 text-gray-800">
                        <th rowspan="2" class="px-4 py-3 border border-gray-200 text-left">Category</th>
                        @foreach($months as $m)
                            <th class="px-4 py-3 border border-gray-200">{{ $m }}</th>
                        @endforeach
                    </tr>
                    <tr class="bg-yellow-100 text-gray-700 font-semibold">
                        @foreach($months as $m)
                            <th class="px-4 py-2 border border-gray-200">Amount</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Income -->
                    @foreach($incomeCats as $cat)
                        <tr class="hover:bg-green-50">
                            <td class="px-4 py-2 text-left font-medium text-gray-700">{{ $cat }}</td>
                            @foreach($months as $m)
                                <td class="px-4 py-2 text-right text-gray-600">
                                    Rp {{ number_format($pivot[$cat][$m] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    <!-- Total Income -->
                    <tr class="bg-green-100 font-semibold text-green-900">
                        <td class="px-4 py-2 text-left">Total Income</td>
                        @foreach($months as $m)
                            <td class="px-4 py-2 text-right">
                                Rp {{ number_format($totals['income'][$m], 0, ',', '.') }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Expense -->
                    @foreach($expenseCats as $cat)
                        <tr class="hover:bg-orange-50">
                            <td class="px-4 py-2 text-left font-medium text-gray-700">{{ $cat }}</td>
                            @foreach($months as $m)
                                <td class="px-4 py-2 text-right text-gray-600">
                                    Rp {{ number_format($pivot[$cat][$m] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    <!-- Total Expense -->
                    <tr class="bg-orange-100 font-semibold text-orange-900">
                        <td class="px-4 py-2 text-left">Total Expense</td>
                        @foreach($months as $m)
                            <td class="px-4 py-2 text-right">
                                Rp {{ number_format($totals['expense'][$m], 0, ',', '.') }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Net Income -->
                    <tr class="bg-gray-100 font-bold text-gray-800">
                        <td class="px-4 py-2 text-left">Net Income</td>
                        @foreach($months as $m)
                            <td class="px-4 py-2 text-right">
                                Rp {{ number_format($totals['net'][$m], 0, ',', '.') }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
