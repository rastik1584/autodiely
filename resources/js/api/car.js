import axios from 'axios'

export default {
    getCars(filters) {
        return axios.get('/api/cars', {
            params: filters
        });
    },
    getCar(car) {
        return axios.get(`/api/cars/${car}/edit`)
    },
    storeCar(car) {
        return axios.post('/api/cars', { ...car });
    },
    updateCar(car) {
        return axios.put(`/api/cars/${car.id}`, { ...car })
    },
    removeCar(car) {
        return axios.delete(`/api/cars/${car.id}`);
    }
}
