import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { Router } from '@angular/router'; // Importar Router desde @angular/router

@Component({
  selector: 'app-cargando',
  templateUrl: './cargando.page.html',
  styleUrls: ['./cargando.page.css'], // Cambia a .scss si estás usando SCSS
  standalone: true,
  imports: [CommonModule, FormsModule, IonicModule]
})
export class CargandoPage implements OnInit {

  constructor(private router: Router) { } // Asegúrate de usar 'router' en minúscula

  ngOnInit() {
    setTimeout(() => {
      this.router.navigate(['/home']);
    }, 3000);
  }

}
