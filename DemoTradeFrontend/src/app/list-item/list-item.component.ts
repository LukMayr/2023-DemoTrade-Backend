import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-list-item',
  templateUrl: './list-item.component.html',
  styleUrls: ['./list-item.component.css']
})
export class ListItemComponent implements OnInit {
  private open: boolean = false;
  private isConvertable: boolean = false;
  private amount: string = "";

  @Input() stock: any;

  constructor() {

  }

  amountChange(event: any): void{
    this.amount = event.target.value;
    if(this.amount.length <= 0){
      console.log("empty" + this.amount);
      this.isConvertable = false;
    }
    else{
      console.log("not empty" + this.amount);
      this.isConvertable = true;
    }
  }

  getConvertable(): boolean{
    return this.isConvertable;
  }

  getOpen(): boolean{
    return this.open;
  }

  showMore(): void{
    this.open = this.open ? false : true;
  }

  ngOnInit(): void {
  }

}
