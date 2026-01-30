import {
  IsEmail,
  IsString,
  MinLength,
  MaxLength,
  IsNotEmpty,
} from 'class-validator';

export class RegisterDto {
  @IsEmail({}, { message: 'Email tidak valid' })
  @IsNotEmpty({ message: 'Email tidak boleh kosong' })
  email: string;

  @IsString({ message: 'Password harus string' })
  @MinLength(6, { message: 'Password minimal 6 karakter' })
  @MaxLength(100, { message: 'Password maksimal 100 karakter' })
  @IsNotEmpty({ message: 'Password tidak boleh kosong' })
  password: string;
}
