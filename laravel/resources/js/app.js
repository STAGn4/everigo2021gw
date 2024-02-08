require('./bootstrap');
import Vue from "../../node_modules/vue/dist/vue.js";

import VueStarRating from 'vue-star-rating';
Vue.component('star-rating', VueStarRating);

new Vue({
  el: '#app',
  methods: {
    setRating: function(rating) {
      this.rating = rating;
      document.review.stars.value = rating;
    },
    showCurrentRating: function(rating) {
      this.currentRating = (rating === 0) ? this.currentSelectedRating : "Click to select " + rating + " stars"
    },
    setCurrentSelectedRating: function(rating) {
      this.currentSelectedRating = "You have Selected: " + rating + " stars";
    }
  },
  data: {
    rating: "No Rating Selected",
    currentRating: "No Rating",
    currentSelectedRating: "No Current Rating",
    boundRating: 3,
  }
});

// function getStars(){
//     confirm('getStars');
//     $stars=document.getElementById('stars');
//     document.review.stars.value=$stars.rating;

// }
import '../../node_modules/chart.js/dist/chart.js';
const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['★5', '★4', '★3', '★2', '★1'],
        datasets: [{
            label: '# of Votes',
            data: [0, 0, 0, 0, 0],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
