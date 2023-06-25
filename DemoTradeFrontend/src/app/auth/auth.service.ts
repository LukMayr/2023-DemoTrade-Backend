import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from "../../environments/environment";
import { User } from '../_model/user.model';
import { Observable } from 'rxjs/internal/Observable';
import { BehaviorSubject, map } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})


export class AuthService {
  private userSubject: BehaviorSubject<User>;
  public user: Observable<User>;

  constructor(private http: HttpClient, private router: Router) {
    
    this.userSubject = new BehaviorSubject<User>(
      JSON.parse(localStorage.getItem('currentUser') as string)
    );
    this.user = this.userSubject.asObservable();

  }
  
  public get userValue(): User {
    return this.userSubject.value;
  }

  // login(username: string, password: string) {
    
  //   console.log("username: " + username + " password: " + password);
  //   return this.http
  //     .post<any>(`${environment.apiUrl}auth/login.php`, { username, password })
  //     .pipe(p
  //       map(({username, token}) => {
  //         let user: User = {
  //           username: username,
  //           token: token,
  //         }
  //         let userString = JSON.toString(user);
  //         console.log(userString);
  //         localStorage.setItem('currentUser', userString);
  //         this.userSubject.next(user);
  //         console.log(localStorage.getItem('currentUser'));
          
  //         console.log("user: " + user.username + " token: " + user.token);
          
  //         console.log(localStorage.getItem('currentUser'));
  //         return user;
  //       })
  //     );
      
  //   }
  login(username: string, password: string): Observable<any> {
    return this.http
      .post<any>(`${environment.apiUrl}auth/login.php`, { username, password })
      .pipe(
        map(({token}) => {
        let user: User = {
        username: username,
        token: token,
      };
      localStorage.setItem('currentUser', JSON.stringify(user));
      this.userSubject.next(user);
      return user;
    })
  );
  }

  
  logout() {
    return this.http
    .post<any>(`${environment.apiUrl}auth/logout.php`, {})
    .pipe(
      map(({token}) => {
        localStorage.removeItem('currentUser');
        this.userSubject.next(null as any);
        return "Logged out";
      })
    );

  }
}
