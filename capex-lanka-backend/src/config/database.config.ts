import { registerAs } from '@nestjs/config';

export default registerAs('database', () => ({
  host: process.env.DB_HOST ?? 'localhost',
  port: parseInt(process.env.DB_PORT ?? '3306', 10),
  username: process.env.DB_USERNAME ?? 'capex_user',
  password: process.env.DB_PASSWORD ?? 'capex_password',
  database: process.env.DB_DATABASE ?? 'capex_lanka',
  synchronize: process.env.DB_SYNCHRONIZE === 'true',
}));
