import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { User } from '../users/entities/user.entity';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql' as const,
      host: '127.0.0.1',        // XAMPP LOCAL
      port: 3306,
      username: 'root',
      password: '',             // XAMPP default
      database: 'user_service',
      entities: [User],
      synchronize: true,
      logging: false,
    }),
  ],
  exports: [TypeOrmModule],
})
export class DatabaseModule {}
