<template>
  <div class="container m-2">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <!-- Фильтр и поиск по параметрам -->
        <div class="mb-3">
          <h5>Фильтр и поиск по параметрам:</h5>
          <!-- Поля для фильтрации -->
          <div class="input-group mb-3">
            <span class="input-group-text">Период или конкретная  дата(от или до):</span>
            <input type="date" class="form-control" v-model="filter.startDate">
            <span class="input-group-text">-</span>
            <input type="date" class="form-control" v-model="filter.endDate">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Сумма:</span>
            <input type="text" class="form-control" v-model="filter.amount">
          </div>
          <!-- Отображение списка отфильтрованных транзакций -->
          <div class="input-group mb-3">
            <label class="input-group-text" for="transactionType">Тип:</label>
            <select class="form-select" id="transactionType" v-model="filter.type">
              <option value="" selected>Все типы</option>
              <option value="income">Доход</option>
              <option value="expense">Расход</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Детали:</span>
            <input type="text" class="form-control" v-model="filter.details">
          </div>
        </div>
        <!-- Отображение списка транзакций -->
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Дата</th>
              <th scope="col">Сумма</th>
              <th scope="col">Тип</th>
              <th scope="col">Детали</th>
              <th scope="col">Посмотреть</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(transaction, key) in filteredTransactions" :key="key" :class="{ 'table-primary': isDateInRange(transaction.date) && (filter.startDate || filter.endDate) }">

              <td>{{ transaction.id }}</td>
              <td>{{ transaction.date }}</td>
              <td>{{ transaction.amount }}</td>
              <td>{{ transaction.type }}</td>
              <td>{{ transaction.details }}</td>
              <td>
                <button type="button" class="btn btn-sm btn-primary" @click="showModal('view', transaction)">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <MDBModal id="viewModal" tabindex="-1" labelledby="viewModalLabel" v-model="viewModal">
          <MDBModalHeader>
            <MDBModalTitle id="viewModalLabel">Просмотр транзакции</MDBModalTitle>
          </MDBModalHeader>
          <MDBModalBody>
            <!-- Отображение данных о выбранной транзакции -->
            <div v-if="selectedTransaction">
              <p><strong>Id:</strong> {{ selectedTransaction.id }}</p>
              <p><strong>Дата:</strong> {{ selectedTransaction.date }}</p>
              <p><strong>Сумма:</strong> {{ selectedTransaction.amount }}</p>
              <p><strong>Тип:</strong> {{ selectedTransaction.type }}</p>
              <p><strong>Детали:</strong> {{ selectedTransaction.details }}</p>
            </div>
          </MDBModalBody>
          <MDBModalFooter>
            <MDBBtn color="secondary" @click="viewModal = false">Закрыть</MDBBtn>
          </MDBModalFooter>
        </MDBModal>
      </div>
    </div>
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
      transactions: [],
      filter: {
        startDate: null,
        endDate: null,
        amount: null,
        type: '',
        details: ''
      },
      viewModal: false,
      selectedTransaction: null
    };
  },
  computed: {
    filteredTransactions() {
      let filtered = this.transactions.filter(transaction => {
      let filterByDate = true;
      if (this.filter.startDate && this.filter.endDate) {
        const startDate = new Date(this.filter.startDate);
        const endDate = new Date(this.filter.endDate);
        const transactionDate = new Date(transaction.date);
        startDate.setHours(0, 0, 0); // Устанавливаем начало дня
        endDate.setHours(23, 59, 59); // Устанавливаем конец дня
        filterByDate = transactionDate >= startDate && transactionDate <= endDate;
      } else if (this.filter.startDate) {
        const startDate = new Date(this.filter.startDate);
        startDate.setHours(0, 0, 0); // Устанавливаем начало дня
        const transactionDate = new Date(transaction.date);
        filterByDate = transactionDate >= startDate;
      } else if (this.filter.endDate) {
        const endDate = new Date(this.filter.endDate);
        endDate.setHours(23, 59, 59); // Устанавливаем конец дня
        const transactionDate = new Date(transaction.date);
        filterByDate = transactionDate <= endDate;
      }
      return filterByDate;
    });

    // Фильтрация по сумме
    if (this.filter.amount) {
      filtered = filtered.filter(transaction => {
        return transaction.amount.toString().startsWith(this.filter.amount);
      });
    }

    // Фильтрация по типу
    if (this.filter.type) {
      filtered = filtered.filter(transaction => {
        return transaction.type === this.filter.type;
      });
    }

    // Фильтрация по деталям
    if (this.filter.details) {
      filtered = filtered.filter(transaction => {
        return transaction.details.includes(this.filter.details);
      });
    }

    return filtered;
    }
  },
  methods: {
    isDateInRange(date) {
      const transactionDate = new Date(date);

  if (this.filter.startDate && this.filter.endDate) {
    const startDate = new Date(this.filter.startDate);
    const endDate = new Date(this.filter.endDate);
    startDate.setHours(0, 0, 0); // Устанавливаем начало дня
    endDate.setHours(23, 59, 59); // Устанавливаем конец дня
    return transactionDate >= startDate && transactionDate <= endDate;
  } else if (this.filter.startDate) {
    const startDate = new Date(this.filter.startDate);
    startDate.setHours(0, 0, 0); // Устанавливаем начало дня
    return transactionDate >= startDate;
  } else if (this.filter.endDate) {
    const endDate = new Date(this.filter.endDate);
    endDate.setHours(23, 59, 59); // Устанавливаем конец дня
    return transactionDate <= endDate;
  }
  return true;
  },
    showModal(action, transaction) {
      if (action === 'view') {
        this.selectedTransaction = transaction;
        this.viewModal = true;
      }
    }
  },
  mounted() {
    axios.get('/api/getAll')
      .then(response => {
        this.transactions = response.data.transactions;
      })
      .catch(error => {
        console.error('Ошибка при загрузке транзакций:', error);
      });
  }
};
</script>