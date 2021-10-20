<template>
    <form v-on:submit.prevent="(e) => search(e, 'enter')" action="#" method="post">
        <input ref="search" type="text" @input="(e) => search(e, 'input')" placeholder="search ..." :value="value"/>
    </form>
</template>

<script>

export default {
    name: 'search-input',
    props: {
      value: {
          type: String,
          default() {
              return ''
          }
      }
    },
    methods: {
        search(event, type) {
            clearTimeout(this.debounce);
            let value = (type === 'enter') ? event.target[0].value : event.target.value;
            let ctx = this;
            this.debounce = setTimeout(() => {
                ctx.$emit('input', value);
            }, 600)
        },
    }
}
</script>

<style scoped>
    input, form {
        margin: 0
    }
</style>