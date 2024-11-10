import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PropertyService {
  private apiUrl = 'http://127.0.0.1:8000/api/properties'; // تأكد من أن هذا هو عنوان الـ API الخاص بك

  constructor(private http: HttpClient) { }

  getProperties(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }

  addProperty(property: any): Observable<any> {
    return this.http.post<any>(this.apiUrl, property);
  }

  getMyProperties(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/my-listings`); // تأكد من وجود نقطة النهاية في الـ API
  }

  deleteProperty(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/${id}`);
  }
}