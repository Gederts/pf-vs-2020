<template>
  <div>
     <template v-if="currentQuestion">
<!--      Your progress-->
<!--       <div class="progress-bar-container">-->
<!--         <div class="progress-bar" :style="{width:(items.length/max) * 100 + '%'}">-->
<!--           {{(items.length/max)*100+'%'}}-->
<!--         </div>-->
<!--       </div>-->


       <h2>{{currentQuestion.title}}</h2>
       <div>
         <button
             v-for="answer in currentQuestion.answers"
             class="btn btn-secondary btn-block"
             :class="getButtonClass(answer.id)"
             @click="selectAnswer(answer.id)"
         >

            {{ answer.title }}
         </button>
       </div>
     </template>
    <button class="btn btn-primary mt-3"
            :disabled="!selectedAnswerId || isLoading"
            @click="onNextClicked()">
      {{isLastQuestion ? "Finish quiz" : "NextQuestion"}}

    </button>
  </div>
</template>

<script>
import Axios from "axios";
import {QuestionStructure, QuizStructure} from "../quiz.structures";

export default {
  data: () => ({
    // max: 0,
    // items: [],
    // msg: 'added',
    isLoading: false,
    /** @type {QuestionStructure} */
    currentQuestion: null,
    isLastQuestion: false,
    selectedAnswerId: null,
  }),
  created(){
    this.getNextQuestion();
   // this.getQuestionCount()
  },
  methods: {
    async getNextQuestion(){
      const formData = new FormData();
      //formData.append('csrf', window.csrf);

      this.isLoading = true;
      await Axios.post('/quiz-rpc/get-question', formData).then((response) => {
          if(!response.data.questionData){
            this.onLastQuestionSubmitted();
            return;
          }

          this.currentQuestion = new QuestionStructure(response.data.questionData);
          this.isLastQuestion = response.data.isLastQuestion;
      }).finally(() => {
        this.isLoading = false;
      });
    },

    selectAnswer(answerId){
      this.selectedAnswerId = answerId;
    },
    getButtonClass(answerId){
      return {  //atgriež klašu mapping objektu
        'button-cyan': answerId === this.selectedAnswerId,
      }
    },
    async onNextClicked() {
      if (!this.selectedAnswerId || this.isLoading){
        return; //atbilde ir obligati jaizvelas
      }


     // this.items.push(this.msg);


      const formData = new FormData();
      //formData.append('csrf', window.csrf());
      formData.append('answerId', this.selectedAnswerId);

      this.isLoading = true;
      await Axios.post('/quiz-rpc/save-answer', formData).then((response) => {
        if(this.isLastQuestion){
          this.onLastQuestionSubmitted();
          return;
        }

        this.getNextQuestion();
      }).finally(() => {
        this.isLoading = false;
      });


    },

    onLastQuestionSubmitted() {
      this.$emit('last-question-submitted');
    },

   /* async getQuestionCount(){
      const formData = new FormData();
      let quizId = this.currentQuestion.quizId;
      formData.append('quizId', quizId);

      this.isLoading = true;
      await Axios.post('/quiz-rpc/get-question-count', formData).then((response) => {
        if(!response.data.questionCount){
          return;
        }

        this.max = response.data.questionCount; // iespējams, nepareiza pieeja
      }).finally(() => {
        this.isLoading = false;
      });

    },*/
  }
}
</script>
