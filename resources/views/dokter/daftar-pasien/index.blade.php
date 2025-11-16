<x-app-layout>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pasien</h2>
           
            <!-- Search Box -->
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari pasien..."
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005248] focus:border-[#005248] w-80">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full" id="patientTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">No.RM</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">No. Telepon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">Alamat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200 whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody" class="divide-y divide-gray-200">
                    <!-- Data akan dimuat oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex justify-center items-center gap-2 mt-6 flex-wrap"></div>
    </div>

    <script>
        // Data pasien (simulasi)
        let patients = [
            {
                id: 1,
                noRM: 'RM001',
                nama: 'Ahmad Wijaya',
                tanggalLahir: '1985-05-15',
                jenisKelamin: 'Laki-laki',
                telepon: '081234567890',
                email: 'ahmad.wijaya@email.com',
                alamat: 'Jl. Merdeka No. 123, Jakarta',
                golonganDarah: 'A',
                status: 'Aktif',
                alergi: 'Penisilin'
            },
            {
                id: 2,
                noRM: 'RM002',
                nama: 'Siti Nurhaliza',
                tanggalLahir: '1990-08-20',
                jenisKelamin: 'Perempuan',
                telepon: '082345678901',
                email: 'siti.nurhaliza@email.com',
                alamat: 'Jl. Sudirman No. 456, Bandung',
                golonganDarah: 'B',
                status: 'Aktif',
                alergi: ''
            },
            {
                id: 3,
                noRM: 'RM003',
                nama: 'Budi Santoso',
                tanggalLahir: '1978-12-10',
                jenisKelamin: 'Laki-laki',
                telepon: '083456789012',
                email: 'budi.santoso@email.com',
                alamat: 'Jl. Asia Afrika No. 789, Surabaya',
                golonganDarah: 'O',
                status: 'Aktif',
                alergi: 'Aspirin'
            },
            {
                id: 4,
                noRM: 'RM004',
                nama: 'Dewi Lestari',
                tanggalLahir: '1995-03-25',
                jenisKelamin: 'Perempuan',
                telepon: '084567890123',
                email: 'dewi.lestari@email.com',
                alamat: 'Jl. Gatot Subroto No. 321, Yogyakarta',
                golonganDarah: 'AB',
                status: 'Tidak Aktif',
                alergi: ''
            },
            {
                id: 5,
                noRM: 'RM005',
                nama: 'Eko Prasetyo',
                tanggalLahir: '1988-07-18',
                jenisKelamin: 'Laki-laki',
                telepon: '085678901234',
                email: 'eko.prasetyo@email.com',
                alamat: 'Jl. Diponegoro No. 654, Semarang',
                golonganDarah: 'A',
                status: 'Aktif',
                alergi: ''
            },
            {
                id: 6,
                noRM: 'RM006',
                nama: 'Rina Mulyani',
                tanggalLahir: '1992-11-30',
                jenisKelamin: 'Perempuan',
                telepon: '086789012345',
                email: 'rina.mulyani@email.com',
                alamat: 'Jl. Ahmad Yani No. 111, Malang',
                golonganDarah: 'B',
                status: 'Aktif',
                alergi: ''
            },
            {
                id: 7,
                noRM: 'RM007',
                nama: 'Joko Widodo',
                tanggalLahir: '1980-06-12',
                jenisKelamin: 'Laki-laki',
                telepon: '087890123456',
                email: 'joko.widodo@email.com',
                alamat: 'Jl. Pahlawan No. 222, Solo',
                golonganDarah: 'O',
                status: 'Aktif',
                alergi: ''
            },
            {
                id: 8,
                noRM: 'RM008',
                nama: 'Mega Sari',
                tanggalLahir: '1998-02-14',
                jenisKelamin: 'Perempuan',
                telepon: '088901234567',
                email: 'mega.sari@email.com',
                alamat: 'Jl. Kartini No. 333, Medan',
                golonganDarah: 'A',
                status: 'Aktif',
                alergi: 'Antibiotik'
            }
        ];

        let currentPage = 1;
        let itemsPerPage = 5;
        let filteredPatients = [...patients];

        // Render tabel
        function renderTable() {
            const tbody = document.getElementById('patientTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const patientsToShow = filteredPatients.slice(startIndex, endIndex);

            if (patientsToShow.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-4 py-16">
                            <div class="text-center text-gray-500">
                                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <h3 class="text-lg font-medium mb-2">Tidak ada data pasien</h3>
                                <p class="text-sm">Tidak ditemukan pasien yang sesuai dengan pencarian</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = patientsToShow.map(patient => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4 text-sm"><strong class="text-gray-900">${patient.noRM}</strong></td>
                    <td class="px-4 py-4 text-sm text-gray-700">${patient.nama}</td>
                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">${formatDate(patient.tanggalLahir)}</td>
                    <td class="px-4 py-4 text-sm text-gray-700">${patient.jenisKelamin}</td>
                    <td class="px-4 py-4 text-sm text-gray-700">${patient.telepon}</td>
                    <td class="px-4 py-4 text-sm text-gray-700">${patient.alamat}</td>
                    <td class="px-4 py-4 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap ${patient.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                            ${patient.status}
                        </span>
                    </td>
                </tr>
            `).join('');

            renderPagination();
        }

        // Render pagination
        function renderPagination() {
            const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
            const pagination = document.getElementById('pagination');
           
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let html = `
                <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm ${currentPage === 1 ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:bg-gray-50 bg-white'}">
                    ‹ Prev
                </button>
            `;

            for (let i = 1; i <= totalPages; i++) {
                html += `
                    <button onclick="changePage(${i})"
                            class="px-3 py-2 border rounded-lg text-sm transition-colors ${i === currentPage ? 'bg-[#005248] text-white border-[#005248]' : 'bg-white border-gray-300 hover:bg-gray-50'}">
                        ${i}
                    </button>
                `;
            }

            html += `
                <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:bg-gray-50 bg-white'}">
                    Next ›
                </button>
            `;

            pagination.innerHTML = html;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        // Pencarian
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filteredPatients = patients.filter(patient =>
                patient.nama.toLowerCase().includes(searchTerm) ||
                patient.noRM.toLowerCase().includes(searchTerm) ||
                patient.telepon.includes(searchTerm)
            );
            currentPage = 1;
            renderTable();
        });

        // Initialize
        renderTable();
    </script>
</x-app-layout>

