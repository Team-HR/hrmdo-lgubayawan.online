<template>
  <div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-layer-group"></i>
            Move MFO/PAP
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <button class="btn btn-primary me-3" @click="removeMfoParent()">
            Set as a Main MFO/PAP
          </button>
          <span><strong>{{mfo.code}} {{mfo.function}}</strong></span>
          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(mfo, m) in mfoParents"
                :key="m"
                :class="mfo.isToBeTransfered ? 'bg-primary text-white' : ''"
              >
                <td>
                  <button
                    v-if="!mfo.disabled"
                    class="btn btn-sm btn-primary text-white"
                    @click="moveMfoHere(mfo.id)"
                  >
                    Move here
                    <i class="fa-solid fa-arrow-turn-down"></i>
                  </button>
                </td>
                <td>
                  <span :style="'margin-left:' + mfo.indent * 15 + 'px;'"
                    >{{ mfo.code }} {{ mfo.function }}</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MfoParentEditor",
  data() {
    return {
      el: null,
      mfo: {},
      mfoParents: [],
      mfoIdToTransfer: 0,
      rating_period_id: 0
    };
  },
  watch: {},
  methods: {
    get_mfo_parents() {
      axios
        .post("/pms/rsm/getMfoParents", {
          mfoIdToTransfer: this.mfoIdToTransfer,
          rating_period_id: this.rating_period_id,
        })
        .then(({ data }) => {
          console.log("get_mfo_parents:", data);
          this.mfoParents = data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    clearData() {
      this.mfoParents = [];
    },
    moveMfoHere(newMfoParentId) {
      axios
        .post("/pms/rsm/changeMfoParent", {
          mfoIdToTransfer: this.mfoIdToTransfer,
          newParentId: newMfoParentId,
        })
        .then(({ data }) => {
          // console.log(data)
          this.get_mfo_parents();
          this.$emit("transferedMfo");
        })
        .catch((err) => {
          console.error(err);
        });
    },
    removeMfoParent() {
      axios
        .post("/pms/rsm/removeMfoParent", {
          mfoIdToTransfer: this.mfoIdToTransfer
        })
        .then(({ data }) => {
          // console.log(data)
          this.get_mfo_parents();
          this.$emit("transferedMfo");
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
  mounted() {
    /* 
        get this child modal element id
    */
    this.el = document.getElementById(this.$el.id);

    /*
        everytime the modal shows the data are fetched
    */
    this.el.addEventListener("show.bs.modal", (event) => {
      var button = event.relatedTarget;
      var mfos = button.getAttribute("data-bs-mfos");
      mfos = JSON.parse(mfos);
      this.mfoIdToTransfer = mfos.mfo.rating_scale_matrix_id;
      this.mfo = mfos.mfo;
      this.rating_period_id = mfos.rating_period_id
      this.get_mfo_parents();
    });

    /* 
        everytime the modal hides the data are cleared!
    */
    this.el.addEventListener("hidden.bs.modal", (event) => {
      this.clearData();
    });
  },
};
</script>