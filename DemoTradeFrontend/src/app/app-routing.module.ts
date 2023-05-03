import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { SignUpComponent } from './sign-up/sign-up.component';
import { PortfolioComponent } from './portfolio/portfolio.component';
import { LogInComponent } from './log-in/log-in.component';
import { MarketComponent } from './market/market.component';
import { DiagramsComponent } from './diagrams/diagrams.component';
import { AuthService } from './auth/auth.service'
import { AuthGuard } from './auth/auth.guard'

const routes: Routes = [
  { path: '', redirectTo: 'portfolio', pathMatch: 'full' },
  { path: 'portfolio', component: PortfolioComponent, canActivate:[AuthGuard] },
  { path: 'signup', component: SignUpComponent },
  { path: 'login', component: LogInComponent },
  { path: 'market', component: MarketComponent, canActivate:[AuthGuard] },
  { path: 'diagrams', component: DiagramsComponent, canActivate:[AuthGuard] },
];

@NgModule({
  declarations: [],
  imports: [
      CommonModule,
      RouterModule.forRoot(routes),
  ],
  exports: [RouterModule]
  })
export class AppRoutingModule { }
