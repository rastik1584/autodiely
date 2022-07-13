<template>
    <div class="cars-filter">
        <h5>Filter</h5>
        <div class="row">
            <div class="col-sm-3 form-group">
                <label for="name">Názov auta</label>
                <input v-model="filter.name" class="form-control" placeholder="Názov auta" id="name">
            </div>
            <div class="col-sm-3">
                <label for="registration">Registračné číslo auta</label>
                <input v-model="filter.registrationNumber" class="form-control" placeholder="Registračné číslo auta" id="registration">
            </div>
            <div class="col-sm-3 register-car">
                <label>Registrované auto</label>
                <toggle-button v-model="filter.is_registered" :labels="{checked: 'Áno', unchecked: 'Nie'}"></toggle-button>
            </div>
            <div class="col-sm-3 filter-buttons">
                <button class="btn btn-sm btn-primary" @click.prevent="setCarFilterData">Filtrovať</button>
                <button class="btn btn-sm btn-warning" @click.prevent="resetFilter" v-if="isSetFilter">Reset filtra</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
import { ToggleButton } from 'vue-js-toggle-button';

export default {
    name: "CarsFilter",
    data() {
        return {
            isSetFilter: false,
        }
    },
    created() {
        this.checkCarFilter()
    },
    methods: {
        ...mapMutations([
            'setFilter'
        ]),
        resetFilter() {
            this.$router.push({query: ''});
            this.isSetFilter = false;
            this.setFilter({
                name: '',
                registrationNumber: '',
                is_registered: false,
            });
            this.$emit('allCars');
        },
        setCarFilterData() {
            const path = `/cars?name=${this.filter.name}&registrationNumber=${this.filter.registrationNumber}&is_registered=${this.filter.is_registered}`
            if(this.$route.fullPath !== path) {
                this.$router.push({query: this.filter})
                this.setFilter(this.filter);
                this.$emit('allCars')
            }
        },
        checkCarFilter() {
            const query = this.$route.query
            if(query.name || query.registrationNumber || query.is_registered) {
                this.isSetFilter = true;
            }
        },
    },
    computed: {
        ...mapGetters({
            'filter': 'getFilter'
        }),
    },
    watch: {
        '$route.query': function () {
            this.checkCarFilter()
        }
    },
    components: {
        ToggleButton,
    }
}
</script>

<style lang="scss" scoped>
    label {
        font-weight: bold;
        margin-bottom: 0;
    }
    .register-car {
        display: flex;
        align-items: center;
        label {
            margin-right: 10px;
        }
    }
    .filter-buttons {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }
</style>
