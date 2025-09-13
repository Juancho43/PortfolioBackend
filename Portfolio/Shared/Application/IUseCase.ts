export interface IUseCase<J, T> {
  execute(arg: J): T;
}
