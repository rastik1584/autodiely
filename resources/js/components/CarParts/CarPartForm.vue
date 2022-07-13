<template>
    <div class="car-part-form">
        <div class="header-links">
            <h1>{{ form.id ? 'Upraviť' : 'Pridať'}} autodiel</h1>
            <router-link class="btn btn-sm btn-primary" to="/car-parts">Späť na zoznam autodielov</router-link>
        </div>
        <form @submit.prevent="savePart">
            <div class="form-group">
                <label for="name">Názov autodielu</label>
                <input v-model="form.name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="serial_number">Sériové číslo</label>
                <input v-model="form.serial_number" id="serial_number" class="form-control">
            </div>
            <div class="form-group">
                <label for="car">Auto</label>
                <select v-model="form.car_id" id="car" class="form-control">
                    <option :value="car.id" v-for="car in cars" :key="car.id">{{ car.name }}</option>
                </select>
            </div>
            <button class="btn btn-sm btn-primary" type="submit">Uložiť</button>
        </form>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import VueCookies from "vue-cookies";
import Swal from "sweetalert2";

export default {
    name: "CarPartForm",
    data() {
        return {
            form: {
                name: '',
                serial_number: '',
                car_id: "",
            },
            cars: [],
        }
    },
    created() {
        if(this.$route.params.id) {
            this.getCarPart(this.$route.params.id).then(data => {
                this.form = data.data;
            });
        }
        this.getCars({}).then(data => {
            this.cars = data.cars.data;
        });
    },
    methods: {
        ...mapActions([
            "getCars",
            "saveCarPart",
            "getCarPart"
        ]),
        savePart() {
            this.saveCarPart(this.form).then(data => {
                $cookies.set('success_save', data.message);
                this.$router.push('/car-parts');
            }).catch(err => {
                Swal.fire({
                    title: 'Chyba',
                    icon: "error",
                    text: err.response.data.error,
                });
            });
        }
    },
    computed: {

    },
    components: {
        VueCookies,
    }
}
</script>

<style scoped>

</style>
