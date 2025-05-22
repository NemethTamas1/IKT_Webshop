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

        async authenticateUser(data) {
            console.log(data)
            const response = await http.post('/authenticate', data);
            
            this.token = response.data.data;

            sessionStorage.setItem('token', this.token)
        }
    }
})