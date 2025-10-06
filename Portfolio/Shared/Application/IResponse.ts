export interface IResponse<T>{
    generate(data: T): any;
}