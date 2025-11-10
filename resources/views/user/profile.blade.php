@extends('layouts.app')

@section('content')
<div class="container mt-5">

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-success text-white text-center rounded-top-4">
      <h4 class="mb-0">Profil Saya</h4>
    </div>

    <div class="card-body">
      {{-- Foto dan Nama --}}
      <div class="text-center mb-4">
        <img 
          src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://via.placeholder.com/120' }}" 
          class="rounded-circle border border-3 border-success shadow-sm"
          width="120" height="120" 
          alt="Foto Profil">
        <h5 class="mt-3 fw-semibold">{{ $user->name }}</h5>
      </div>

      {{-- Informasi Pengguna --}}
      <table class="table table-striped align-middle">
        <tr>
          <th width="30%">Nama Lengkap</th>
          <td>{{ $user->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $user->email ?? '-' }}</td>
        </tr>
        <tr>
          <th>No HP</th>
          <td>{{ $user->phone ?? '-' }}</td>
        </tr>
        <tr>
          <th>Alamat</th>
          <td>{{ $user->address ?? '-' }}</td>
        </tr>
        <tr>
          <th>Tanggal Lahir</th>
          <td>{{ $user->birth_date ?? '-' }}</td>
        </tr>
      </table>

      {{-- Tombol Aksi --}}
      <div class="text-end mt-4">
        <a href="{{ route('user.profile.edit') }}" class="btn btn-success rounded-3 px-4 me-2">
          <i class="bi bi-pencil-square"></i> Edit Profil
        </a>

        {{-- Tombol Hapus Akun --}}
        <form id="deleteForm" action="{{ route('user.profile.destroy') }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="button" id="deleteBtn" class="btn btn-danger rounded-3 px-4">
            <i class="bi bi-trash"></i> Hapus Akun
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- ✅ Tambahkan di akhir halaman --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Konfirmasi sebelum hapus akun --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  const deleteBtn = document.getElementById('deleteBtn');
  const deleteForm = document.getElementById('deleteForm');

  if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin hapus akun?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteForm.submit();
        }
      });
    });
  }

  // ✅ Pop-up sukses setelah update atau hapus akun
  @if (session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 2000
    });
  @endif
});
</script>
@endsection
