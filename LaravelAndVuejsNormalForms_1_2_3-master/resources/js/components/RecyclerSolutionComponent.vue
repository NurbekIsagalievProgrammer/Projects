<template>
  <div class="container m-2">
    <div class="d-flex flex-row-reverse">
      <button class="btn btn-sm btn-success" @click="showModal('create')">
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">№.</th>
              <th scope="col">Заголовок темы</th>
              <th scope="col">Заголовок решения</th>
              <th scope="col">Дата создания</th>
              <th scope="col">Дата изменения</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(recyclerSolution, key) of recyclerSolutions" :key="key">
              <td>{{ recyclerSolution.id }}</td>
              <td>{{ getThemeTitle(recyclerSolution.theme_id) }}</td>
              <td>{{ recyclerSolution.title }}</td>
              <td>{{ recyclerSolution.created_at }}</td>
              <td>{{ recyclerSolution.updated_at }}</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-primary" @click="showModal('edit', recyclerSolution)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-danger" @click="showModal('delete', recyclerSolution)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
   
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
      <MDBModalHeader>
        <MDBModalTitle id="createModalLabel">Создать решение</MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="createTitle">Заголовок решения</label>
            <input type="text" class="form-control" id="createTitle" v-model="newObject.title">
          </div>
          <div class="form-group">
            <label for="createTheme">Заголовок темы</label>
            <select class="form-control" id="createTheme" v-model="newObject.theme_id">
              <option value="" disabled selected>Выберите тему</option>
              <option v-for="recyclerTheme in recyclerThemes" :value="recyclerTheme.id">{{ recyclerTheme.title }}</option>
            </select>
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
        <MDBModalTitle id="editModalLabel">Изменить решение</MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="createTitle">Заголовок решения</label>
            <input type="text" class="form-control" id="createTitle" v-model="editObject.title">
          </div>
          <div class="form-group">
            <label for="createTheme">Заголовок темы</label>
            <select class="form-control" id="createTheme" v-model="editObject.theme_id">
              <option value="" disabled selected>Выберите тему</option>
              <option v-for="recyclerTheme in recyclerThemes" :value="recyclerTheme.id">{{ recyclerTheme.title }}</option>
            </select>
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
      recyclerSolutions: [],
      recyclerThemes: [],
      createModal: false,
      editModal: false,
      newObject: {
        theme_id: 0,
        title: '',
      },
      editObject: {},
    };
  },
  mounted() {
    let vue = this;
    axios.get('/api/getAllSolution')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerSolutions = response.data.recyclerSolutions;
        }
      });
    axios.get('/api/getAllTheme')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerThemes = response.data.recyclerThemes;
        }

      });
 },
  methods: {
    showModal: function (modal, recyclerSolution = null) {
      if (modal == 'create') {
        this.createModal = !this.createModal;
      } else if (modal == 'edit') {
        if (recyclerSolution != null) {
          // Создание глубокой копий объекта recyclerSolution
          this.editObject = JSON.parse(JSON.stringify(recyclerSolution));
        }
        this.editModal = !this.editModal;
      } else if (modal == 'delete') {
        if (recyclerSolution != null) {
          const shouldDelete = confirm(`Вы действительно хотите удалить это решение ID=${recyclerSolution.id}?`);
          if (shouldDelete) {
            const idToDelete = recyclerSolution.id;
            let vue = this;
            axios.post('/api/deleteSolution', { id: idToDelete })
              .then((response) => {
                if (response.data.status) {
                  // Обновляем данные только после успешного удаления
                  vue.recyclerSolutions = response.data.recyclerSolutions;
                } else {
                  console.error('Ошибка при удалении решения.');
                }
              })
              .catch((error) => {
                console.error('Произошла ошибка при удалении решения:', error);
              });
          }
        }
      }
    },
    save: function (modal) {
      let vue = this;
      if (modal == 'create') {
        axios.post('/api/createSolution', vue.newObject)
          .then(function (response) {
            if (response.data.status) {
              vue.recyclerSolutions = response.data.recyclerSolutions;
              vue.newObject = {
                theme_id: 0,
                title: '',
              };
              vue.showModal(modal);
            } else {
              console.log(response);
            }
          }).catch(function (error) {
            console.log(error);
          });
      } else if (modal == 'edit') {
        axios.post('/api/editSolution', vue.editObject)
          .then(function (response) {
            if (response.data.status) {
              vue.recyclerSolutions = response.data.recyclerSolutions;
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
    getThemeTitle(themeId) {
    const theme = this.recyclerThemes.find((t) => t.id === themeId);
    return theme ? theme.title : 'Тема не найдена';
  },
  },
};
</script>
