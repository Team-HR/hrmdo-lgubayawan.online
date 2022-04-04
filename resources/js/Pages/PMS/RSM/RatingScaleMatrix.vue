<template>
  <Head title="Rating Scale Matrix" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Rating Scale Matrix |
        <span v-if="rating_period.period == 1">January - June</span>
        <span v-else-if="rating_period.period == 2">July - December</span>
        {{ rating_period.year }}
      </h2>
    </template>

    <div class="py-12">
      <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
      <div>
        <div class="bg-white _overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- content start -->
            <SuccessIndicatorEditor
              id="successIndicatorEditor"
              :success_indicator_id="edit_success_indicator_id"
              :rating_scale_matrix_id="edit_rating_scale_matrix_id"
              @submittedForm="getItems()"
            />
            <DeleteConfirmation
              id="deleteConfirmation"
              :text="'the item'"
              :success_indicator_id="edit_success_indicator_id"
              :rating_scale_matrix_id="edit_rating_scale_matrix_id"
              @deleteConfirmed="getItems()"
            />
            <MfoEditor
              id="mfoEditor"
              :mfo="edit_mfo_item"
              @addedSubFunction="getItems()"
            />
            <MfoParentEditor id="mfoParentEditor" @transferedMfo="getItems()" />
            <!-- 
    Edit MFO start
   -->
            <div
              class="modal fade"
              data-bs-backdrop="static"
              data-bs-keyboard="false"
              id="editMfoModal"
              tabindex="-1"
            >
              <form
                id="form_edit_mfo"
                @submit.prevent="save_edit_mfo()"
                class="modal-dialog modal-lg"
              >
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- {{edit_mfo_item.code +" "+edit_mfo_item.function}} -->
                    <h5 class="modal-title">Edit MFO/PAP</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-2">
                      <div class="col-3">
                        <div class="form-floating">
                          <input
                            type="text"
                            class="form-control"
                            id="category_number"
                            placeholder="Category Number"
                            v-model="edit_mfo_item.code"
                          />
                          <label for="category_number">Category Number:</label>
                        </div>
                      </div>
                      <div class="col-9">
                        <div class="form-floating">
                          <input
                            type="text"
                            class="form-control"
                            id="mfo_title"
                            placeholder="Title"
                            v-model="edit_mfo_item.function"
                          />
                          <label for="mfo_title">MFO/PAP Title:</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-bs-dismiss="modal"
                    >
                      Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                      Save changes
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- 
    Edit MFO end
   -->
            <div class="row">
              <div class="col-12">
                <div class="card shadow-sm">
                  <!-- <div class="card-header text-center">
                    <h3>Rating Scale Matrix</h3>
                    <h5 class="text-red">{{}}</h5>
                    <h5 class="text-red">
                      {{
                        (period == 1 ? "January-June" : "July-December") +
                        ", " +
                        year
                      }}
                    </h5>
                  </div> -->
                  <div class="card-body">
                    <table class="table table-sm table-bordered">
                      <thead class="table-primary">
                        <tr class="text-center" style="vertical-align: middle">
                          <th scope="col" rowspan="2"></th>
                          <th scope="col" rowspan="2">MFO/PAP</th>
                          <th scope="col" rowspan="2">SUCCESS INDICATOR</th>
                          <th scope="col" rowspan="2">PERFORMANCE MEASURE</th>
                          <th scope="col" colspan="3">RATING</th>
                          <th scope="col" rowspan="2">IN-CHARGE</th>
                          <th scope="col" rowspan="2" colspan="2">OPTIONS</th>
                        </tr>
                        <tr class="text-center" style="vertical-align: middle">
                          <th scope="col">QUALITY</th>
                          <th scope="col">EFFICIENCY</th>
                          <th scope="col">TIMELINESS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="items.length < 1">
                          <td colspan="9" style="text-align: center">
                            <h4 class="text-secondary">No records found!</h4>
                          </td>
                        </tr>
                        <tr v-for="(item, i) in items" :key="i">
                          <td
                            style="vertical-align: middle; text-align:center;"
                            v-if="item.code"
                            :rowspan="item.rowspan"
                            width="20"
                          >
                            <span class="dropdown">
                              <button
                                :style="'margin-left:'+(item.indent*50)+'px;'"
                                class="
                                  btn btn-sm btn-light
                                  dropdown-toggle
                                  text-success
                                "
                                type="button"
                                id="dropdownMenu2"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                              >
                                <i class="bi bi-gear"></i> Config
                              </button>
                              <ul
                                class="dropdown-menu shadow-lg"
                                aria-labelledby="dropdownMenu2"
                              >
                                <li>
                                  <button
                                    class="dropdown-item"
                                    type="button"
                                    @click="edit_mfo(item)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editMfoModal"
                                  >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit MFO/PAP
                                  </button>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                  <button
                                    class="dropdown-item"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#successIndicatorEditor"
                                    @click="
                                      add_success_indicator(
                                        item.rating_scale_matrix_id
                                      )
                                    "
                                  >
                                    <i class="fa-solid fa-square-plus"></i>
                                    Add Success Indicator
                                  </button>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                  <button
                                    class="dropdown-item"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mfoParentEditor"
                                    :data-bs-mfos="
                                      JSON.stringify({
                                        mfo: item,
                                        rating_period_id: rating_period.id
                                      })
                                    "
                                  >
                                    <!-- @click="editMfoParent(item)" -->
                                    <i class="fa-solid fa-layer-group"></i>
                                    Move MFO/PAP
                                  </button>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                  <button
                                    class="dropdown-item"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mfoEditor"
                                    @click="addSubFunction(item)"
                                  >
                                    <i class="fa-solid fa-turn-down"></i>
                                    Add Subfunction
                                  </button>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                  <a
                                    class="dropdown-item text-danger"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteConfirmation"
                                    @click="
                                      deleteMfo(item.rating_scale_matrix_id)
                                    "
                                  >
                                    <i class="fa-solid fa-trash-can"></i>
                                    Delete MFO/PAP
                                  </a>
                                </li>
                              </ul>
                            </span>
                          </td>
                          <td
                            v-if="item.code"
                            :rowspan="item.rowspan"
                            :colspan="!item.success_indicator ? '9' : ''"
                            style="vertical-align: middle"
                          >
                            <span :style="set_text_indent(item.indent)">
                              {{ item.code + " " + item.function }}
                            </span>
                          </td>
                          <template v-if="item.success_indicator">
                            <td style="vertical-align: middle">
                              {{ item.success_indicator }}
                            </td>
                            <td>
                              <span
                                v-for="(
                                  performance_measure, pf
                                ) in item.performance_measures"
                                :key="pf"
                              >
                                {{ performance_measure }}
                                <br
                                  v-if="
                                    pf + 1 !== item.performance_measures.length
                                  "
                                />
                              </span>
                            </td>
                            <td style="white-space: nowrap">
                              <span
                                v-for="(quality, q) in item.quality"
                                :key="q"
                              >
                                <div v-if="item.quality[5 - q - 1]">
                                  <b>{{ 5 - q }}</b> -
                                  {{ item.quality[5 - q - 1] }}
                                  <br />
                                </div>
                              </span>
                            </td>

                            <td style="white-space: nowrap">
                              <span
                                v-for="(efficiency, e) in item.efficiency"
                                :key="e"
                              >
                                <div v-if="item.efficiency[5 - e - 1]">
                                  <b>{{ 5 - e }}</b> -
                                  {{ item.efficiency[5 - e - 1] }}
                                  <br />
                                </div>
                              </span>
                            </td>
                            <td style="white-space: nowrap">
                              <span
                                v-for="(timeliness, t) in item.timeliness"
                                :key="t"
                              >
                                <div v-if="item.timeliness[5 - t - 1]">
                                  <b>{{ 5 - t }}</b> -
                                  {{ item.timeliness[5 - t - 1] }}
                                  <br />
                                </div>
                              </span>
                            </td>
                            <td nowrap>
                              <div
                                v-for="(incumbent, i) in item.incumbents"
                                :key="i"
                              >
                                <a
                                  class="btn p-0 m-0"
                                  href="javascript:void(0)"
                                  >{{ incumbent.full_name }}</a
                                >
                                <br v-if="i + 1 !== item.incumbents.length" />
                              </div>
                            </td>
                            <td style="vertical-align: middle; text-align:center;">
                              <button
                                class="btn btn-sm text-success"
                                title="Edit success indicator"
                                data-bs-toggle="modal"
                                data-bs-target="#successIndicatorEditor"
                                @click="edit_success_indicator(item.id)"
                              >
                                <i class="bi bi-pencil-square"></i>
                              </button>
                            </td>
                            <td style="vertical-align: middle; text-align:center;">
                              <button
                                class="btn btn-sm text-danger"
                                title="Delete success indicator"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteConfirmation"
                                @click="deleteSuccessIndicator(item.id)"
                              >
                                <!-- @click="add_success_indicator(item)" -->
                                <i class="bi bi-x-square"></i>
                              </button>
                            </td>
                          </template>
                        </tr>
                      </tbody>
                    </table>
                    <form class="row g-3" @submit.prevent="submit_new_mfo()">
                      <div class="col-auto">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Category Number:"
                          v-model="new_mfo.category"
                        />
                      </div>
                      <div class="col-auto">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="MFO/PAP Title"
                          v-model="new_mfo.title"
                        />
                      </div>
                      <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                          Add
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- conetent end -->
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
<script>
import SuccessIndicatorEditor from "@/Pages/PMS/RSM/components/SuccessIndicatorEditor.vue";
import DeleteConfirmation from "@/Pages/PMS/RSM/components/DeleteConfirmation.vue";
import MfoEditor from "@/Pages/PMS/RSM/components/MfoEditor.vue";
import MfoParentEditor from "@/Pages/PMS/RSM/components/MfoParentEditor.vue";

