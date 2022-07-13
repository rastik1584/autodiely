<template>
    <div>
        <div class="header-links">
            <h1>Autodiely</h1>
            <router-link class="btn btn-sm btn-primary" to="/car-parts/form">Pridať autodiel</router-link>
        </div>
        <div class="project-content">
            <car-part-filter @refreshParts="getAllParts" />
            <table class="table mt-3">
                <thead>
                <tr>
                    <th>Názov autodielu</th>
                    <th>Sériové číslo</th>
                    <th>Auto</th>
                    <th>Akcie</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="part in parts" :key="part.id">
                    <td>{{ part.name }}</td>
                    <td>{{ part.serial_number }}</td>
                    <td>{{ part.car_name }}</td>
                    <td class="actions">
                        <router-link :to="`/car-parts/form/${part.id}`" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></router-link>
                        <form @submit.prevent="removePart(part)">
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
import {mapGetters, mapActions, mapMutations} from "vuex";
import CarPartFilter from "./CarPartFilter";
import Swal from "sweetalert2";
import VueCookies from "vue-cookies";
import { library, dom } from "@fortawesome/fontawesome-svg-core";
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
dom.watch();

export default {
    name: "CarPart",
    data() {
        return {
            parts: [],
        }
    },
    created() {
        this.checkFilter();
        this.getAllParts();
        if($cookies.get('success_value')) {
            Swal.fire({
                title: 'Úspešne',
                icon: "success",
                text: $cookies.get('success_value'),
            });
            $cookies.remove('success_value');
        }
    },
    methods: {
        ...mapActions([
            "getCarParts",
            "removeCarPart",
        ]),
        ...mapMutations([
            "setFilter",
        ]),
        getAllParts() {
            const query = this.$route.query
            let filter = {};
            if(query.name || query.serial_number || query.car) {
                filter = this.getPartFilter;
            }
            this.getCarParts(filter).then(data => {
                this.parts = data.data;
            });
        },
        removePart(carPart) {
           Swal.fire({
               title: 'Naozaj si prajete zmazať autodiel ?',
               showCancelButton: true,
               confirmButtonText: 'Zmazať',
           }).then(res => {
               if(res.isConfirmed) {
                   this.removeCarPart(carPart).then(data => {
                       Swal.fire(data.message, '', "success");
                       this.getAllParts();
                   });
               }
           });
        },
        checkFilter() {
            const query = this.$route.query
            if(query.name || query.serial_number || query.car) {
                this.setFilter({
                    name: query.name,
                    serial_number: query.serial_number,
                    car: query.car,
                });
            }
        },
    },
    computed: {
        ...mapGetters([
            "getPartFilter"
        ]),
    },
    components: {
        CarPartFilter,
        VueCookies,

    },
}
</script>

<style lang="scss" scoped>

</style>
