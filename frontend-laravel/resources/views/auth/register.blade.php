@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="mb-0">📝 Daftar Akun Baru</h4>
            </div>
            <div class="card-body">
                <form id="registerForm">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="regEmail" placeholder="user@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="regPassword" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="regPasswordConfirm" placeholder="••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>

                <div class="text-center mt-3">
                    <p>Sudah punya akun? <a href="/login" class="text-decoration-none">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('regEmail').value;
        const password = document.getElementById('regPassword').value;
        const passwordConfirm = document.getElementById('regPasswordConfirm').value;

        if (password !== passwordConfirm) {
            showAlert('❌ Password tidak cocok!', 'danger');
            return;
        }

        try {
            const response = await axios.post('http://localhost:3001/auth/register', { email, password });
            showAlert('✅ Daftar Berhasil! Silakan login', 'success');
            setTimeout(() => window.location.href = '/login', 1500);
        } catch (error) {
            showAlert('❌ Daftar Gagal: ' + (error.response?.data?.message || error.message), 'danger');
        }
    });
</script>
@endsection
