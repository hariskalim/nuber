<template>
    <div>
        <div v-if="isLoading">Loading bookings...</div>
        <div v-else>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:2%">ID</th>
                    <th style="width:2%">Name</th>
                    <th style="width:2%">Car Type</th>
                    <th style="width:2%">Status</th>
                    <th style="width:2%">Reference Code</th>
                    <th style="width:2%">Created At</th>
                    <th style="width:2%">Updated At</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="booking in bookings">
                    <tr v-bind:key="booking.id">
                        <td style="width:2%">{{ booking.id }}</td>
                        <td style="width:2%">{{ booking.name }}</td>
                        <td style="width:2%">{{ booking.car_type }}</td>
                        <td style="width:2%">{{ booking.status }}</td>
                        <td style="width:2%">{{ booking.reference_code }}</td>
                        <td style="width:2%">{{ booking.created_at }}</td>
                        <td style="width:2%">{{ booking.updated_at }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { API_BASE_URL } from '../config'

export default {
    data() {
        return {
            isLoading: true,
            bookings: {}
        }
    },
    methods:{
        callFunction: function () {
            var v = this;
            setInterval(function () {
                const response = axios.get(API_BASE_URL)
                response.then(function(res){
                v.bookings = res.data.response
                    console.log(res.data.response);
                });
            }, 5000);
        }
    },
    mounted () {
      this.callFunction()
    },
    async created () {
        try {
            const response = await axios.get(API_BASE_URL)
            this.bookings = response.data.response
            this.isLoading = false
        } catch (e) {
            // handle the authentication error here
        }
    }
}
</script>