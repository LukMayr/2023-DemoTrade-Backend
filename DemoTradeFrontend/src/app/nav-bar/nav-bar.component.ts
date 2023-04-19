import { Component, OnInit } from '@angular/core';
import { Router,NavigationEnd  } from '@angular/router';
import { filter } from 'rxjs/operators';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.css']
})
export class NavBarComponent implements OnInit {
  currentPage: string = "";

  constructor(private router: Router) {
    console.log("NavBarComponent constructor"); 

    this.router.events.pipe(
    filter(event => event instanceof NavigationEnd)).subscribe(event =>{
      if(event instanceof NavigationEnd){
        console.log(event.url);
        this.currentPage = event.url;
      }
      else{
        console.log("not a NavigationEnd");
      }
    })
  }


  ngOnInit(): void {
  }

}
