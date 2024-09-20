import { Component, OnInit } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonItem, IonInput, IonImg, IonButton, IonBackButton, IonTabButton, IonLabel, NavController } from '@ionic/angular/standalone';
import {ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.css'],
  standalone: true,
  imports: [ReactiveFormsModule,IonLabel, IonTabButton, IonBackButton, IonButton, IonImg, IonInput, IonItem, IonHeader, IonToolbar, IonTitle, IonContent, RouterModule, RouterOutlet],
})
export class HomePage implements OnInit {
  loginForm: FormGroup;

  constructor(private nav: NavController, private formBuilder: FormBuilder ) {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });
  }

  ngOnInit() {}

  onSubmit() {
    if (this.loginForm.valid) {
      const { email, password } = this.loginForm.value;
  
      // Credenciales correctas
      const correctEmail = 'jdjjz19@gmail.com';
      const correctPassword = 'aguirre12';
  
      // Verificación de credenciales
      if (email === correctEmail && password === correctPassword) {
        this.nav.navigateForward('/cargando'); // Cambia a la página de carga si es necesario
      } else {
        // Mostrar mensaje de error
        this
        // Aquí puedes mostrar una alerta o un mensaje en la interfaz
      }
    }
  }
}
