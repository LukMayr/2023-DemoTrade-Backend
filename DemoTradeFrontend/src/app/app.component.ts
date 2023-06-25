import { Component } from '@angular/core';
import { Router } from '@angular/router'; 
import { HttpClient } from '@angular/common/http';
import { User } from './_model/user.model';
import { AuthService } from './auth/auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'DemoTrade';
  currentUser: User;
  // private isUserLoggedIn: boolean = false;
  constructor(private authenticationService: AuthService
    ) {
      this.authenticationService.user.subscribe(user => this.currentUser = user);
     }

  
  
  //TODO: Fix not able to navigate to login page
  // private checkUserLoggedIn(){
  //   if(!this.isUserLoggedIn){
  //     this.router.navigate(['signup']);
  //   };
  // }
  
}
