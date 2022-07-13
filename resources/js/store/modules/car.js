import api from '../../api/car';

export default {
    state: {
        filter: {
            name: '',
            registrationNumber: '',
            is_registered: false,
        },
    },
    getters: {
        getFilter: state => {
            return state.filter;
        }
    },
    actions: {
        getCars({commit, getters}, filters) {
            return api.getCars(filters).then(data => {
                return data.data;
            })
        },
        getCar({commit}, car) {
            return api.getCar(car).then(data => {
                return data.data;
            });
        },
        saveCar({commit}, car) {
            if(car.id) {
                return api.updateCar(car).then(data => {
                    return data.data;
                });
            } else {
                return api.storeCar(car).then(data => {
                    return data.data;
                })
            }
        },
        deleteCar({commit}, car) {
            return api.removeCar(car).then(data => {
                return data.data;
            });
        }
    },
    mutations: {
        setFilter(state, data) {
            state.filter = data;
        }
    },
}
