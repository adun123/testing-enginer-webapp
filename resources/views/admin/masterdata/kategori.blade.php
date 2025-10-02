<x-admin-layout>
    <div x-data="kategoriPage()" class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">📂 Kategori COA</h1>
            <button 
                @click="openAddModal()" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                ➕ Tambah Kategori
            </button>
        </div>

        <!-- Flash message -->
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
                        <th class="px-6 py-3">Nama Kategori</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                            <td class="px-6 py-3">{{ $item->nama }}</td>
                            <td class="px-6 py-3 text-right space-x-2">
                                <!-- Tombol Edit -->
                                <button 
                                    @click="openEditModal({{ $item->id }}, '{{ $item->nama }}')"
                                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded shadow">
                                    ✏️ Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus?')"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow">
                                        🗑 Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah/Edit -->
        <div 
            x-show="modalOpen" 
            x-cloak 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg" @click.away="modalOpen=false" x-transition>
                <h2 class="text-xl font-semibold mb-4" x-text="editMode ? '✏️ Edit Kategori' : '➕ Tambah Kategori'"></h2>
                
                <form :action="editMode ? updateUrl : storeUrl" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="mb-4">
                        <label class="block text-gray-600 mb-1">Nama Kategori</label>
                        <input type="text" name="nama" x-model="formData.nama" required
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

    <!-- Alpine.js state -->
    <script>
        function kategoriPage() {
            return {
                modalOpen: false,
                editMode: false,
                formData: { id: null, nama: '' },
                storeUrl: '{{ route('kategori.store') }}',
                updateUrl: '',

                openAddModal() {
                    this.editMode = false;
                    this.formData = { id: null, nama: '' };
                    this.modalOpen = true;
                },
                openEditModal(id, nama) {
                    this.editMode = true;
                    this.formData = { id: id, nama: nama };
                    this.updateUrl = '{{ url('kategori') }}/' + id;
                    this.modalOpen = true;
                }
            }
        }
    </script>
</x-admin-layout>
