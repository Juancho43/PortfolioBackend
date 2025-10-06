import { Error } from 'mongoose';

export class EducationPeriod {
  private readonly _startDate: Date;
  private readonly _endDate: Date;

  private constructor(startDate: Date, endDate: Date) {
    this._startDate = startDate;
    this._endDate = endDate;
  }

  static create(startDate: string, endDate: string) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    if (end < start) {
      throw new Error('End date cannot be before start date');
    }
    return new EducationPeriod(start, end);
  }

  get startDate(): Date {
    return this._startDate;
  }

  get endDate(): Date {
    return this._endDate;
  }
}
