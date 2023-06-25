import { Component, OnInit } from '@angular/core';
import { AuthService } from '../auth/auth.service';
import { User } from '../_model/user.model';

@Component({
  selector: 'app-portfolio',
  templateUrl: './portfolio.component.html',
  styleUrls: ['./portfolio.component.css']
})
export class PortfolioComponent implements OnInit {
currentUser: User;

constructor(private authService: AuthService
  ) {
    
   }

  ngOnInit(): void {
    this.authService.user.subscribe(user => {
      this.currentUser = user;
    });
  }

}
