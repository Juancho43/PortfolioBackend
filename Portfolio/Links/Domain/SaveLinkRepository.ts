export interface SaveLinkRepository{
  save(link: any): Promise<void>;
}
