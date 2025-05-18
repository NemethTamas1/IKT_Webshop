import { defineStore } from 'pinia';
import { http } from '@utils/http';

export const useUserStore = defineStore('users', {
    state: () => ({

    }),
    actions:{
        async RegisterUser(data){
            const response = await http.post('/users', data)
            return response.data.data;
        }
    }
})