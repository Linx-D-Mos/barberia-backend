import { Component, OnInit } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonItem, IonInput, IonImg, IonButton, IonBackButton, IonTabButton, IonLabel, NavController } from '@ionic/angular/standalone';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.css'],
  standalone: true,
  imports: [IonLabel, IonTabButton, IonBackButton, IonButton, IonImg, IonInput, IonItem, IonHeader, IonToolbar, IonTitle, IonContent, RouterModule, RouterOutlet],
})
export class HomePage implements OnInit {
  constructor(private nav: NavController) {}

  ngOnInit() {
  }

  go(){
    
  }
}
