<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  props: {
    label: String,
  },
  data() {
    return {
      employees: [],
      employeeSearch: "",
      employeeSearchFocused: false,
      employeeSearchResults: [],
      employeePicked: {},
    };
  },
  methods: {
    getEmployees() {
      axios
        .post("/employees", {
          excepts: [],
        })
        .then(({ data }) => {
          this.employees = data;
          // console.log(data);
        })
        .catch((err) => {
          console.error(err);
        });
    },
    searchEmployee() {
      this.employeeSearchResults = [];
      this.employees.forEach((employee) => {
        if (employee.full_name.match(this.employeeSearch.toUpperCase())) {
          this.employeeSearchResults.push(employee);
        } //else this.employeeSearchResults = []
      });
    },
    selectEmployee(employee) {
      this.$emit("pickedEmployee", employee);
      // console.log(employee);
      this.employeePicked = employee;
      this.employeeSearch = employee.full_name;
      this.employeeSearchFocused = false;
      this.employeeSearchResults = [];
    },
  },
  computed: {
    isFocused() {
      if (this.employeeSearch.length > 0 || this.employeeSearchFocused) {
        return true;
      }
      return false;
    },
    nothingFound() {
      return this.employeeSearch.length > 0 &&
        this.employeeSearchResults.length == 0 &&
        this.employeeSearchFocused
        ? true
        : false;
    },
  },
  mounted() {
    this.getEmployees();
  },
};
</script>

<template>
  <div>
    <div class="dropdown" style="width: 100%">
      <label for="nameSearchInput" class="form-label">{{ label }}:</label>
      <input
        id="nameSearchInput"
        type="text"
        class="form-control"
        placeholder="Enter name here..."
        v-model="employeeSearch"
        @keydown="searchEmployee()"
        @focus="employeeSearchFocused = true"
        @focusout="employeeSearchFocused = false"
      />

      <div class="list-group" v-if="nothingFound">
        <button
          type="button"
          class="list-group-item list-group-item-action disabled"
        >
          Nothing found
        </button>
      </div>

      <div v-if="isFocused">
        <div
          class="list-group dropdown-content"
          style="width: 100%; overflow: auto; max-height: 200px"
        >
          <button
            type="button"
            v-for="(employee, i) in employeeSearchResults"
            :key="i"
            class="list-group-item list-group-item-action"
            @click="selectEmployee(employee)"
          >
            {{ employee.full_name }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.dropdowns {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-contents {
  /* display: none; */
  position: absolute;
  background-color: #f1f1f100;
  /* min-width: 160px; */
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  /* z-index: 1; */
}
</style>