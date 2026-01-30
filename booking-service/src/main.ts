import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);
  
  // ✅ FIX CORS UAS
  app.enableCors({
    origin: ['http://127.0.0.1:8000', 'http://localhost:8000', '*'],
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE,OPTIONS',
    credentials: true,
    allowedHeaders: ['Content-Type', 'Authorization'],
  });

  const port = process.env.PORT || 3002;
  await app.listen(port);
  console.log(`🚀 Booking Service running on http://localhost:${port}`);
}
bootstrap();
