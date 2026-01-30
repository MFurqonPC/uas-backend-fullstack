import { IsNotEmpty, IsNumber, IsDateString } from 'class-validator';

export class CreateBookingDto {
  @IsNumber()
  @IsNotEmpty()
  roomId: number;

  @IsDateString()
  @IsNotEmpty()
  checkIn: string;

  @IsDateString()
  @IsNotEmpty()
  checkOut: string;
}
