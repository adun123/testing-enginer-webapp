<x-admin-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-700">Laporan Laba Rugi</h1>

        <!-- Ringkasan -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Total Debit</p>
                <p class="text-xl font-bold text-blue-700">Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Total Credit</p>
                <p class="text-xl font-bold text-green-700">Rp {{ number_format($totalCredit, 0, ',', '.') }}</p>
            </div>
            <div class="bg-{{ $profit >= 0 ? 'green' : 'red' }}-100 p-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Profit / Loss</p>
                <p class="text-xl font-bold text-{{ $profit >= 0 ? 'green' : 'red' }}-700">
                    Rp {{ number_format($profit, 0, ',', '.') }}
                </p>
            </div>
        </div>
        <!-- Chart Section -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Pie Chart -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Komposisi Credit per Kategori</h2>
                <canvas id="pieChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Debit vs Credit per Kategori</h2>
                <canvas id="barChart"></canvas>
            </div>
        </div>


        <!-- Tabel detail -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Total Debit</th>
                        <th class="px-6 py-3">Total Credit</th>
                        <th class="px-6 py-3">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium">{{ $row->kategori }}</td>
                            <td class="px-6 py-3">Rp {{ number_format($row->total_debit, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">Rp {{ number_format($row->total_credit, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                Rp {{ number_format($row->total_credit - $row->total_debit, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Data dari Laravel
    const categories = @json($report->pluck('kategori'));
    const debitData = @json($report->pluck('total_debit'));
    const creditData = @json($report->pluck('total_credit'));

    // Pie Chart (Credit per Kategori)
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: categories,
            datasets: [{
                label: 'Credit',
                data: creditData,
                backgroundColor: [
                    '#60a5fa','#34d399','#f87171','#fbbf24','#a78bfa','#fb7185'
                ],
                borderWidth: 1
            }]
        }
    });

    // Bar Chart (Debit vs Credit)
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [
                {
                    label: 'Debit',
                    data: debitData,
                    backgroundColor: '#f87171'
                },
                {
                    label: 'Credit',
                    data: creditData,
                    backgroundColor: '#34d399'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</x-admin-layout>
