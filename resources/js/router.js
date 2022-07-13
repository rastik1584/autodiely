import Vue from 'vue'
import VueRouter from 'vue-router'
import Cars from "./components/Cars/Cars";
import CarPart from "./components/CarParts/CarPart";
import CarsForm from "./components/Cars/CarsForm";
import CarPartForm from "./components/CarParts/CarPartForm";

Vue.use(VueRouter);
export default new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'Autá',
            path: '/cars',
            component: Cars,
        },
        {
            name: 'Cars form',
            path: '/cars/form/:id?',
            component: CarsForm,
        },
        {
            name: 'Autodiely',
            path: '/car-parts',
            component: CarPart,
        },
        {
            name: 'Car part form',
            path: '/car-parts/form/:id?',
            component: CarPartForm,
        }
    ],
});
