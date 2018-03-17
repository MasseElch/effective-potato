import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as jwt_decode from 'jwt-decode';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/do';
import { isAfter } from 'date-fns';
import { UserInterface } from '../../../codegen/user';

export interface SimpleHeaders {
    [name: string]: string;
}

export interface SimpleCredentials {
    email: string;
    password: string;
}

@Injectable()
export class AuthService {

    /**
     * The key used to store the jwt-token in localStorage.
     */
    private static readonly LOCAL_STORAGE_TOKEN_KEY = 'jwt';

    /**
     * The currently used token. Used as cache by the retrieveToken()-method
     */
    private static _token: string;

    constructor(private http: HttpClient) {
    }

    /**
     * The currently logged in user.
     */
    static get user(): UserInterface {
        return jwt_decode(AuthService.retrieveToken())['user'];
    }

    /**
     * Stores the given token in the localStorage.
     */
    static storeToken(token: string): void {
        localStorage.setItem(AuthService.LOCAL_STORAGE_TOKEN_KEY, token);
    }

    /**
     * Fetches a saved token from the localStorage.
     */
    static retrieveToken(): string {
        if (!this._token) {
            this._token = localStorage.getItem(AuthService.LOCAL_STORAGE_TOKEN_KEY);
        }
        return this._token;
    }

    /**
     * Deletes a saved token from the localStorage.
     */
    static deleteToken(): void {
        this._token = null;
        localStorage.removeItem(AuthService.LOCAL_STORAGE_TOKEN_KEY);
    }

    /**
     * Returns the headers needed for authenticated requests.
     */
    static getAuthorizationHeader(): SimpleHeaders {
        const token = AuthService.retrieveToken();
        if (token) {
            return {'Authorization': 'Bearer ' + token};
        }
        return null;
    }

    /**
     * Returns true if there is a stored token in localStorage.
     */
    static isAuthenticated(): boolean {
        const token = AuthService.retrieveToken();

        if (token) {
            const decoded = jwt_decode(token);

            // Multiply by thousand since JS counts epochal in milliseconds
            if (isAfter(new Date(decoded['exp'] * 1000), new Date())) {
                return true;
            }
        }

        // Token is invalid or has expired. Delete it.
        AuthService.deleteToken();
        return false;
    }

    /**
     * Requests a jwt token from the remote.
     */
    getToken(credentials: SimpleCredentials): Observable<Object> {
        return this.http
            .post('/auth/token', credentials)
            .do((response: { token: string }) => {
                AuthService.storeToken(response.token);
            });
    }

    /**
     * Removes the stored token and redirects the user to the login screen.
     */
    forgetToken(): void {
        AuthService.deleteToken();
    }
}
