import { Component, OnInit } from '@angular/core';
import { PropertyService } from '../services/property.service'; // تأكد من إنشاء هذه الخدمة

@Component({
  selector: 'app-my-listings',
  templateUrl: './my-listings.component.html',
  styleUrls: ['./my-listings.component.css']
})
export class MyListingsComponent implements OnInit {
  myProperties: any[] = [];

  constructor(
    private propertyService: PropertyService
  ) { }

  ngOnInit(): void {
    this.loadMyProperties();
  }

  loadMyProperties() {
    this.propertyService.getMyProperties().subscribe(data => {
      this.myProperties = data;
    });
  }

  deleteProperty(id: number) {
    this.propertyService.deleteProperty(id).subscribe(() => {
      this.loadMyProperties(); // إعادة تحميل العقارات بعد الحذف
    });
  }
}