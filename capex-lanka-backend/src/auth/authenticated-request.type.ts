import type { Request } from 'express';
import type { User } from '../users/user.entity.js';

export type AuthenticatedRequest = Request & {
  user: User;
};
