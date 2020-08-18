<template>
  <div>
    <h1>Thanks, {{userName}}!</h1>
    <button class="btn btn-primary" @click="onNextClicked()">
        Back to start
    </button>
  </div>
</template>

<script>
export default {
  props:{
    userName: {
      type: String,
      required: true,
    }
  },
  methods:{
    onNextClicked(){
      this.onBackToStartClicked();
    },
    onBackToStartClicked(){
      this.$emit('quiz-finished');
    }
  }
}
</script>


