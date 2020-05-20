<template>
  <div class="columns">
    <div class="column is-one-third">
      <h3 class="title">Details</h3>
      <span class="tag is-info">Du bist Admin</span>
      <br />
      <table>
        <tr>
          <th>Name:</th>
          <td>{{ user.name }}</td>
        </tr>
        <tr>
          <th>E-Mail:</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>Registriert:</th>
          <td>{{ user.created_at }}</td>
        </tr>
        <tr>
          <th>Letzte Änderung:</th>
          <td>{{ user.updated_at }}</td>
        </tr>
      </table>
    </div>
    <div class="column is-one-third">
      <h3 class="title">Deine Rezepte</h3>
      <ul>
        <li>Rezept 1</li>
        <li>Rezept 2</li>
      </ul>
    </div>
    <div class="column is-one-third">
      <h3 class="title">Gelöschte Rezepte</h3>
      <ul>
        <li>Rezept 3</li>
      </ul>
    </div>
  </div>
</template>
<script>
import Users from "../modules/ApiClient/Users";

export default {
  data() {
    return {
      user: {
        name: "-",
        email: "-",
        admin: false,
        created_at: "-",
        updated_at: "-"
      }
    };
  },
  mounted() {
    new Users().show().then(user => (this.user = user));
  }
};
</script>
<style lang="scss" scoped>
th {
  text-align: right !important;
  padding-right: 10px;
}
</style>
