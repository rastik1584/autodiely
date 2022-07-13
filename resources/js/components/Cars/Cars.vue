<template>
    <div>
        <div class="header-links">
            <h1>Správa áut</h1>
            <router-link class="btn btn-sm btn-primary" to="/cars/form">Pridať auto</router-link>
        </div>

        <div class="project-content">
            <cars-filter @allCars="getAllCars" />

            <table class="table mt-3">
                <thead>
                <tr>
                    <th>Názov auta</th>
                    <th>Registračné číslo auta</th>
                    <th class="text-center">Registrované</th>
                    <th class="text-center">Počet komponentov</th>
                    <th>Akcie</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="car in cars" :key="car.id">
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number ?? 'n/a' }}</td>
                    <td class="text-center">{{ car.is_registered ? 'Áno' : 'Nie'}}</td>
                    <td class="text-center">{{ car.parts_count }}</td>
                    <td class="actions">
                        <router-link class="btn btn-sm btn-primary" :to="`/cars/form/${car.id}`"><i class="fas fa-pencil-alt"></i></router-link>
                        <form @submit.prevent="removeCar(car)">
                            <button class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';
import CarsFilter from "./CarsFilter";
import Swal from "sweetalert2";
import VueCookies from 'vue-cookies';
import { library, dom } from "@fortawesome/fontawesome-svg-core";
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
dom.watch();

export default {
    name: "Cars",
    data() {
        return {
            cars: [],
        }
    },
    created() {
        this.checkFilter();
        this.getAllCars();
        if($cookies.get('success_save')) {
            Swal.fire({
                icon: 'success',
                title: 'Výborne',
                text: $cookies.get('success_save'),
            });
            $cookies.remove('success_save');
        }
    },
    methods: {
        ...mapActions([
            'getCars',
            'deleteCar',
        ]),
        ...mapMutations([
            'setFilter'
        ]),
        getAllCars() {
            const query = this.$route.query
            let filter = {};
            if(query.name || query.registrationNumber || query.is_registered) {
                filter = this.filter;
            }
            this.getCars(filter).then(data => {
                this.cars = data.cars.data;
            })
        },
        removeCar(car) {
            Swal.fire({
                title: 'Naozaj si prajete zmazať auto ?',
                showCancelButton: true,
                confirmButtonText: 'Zmazať',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteCar(car).then(data => {
                        Swal.fire(data.message, '', 'success');
                        this.getAllCars();
                    }).catch(err => {
                        Swal.fire(err.response.data.error,'', 'error');
                    })
                }
            })
        },
        checkFilter() {
            const query = this.$route.query
            if(query.name || query.registrationNumber || query.is_registered) {
                this.setFilter({
                    name: query.name,
                    registrationNumber: query.registrationNumber,
                    is_registered: query.is_registered === 'true',
                });
            }
        },
    },
    computed: {
        ...mapGetters({
            'filter': 'getFilter',
        }),
    },
    components: {
        CarsFilter,
        VueCookies,
    }
}
</script>

<style lang="scss" scoped>
    .cars-content {
        background: #fff;
        padding: 10px;
    }
</style>
