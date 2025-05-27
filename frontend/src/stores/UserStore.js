import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useUserStore = defineStore('users', {
    state: () => ({
        token: sessionStorage.getItem('token') || null,
        user: sessionStorage.getItem('user') ? JSON.parse(sessionStorage.getItem('user')) : null
    }),
    getters:{
        isLoggedIn: (state) => !!state.token,
    },
    actions:{
        async RegisterUser(data){
            const response = await http.post('/users', data)
            return response.data.data;
        },

        async authenticateUser(email, password) {
            console.log('email a store-ban: ',email)
            console.log('password a store-ban: ',password)
            const response = await http.post('/authenticate', {email, password});
            
            console.log('UserStore response.data.data: ',response.data.data);

            this.user = response.data.data.user;
            this.token = response.data.data.token;

            sessionStorage.setItem('token', this.token)
            sessionStorage.setItem('user', JSON.stringify(this.user))
        },

        logout(){
            this.token = null;

            sessionStorage.removeItem('token');
            sessionStorage.removeItem('user');
            
            console.log('Token törölve. Kijelentkezett a felhasználó.')
        }
    }
})