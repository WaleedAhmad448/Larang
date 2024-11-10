import { Component } from '@angular/core';
import { PropertyService } from '../services/property.service'; // تأكد من إنشاء هذه الخدمة
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-property',
  templateUrl: './add-property.component.html',
  styleUrls: ['./add-property.component.css']
})
export class AddPropertyComponent {
  property = {
    title: '',
    price: null,
    description: ''
  };

  constructor(private propertyService: PropertyService, private router: Router) { }

  addProperty() {
    this.propertyService.addProperty(this.property).subscribe(response => {
      // يمكنك إضافة رسالة نجاح هنا
      console.log('Property added', response);
      this.router.navigate(['/properties']); // انتقل إلى صفحة العقارات بعد الإضافة
    });
  }
}