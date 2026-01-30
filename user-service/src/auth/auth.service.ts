import { Injectable, UnauthorizedException, ConflictException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from '../users/entities/user.entity';
import { JwtService } from '@nestjs/jwt';
import { AmqpConnection } from '@golevelup/nestjs-rabbitmq';

@Injectable()
export class AuthService {
  constructor(
    @InjectRepository(User)
    private userRepository: Repository<User>,
    private jwtService: JwtService,
    private amqpConnection: AmqpConnection, // ← ADD
  ) {}

  async register(email: string, password: string) {
    const existingUser = await this.userRepository.findOne({ where: { email } });
    if (existingUser) {
      throw new ConflictException('Email already registered');
    }

    const user = this.userRepository.create({ email, password });
    const savedUser = await this.userRepository.save(user);

    // 📤 KIRIM EVENT KE RABBITMQ
    await this.amqpConnection.publish(
      'user-service-exchange',
      'user.created',
      {
        userId: savedUser.id,
        email: savedUser.email,
        timestamp: new Date(),
      }
    );
    console.log(`📤 Event user.created sent: userId=${savedUser.id}`);

    const payload = { sub: savedUser.id, email: savedUser.email };
    const access_token = this.jwtService.sign(payload);

    return {
      message: 'User registered successfully',
      userId: savedUser.id,
      email: savedUser.email,
      access_token,
    };
  }

  async login(email: string, password: string) {
    const user = await this.userRepository.findOne({ where: { email } });
    if (!user || user.password !== password) {
      throw new UnauthorizedException('Invalid credentials');
    }

    const payload = { sub: user.id, email: user.email };
    const access_token = this.jwtService.sign(payload);

    return {
      message: 'Login successful',
      userId: user.id,
      email: user.email,
      access_token,
    };
  }
}
