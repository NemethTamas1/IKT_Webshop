import { defineStore } from 'pinia';
import { http } from '@utils/http';
import { computed } from 'vue';

export const useUserStore = defineStore('users', {
    state: () => ({
        token: sessionStorage.getItem('token') || null,
        tokenType: sessionStorage.getItem('tokenType') ?? null,
        userData: {},
        userID: null,
    }),
    getters: {
        isLoggedIn: (state) => !!state.token,
        isAdmin: (state) => state.userData?.role === 'admin',
    },
    actions: {
        async RegisterUser(data) {
            const response = await http.post('/users', data)
            return response.data.data;
        },

        async authenticateUser(email, password) {
            console.log('email a store-ban: ', email);
            console.log('password a store-ban: ', password);

            const response = await http.post('/authenticate', { email, password });

            this.token = response.data.data.token;
            sessionStorage.setItem('token', this.token);
        },

        async modifyUserData(id, data) {
            try {
                console.log("modifyUserData ID: ", id)
                const response = await http.put(`/users/${id}`, data);
                this.userData = response.data.data;
                console.log("UserData: ", this.userData)
                console.log('Felhasználói adatok sikeresen frissítve.');
            } catch (error) {
                console.error('Hiba történt a felhasználói adatok módosításakor:', error);
                throw error;
            }
        },

        async getUser() {
            const token = sessionStorage.getItem('token');
            const response = await http.get('http://backend.vm1.test/api/user', {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });

            this.userID = response.data;

            const userResponse = await http.get(`/users/${this.userID}`);
            this.userData = userResponse.data.data;

            return response.data;
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