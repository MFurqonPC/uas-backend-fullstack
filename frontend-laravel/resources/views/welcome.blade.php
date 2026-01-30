<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAS Booking System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        
        .navbar { background: #333; color: white; padding: 15px; margin-bottom: 20px; }
        .navbar h1 { font-size: 24px; }
        
        .content { display: flex; gap: 20px; }
        
        .left { flex: 1; }
        .right { flex: 1; }
        
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        button:hover { background: #0056b3; }
        
        .booking-item { background: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; margin-bottom: 10px; }
        .booking-item h4 { margin-bottom: 5px; }
        .booking-item p { color: #666; font-size: 14px; }
        
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        
        .status { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; }
        .status.pending { background: #ffc107; color: white; }
        .status.confirmed { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🏨 UAS Booking System</h1>
        <p>Sistem Pemesanan Kamar Hotel</p>
    </div>

    <div class="container">
        <div class="content">
            <!-- LEFT: FORM REGISTER & BOOKING -->
            <div class="left">
                <!-- REGISTER SECTION -->
                <div class="card">
                    <h2>📝 Daftar Akun</h2>
                    <form id="registerForm">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="regEmail" required placeholder="user@example.com">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="regPassword" required placeholder="Minimal 6 karakter">
                        </div>
                        <button type="submit">Daftar</button>
                    </form>
                    <div id="registerMsg"></div>
                </div>

                <!-- BOOKING SECTION -->
                <div class="card">
                    <h2>🔑 Pesan Kamar</h2>
                    <form id="bookingForm">
                        <div class="form-group">
                            <label>No. Kamar</label>
                            <input type="number" id="roomId" required placeholder="103" value="103">
                        </div>
                        <div class="form-group">
                            <label>Check In</label>
                            <input type="date" id="checkIn" required value="2026-03-01">
                        </div>
                        <div class="form-group">
                            <label>Check Out</label>
                            <input type="date" id="checkOut" required value="2026-03-05">
                        </div>
                        <button type="submit">Pesan Sekarang</button>
                    </form>
                    <div id="bookingMsg"></div>
                </div>
            </div>

            <!-- RIGHT: BOOKING LIST -->
            <div class="right">
                <div class="card">
                    <h2>📋 Daftar Pemesanan</h2>
                    <div id="bookingList"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_USER = 'http://localhost:3001';
        const API_BOOKING = 'http://localhost:3002';

        // REGISTER
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;

            try {
                const response = await fetch(`${API_USER}/auth/register`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('registerMsg', '✅ Daftar Berhasil! User ID: ' + data.userId, 'success');
                    document.getElementById('registerForm').reset();
                } else {
                    showMessage('registerMsg', '❌ ' + data.message, 'error');
                }
            } catch (error) {
                showMessage('registerMsg', '❌ Error: ' + error.message, 'error');
            }
        });

        // BOOKING
        document.getElementById('bookingForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const roomId = parseInt(document.getElementById('roomId').value);
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;

            try {
                const response = await fetch(`${API_BOOKING}/bookings`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ roomId, checkIn, checkOut })
                });
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('bookingMsg', `✅ Pesan Berhasil! ID: ${data.id} - Rp${data.totalPrice.toLocaleString('id-ID')}`, 'success');
                    loadBookings();
                    document.getElementById('bookingForm').reset();
                } else {
                    showMessage('bookingMsg', '❌ ' + data.message, 'error');
                }
            } catch (error) {
                showMessage('bookingMsg', '❌ Error: ' + error.message, 'error');
            }
        });

        // LOAD BOOKINGS
        async function loadBookings() {
            try {
                const response = await fetch(`${API_BOOKING}/bookings`);
                const bookings = await response.json();
                
                let html = '';
                if (Array.isArray(bookings) && bookings.length > 0) {
                    bookings.forEach(b => {
                        html += `
                            <div class="booking-item">
                                <h4>Kamar ${b.roomId}</h4>
                                <p><strong>ID:</strong> ${b.id}</p>
                                <p><strong>Check In:</strong> ${b.checkIn}</p>
                                <p><strong>Check Out:</strong> ${b.checkOut}</p>
                                <p><strong>Total:</strong> Rp${b.totalPrice.toLocaleString('id-ID')}</p>
                                <span class="status ${b.status}">${b.status}</span>
                            </div>
                        `;
                    });
                } else {
                    html = '<p style="color: #999;">Belum ada pemesanan</p>';
                }
                
                document.getElementById('bookingList').innerHTML = html;
            } catch (error) {
                console.error('Error loading bookings:', error);
            }
        }

        // HELPER
        function showMessage(elementId, message, type) {
            const el = document.getElementById(elementId);
            el.className = `alert alert-${type}`;
            el.textContent = message;
            setTimeout(() => el.textContent = '', 5000);
        }

        // INITIAL LOAD
        loadBookings();
        setInterval(loadBookings, 3000);
    </script>
</body>
</html>
