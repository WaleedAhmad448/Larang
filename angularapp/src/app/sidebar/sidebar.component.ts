import { Component, OnInit } from '@angular/core';
import { Router } from 'express';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements OnInit {

  constructor(private router: Router) { }

  logout() {
    // إزالة التوكن من التخزين المحلي
    localStorage.removeItem('token');
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
    this.router
  }
  ngOnInit(): void {
  }

}
