<template>
    <div>
        <h5>Filter</h5>
        <div class="row car-part-filter">
            <div class="col-sm-3">
                <label for="name">Názov autodielu</label>
                <input v-model="filter.name" class="form-control" id="name">
            </div>
            <div class="col-sm-3">
                <label for="number">Sériové číslo</label>
                <input v-model="filter.serial_number" class="form-control" id="number">
            </div>
            <div class="col-sm-3">
                <label for="car">Auto</label>
                <select v-model="filter.car" id="car" class="form-control">
                    <option :value="car.id" v-for="car in cars.data" :key="car.id">{{ car.name }}</option>
                </select>
            </div>
            <div class="col-sm-3 filter-buttons">
                <button class="btn btn-sm btn-primary" @click.prevent="setFilterData">Filtrovať</button>
                <button class="btn btn-sm btn-warning" @click.prevent="resetFilter" v-if="isSetFilter">Reset filtra</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions, mapMutations} from "vuex";

export default {
    name: "CarPartFilter",
    data() {
        return {
            isSetFilter: false,
            cars: [],
        }
    },
    created() {
        this.checkFilter();
        this.getCars({}).then(data => {
            this.cars = data.cars;
        });
    },
    methods: {
        ...mapMutations([
            'setFilter',
        ]),
        ...mapActions([
            'getCars',
        ]),
        setFilterData() {
            const path = `/car-parts?name=${this.filter.name}&serial_number=${this.filter.serial_number}`
            if(this.$route.fullPath !== path) {
                this.setFilter(this.filter);
                this.isSetFilter = true;
                this.$router.push({query: this.filter});
                this.$emit('refreshParts');
            }

        },
        checkFilter() {
            const query = this.$route.query
            if(query.name || query.serial_number || query.car) {
                this.isSetFilter = true;
                this.setFilter({
                    name: query.name,
                    serial_number: query.serial_number,
                    car: query.car,
                });
            }
        },
        resetFilter() {
            this.$router.push({query: ''});
            this.isSetFilter = false;
            this.setFilter({
                name: '',
                serial_number: '',
                car: ''
            });
            this.$emit('refreshParts');
        }
    },
    computed: {
        ...mapGetters({
            'filter': 'getPartFilter',
        })
    },
    watch: {
        '$route.query': function () {
            this.checkFilter()
        }
    },
    components: {

    },
}
</script>

<style scoped>
.filter-buttons {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
label {
    font-weight: bold;
    margin-bottom: 0;
}
</style>
