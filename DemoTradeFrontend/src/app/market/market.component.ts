import { HttpClient } from '@angular/common/http';
import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { Currency } from '../_model/currency';

@Component({
  selector: 'app-market',
  templateUrl: './market.component.html',
  styleUrls: ['./market.component.css']
})
export class MarketComponent implements OnInit {

  currencies: Currency[] = [];

  @ViewChild('quantityInput') quantityInput: ElementRef;

  constructor(private http: HttpClient) { }

  ngOnInit(): void {
    this.http.get<{data: Currency[]}>('/api/currency/getAll.php').subscribe((data1) => {

      this.http.get<{ rates: any }>('https://open.er-api.com/v6/latest/USD').subscribe((data2) => {


        for (let i = 0; i < data1.data.length; i++) {
          const currency = {
            C_NAME: data1.data[i].C_NAME,
            C_PRICE: data2.rates[data1.data[i].C_NAME],
          }
          this.currencies.push(currency);
        }

        console.log(this.currencies);


      });
    });
  }

  buyStock(C_NAME: string): void {
    let quantity = this.quantityInput.nativeElement.value;

    this.http.get<{data: any}>('/api/portfolio/get.php').subscribe((data) => {

      let portfolioId = data.data[0].P_ID;
      console.log({
        portfolioId,
        C_NAME,
        quantity,
        price: this.getPrice(C_NAME),
      });

      this.http.post('/api/stock/buy.php', {portfolioId, C_NAME, quantity, price: this.getPrice(C_NAME) }).subscribe((data) => {
        console.log(data);
      });
    });
  }

  getPrice(C_NAME: string): number {
    for (let i = 0; i < this.currencies.length; i++) {
      if (this.currencies[i].C_NAME == C_NAME) {
        return this.currencies[i].C_PRICE;
      }
    }
    return 0;
  }

}
