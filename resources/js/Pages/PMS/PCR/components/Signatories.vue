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
        employeeType: "",
        pcrType: "",
        immediateSupervisor: {},
        departmentHead: {},
        headOfAgency: {},
      },
      formInputs: {
        employeeTypes: ["lgu", "nga"],
        pcrTypes: ["ipcr", "spcr", "division", "dpcr"],
      },
    };
  },
  watch: {
    "formData.pcrType"(newValue, oldValue) {
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
    submitForm() {
      console.log(this.formData);
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
            v-for="(type, e) in formInputs.employeeTypes"
            :key="e"
            class="form-check"
          >
            <input
              class="form-check-input"
              type="radio"
              name="employeeTypes"
              :id="type"
              :value="type"
              v-model="formData.employeeType"
            />
            <label class="form-check-label" :for="type">
              {{ `${type.toUpperCase()} Employee` }}
            </label>
          </div>
        </div>

        <label class="form-label">PCR Type:</label>
        <div
          v-for="(pcrType, e) in formInputs.pcrTypes"
          :key="e"
          class="form-check"
        >
          <input
            class="form-check-input"
            type="radio"
            name="pcrTypes"
            :id="pcrType"
            :value="pcrType"
            v-model="formData.pcrType"
          />
          <label class="form-check-label" :for="pcrType">
            {{ pcrType.toUpperCase() }}
          </label>
        </div>

        <ImmediateSupervisorPicker
          v-if="formData.pcrType !== 'dpcr'"
          class="mt-2"
          label="Immediate Supervisor"
          @pickedEmployee="setImmediateSupervisor($event)"
        >

        </ImmediateSupervisorPicker>

        <DepartmentHeadPicker
          v-if="formData.pcrType !== 'dpcr'"
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
