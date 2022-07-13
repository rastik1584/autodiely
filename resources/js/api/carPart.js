import axios from "axios";

export default {
    getCarParts(filter) {
        return axios.get('/api/car-part', { params: filter});
    },
    getCarPart(carPart) {
        return axios.get(`/api/car-part/${carPart}/edit`);
    },
    storeCarPart(carPart) {
        return axios.post('/api/car-part', { ... carPart });
    },
    updateCarPart(carPart) {
        return axios.put(`/api/car-part/${carPart.id}`, { ...carPart });
    },
    removeCarPart(carPart) {
        return axios.delete(`api/car-part/${carPart.id}`);
    }

}
