import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { RabbitMQModule } from '@golevelup/nestjs-rabbitmq';
import { BookingService } from './booking.service';
import { BookingController } from './booking.controller';
import { Booking } from './entities/booking.entity';
import { BookingEventListener } from './booking.event-listener';

@Module({
  imports: [
    TypeOrmModule.forFeature([Booking]),
    RabbitMQModule.forRoot({
      exchanges: [
        {
          name: 'user-service-exchange',
          type: 'direct',
        },
      ],
      uri: process.env.RABBITMQ_URL || 'amqp://guest:guest@localhost:5672',
    }),
  ],
  providers: [BookingService, BookingEventListener],
  controllers: [BookingController],
})
export class BookingModule {}
