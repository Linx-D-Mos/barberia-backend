import { Component, OnInit } from '@angular/core';
import { ActionSheetController, AlertController } from '@ionic/angular'; // Importa AlertController
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

  users: any[] = [];
  date: string = '';

  constructor(
    private actionSheetController: ActionSheetController,
    private alertController: AlertController // Inyecta AlertController
  ) {
    addIcons({ personCircleOutline });
  }

  ngOnInit() {
    this.cargarDatos();
    this.date = new Date().toLocaleDateString();
  }

  async cargarDatos() {
    const datos = {
      url: 'https://jsonplaceholder.typicode.com/users'
    };

    const response: HttpResponse = await CapacitorHttp.get(datos);
    this.users = response.data;
  }

  getCurrentDateTime() {
    const now = new Date();
    const date = now.toLocaleDateString();
    const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    return { date, time };
  }

  public async presentActionSheet(user: any) {
    const { date, time } = this.getCurrentDateTime(); 
    const actionSheet = await this.actionSheetController.create({
      header: 'Detalles de la cita',
      cssClass: 'custom-action-sheet',
      buttons: [
        {
          text: `${user.name}`,
          icon: personCircleOutline,  // Usando el ícono importado correctamente
          handler: () => { }
        },
        {
          text: `Fecha: ${date}`, 
          handler: () => { }
        },
        {
          text: `Hora: ${time}`, 
          handler: () => { }
        },
        {
          text: `Servicio: Consulta`,
          handler: () => { }
        },
        {
          text: 'Aceptar',
          role: 'accept',
          handler: () => {
            this.showAlert('Cita aceptada', 'Has aceptado la cita.');
          }
        },
        {
          text: 'Rechazar',
          role: 'reject',
          handler: () => {
            this.showAlert('Cita rechazada', '¿Estas seguro?');
          }
        }
      ]
    });
    await actionSheet.present();
  }

  // Método modificado para mostrar alertas usando AlertController
  async showAlert(header: string, message: string) {
    const alert = await this.alertController.create({
      header: header,
      message: message,
      buttons: ['Si']
    });

    await alert.present();
  }
}
