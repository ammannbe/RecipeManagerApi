<template>
  <div class="card">
    <header class="card-header-title is-centered">
      <b-skeleton></b-skeleton>
    </header>

    <div class="card-content">
      <div class="media is-centered">
        <figure class="image">
          <b-skeleton height="100%"></b-skeleton>
        </figure>
      </div>
      <div class="content">
        <b-skeleton></b-skeleton>
        <b-skeleton></b-skeleton>
        <b-skeleton></b-skeleton>
        <b-skeleton></b-skeleton>
      </div>
    </div>

    <footer class="card-footer">
      <div>
        <span class="time">
          <b-skeleton></b-skeleton>
        </span>
      </div>
    </footer>
  </div>
</template>

<style lang="scss" scoped>
.card {
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);

  header {
    align-items: flex-start;
    flex-grow: unset;
  }

  div.card-content {
    flex-grow: 1;

    .media {
      justify-content: center;
      margin-bottom: 2rem;
    }

    .content {
      font-size: 90%;
    }
  }

  .card-footer .time {
    width: 80px;
    display: inline-block;
  }

  footer {
    height: 35px;
    padding: 5px;
  }
}
</style>

<style lang="scss">
.content > * {
  margin-top: 0 !important;
  margin-bottom: 0.4em !important;
}

div.card-content > .media > .image {
  height: 300px;
  object-fit: contain;
  width: 80%;
}

.image div.b-skeleton {
  height: 100%;

  > .b-skeleton-item {
    height: 100%;
  }
}
</style>
