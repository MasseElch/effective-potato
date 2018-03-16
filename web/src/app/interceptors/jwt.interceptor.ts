import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AuthService } from '../services/auth.service';

@Injectable()
export class JwtInterceptor implements HttpInterceptor {
    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        // Get the auth header from the service.
        const authHeader = AuthService.getAuthorizationHeader();

        // If there is an auth header add it and pass on the new request.
        if (authHeader) {
            return next.handle(req.clone({setHeaders: authHeader}));
        }

        // Simply pass on the request if there is no header to set.
        return next.handle(req);
    }
}
