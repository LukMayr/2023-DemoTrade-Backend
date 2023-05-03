import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private isLoggedIn: boolean = false;
  constructor(private http: HttpClient) {
    this.fetchUserLoggedIn();
  }
isAuthenticated(){
    return this.isLoggedIn;
  }

  private fetchUserLoggedIn(){
    this.http.get( environment.apiUrl +'/api/auth/isLoggedIn.php', {observe: "response"}).subscribe((res) => {
      if(res.status !== 200){
        this.isLoggedIn = true;
      }else{
        this.isLoggedIn = false;
      }

    });
  };
}
