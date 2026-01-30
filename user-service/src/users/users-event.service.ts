import { Injectable, OnModuleInit } from '@nestjs/common';
import { ClientProxyFactory, Transport } from '@nestjs/microservices';
import { ConfigService } from '@nestjs/config';

@Injectable()
export class UsersEventService implements OnModuleInit {
  private bookingClient: any;

  constructor(private configService: ConfigService) {}

  onModuleInit() {
    this.bookingClient = ClientProxyFactory.create({
      transport: Transport.RMQ,
      options: {
        urls: [this.configService.get('RABBITMQ_URL')],
        queue: 'user_events',
        queueOptions: {
          durable: false,
        },
      },
    });
  }

  // Emit event ke booking-service
  async userCreated(userId: number, email: string) {
    return this.bookingClient.emit('user.created', {
      userId,
      email,
    });
  }
}
