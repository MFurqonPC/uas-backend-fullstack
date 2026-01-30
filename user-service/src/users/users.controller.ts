import { Controller, Post, Body } from '@nestjs/common';
import { UsersService } from './users.service';

@Controller('auth')
export class UsersController {
  constructor(private readonly usersService: UsersService) {}

  @Post('register')
  async register(@Body() registerDto: { email: string; password: string }) {
    const user = await this.usersService.register(registerDto.email, registerDto.password);
    return {
      message: 'User registered successfully',
      userId: user.id,
      email: user.email,
    };
  }

  @Post('login')
  async login(@Body() loginDto: { email: string; password: string }) {
    const user = await this.usersService.login(loginDto.email, loginDto.password);
    return {
      message: 'Login successful',
      userId: user.id,
      email: user.email,
    };
  }
}
