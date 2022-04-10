<template>
    <div>
        <div class="text-center">
            <h1>APPOINTMENTS</h1>
        </div>
        <!-- FORM -->
        <form @submit.prevent="addAppointment">
            <div>
                <label for="description">Description</label>
                <div>
                    <textarea
                        type="text"
                        name="description"
                        v-model="data.description"
                        required
                        class="form-control"
                    >
                    </textarea>
                </div>
            </div>
            <div>
                <label for="date_start">Date Start</label>
                <div>
                    <input
                        type="datetime-local"
                        name="date_start"
                        v-model="data.date_start"
                        :disabled="data.is_all_day"
                        required
                        class="form-control"
                    />
                </div>
            </div>
            <div>
                <label for="date_end">Date End</label>
                <div>
                    <input
                        type="datetime-local"
                        name="date_end"
                        v-model="data.date_end"
                        :disabled="data.is_all_day"
                        required
                        class="form-control"
                    />
                </div>
            </div>
            <div>
                <label for="url">Link</label>
                <div>
                    <input
                        type="text"
                        name="url"
                        v-model="data.url"
                        required
                        class="form-control"
                    />
                </div>
            </div>
            <div>
                <label for="is_all_day">All Day</label>
                <div>
                    <input
                        type="checkbox"
                        name="is_all_day"
                        v-model="data.is_all_day"
                    />
                </div>
            </div>
            <div>
                <label for="emails">Emails (comma separated)</label>
                <div>
                    <input
                        type="email"
                        name="emails"
                        multiple
                        v-model="data.emails"
                        required
                        class="form-control"
                    />
                </div>
            </div>
            <div class="my-3">
                <button class="btn btn-primary"
                type="submit"
                 >
                    Add New Appointment
                </button>
            </div>
        </form>
        <!-- TABLE APPOINTMENTS -->
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th scope="col">Date-creation</th>
                        <th scope="col">Date-start</th>
                        <th scope="col">Date-End</th>
                        <th scope="col">All Day</th>
                        <th scope="col">Notificated</th>
                        <th scope="col">Link</th>
                        <th scope="col">Emails</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in appointments" :key="index">
                        <td>{{ item.description }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.date_start }}</td>
                        <td>{{ item.date_end }}</td>
                        <td>{{ item.is_all_day }}</td>
                        <td>{{ item.is_notificate }}</td>
                        <td>{{ item.url }}</td>
                        <td><span v-show="item.emails" v-for="(email, index) in item.emails" :key="index">
                            {{email.email}}
                            </span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            appointments: [],
            data: {
                description: "",
                date_start: '',
                date_end: '',
                url: "",
                is_all_day: false,
                emails: '',
            },
        };
    },

    mounted() {
        this.getAppointments();
    },

    methods: {
        // AXIOS GET APPOINTMENTS OF USER
        getAppointments() {
            axios.get("/appointments",{ withCredentials: true }).then((resp) => {
                this.appointments = resp.data;
            });
        },
        //  ADD NEW APPOINTMENT
        addAppointment() {
            axios.post("/appointments", this.data).then((resp) => {
                if(resp.status == 200){
                    this.appointments.push(this.data);
                    this.data = {};
                }
            }).catch((error)=>{
                console.log(error);
            })
            
        },
    },
};
</script>

<style></style>
