<template>
  <div
    id="action-groups"
    class="flex-grow-1"
  >
    <div
      v-for="group in grps"
      :key="group.id"
      class="d-flex align-items-end group-container"
    >
      <div>
        <button
          type="button"
          className="btn btn-danger"
          :onClick="deleteGroup(group.id)"
        >
          <i class="fas fa-trash"></i>
        </button>
      </div>
      <span className="group_separator"></span>
      <div className="flex-even">
        <div>
          <label className="text-white">Nom du groupe :</label>
          <input
            type="text"
            className="form-control text-orange"
            id="nameInput"
            name="nom"
            value="{group.name}"
            :onChange="updateGroupName(group.id)"
          />
        </div>
      </div>
      <span className="group_separator"></span>
      <div className="flex-even">
        <div>
          <label className="text-white">Les élèves :</label>
          <input
            type="text"
            class="form-control text-black"
            id="nameInput"
            name="nom"
            :value="group.members.map((m) => m.name).join(' , ')"
            readOnly="{true}"
            :onClick="editGroupMembers(group.id)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      suffix: "create",
      grps: [],
    };
  },
  created() {
    this.studs = students;
  },
};
</script>
