import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useUserStore = defineStore('users', {
    state: () => ({
        token: null
    }),
    actions:{
        async RegisterUser(data){
            const response = await http.post('/users', data)
            return response.data.data;
        },

        async authenticateUser(email, password) {
            console.log('email a store-ban: ',email)
            console.log('password a store-ban: ',password)
            const response = await http.post('/authenticate', {email, password});
            
            console.log('response.data.data: ',response.data.data)
            this.token = response.data.data.token;

            sessionStorage.setItem('token', this.token)
        }
    }
})