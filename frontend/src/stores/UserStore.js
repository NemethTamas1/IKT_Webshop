import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useUserStore = defineStore('users', {
    state: () => ({
        token: sessionStorage.getItem('token') || null,
        user: sessionStorage.getItem('user') ? JSON.parse(sessionStorage.getItem('user')) : null,
        tokenType: sessionStorage.getItem('tokenType') ?? null
    }),
    getters: {
        isLoggedIn: (state) => !!state.token,
    },
    actions: {
        async RegisterUser(data) {
            const response = await http.post('/users', data)
            return response.data.data;
        },

        async authenticateUser(email, password) {
            console.log('email a store-ban: ', email)
            console.log('password a store-ban: ', password)
            const response = await http.post('/authenticate', { email, password });

            console.log('UserStore response.data.data: ', response.data.data);

            this.user = response.data.data.user;
            this.token = response.data.data.token;
            this.tokenType = response.data.data.tokenType;

            sessionStorage.setItem('token', this.token)
            sessionStorage.setItem('tokenType', this.tokenType)
            sessionStorage.setItem('user', JSON.stringify(this.user))
        },

        async modifyUserData(data) {
            try {
                const response = await http.put(`/users/${this.user.id}`, data);
                this.user = response.data.data;
                sessionStorage.setItem('user', JSON.stringify(this.user));
                console.log('Felhasználói adatok sikeresen frissítve.');
            } catch (error) {
                console.error('Hiba történt a felhasználói adatok módosításakor:', error);
                throw error;
            }
        },

        logout() {
            this.token = null;

            sessionStorage.removeItem('token');
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('tokenType');

            console.log('Token törölve. Kijelentkezett a felhasználó.')
        }
    }
})