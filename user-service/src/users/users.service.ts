import { Injectable, ConflictException, UnauthorizedException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from './entities/user.entity';

@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private usersRepository: Repository<User>,
  ) {}

  async register(email: string, password: string) {
    // Check if user exists
    const existingUser = await this.usersRepository.findOne({ where: { email } });
    if (existingUser) {
      throw new ConflictException('Email already registered');
    }

    // Create new user (plain password for UAS demo)
    const user = this.usersRepository.create({
      email,
      password, // In production: hash password!
    });

    return this.usersRepository.save(user);
  }

  async login(email: string, password: string) {
    const user = await this.usersRepository.findOne({ where: { email } });
    
    if (!user || user.password !== password) {
      throw new UnauthorizedException('Invalid credentials');
    }

    return user;
  }

  async findOne(id: number) {
    return this.usersRepository.findOne({ where: { id } });
  }
}
