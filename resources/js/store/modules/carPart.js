import api from '../../api/carPart';

export default {
    state: {
        filter: {
            name: '',
            serial_number: '',
            car: ''
        }
    },
    getters: {
        getPartFilter: state => {
            return state.filter;
        }
    },
    actions: {
        getCarParts({commit, state}, filters) {
            return api.getCarParts(filters).then(data => {
                return data.data;
            });
        },
        getCarPart({commit}, carPart) {
            return api.getCarPart(carPart).then(data => {
                return data.data;
            });
        },
        saveCarPart({commit}, carPart) {
            if(carPart.id) {
                return api.updateCarPart(carPart).then(data => {
                    return data.data;
                });
            } else {
                return api.storeCarPart(carPart).then(data => {
                    return data.data;
                });
            }
        },
        removeCarPart({commit}, carPart) {
            return api.removeCarPart(carPart).then(data => {
                return data.data;
            })
        }
    },
    mutations: {
        setFilter(state, data) {
            state.filter = data;
        }
    }
}
