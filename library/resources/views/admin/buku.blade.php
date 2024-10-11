<!-- resources/views/admin/buku.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Buku</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h2 class="text-center">Daftar Buku</h2>
        <button id="addBukuBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bukuModal">Tambah Buku</button>
        <!-- Modal untuk tambah/edit buku -->
    <div class="modal fade" id="bukuModal" tabindex="-1" aria-labelledby="bukuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bukuModalLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bukuForm">
                        <input type="hidden" id="bukuId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" required></textarea>
                        </div>
               <div class="mb-3">
    <label for="poster" class="form-label">Poster</label>
    <input type="file" class="form-control" id="poster" accept="image/*">
</div>


                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" >
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">kategori_id</label>
                            <input type="text" class="form-control" id="kategori_id" >
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBukuBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Poster</th>
                    <th>Tahun</th>
                    <th>kategori_id</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="bukuList"></tbody>
        </table>
    </div>

    

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const token = localStorage.getItem('token');

        async function fetchBuku() {
            const response = await fetch('/api/v1/buku', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });
            const data = await response.json();
            const bukuList = document.getElementById('bukuList');
            bukuList.innerHTML = '';

            data.data.forEach(buku => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${buku.id}</td>
                    <td>${buku.title}</td>
                    <td>${buku.deskripsi}</td>
                    <td><img src="${buku.poster}" alt="Poster" width="50"></td>
                    <td>${buku.tahun}</td>
                    <td>${buku.kategori_id}</td>
                    <td>
                        <button onclick="editBuku('${buku.id}')" class="btn btn-warning">Edit</button>
                        <button onclick="deleteBuku('${buku.id}')" class="btn btn-danger">Hapus</button>
                    </td>
                `;
                bukuList.appendChild(row);
            });
        }

      async function saveBuku(event) {
    event.preventDefault();
    
    const id = document.getElementById('bukuId').value;
    const title = document.getElementById('title').value;
    const deskripsi = document.getElementById('deskripsi').value;
    const tahun = document.getElementById('tahun').value;
    const poster = document.getElementById('poster').files[0]; // Mengambil file poster
    const kategori_id = document.getElementById('kategori_id').value; // Mendapatkan nilai kategori

    const method = id ? 'PUT' : 'POST';
    const url = id ? `/api/v1/buku/${id}` : '/api/v1/buku';

    const formData = new FormData();
    formData.append('title', title);
    formData.append('deskripsi', deskripsi);
    formData.append('tahun', tahun);
    formData.append('kategori_id', kategori_id); // Menambahkan kategori_id ke FormData
    if (poster) {
        formData.append('poster', poster); // Menambahkan file ke FormData
    }

    const response = await fetch(url, {
        method: method,
        headers: {
            'Authorization': `Bearer ${token}`, // Hapus Content-Type, biarkan browser yang menanganinya
        },
        body: formData, // Menggunakan FormData
    });

    if (response.ok) {
        fetchBuku();
        document.getElementById('bukuForm').reset();
        $('#bukuModal').modal('hide');
    } else {
        const errorData = await response.json(); // Menangkap error response
        alert(`Gagal menyimpan buku: ${errorData.messege}`);
    }
}



       async function editBuku(id) {
    const response = await fetch(`/api/v1/buku/${id}`, {
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    });

    const buku = await response.json();
    document.getElementById('bukuId').value = buku.data.id;
    document.getElementById('title').value = buku.data.title;
    document.getElementById('deskripsi').value = buku.data.deskripsi;
    document.getElementById('tahun').value = buku.data.tahun;
    document.getElementById('kategori_id').value = buku.data.kategori_id;
    document.getElementById('poster').value = '';

    document.getElementById('bukuModalLabel').innerText = 'Edit Buku';
    $('#bukuModal').modal('show');
}


        async function deleteBuku(id) {
            if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
                const response = await fetch(`/api/v1/buku/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                });
                if (response.ok) {
                    fetchBuku();
                } else {
                    alert('Gagal menghapus buku');
                }
            }
        }

        document.getElementById('addBukuBtn').onclick = () => {
            document.getElementById('bukuId').value = '';
            document.getElementById('bukuForm').reset();
            document.getElementById('bukuModalLabel').innerText = 'Tambah Buku';
        };

        document.getElementById('bukuForm').onsubmit = saveBuku;

        // Load data saat halaman dimuat
        fetchBuku();
    </script>
</body>
</html>
