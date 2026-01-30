import { Controller } from '@nestjs/common';
import { MessagePattern } from '@nestjs/microservices';

@Controller()
export class BookingController {
  @MessagePattern('user.created')
  handleUserCreated(data: { userId: number; email: string }) {
    console.log('Booking service received user.created event:', data);
    
    // Logic: create welcome booking for new user, etc
    return { status: 'user event processed' };
  }
}
