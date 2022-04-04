
<template>
  <Head title="Performance Commitment Report" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Performance Commitment Report
      </h2>
    </template>

    <div class="py-12 px-5">
      <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <!-- content start -->

          <!-- nav start -->
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="route().current('pcr.show') ? 'active' : ''"
                aria-current="page"
                href="/pms/pcr/1"
                >Status</Link
              >
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="route().current('pcr.sig') ? 'active' : ''"
                aria-current="page"
                href="/pms/pcr/1/signatories"
                >Signatories</Link
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Core Function</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled">Disabled</a>
            </li>
          </ul>
          <!-- nav end -->

          <div class="py-12" style="min-height:500px;">
            <div v-if="route().current('pcr.show')">STATUS HERE</div>
            <slot />
          </div>

          <!-- content end -->
        </div>
      </div>
      <!-- </div> -->
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Link, Head, useRemember } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
  },
};
</script>