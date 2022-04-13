<template>
    <div>
        <h1>Add mail to Appointment</h1>
        <p>mails :</p>
    </div>
</template>

<script>
export default {

    data(){
        return {
          emails : [],
        }
    },

    mounted() {
       axios.get(`/appointments/36`).then((resp)=>{
           this.emails = resp.data.emails;
       })     

    },
    methods: {



    },
};
</script>

<style></style>
