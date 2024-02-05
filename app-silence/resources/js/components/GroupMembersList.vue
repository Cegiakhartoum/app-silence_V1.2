<template>
   <div id="create-students" class="form-group flex-grow-1 overflow-scroll text-center">
    <div
      v-for="student in studs"
      :key="student.id"
      class="d-flex align-content-stretch"
    >
      <input
        type="checkbox"
        class="btn-check student-button"
        :id="'btn-check-edit-' + suffix + '-' + student.id"
        autoComplete="off"
        :value="student.id"
      />
      <label
        class="btn btn-outline-primary student-button-label"
        :htmlFor="'btn-check-edit-' + suffix + '-' + student.id"
        >{{ student.name }} {{ student.name }}</label
      >
    </div>
  </div>
</template>

<script>
export default {
  props: ["students"],
  data: function () {
    return {
      suffix: "create",
      studs: this.students
    };
  },
};
</script>
