import { RabbitMQModule } from '@golevelup/nestjs-rabbitmq';

export const rabbitmqConfig = {
  uri: process.env.RABBITMQ_URL || 'amqp://guest:guest@localhost:5672',
  connectionInitOptions: { timeout: 5000 },
  exchanges: [
    {
      name: 'user-events',
      type: 'topic',
    },
    {
      name: 'booking-events',
      type: 'topic',
    },
  ],
};
