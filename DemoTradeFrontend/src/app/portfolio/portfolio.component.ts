import { Component, OnInit } from '@angular/core';
import { AuthService } from '../auth/auth.service';
import { User } from '../_model/user.model';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-portfolio',
  templateUrl: './portfolio.component.html',
  styleUrls: ['./portfolio.component.css']
})
export class PortfolioComponent implements OnInit {
  currentUser: User;
  portfolios: any;
  stocks: any;

  constructor(private authService: AuthService, private http: HttpClient) {

  }

  ngOnInit(): void {
    this.authService.user.subscribe(user => {
      this.currentUser = user;
    });

    this.http.get<{data: any}>('/api/portfolio/get.php').subscribe((data) => {

      this.portfolios = data.data;

      this.http.get<{data: any}>('/api/stock/getAll.php?portfolioId=' + this.portfolios[0].P_ID).subscribe((data) => {
        this.stocks = data.data;
      });
    });
  }
}
