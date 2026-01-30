import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Booking } from './entities/booking.entity';
import { CreateBookingDto } from './dto/create-booking.dto';

@Injectable()
export class BookingService {
  constructor(
    @InjectRepository(Booking)
    private bookingRepository: Repository<Booking>,
  ) {}

  calculateNights(checkIn: string, checkOut: string): number {
    const inDate = new Date(checkIn);
    const outDate = new Date(checkOut);
    const timeDiff = outDate.getTime() - inDate.getTime();
    return Math.ceil(timeDiff / (1000 * 3600 * 24));
  }

  async create(createBookingDto: CreateBookingDto) {
    const nights = this.calculateNights(
      createBookingDto.checkIn,
      createBookingDto.checkOut,
    );
    const totalPrice = nights * 500000;

    const booking = this.bookingRepository.create({
      roomId: createBookingDto.roomId,
      checkIn: createBookingDto.checkIn,
      checkOut: createBookingDto.checkOut,
      totalPrice,
      userId: 5,
      status: 'pending',
    });

    return this.bookingRepository.save(booking);
  }

  async findAll() {
    return this.bookingRepository.find();
  }

  async findOne(id: number) {
    const booking = await this.bookingRepository.findOne({ where: { id } });
    if (!booking) throw new NotFoundException('Booking not found');
    return booking;
  }

  async update(id: number, updateData: any) {
    await this.bookingRepository.update(id, updateData);
    return this.findOne(id);
  }

  async remove(id: number) {
    await this.bookingRepository.delete(id);
    return { message: 'Booking deleted' };
  }
}
