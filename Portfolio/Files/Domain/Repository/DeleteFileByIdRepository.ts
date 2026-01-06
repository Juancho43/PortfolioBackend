export interface DeleteFileByIdRepository {
  deleteById(fileId: string): Promise<void>;
}
