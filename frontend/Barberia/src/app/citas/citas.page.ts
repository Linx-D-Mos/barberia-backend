import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent, IonHeader, IonTitle, IonToolbar, IonCard, IonFooter, IonCardContent, IonButton, IonCardHeader, IonCardTitle, IonCardSubtitle, IonIcon, IonLabel, IonImg } from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { personCircleOutline } from 'ionicons/icons';
import { CapacitorHttp, HttpResponse } from '@capacitor/core';

@Component({
  selector: 'app-citas',
  templateUrl: './citas.page.html',
  styleUrls: ['./citas.page.css'],
  standalone: true,
  imports: [IonImg, IonLabel, IonIcon, IonCardSubtitle, IonCardTitle, IonCardHeader, IonButton, IonCardContent, IonFooter, IonCard, IonContent, IonHeader, IonTitle, IonToolbar, CommonModule, FormsModule]
})
export class CitasPage implements OnInit {

  users : any[] = [];

  constructor() { 

    addIcons({personCircleOutline})
  }

  ngOnInit() {
    this.cargarDatos();
  }

  async cargarDatos(){
    const datos = {
      url : 'https://jsonplaceholder.typicode.com/users'
    }

    const response : HttpResponse = await CapacitorHttp.get(datos)
    this.users = response.data
  }


}
