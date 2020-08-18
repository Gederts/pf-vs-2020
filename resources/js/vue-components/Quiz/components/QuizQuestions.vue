<template>
  <div>
      <h1>Question</h1>
      <button class="btn btn-primary" @click="onNextClicked()" >Next</button>
  </div>
</template>

<script>
export default {
  methods: {
    onNextClicked(){
      this.onLastQuestionSubmitted();
    },
    onLastQuestionSubmitted(){
      this.$emit('last-question-submitted');
    },
  }
}
</script>
