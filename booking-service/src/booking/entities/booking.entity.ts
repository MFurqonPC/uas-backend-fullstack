import { Entity, Column, PrimaryGeneratedColumn, CreateDateColumn } from 'typeorm';

@Entity('bookings')
export class Booking {
  @PrimaryGeneratedColumn()
  id: number;

  @Column()
  roomId: number;

  @Column()
  checkIn: string;

  @Column()
  checkOut: string;

  @Column('decimal', { precision: 12, scale: 2 })
  totalPrice: number;

  @Column({ default: 'pending' })
  status: string;

  @Column({ default: 5 }) // UAS Demo User
  userId: number;

  @CreateDateColumn()
  createdAt: Date;
}
