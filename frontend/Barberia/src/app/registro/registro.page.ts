import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent, IonHeader, IonTitle, IonToolbar, IonImg, IonInput, IonItem, IonTabButton, IonButton, IonBackButton, IonIcon } from '@ionic/angular/standalone';
import { addIcons, } from 'ionicons';
import { arrowBackOutline } from 'ionicons/icons';
import { NavController } from '@ionic/angular/standalone';
@Component({
  selector: 'app-registro',
  templateUrl: './registro.page.html',
  styleUrls: ['./registro.page.css'],
  standalone: true,
  imports: [IonIcon, IonBackButton, IonButton, IonTabButton, IonItem, IonInput, IonImg, IonContent, IonHeader, IonTitle, IonToolbar, CommonModule, FormsModule]
})
export class RegistroPage implements OnInit {

  constructor(private nav: NavController) {
    addIcons({ arrowBackOutline })
  }

  ngOnInit() {
  }

  goBack() {
    this.nav.back();
  }
}
