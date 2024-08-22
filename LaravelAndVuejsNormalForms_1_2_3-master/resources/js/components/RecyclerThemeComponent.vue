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
              <th scope="col">Заголовок темы</th>
              <th scope="col">Описание</th>
              <th scope="col">Дата создания</th>
              <th scope="col">Дата изменения</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(recyclerTheme, key) of recyclerThemes" :key="key">
              <td>{{ recyclerTheme.id }}</td>
              <td>{{ recyclerTheme.title }}</td>
              <td>{{ recyclerTheme.description }}</td>
              <td>{{ recyclerTheme.created_at }}</td>
              <td>{{ recyclerTheme.updated_at }}</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-primary" @click="showModal('edit', recyclerTheme)"><i
                      class="fa-solid fa-pen-to-square"></i></button>
                  <button type="button" class="btn btn-sm btn-danger" @click="showModal('delete', recyclerTheme)"><i
                      class="fa-solid fa-trash"></i></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
      <MDBModalHeader>
        <MDBModalTitle id="createModalLabel"> Создать тему </MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="createTitle">Заголовок</label>
            <input type="text" class="form-control" id="createTitle" aria-describedby="createTitleHelp"
              placeholder="Введите заголовок темы..." v-model="newObject.title">
            <small id="createTitleHelp" class="form-text text-muted">Заголовок темы</small>
          </div>
          <div class="form-group">
            <label for="createDescription">Описание</label>
            <textarea class="form-control" id="createDescription" rows="3" v-model="newObject.description"></textarea>
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
        <MDBModalTitle id="editModalLabel"> Изменить тему </MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="editTitle">Заголовок</label>
            <input type="text" class="form-control" id="editTitle" aria-describedby="editTitleHelp"
              placeholder="Введите заголовок темы..." v-model="editObject.title">
            <small id="editTitleHelp" class="form-text text-muted">Заголовок темы</small>
          </div>
          <div class="form-group">
            <label for="editDescription">Описание</label>
            <textarea class="form-control" id="editDescription" rows="3" v-model="editObject.description"></textarea>
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
      recyclerThemes: [],
      createModal: false,
      editModal: false,
      newObject: {
        title: null,
        description: null,
      },
      editObject: {},
    };
  },
  mounted() {
    let vue = this;
    axios.get('/api/getAllTheme')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerThemes = response.data.recyclerThemes;
        }
      });

  },
  methods: {
    showModal: function (modal, recyclerTheme = null) {
      if (modal == 'create') {
        this.createModal = !this.createModal;
      } else if (modal == 'edit') {
        if (recyclerTheme != null) {
          // Создание глубокой копий объекта recyclerTheme
          this.editObject = JSON.parse(JSON.stringify(recyclerTheme));
        }
        this.editModal = !this.editModal;
      } else if (modal == 'delete') {
        if (recyclerTheme != null) {
          const shouldDelete = confirm(`Вы действительно хотите удалить эту тему ID=${recyclerTheme.id}?`);
          if (shouldDelete) {
            const idToDelete = recyclerTheme.id;
            let vue = this;
            axios.post('/api/deleteTheme', { id: idToDelete })
              .then((response) => {
                if (response.data.status) {
                  // Обновляем данные только после успешного удаления
                  vue.recyclerThemes = response.data.recyclerThemes;
                } else {
                  console.error('Ошибка при удалении темы.');
                }
              })
              .catch((error) => {
                console.error('Произошла ошибка при удалении темы:', error);
              });
          }
        }
      }
    },
    save: function (modal) {
      let vue = this;
      if (modal == 'create') {
        axios.post('/api/createTheme', vue.newObject)
          .then(function (response) {
            if (response.data.status) {
              vue.recyclerThemes = response.data.recyclerThemes;
              vue.newObject = {
                title: null,
                description: null,
              };
              vue.showModal(modal);
            } else {
              console.log(response);
            }
          }).catch(function (error) {
            console.log(error);
          });
      } else if (modal == 'edit') {
        axios.post('/api/editTheme', vue.editObject)
          .then(function (response) {
            if (response.data.status) {
              vue.recyclerThemes = response.data.recyclerThemes;
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
  },
};
</script>


  