<script>
import { ref, computed } from "vue";
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import NavItem from "@/Components/NavItem.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      pages: [
        {
          name: "pcr",
          children: ["pcr.show", "pcr.sig"],
        },
      ],
    };
  },
  components: {
    BreezeApplicationLogo,
    BreezeDropdown,
    BreezeDropdownLink,
    BreezeNavLink,
    NavItem,
    BreezeResponsiveNavLink,
    Link,
  },
  computed: {
    rsm() {
      if (!Inertia.page.props.auth.user.roles) {
        return false;
      }
      const roles = JSON.parse(Inertia.page.props.auth.user.roles);
      return roles.includes("rsm") ? true : false;
    },
  },
  methods: {
    currentPage(pageName) {
      let isCurrent = false;
      let page = {};
      for (let index = 0; index < this.pages.length; index++) {
        if (this.pages[index].name == pageName) {
          page = this.pages[index];
          break;
        }
      }

      isCurrent = route().current(page.name);
      page.children.forEach((child) => {
        if (route().current(child)) {
          isCurrent = true;
        }
      });

      return isCurrent;
    },
  },
};
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <NavItem
                :href="route('dashboard')"
                :active="route().current('dashboard')"
              >
                Dashboard
              </NavItem>
              <NavItem :href="route('pcr')" :active="currentPage('pcr')">
                Performance Review
              </NavItem>
              <NavItem :href="route('rpc')" :active="route().current('rpc')">
                Review Performance Commitment
              </NavItem>
              <NavItem :href="route('pmt')" :active="route().current('pmt')">
                Performance Management Team
              </NavItem>
              <NavItem
                v-if="rsm"
                :href="route('rsm')"
                :active="route().current('rsm') || route().current('rsm.show')"
              >
                Rating Scale Matrix
              </NavItem>
            </ul>
            <!-- <form class="d-flex">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-outline-success" type="submit">
                Search
              </button>
            </form> -->

            <Link
              :href="route('logout')"
              class="btn btn-danger"
              method="post"
              as="button"
            >
              Logout
            </Link>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
