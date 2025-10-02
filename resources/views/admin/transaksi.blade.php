<x-admin-layout>
    <div x-data="transaksiPage()" class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Transaksi</h1>
            <button 
                @click="openAddModal()" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                Tambah Transaksi
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Akun</th>
                        <th class="px-6 py-3">Debit</th>
                        <th class="px-6 py-3">Credit</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                            <td class="px-6 py-3">{{ $item->tanggal }}</td>
                            <td class="px-6 py-3">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-3">{{ $item->chartOfAccount->nama ?? '-' }}</td>
                            <td class="px-6 py-3">{{ number_format($item->debit, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">{{ number_format($item->credit, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right space-x-2">
                                <button 
                                    @click="openEditModal({{ $item->id }}, '{{ $item->tanggal }}', '{{ $item->deskripsi }}', {{ $item->coa_id }}, '{{ $item->debit }}', '{{ $item->credit }}')"
                                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded shadow">
                                    Edit
                                </button>
                                <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus?')"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div 
            x-show="modalOpen" 
            x-cloak 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg" @click.away="modalOpen=false" x-transition>
                <h2 class="text-xl font-semibold mb-4" x-text="editMode ? 'Edit Transaksi' : 'Tambah Transaksi'"></h2>
                
                <form :action="editMode ? updateUrl : storeUrl" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" x-model="formData.tanggal" required
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" x-model="formData.deskripsi" required
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Akun</label>
                        <select name="coa_id" x-model="formData.coa_id" required
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="">-- Pilih Akun --</option>
                            @foreach($coa as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Debit</label>
                        <input type="number" name="debit" x-model="formData.debit"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Credit</label>
                        <input type="number" name="credit" x-model="formData.credit"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="modalOpen=false"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function transaksiPage() {
            return {
                modalOpen: false,
                editMode: false,
                formData: { id:null, tanggal:'', deskripsi:'', coa_id:'', debit:0, credit:0 },
                storeUrl: '{{ route('transaksi.store') }}',
                updateUrl: '',

                openAddModal() {
                    this.editMode = false;
                    this.formData = { id:null, tanggal:'', deskripsi:'', coa_id:'', debit:0, credit:0 };
                    this.modalOpen = true;
                },
                openEditModal(id, tanggal, deskripsi, coa_id, debit, credit) {
                    this.editMode = true;
                    this.formData = { id:id, tanggal:tanggal, deskripsi:deskripsi, coa_id:coa_id, debit:debit, credit:credit };
                    this.updateUrl = '{{ url('transaksis') }}/' + id;
                    this.modalOpen = true;
                }
            }
        }
    </script>
</x-admin-layout>
