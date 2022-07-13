<template>
    <div class="cars-form">
        <div class="car-header">
            <h1>{{ form.id ? 'Upraviť': 'Pridať'}} auto</h1>
            <router-link to="/cars" class="btn btn-sm btn-primary back-btn">Späť na zoznam áut</router-link>
        </div>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Názov auta</label>
                <input v-model="form.name" class="form-control">
            </div>
            <div class="form-group">
                <label for="registration_number">Registračné číslo vozidla</label>
                <input v-model="form.registration_number" class="form-control" :required="form.is_registered">
            </div>
            <div class="form-group">
                <label for="is_registered">Registrované</label>
                <toggle-button v-model="form.is_registered" :labels="{checked: 'Áno', unchecked: 'Nie'}" :sync="true"><i class="fas fa-trash-alt"></i></toggle-button>
            </div>

            <h4>Autodiely</h4>
            <button class="btn btn-sm btn-primary add-row" @click.prevent="addRow">Pridať autodiel</button>
            <div class="row" v-for="(part, index) in form.parts" :key="index">
                <div class="col-sm-5 form-group">
                    <label :for="`name_${index}`">Názov autodielu</label>
                    <input v-model="part.name" class="form-control" :id="`name_${index}`">
                </div>
                <div class="col-sm-5 form-group">
                    <label :for="`number_${index}`">Sériové číslo</label>
                    <input v-model="part.serial_number" class="form-control" :id="`number_${index}`">
                </div>
                <div class="col-sm-2 form-group remove-row">
                    <button class="btn btn-sm btn-danger" @click.prevent="removeRow(index)"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Uložiť</button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import { ToggleButton } from 'vue-js-toggle-button';
import Swal from 'sweetalert2';
import VueCookies from 'vue-cookies';
import { library, dom } from "@fortawesome/fontawesome-svg-core";
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);
dom.watch();

export default {
    name: "CarsForm",
    data() {
        return {
            form: {
                name: '',
                registration_number: '',
                is_registered: false,
                parts: [{
                        name: '',
                        serial_number: '',
                    }],
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.getCar(this.$route.params.id).then(data => {
                this.form = data.data;
                this.form.parts = data.data.parts.data;
            }).catch(err => {
                Swal.fire({
                    title: 'Chyba',
                    icon: 'error',
                    text: err.response.data.error
                })
            })
        }
    },
    methods: {
        ...mapActions({
            'sendForm': 'saveCar',
            'getCar': 'getCar',
        }),
        submitForm() {
            this.sendForm(this.form).then(data => {
                const message = data.message;
                $cookies.set('success_save', message);
                this.$router.push('/cars');
            }).catch(err => {
                if(err.response) {
                    Swal.fire({
                        title: 'Chyba!',
                        icon: 'error',
                        text: err.response.data.error,
                    });
                }
            });
        },
        addRow() {
            this.form.parts.push({
                name: '',
                serial_number: '',
            })
        },
        removeRow(index) {
            this.form.parts.splice(index, 1);
        }
    },
    computed: {
        ...mapGetters({

        }),
    },
    components: {
        ToggleButton,
        VueCookies
    }
}
</script>

<style lang="scss" scoped>
    .remove-row {
        margin-top: 34px;
    }
    h4 {
        display: inline-flex;
    }
    .add-row {
        margin-left: 15px;
    }
    .car-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

</style>
