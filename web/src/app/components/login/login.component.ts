import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../services/auth.service';
import 'rxjs/add/operator/finally';
import { Router } from '@angular/router';

@Component({
  selector: 'efpo-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  form: FormGroup;

  states = {
    loading: false
  };

  constructor(private fb: FormBuilder, private authService: AuthService, private router: Router) { }

  ngOnInit() {
    this.form = this.fb.group({
      email: [null, Validators.required],
      password: [null, Validators.required]
    });
  }

  submit(): void {
    this.states.loading = true;
    this.authService.getToken(this.form.value)
      .finally(() => this.states.loading = false)
      .subscribe(
        _ => {
          this.router.navigate(['']);
          console.log(_);
        },
        console.error // todo - error handling
      )
    ;
  }

}
