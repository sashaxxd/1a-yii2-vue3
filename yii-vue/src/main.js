import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')


// Для ssr

// import Vue from 'vue'
// import App from './App.vue'
//
// // import renderVueComponentToString from 'vue-server-renderer/basic';
// // Vue.config.productionTip = false
//
// Vue.config.productionTip = false
// export default () => new Vue({
//   render: h => h(App),
// }).$mount('#app')
