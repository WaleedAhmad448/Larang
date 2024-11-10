import { Component, OnInit } from '@angular/core';
import { PropertyService } from '../services/property.service'; // تأكد من وجود هذه الخدمة

@Component({
  selector: 'app-properties',
  templateUrl: './properties.component.html',
  styleUrls: ['./properties.component.css']
})
export class PropertiesComponent implements OnInit {
  properties: any[] = [];

  constructor(private propertyService: PropertyService) { }

  ngOnInit(): void {
    this.loadProperties();
  }

  loadProperties() {
    this.propertyService.getProperties().subscribe(data => {
      this.properties = data;
    });
  }
}