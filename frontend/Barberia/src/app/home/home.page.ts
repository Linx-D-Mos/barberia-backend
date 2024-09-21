import { Component, inject, OnInit } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonItem, IonInput, IonImg, IonButton, IonBackButton, IonTabButton, IonLabel, NavController } from '@ionic/angular/standalone';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { AuthService } from '../services/auth/auth.service'; // Asegúrate de que la ruta sea correcta

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.css'],
  standalone: true,
  imports: [ReactiveFormsModule, IonLabel, IonTabButton, IonBackButton, IonButton, IonImg, IonInput, IonItem, IonHeader, IonToolbar, IonTitle, IonContent, RouterModule, RouterOutlet],
})
export class HomePage implements OnInit {
  constructor( private formBuilder: FormBuilder ) {

    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],});
    
  }

  loginForm!: FormGroup; // Formulario de login

  isLogin = false; 

  // private authService = inject(Auth2Service);
  private authService = inject(AuthService);
  
  ngOnInit() {
    /* Inincializamos el formulario */
    this.loginForm = new FormGroup({
      email: new FormControl(''),
      password: new FormControl(''),
    });
  }

  /* Función para el login */
  login() {
    this.isLogin = true;

    this.authService.login(this.loginForm.value)
      .then((response) => {
        if (response?.data?.success === 1) {
          this.authService.navigateByUrl('/cargando');
          this.isLogin = false;
          this.loginForm.reset();
        }else{
          this.isLogin = false;
          this.authService.showAlert(response?.data?.message);
        }
      })
      .catch((e) => {
        this.isLogin = false;
        this.authService.showAlert(e?.error?.message);
      });
  }

  


}
