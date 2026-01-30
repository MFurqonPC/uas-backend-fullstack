import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { ConfigModule } from '@nestjs/config';
import { RabbitMQModule } from '@golevelup/nestjs-rabbitmq';
import { BookingModule } from './booking/booking.module';
import { Booking } from './booking/entities/booking.entity';

@Module({
  imports: [
    ConfigModule.forRoot(),
    TypeOrmModule.forRoot({
      type: 'mysql',
      host: process.env.DB_HOST || '127.0.0.1',
      port: 3306,
      username: process.env.DB_USERNAME || 'root',
      password: process.env.DB_PASSWORD || '',
      database: process.env.DB_DATABASE || 'booking_service',
      entities: [Booking],
      synchronize: true,
    }),
    RabbitMQModule.forRoot({
      exchanges: [
        {
          name: 'user-service-exchange',
          type: 'direct',
        },
      ],
      uri: process.env.RABBITMQ_URL || 'amqp://guest:guest@localhost:5672',
    }),
    BookingModule,
  ],
})
export class AppModule {}
