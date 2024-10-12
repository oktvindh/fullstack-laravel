<!-- resources/views/admin/buku.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h2 class="text-center">Daftar Buku</h2>
        <button id="addBukuBtn" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#bukuModal">Tambah Buku</button>
        <!-- Modal untuk tambah/edit buku -->
           
                   <div class="container card mb-5 pt-3 pb-3">
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
                    <div class="container">
                        <table class="table mt-3 mb-5">
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
                        <button onclick="editBuku('${buku.id}')" class="btn btn-warning mb-2">Edit</button>
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
        const poster = document.getElementById('poster').files[0]; 
        const kategori_id = document.getElementById('kategori_id').value; 

        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/v1/buku/${id}` : '/api/v1/buku';

        const formData = new FormData();
        formData.append('title', title);
        formData.append('deskripsi', deskripsi);
        formData.append('tahun', tahun);
        formData.append('kategori_id', kategori_id); 
        if (poster) {
            formData.append('poster', poster); 
        }

        const response = await fetch(url, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`, 
                },
                body: formData, 

            if (response.ok) {
                fetchBuku();
                document.getElementById('bukuForm').reset();
                $('#bukuModal').modal('hide');
            } else {
                const errorData = await response.json(); 
                alert(`Gagal menyimpan buku: ${errorData.messege}`);
            }
        });
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
