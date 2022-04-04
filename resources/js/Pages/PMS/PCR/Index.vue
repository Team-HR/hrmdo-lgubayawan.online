<script>
import RatingPeriodSelector from "@/Components/RatingPeriodSelector.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Head,
    RatingPeriodSelector,
    BreezeAuthenticatedLayout,
  },
};
</script>

<template>
  <Head title="Performance Review" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Performance Review
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <RatingPeriodSelector
              title="Rating Scale Matrix"
              routeName="/pms/pcr/"
            />
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>