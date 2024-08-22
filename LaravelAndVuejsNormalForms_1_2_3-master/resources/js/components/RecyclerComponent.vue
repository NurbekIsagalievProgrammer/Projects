<template>
    <div class="container m-2">
        <div class="d-flex flex-row-reverse">
            <button class="btn btn-sm btn-success" @click="showModal('create')"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">№.</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Системный идентификатор</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Серийный номер</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Дата изменения</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(recycler, key) of recyclers" :key="key">
                            <td>{{ recycler.id }}</td>
                            <td>{{ recycler.status }}</td>
                            <td>{{ recycler.system_id }}</td>
                            <td>{{ recycler.address }}</td>
                            <td>{{ recycler.serial_number }}</td>
                            <td>{{ recycler.created_at }}</td>
                            <td>{{ recycler.updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        @click="showModal('edit', recycler)"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        @click="showModal('delete', recycler)"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel"> Создать банкомат </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div class="form-group">
                        <label for="createStatus">Статус</label>
                        <select class="form-control" id="createStatus" aria-describedby="createStatusHelp"
                            v-model="newObject.status">
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                        <small id="createStatusHelp" class="form-text text-muted">Статус банкомата</small>
                    </div>
                    <div class="form-group">
                        <label for="createSystem_id">Системный идентификатор</label>
                        <input type="text" class="form-control" id="createSystem_id" aria-describedby="createSystem_idHelp"
                            placeholder="Введите системный  идентификатор банкомата..." v-model="newObject.system_id">
                        <small id="createSystem_idHelp" class="form-text text-muted">Системный идентификатор
                            банкомата</small>
                    </div>
                    <div class="form-group">
                        <label for="createAddress">Адрес банкомата</label>
                        <textarea class="form-control" id="createAddress" rows="3" v-model="newObject.address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="createSerial_number">Серийный номер</label>
                        <input type="text" class="form-control" id="createSerial_number"
                            aria-describedby="createSerial_numberHelp" placeholder="Введите серийный  номер банкомата..."
                            v-model="newObject.serial_number">
                        <small id="createSerial_numberHelp" class="form-text text-muted">Серийный номер банкомата</small>
                    </div>
                </form>
            </MDBModalBody>
            <MDBModalFooter>
                <MDBBtn color="secondary" @click="showModal('create')">Отмена</MDBBtn>
                <MDBBtn color="primary" @click="save('create')">Сохранить</MDBBtn>
            </MDBModalFooter>
        </MDBModal>
        <MDBModal id="editModal" tabindex="-1" labelledby="editModalLabel" v-model="editModal">
            <MDBModalHeader>
                <MDBModalTitle id="editModalLabel"> Изменить банкомат </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div class="form-group">
                        <label for="editStatus">Статус</label>
                        <select class="form-control" id="createStatus" aria-describedby="createStatusHelp"
                            v-model="editObject.status">
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editSystem_id">Системный идентификатор</label>
                        <input type="text" class="form-control" id="editSystem_id" aria-describedby="editSystem_idHelp"
                            placeholder="Введите системный идентификатор банкомата..." v-model="editObject.system_id">
                        <small id="editSystem_idHelp" class="form-text text-muted">Системный идентификатор банкомата</small>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Адрес банкомата</label>
                        <textarea class="form-control" id="editAddress" rows="3" v-model="editObject.address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editSerial_number">Серийный номер</label>
                        <input type="text" class="form-control" id="editSerial_number"
                            aria-describedby="editSerial_numberHelp" placeholder="Введите серийный номер банкомата..."
                            v-model="editObject.serial_number">
                        <small id="editSerial_numberHelp" class="form-text text-muted">Серийный номер банкомата</small>
                    </div>
                </form>
            </MDBModalBody>
            <MDBModalFooter>
                <MDBBtn color="secondary" @click="showModal('edit')">Отмена</MDBBtn>
                <MDBBtn color="primary" @click="save('edit')">Сохранить</MDBBtn>
            </MDBModalFooter>
        </MDBModal>
    </div>
</template>

<script>
import {
    MDBModal,
    MDBModalHeader,
    MDBModalTitle,
    MDBModalBody,
    MDBModalFooter,
    MDBBtn,
} from 'mdb-vue-ui-kit';
import axios from 'axios';
export default {
    components: {
        MDBModal,
        MDBModalHeader,
        MDBModalTitle,
        MDBModalBody,
        MDBModalFooter,
        MDBBtn,
    },
    data() {
        return {
            recyclers: [],
            createModal: false,
            editModal: false,
            newObject: {
                status: 0,
                system_id: null,
                address: null,
                serial_number: null
            },
            editObject: {}
        };
    },
    mounted() {
        let vue = this;
        axios.get('/api/getAll')
            .then(function (response) {
                if (response.data.status) {
                    vue.recyclers = response.data.recyclers;
                }
            });
    },

    methods: {
        showModal: function (modal, recycler = null) {
            if (modal == 'create') {
        this.createModal = !this.createModal;
    } else if (modal == 'edit') {
        if (recycler != null) {
            // Создание глубокой копий объекта recycler
            this.editObject = JSON.parse(JSON.stringify(recycler));
        }
        this.editModal = !this.editModal;
    } else if (modal == 'delete') {
                if (recycler != null) {
            const shouldDelete = confirm(`Вы действительно хотите удалить этот банкомат ID=${recycler.id}?`);
            if (shouldDelete) {
                const idToDelete = recycler.id; // Получаем id банкомата для удаления
                let vue = this;
                // Отправляем запрос на сервер для удаления банкомата
                axios.post('/api/delete', { id: idToDelete })
                    .then(function (response) {
                        if (response.data.status) {
                            // Обновляем данные на клиентской стороне после успешного удаления
                            vue.recyclers = response.data.recyclers;
                        } else {
                            console.error('Ошибка при удалении банкомата.');
                        }
                    })
                    .catch(error => {
                        console.error('Произошла ошибка при удалении банкомата:', error);
                    });
            }
        }
            }
        },

        save: function (modal) {
            let vue = this;
            if (modal == 'create') {
                axios.post('/api/create', vue.newObject)
                    .then(function (response) {
                        if (response.data.status) {
                            vue.recyclers = response.data.recyclers;
                            vue.newObject = {
                                status: 0,
                                system_id: null,
                                address: null,
                                serial_number: null
                            };
                            vue.showModal(modal);
                        } else {
                            console.log(response);
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
            } else if (modal == 'edit') {
                axios.post('/api/edit', vue.editObject)
                    .then(function (response) {
                        if (response.data.status) {
                            vue.recyclers = response.data.recyclers;
                            vue.showModal(modal);
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        },
    }
}

</script>