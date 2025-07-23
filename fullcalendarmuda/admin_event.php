<?php
session_start();
// Baris ini diubah untuk menggunakan koneksi utama dan gaya procedural
require_once "../connect.php"; 

// Jika pengguna belum login, arahkan ke halaman login
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// ----------------- PROSES CRUD ------------------ //
if(isset($_POST['save_event'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $start = $_POST['start'];
    // Jadikan NULL jika kosong
    $end = !empty($_POST['end']) ? $_POST['end'] : null; 
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    if (empty($id)) { // Tambah Baru
        $stmt = mysqli_prepare($connect, "INSERT INTO events (title, start, end, description, category_id) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssi", $title, $start, $end, $description, $category_id);
        $message = "Kegiatan berhasil ditambahkan!";
    } else { // Edit
        $stmt = mysqli_prepare($connect, "UPDATE events SET title=?, start=?, end=?, description=?, category_id=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssii", $title, $start, $end, $description, $category_id, $id);
        $message = "Kegiatan berhasil diperbarui!";
    }
    mysqli_stmt_execute($stmt);
    header("Location: admin_event.php?success=" . urlencode($message));
    exit;
}

if(isset($_GET['delete'])) {
    $stmt = mysqli_prepare($connect, "DELETE FROM events WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['delete']);
    mysqli_stmt_execute($stmt);
    $message = "Kegiatan berhasil dihapus!";
    header("Location: admin_event.php?success=" . urlencode($message));
    exit;
}

// ----------------- Notifikasi ------------------ //
$msg = "";
if (isset($_GET['success'])) {
    $msg = $_GET['success'];
}

// ----------------- Ambil Data ------------------ //
$events = mysqli_query($connect, "SELECT e.*, c.name as category_name FROM events e LEFT JOIN categories c ON e.category_id = c.id ORDER BY e.start DESC");
$categories = mysqli_query($connect, "SELECT * FROM categories ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Event Kepemudaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .form-label { font-weight: 600; font-size: 0.9rem; }
    </style>
</head>
<body>

<?php if($msg): ?>
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"><?= htmlspecialchars($msg) ?></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>


<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar vh-100 p-4 text-white">
            <h3><i class="bi bi-grid-1x2"></i> Admin</h3>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item"><a href="#" class="nav-link active text-white"><i class="bi bi-calendar-event"></i> Kelola Event</a></li>
              <li><a href="logout.php" class="nav-link text-white"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            <h2 class="mb-4">Kelola Kegiatan Kepemudaan</h2>

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="my-0" id="form-title">Tambah Kegiatan Baru</h5>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Judul Kegiatan</label>
                                <input type="text" name="title" class="form-control" required id="edit-title">
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" id="edit-category" required>
                                    <option value="">Pilih Kategori...</option>
                                    <?php mysqli_data_seek($categories, 0); while($cat = mysqli_fetch_assoc($categories)): ?>
                                      <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="start" class="form-label">Waktu Mulai</label>
                                <input type="datetime-local" name="start" class="form-control" required id="edit-start">
                            </div>
                            <div class="col-md-6">
                                <label for="end" class="form-label">Waktu Selesai (Opsional)</label>
                                <input type="datetime-local" name="end" class="form-control" id="edit-end">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" id="edit-desc" rows="3"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" id="cancel-edit-btn" style="display:none;">Batal Edit</button>
                            <button type="submit" name="save_event" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header"><h5 class="my-0">Daftar Event</h5></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th><th>Kategori</th><th>Mulai</th><th>Selesai</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($events)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['category_name']) ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['start'])) ?></td>
                                <td><?= $row['end'] ? date('d M Y, H:i', strtotime($row['end'])) : '-' ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-event='<?= json_encode($row) ?>'><i class="bi bi-pencil"></i></button>
                                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus event ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const formTitle = document.getElementById('form-title');
    const editId = document.getElementById('edit-id');
    const editTitle = document.getElementById('edit-title');
    const editCategory = document.getElementById('edit-category');
    const editStart = document.getElementById('edit-start');
    const editEnd = document.getElementById('edit-end');
    const editDesc = document.getElementById('edit-desc');
    const cancelBtn = document.getElementById('cancel-edit-btn');

    // Fungsi untuk mengisi form saat tombol edit di klik
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const eventData = JSON.parse(this.dataset.event);
            formTitle.innerText = 'Edit Kegiatan';
            editId.value = eventData.id;
            editTitle.value = eventData.title;
            editCategory.value = eventData.category_id;
            // Format tanggal untuk input datetime-local
            editStart.value = eventData.start.replace(' ', 'T');
            editEnd.value = eventData.end ? eventData.end.replace(' ', 'T') : '';
            editDesc.value = eventData.description;
            cancelBtn.style.display = 'inline-block';
            window.scrollTo(0, 0); // Gulir ke atas
        });
    });

    // Fungsi untuk mereset form saat tombol batal di klik
    cancelBtn.addEventListener('click', function() {
        formTitle.innerText = 'Tambah Kegiatan Baru';
        editId.value = '';
        form.reset();
        this.style.display = 'none';
    });
});
</script>
</body>
</html>