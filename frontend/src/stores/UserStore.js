import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useUserStore = defineStore('users', {
    state: () => ({
        token: sessionStorage.getItem('token') || null,
        userData: JSON.parse(sessionStorage.getItem('userData')) || {},
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
            try {
                console.log('email a store-ban: ', email)
                console.log('password a store-ban: ', password)
                
                const response = await http.post('/authenticate', { email, password });
        
                console.log('UserStore response.data.data.user.name: ', response.data.data.user.name);
                console.log('UserStore response.data.data: ', response.data.data);
        
                this.token = response.data.data.token;
        
                this.userData = {
                    name: response.data.data.user.name,
                    email: response.data.data.user.email,
                    phone: response.data.data.user.phone,
                    country: response.data.data.user.country,
                    city: response.data.data.user.city,
                    zip: response.data.data.user.zip,
                    street_name: response.data.data.user.street_name,
                    street_type: response.data.data.user.street_type,
                    street_number: response.data.data.user.street_number,
                    floor: response.data.data.user.floor
                }
        
                sessionStorage.setItem('token', this.token);
                sessionStorage.setItem('userData', JSON.stringify(this.userData));
            } catch (error) {
                console.error('Hiba az authenticateUser-ben:', error);
            }
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
            this.userData = {};

            sessionStorage.removeItem('token');
            sessionStorage.removeItem('userData');

            console.log('Token törölve. Kijelentkezett a felhasználó.')
        }
    }
})