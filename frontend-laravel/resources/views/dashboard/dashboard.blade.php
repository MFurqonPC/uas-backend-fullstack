@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">🔑 Pesan Kamar</h4>
            </div>
            <div class="card-body">
                <form id="bookingForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. Kamar</label>
                                <input type="number" class="form-control" id="roomId" placeholder="103" value="103" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Kamar</label>
                                <select class="form-control" id="roomType">
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Suite">Suite</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Check In</label>
                                <input type="date" class="form-control" id="checkIn" value="2026-03-01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Check Out</label>
                                <input type="date" class="form-control" id="checkOut" value="2026-03-05" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">👤 Profil Anda</h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <span id="userEmail">-</span></p>
                <p><strong>User ID:</strong> <span id="userIdDisplay">-</span></p>
                <button class="btn btn-danger w-100" onclick="logout()">Logout</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">📋 Daftar Pemesanan Anda</h4>
            </div>
            <div class="card-body" id="bookingList">
                <p class="text-muted">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Check login
    window.addEventListener('load', () => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }
        const API_USER = 'http://localhost:3001';
        const API_BOOKING = 'http://localhost:3002';
        
        document.getElementById('userEmail').textContent = localStorage.getItem('email');
        document.getElementById('userIdDisplay').textContent = localStorage.getItem('userId');
        document.getElementById('userInfo').textContent = localStorage.getItem('email');
        
        loadBookings();
    });

    // BOOKING FORM
    document.getElementById('bookingForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const roomId = parseInt(document.getElementById('roomId').value);
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;

        try {
            const response = await axios.post('http://localhost:3002/bookings', 
                { roomId, checkIn, checkOut },
                { headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` } }
            );
            
            showAlert(`✅ Pesan Berhasil! ID: ${response.data.id} - Rp${response.data.totalPrice.toLocaleString('id-ID')}`, 'success');
            loadBookings();
            document.getElementById('bookingForm').reset();
        } catch (error) {
            showAlert('❌ ' + (error.response?.data?.message || error.message), 'danger');
        }
    });

    // LOAD BOOKINGS
    async function loadBookings() {
        try {
            const response = await axios.get('http://localhost:3002/bookings',
                { headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` } }
            );
            
            let html = '';
            if (response.data && response.data.length > 0) {
                response.data.forEach(b => {
                    html += `
                        <div class="card booking-card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>Kamar ${b.roomId}</h5>
                                        <p class="mb-1"><small><strong>Check In:</strong> ${b.checkIn}</small></p>
                                        <p class="mb-1"><small><strong>Check Out:</strong> ${b.checkOut}</small></p>
                                        <p class="mb-0"><small><strong>Total:</strong> Rp${b.totalPrice.toLocaleString('id-ID')}</small></p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-${b.status === 'pending' ? 'warning' : 'success'}">${b.status}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = '<p class="text-muted text-center">Belum ada pemesanan</p>';
            }
            
            document.getElementById('bookingList').innerHTML = html;
        } catch (error) {
            console.error('Error loading bookings:', error);
        }
    }

    function logout() {
        localStorage.clear();
        window.location.href = '/login';
    }
</script>
@endsection
