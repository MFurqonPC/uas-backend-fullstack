@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="mb-0">🔑 Login Akun</h4>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="loginEmail" placeholder="user@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <p>Belum punya akun? <a href="/register" class="text-decoration-none">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;

        try {
            const response = await axios.post('http://localhost:3001/auth/login', { email, password });
            
            if (response.data.access_token) {
                // Simpan token ke localStorage
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('userId', response.data.userId);
                localStorage.setItem('email', response.data.email);
                
                showAlert('✅ Login Berhasil!', 'success');
                setTimeout(() => window.location.href = '/dashboard', 1500);
            }
        } catch (error) {
            showAlert('❌ Login Gagal: ' + (error.response?.data?.message || error.message), 'danger');
        }
    });
</script>
@endsection
