export type PaginatedResult<T> = {
  data: T[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
};

export function parsePagination(page?: string, limit?: string) {
  const parsedPage = Math.max(1, Number.parseInt(page ?? '1', 10) || 1);
  const parsedLimit = Math.min(100, Math.max(1, Number.parseInt(limit ?? '20', 10) || 20));

  return { page: parsedPage, limit: parsedLimit };
}

export function toPaginatedResult<T>(
  data: T[],
  total: number,
  page: number,
  limit: number,
): PaginatedResult<T> {
  return {
    data,
    total,
    page,
    limit,
    totalPages: total === 0 ? 1 : Math.ceil(total / limit),
  };
}
