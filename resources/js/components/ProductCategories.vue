<template>
  <div class="card">
    <div class="card-header">
      <h4 class="text-uppercase card-title">Categories</h4>
    </div>
    <table class="table table-hover">
      <tbody>
        <tr v-for="(category, index) in categories" :key="category.id">
          <td style="justify-content: top">{{ index + 1 }}</td>
          <td>
            <div class="mb-2">{{ category.name }}</div>
            <div class="text-right">
              <button
                class="btn btn-danger btn-sm btn-link"
                @click="deleteCategory(category.id, index)"
              >
                <span class="tim-icons icon-trash-simple"></span>
              </button>
              <button
                class="btn btn-success btn-sm btn-link"
                @click="editCategory(category)"
              >
                <span class="tim-icons icon-pencil"></span>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: [],
      category: {},
      edit: false,
    };
  },
  methods: {
    getCategories() {
      axios
        .get("/api/product-categories")
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editCategory(category) {
      this.edit = true;
      this.category = category;
    },
    deleteCategory(id, index) {
      axios
        .delete(`/api/product-categories?id=${id}`)
        .then((response) => {
          if (response.status == 204) {
            this.categories.splice(index, 1);
            $.notify(
              {
                message: "Category Removed",
              },
              {
                type: "danger",
              }
            );
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getCategories();
  },
};
</script>
