import {
  IsEmail,
  IsString,
  IsNotEmpty,
} from 'class-validator';

export class LoginDto {
  @IsEmail({}, { message: 'Email tidak valid' })
  @IsNotEmpty({ message: 'Email tidak boleh kosong' })
  email: string;

  @IsString({ message: 'Password harus string' })
  @IsNotEmpty({ message: 'Password tidak boleh kosong' })
  password: string;
}
