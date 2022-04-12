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
                        id="date_start"
                        v-model="data.date_start"
                        :disabled="data.is_all_day"
                        required
                        class="form-control"
                        @click="setMinToInputDate"
                    />
                </div>
            </div>
            <div>
                <label for="date_end">Date End</label>
                <div>
                    <input
                        type="datetime-local"
                        name="date_end"
                        id="date_end"
                        v-model="data.date_end"
                        :disabled="data.is_all_day"
                        required
                        class="form-control"
                        @click="setMinToInputDate"
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
                <button class="btn btn-primary" type="submit">
                    Add New Appointment
                </button>
            </div>
        </form>
        <!-- TABLE APPOINTMENTS -->
        <div class="horizontal-scroll">
            <table class="my_table table">
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
                        <td>
                            <span
                                v-show="item.emails"
                                v-for="(email, index) in item.emails"
                                :key="index"
                            >
                                {{ email.email }}
                            </span>
                        </td>
                        <td><button class="btn btn-dark" @click="deleteAppointment(item.id)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- DOWNLOAD PDF -->
        <div>
            <h1>Download your programm</h1>
            <div>
                <span
                    ><button
                        class="btn btn-danger"
                        id="week_btn"
                        @click="downloadPDF"
                    >
                        Download pdf 1 week
                    </button></span
                >
                <span
                    ><button
                        class="btn btn-danger"
                        id="month_btn"
                        @click="downloadPDF"
                    >
                        Download pdf 1 month
                    </button></span
                >
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import dayjs from "dayjs";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
export default {
    data() {
        return {
            appointments: [],
            filteredAppointments : [],
            pdfAppointments:[],
            data: {
                description: "",
                date_start: "",
                date_end: "",
                url: "",
                is_all_day: false,
                emails: "",
            },
            period :{
                week : 7,
                month: 30,
            }
        };
    },

    mounted() {
        this.getAppointments();
    },

    methods: {
        // AXIOS GET APPOINTMENTS OF USER
        getAppointments() {
            axios
                .get("/appointments", { withCredentials: true })
                .then((resp) => {
                    this.appointments = resp.data;
                });
        },
        //  ADD NEW APPOINTMENT
        addAppointment() {
            axios
                .post("/appointments", this.data)
                .then((resp) => {
                    if (resp.status == 200) {
                        this.getAppointments();
                        this.data = {};
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // DELETE APPOINTMENT
        deleteAppointment(id){
           axios.delete(`/appointments/${id}`).then((resp)=>{
               if(resp.status==200){
                   this.getAppointments();
               }
           })
           .catch((error) => {
                    console.log(error);
                });
        },
        // GET TODAY DAY AND SET MIN TO INPUT DATE_START
        setMinToInputDate(e) {
            let today = dayjs().format("YYYY-MM-DD HH:mm");
            document.getElementById(e.target.id).setAttribute("min", today);
        },
        downloadPDF(e) {
            this.filterForPeriod(e);
            this.filterAppointmentsForValues();

            //Create doc PDF
            const doc = new jsPDF();
            doc.text('APPOINTMENTS', 50, 15 , {align: 'center'} , {baseline:'top'});

            //Create table
            autoTable(doc, { html: "APPOINTMENTS" });

            // add data to table
            autoTable(doc, {
                head: [["ID", "DESCRIPTION", "LINK", "DATE START" , "DATE END", "All DAY","EMAILS"]],
                body: this.pdfAppointments,
            });

            doc.output('save', 'info.pdf');
        },
        
        //   FILTER FOR PERIOD
        filterForPeriod(e){
            // RECEIVE ID FROM TARGET
          let period = 0;
          if(e.target.id == 'week_btn'){
              period = this.period.week;
          }else{
              period = this.period.month;
          }
          this.filteredAppointments = this.appointments.filter((e)=>{
              let today = dayjs();
              let data_inizio = dayjs(e.date_start);
              let data_fine = dayjs(e.date_end);

              let diffA = data_inizio.diff(today , 'day');
              let diffB = data_fine.diff(today , 'day');
              return diffA > 0 && diffB < period;
          })
        },
        //FILTER FOR VALUES AND CONVERT EMAILS ARRAY TO STRING
        filterAppointmentsForValues(){
           this.filteredAppointments.map((element) => { 
              let stringEmails = '';
              let {emails} = element;
              let emailsArray = Object.values({...emails});
              emailsArray.forEach(element => {
                  stringEmails = stringEmails + ' ' + element.email;
              });
             let {id, description, url, date_start , date_end, is_all_day , email = stringEmails.trim()} = element;        
              this.pdfAppointments.push(Object.values({id, description, url, date_start , date_end, is_all_day , email}));
           });
        }
    },
};
</script>

<style>

.horizontal-scroll{
overflow: hidden;
  overflow-x: auto;
  clear: both;
  width: 100%;
}

.my-table {
  min-width: rem-calc(640);
}

</style>
