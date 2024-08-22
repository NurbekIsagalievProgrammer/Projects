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
              <th scope="col">Статус</th>
              <th scope="col">АТМ</th>
              <th scope="col">Тематика</th>
              <th scope="col">Решение</th>
              <th scope="col">Дата создания</th>
              <th scope="col">Дата изменения</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(recyclerRequest, key) in recyclerRequests" :key="key">
              <td>{{ recyclerRequest.id }}</td>
              <td>{{ getRecyclerStatus(recyclerRequest.status) }}</td>
              <td>{{ getRecyclerSerialNumberById(recyclerRequest.recycler_id) }}</td>
              <td>{{ getRecyclerThemeTitleById(recyclerRequest.theme_id) }}</td>
              <td>{{ getRecyclerSolutionTitleById(recyclerRequest.solution_id) }}</td>
              <td>{{ recyclerRequest.created_at }}</td>
              <td>{{ recyclerRequest.updated_at }}</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button v-if="recyclerRequest.status !== 2 || recyclerRequest.status === 1" type="button"
                    class="btn btn-sm btn-primary"
                    @click="recyclerRequest.status === 1 ? openSolutionModal(recyclerRequest) : changeStatus('in_progress', recyclerRequest)">
                    {{ recyclerRequest.status === 1 ? 'Закрыть' : 'Открыть' }}
                  </button>
                  <button v-if="recyclerRequest.status === 1" type="button" class="btn btn-sm btn-danger"
                    @click="changeStatus('canceled', recyclerRequest)">
                    Отменить
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Модальное окно для создания  запроса -->
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
      <MDBModalHeader>
        <MDBModalTitle id="createModalLabel">Создать запрос</MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="createATM">АТМ</label>
            <select class="form-control" id="createATM" v-model="newRequest.recycler_id">
              <option value="" disabled selected>Выберите АТМ</option>
              <option v-for="recycler in recyclerSerialNumbers" :value="recycler.id">{{ recycler.serial_number }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="createSubjects">Тематика</label>
            <select class="form-control" id="createSubjects" v-model="newRequest.theme_id">
              <option value="" disabled selected>Выберите тематику</option>
              <option v-for="theme in recyclerThemeTitles" :value="theme.id">{{ theme.title }}</option>
            </select>
          </div>
        </form>
      </MDBModalBody>
      <MDBModalFooter>
        <MDBBtn color="secondary" @click="showModal('create')">Отмена</MDBBtn>
        <MDBBtn color="primary" @click="save('create')">Сохранить</MDBBtn>
      </MDBModalFooter>
    </MDBModal>
    <!-- Модальное окно для выбора Решения -->
    <MDBModal id="solutionModal" tabindex="-1" labelledby="solutionModalLabel" v-model="solutionModal">
      <MDBModalHeader>
        <MDBModalTitle id="solutionModalLabel">Выбрать Решение</MDBModalTitle>
      </MDBModalHeader>
      <MDBModalBody>
        <form>
          <div class="form-group">
            <label for="selectSolution">Выберите Решение</label>
            <select class="form-control" id="selectSolution" v-model="newRequest.solution_id">
              <option v-for="solution in recyclerSolutionTitles" :value="solution.id">{{ solution.title }}</option>
            </select>
          </div>
        </form>
      </MDBModalBody>
      <MDBModalFooter>
        <MDBBtn color="primary" @click="saveSolution()">Сохранить</MDBBtn>
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
      recyclerRequests: [],
      recyclerSerialNumbers: [],
      recyclerThemeTitles: [],
      recyclerSolutionTitles: [],
      createModal: false,
      solutionModal: false,
      newRequest: {
        recycler_id: 0,
        theme_id: 0,
        solution_id: null,
      },
      currentRequestId: null,
    };
  },
  mounted() {
    let vue = this;
    axios.get('/api/getAllRequest')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerRequests = response.data.recyclerRequests;

        }
      });
    axios.get('/api/getAllRecyclerSerialNumber')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerSerialNumbers = response.data.serialNumbers;
        }
      });
    axios.get('/api/getAllRecyclerThemeTitle')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerThemeTitles = response.data.titles;
        }
      });
    axios.get('/api/getAllRecyclerSolutionTitle')
      .then(function (response) {
        if (response.data.status) {
          vue.recyclerSolutionTitles = response.data.titles;
        }
      });

  },
  methods: {

    openSolutionModal(recyclerRequest) {
      this.currentRequestId = recyclerRequest.id;
      if (recyclerRequest.status === 1) {
        this.newRequest.solution_id = recyclerRequest.solution_id;
        this.solutionModal = true;
      }
    },

    saveSolution() {

      let vue = this;

      const requestData = {
        id: vue.currentRequestId,
        solution_id: vue.newRequest.solution_id,
        status: 2,
      };

      axios.post('/api/updateRequest', requestData)
        .then((response) => {
          vue.recyclerRequests = response.data.recyclerRequests;
          vue.solutionModal = false;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    showModal: function (modal) {
      if (modal == 'create') {
        this.createModal = !this.createModal;
      }
    },

    save: function (modal) {
      let vue = this;
      if (modal === 'create') {
        axios.post('/api/createRequest', vue.newRequest)
          .then(function (response) {
            if (response.data.status) {
              vue.recyclerRequests = response.data.recyclerRequests;
              vue.newRequest = {
                recycler_id: 0,
                theme_id: 0,
                solution_id: null,
              };
              vue.showModal(modal);
            } else {
              console.log(response);
            }
          }).catch(function (error) {
            console.log(error);
          });
      }
    },

    getRecyclerStatus(status) {

      const statusLabels = {
        1: 'В работе',
        2: 'Закрыто',
        3: 'Отменено',
      };

      return statusLabels[status] || 'Открыто';
    },

    getRecyclerSerialNumberById(id) {
      const recycler = this.recyclerSerialNumbers.find(item => item.id === id);
      return recycler ? recycler.serial_number : '';
    },

    getRecyclerThemeTitleById(id) {
      const theme = this.recyclerThemeTitles.find(item => item.id === id);
      return theme ? theme.title : '';
    },

    getRecyclerSolutionTitleById(id) {
      const solution = this.recyclerSolutionTitles.find(item => item.id === id);
      return solution ? solution.title : '';
    },

    saveChanges(recyclerRequest) {

      let vue = this;

      axios.post('/api/updateRequest', recyclerRequest)
        .then((response) => {
          if (response.data.status) {
            vue.recyclerRequests = response.data.recyclerRequests;
          }
        })
        .catch((error) => {
          console.error(error);
        });

    },

    changeStatus(action, recyclerRequest) {
      let vue = this;

      if ((action === 'in_progress' && recyclerRequest.status === 1) ||
        (action === 'canceled' && recyclerRequest.status === 3) ||
        (action === 'closed' && recyclerRequest.status === 2)) {
        return;
      }

      switch (action) {
        case 'in_progress':
          recyclerRequest.status = (recyclerRequest.status === 1) ? 3 : 1;
          vue.saveChanges(recyclerRequest);
          break;
        case 'canceled':
          recyclerRequest.status = 3;
          vue.saveChanges(recyclerRequest);
          break;
        case 'closed':
          vue.saveSolution();
          recyclerRequest.status = 2;
          vue.saveChanges(recyclerRequest);
          break;
        default:
          break;
      }
    }

  },
}
</script>  