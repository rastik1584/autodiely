<template>
    <div class="modal fade bd-example-modal-lg" ref="car-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Zobrazenie auta - {{ car.name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>Auto</h3>
                            <ul>
                                <li>Názov auta: {{ car.name }}</li>
                                <li>Registračné číslo: {{ car.registration_number ?? 'n/a' }}</li>
                                <li>Registrované: {{ car.is_registered ? 'Áno' : 'Nie' }}</li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h3>Autodiely</h3>
                            <table class="table" v-if="car.parts">
                                <thead>
                                    <tr>
                                        <th>Názov autodielu</th>
                                        <th>Sériové číslo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="part in car.parts.data" >
                                        <td>{{ part.name }}</td>
                                        <td>{{ part.serial_number }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" @click.prevent="closeModal">Zavrieť</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CarsModal",
    props: ['car', 'openModal'],
    methods: {
        closeModal() {
            this.$emit('closeModal');
            $(this.$refs['car-modal']).modal('hide');
        }
    },
    watch: {
        'openModal': function (val) {
            if(val) {
                $(this.$refs['car-modal']).modal('show');
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .modal-body {
        ul {
            list-style: none;
            padding-left: 0;
        }
    }
</style>
