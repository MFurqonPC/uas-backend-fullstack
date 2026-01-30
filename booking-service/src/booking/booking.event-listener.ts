import { Injectable, Logger } from '@nestjs/common';
import { RabbitSubscribe } from '@golevelup/nestjs-rabbitmq';

@Injectable()
export class BookingEventListener {
  private logger = new Logger('BookingEventListener');

  @RabbitSubscribe({
    exchange: 'user-service-exchange',
    routingKey: 'user.created',
    queue: 'booking-service-queue',
  })
  async handleUserCreated(msg: { userId: number; email: string; timestamp: string }) {
    this.logger.log(`📥 Received user.created event: ${JSON.stringify(msg)}`);
    console.log(`✅ Event received in Booking Service:`);
    console.log(`   - User ID: ${msg.userId}`);
    console.log(`   - Email: ${msg.email}`);
    console.log(`   - Timestamp: ${msg.timestamp}`);
    
    // Simpan ke log atau database jika perlu
  }
}