import RatingPeriodSelector from "@/Components/RatingPeriodSelector.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  name: "RatingScaleMatrix",
  props: {
    items: Array,
    rating_period: Object,
  },
  components: {
    Head,
    RatingPeriodSelector,
    BreezeAuthenticatedLayout,
    SuccessIndicatorEditor,
    DeleteConfirmation,
    MfoEditor,
    MfoParentEditor,
  },
  data() {
    return {
      period: this.rating_period.period,
      year: this.rating_period.year,
      new_mfo: {
        category: "",
        title: "",
      },
      // items: [],
      edit_mfo_item: {},
      edit_rating_scale_matrix_id: 0,
      edit_success_indicator_id: 0,
    };
  },
  methods: {
    addSubFunction(edit_mfo_item) {
      this.edit_mfo_item = edit_mfo_item;
    },
    deleteMfo(rating_scale_matrix_id) {
      this.edit_rating_scale_matrix_id = rating_scale_matrix_id;
      this.edit_success_indicator_id = 0;
    },
    deleteSuccessIndicator(id) {
      this.edit_rating_scale_matrix_id = 0;
      this.edit_success_indicator_id = id;
    },
    add_success_indicator(rating_scale_matrix_id) {
      // console.log(item.rating_scale_matrix_id);
      this.edit_rating_scale_matrix_id = rating_scale_matrix_id;
      this.edit_success_indicator_id = 0;
    },
    edit_success_indicator(id) {
      this.edit_rating_scale_matrix_id = 0;
      this.edit_success_indicator_id = id;
      // console.log('si_id',id);
    },
    edit_mfo(item) {
      var item = JSON.parse(JSON.stringify(item));
      this.edit_mfo_item = {
        id: item.rating_scale_matrix_id,
        code: item.code,
        function: item.function,
      };
      // console.log(this.edit_mfo_item);
    },
    async save_edit_mfo() {
      await axios
        .post("/pms/rsm/saveEditMfo", {
          id: this.edit_mfo_item.id,
          code: this.edit_mfo_item.code,
          function: this.edit_mfo_item.function,
        })
        .then(({ data }) => {
          console.log("action submit form!: ", data);
          var myModalEl = document.getElementById("editMfoModal");
          var modal = bootstrap.Modal.getInstance(myModalEl); // Returns a Bootstrap modal instance
          modal.hide();
          this.getItems().then(() => {});
        })
        .catch(({ response: { data } }) => {
          // alert(response);
          // console.log(response);
        });
    },
    async submit_new_mfo() {
      await axios
        .post("/pms/rsm/addNewMfo", {
          new_mfo: this.new_mfo,
          period: this.period,
          year: this.year,
        })
        .then(({ data }) => {
          this.getItems() //.then(() => {});
          this.new_mfo.category = "";
          this.new_mfo.title = "";
        })
        .catch(({ response: { data } }) => {
          alert(data.message);
          console.log(data);
        });
    },
    async getItems() {
      this.$inertia.reload()
      // await axios
      //   .get("/api/rsm", {
      //     params: {
      //       period: this.period,
      //       year: this.year,
      //     },
      //   })
      //   .then(({ data }) => {
      //     this.items = JSON.parse(JSON.stringify(data));
      //   })
      //   .catch(({ response: { data } }) => {
      //     alert(data.message);
      //     // console.log(data);
      //   });
    },

    set_text_indent(order_number_mfo) {
      var tabs = "";
      if (!order_number_mfo) return tabs;
      tabs = "margin-left:" + 15 * order_number_mfo + "px;";
      return tabs;
    },
  },
  mounted() {
    // this.getItems();
    // console.log(this.year);
    // console.log(this.period);
  },
};
</script>