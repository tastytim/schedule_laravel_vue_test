import Router from "vue-router";
import Vue from "vue";
import AppointmentShow from './components/AppointmentShow.vue';
import Appointments from './components/Appointment.vue';

Vue.use(Router);

let router = new Router({
   
   
    
    routes:[
         {
             path:'edit/:appId',
             name : 'appointmentshow',
             component:AppointmentShow,
             props: true
         },
         {
             path:'',
             name: 'appointments',
             component:Appointments
         },
    ]
})




export default router;