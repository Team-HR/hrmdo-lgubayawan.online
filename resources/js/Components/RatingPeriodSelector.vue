

<template>
  <div>
    <div class="text-center m-5">
      <h1><i :class="icon" class="me-2"></i> {{ "SELECT SEMESTER" }}</h1>
    </div>
    <table
      class="table table-sm table-bordered text-center mx-auto"
      style="width: 800px"
    >
      <thead>
        <tr>
          <th scope="col">
            1st Period <br />
            <!-- January - June -->
          </th>
          <th scope="col">
            2nd Period <br />
            <!-- July - December -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(period, p) in periods" :key="p">
          <td>
            <Link
              :href="routeName + period.first.id"
              class="btn px-5"
              :class="period.first.is_current == 1 ? 'text-success' : ''"
            >
              <i class="fa-solid fa-folder me-2"></i> January - June,
              {{ period.year }}
            </Link>
          </td>
          <td>
            <Link
              :href="routeName + period.second.id"
              class="btn px-5"
              :class="period.second.is_current == 1 ? 'text-success' : ''"
            >
              <i class="fa-solid fa-folder me-2"></i> July - December,
              {{ period.year }}
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  name: "PeriodSelector",
  components: {
    Link,
  },
  props: {
    title: String,
    routeName: String,
    icon: String,
  },
  data() {
    return {
      periods: [],
    };
  },
  methods: {
    async getPeriods() {
      await axios({
        method: "get",
        url: "/getRatingPeriods",
      }).then(({ data }) => {
        console.log(data);
        this.periods = data;
      });
    },
  },
  mounted() {
    this.getPeriods();
  },
};
</script>
