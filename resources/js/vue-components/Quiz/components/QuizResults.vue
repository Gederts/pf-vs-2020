<template>
  <div>
    Your progress (QuizQuestions.vue iesāku bet nepabeidzu (Progress Bar))
    <div class="progress-bar-container">
      <div class="progress-bar" :style="{width:100 + '%'}">
        100%
      </div>
    </div>
    <h1>Thanks, {{userName}}!</h1>


    <div v-if="isLoading">
      Fetching results...
    </div>
    <div v-else>
      You answered correctly to {{correctAnswerCount}} out of {{totalQuestionCount}} questions!
    </div>
    <br>

    <button class="btn btn-primary" :disabled="isLoading" @click="onBackToStartClicked()">
        Back to start
    </button>
  </div>
</template>

<script>
import Axios from "axios";
import {QuestionStructure} from "../quiz.structures";

export default {
  props:{
    userName: {
      type: String,
      required: true,
    }
  },
  data: ()=> ({
    isLoading: true,
    correctAnswerCount: null,
    totalQuestionCount: null,
  }),
  created(){
    this.getResults();
  },
  methods:{
    async getResults(){
      const formData = new FormData();
      //formData.append('csrf', window.csrf);

      this.isLoading = true;
      await Axios.post('/quiz-rpc/get-results', formData).then((response) => {
          this.correctAnswerCount = response.data.correctAnswerCount;
          this.totalQuestionCount = response.data.totalQuestionCount;

      }).finally(() => {
        this.isLoading = false;
      });
    },

    onBackToStartClicked(){
      if (this.isLoading){
        return;
      }
      this.$emit('quiz-finished');
    }
  }
}
</script>


