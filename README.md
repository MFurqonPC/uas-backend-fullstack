# Sistem Booking Ruangan - UAS Backend Development

Aplikasi full-stack microservices untuk sistem booking ruangan dengan NestJS, Laravel, RabbitMQ, dan Docker.

## 🏗️ Arsitektur

- **User Service** (NestJS): Authentication & User Management (Port 3001)
- **Booking Service** (NestJS): Room Management & Booking (Port 3002)
- **Frontend** (Laravel): Web Interface (Port 3000)
- **RabbitMQ**: Async Event Communication (Port 5672, Management: 15672)
- **MySQL**: Database (Port 3306)

## 🚀 Cara Menjalankan

### Dengan Docker Compose (Recommended)

\`\`\`bash
docker-compose up --build
\`\`\`

Akses aplikasi:
- Frontend: http://localhost:3000
- RabbitMQ Admin: http://localhost:15672 (guest/guest)

### Manual (Tanpa Docker)

1. **Start MySQL**
2. **User Service**: `cd user-service && npm run start:dev`
3. **Booking Service**: `cd booking-service && npm run start:dev`
4. **Frontend**: `cd frontend-laravel && php artisan serve`

## 📁 Project Structure

\`\`\`
uas-backend-fullstack/
├── user-service/          (NestJS Port 3001)
├── booking-service/       (NestJS Port 3002)
├── frontend-laravel/      (Laravel Port 3000)
├── mysql-init/            (SQL initialization)
├── .github/workflows/     (CI/CD)
├── docker-compose.yml
└── README.md
\`\`\`

## 👤 Author

- Mata Kuliah: Backend Development (DT199)
- Program: D3 Teknik Informatika
- Universitas: AMIKOM Yogyakarta
