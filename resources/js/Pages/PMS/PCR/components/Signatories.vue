<script>
import PerformanceCommitmentReport from "@/Pages/PMS/PCR/PerformanceCommitmentReport.vue";
import ImmediateSupervisorPicker from "@/Pages/PMS/PCR/components/EmployeePicker.vue";
import DepartmentHeadPicker from "@/Pages/PMS/PCR/components/EmployeePicker.vue";
import HeadOfAgencyPicker from "@/Pages/PMS/PCR/components/EmployeePicker.vue";

export default {
  props: {
    rating_period_id: Number,
  },
  data() {
    return {
      formData: {
        employee_type: "",
        form_type: "",
        immediateSupervisor: {},
        departmentHead: {},
        headOfAgency: {},
      },
      formInputs: {
        employee_types: ["lgu", "nga"],
        form_types: ["ipcr", "spcr", "division", "dpcr"],
      },
    };
  },
  watch: {
    "formData.form_type"(newValue, oldValue) {
      if (newValue == "dpcr") {
        this.formData.immediateSupervisor = {};
        this.formData.departmentHead = {};
      }
    },
  },
  components: {
    PerformanceCommitmentReport,
    ImmediateSupervisorPicker,
    DepartmentHeadPicker,
    HeadOfAgencyPicker,
  },
  methods: {
    async getSignatoryData() {
     await axios
        .get("/pms/pcr/signatories", {
          params: {
            rating_period_id: this.rating_period_id,
          },
        })
        .then(({ data }) => {
          console.log(data);
          this.formData.employee_type = data.employee_type
          this.formData.form_type = data.form_type
        })
        .catch((err) => {
          console.error(err);
        });
    },
    submitForm() {
      console.log(this.formData);
      axios.post('/pms/pcr/signatories/store',{
        rating_period_id: this.rating_period_id,
        form_data: this.formData
      })
      .then(res => {
        console.log(res)
      })
      .catch(err => {
        console.error(err); 
      })
    },
    setImmediateSupervisor(event) {
      console.log(event);
      this.formData.immediateSupervisor = event;
    },
    setDepartmentHead(event) {
      this.formData.departmentHead = event;
    },
    setHeadOfAgency(event) {
      this.formData.headOfAgency = event;
    },
  },
  mounted() {
    this.getSignatoryData()
  },
};
</script>

<template>
  <PerformanceCommitmentReport>
    <!-- SIGNATORIES HERE! rating_period_id:{{rating_period_id}} -->
    <div class="container">
      <form @submit.prevent="submitForm()" id="sigForm">
        <div class="mb-2">
          <label class="form-label">Employed as:</label>
          <div
            v-for="(type, e) in formInputs.employee_types"
            :key="e"
            class="form-check"
          >
            <input
              class="form-check-input"
              type="radio"
              name="employee_types"
              :id="type"
              :value="type"
              v-model="formData.employee_type"
            />
            <label class="form-check-label" :for="type">
              {{ `${type.toUpperCase()} Employee` }}
            </label>
          </div>
        </div>

        <label class="form-label">PCR Type:</label>
        <div
          v-for="(form_type, e) in formInputs.form_types"
          :key="e"
          class="form-check"
        >
          <input
            class="form-check-input"
            type="radio"
            name="form_types"
            :id="form_type"
            :value="form_type"
            v-model="formData.form_type"
          />
          <label class="form-check-label" :for="form_type">
            {{ form_type.toUpperCase() }}
          </label>
        </div>

        <ImmediateSupervisorPicker
          v-if="formData.form_type !== 'dpcr'"
          class="mt-2"
          label="Immediate Supervisor"
          @pickedEmployee="setImmediateSupervisor($event)"
        >
        </ImmediateSupervisorPicker>

        <DepartmentHeadPicker
          v-if="formData.form_type !== 'dpcr'"
          class="mt-2"
          label="Department Head"
          @pickedEmployee="setDepartmentHead($event)"
        >
        </DepartmentHeadPicker>

        <HeadOfAgencyPicker
          class="mt-2"
          label="Head of Agency"
          @pickedEmployee="setHeadOfAgency($event)"
        >
        </HeadOfAgencyPicker>

        <button class="btn btn-secondary mt-5" type="submit">Save</button>
      </form>
    </div>
  </PerformanceCommitmentReport>
</template>
