<template>
  <div id="calendar">
    <div class="heading main centered">
        <h3 class="uppercase lg-title"><span class="titles">{{ header }}</span></h3>
    </div>
    <vue-event-calendar :events="allevents"></vue-event-calendar>
  </div>
</template>

<script>
import 'vue-event-calendar/dist/style.css'
import vueEventCalendar from 'vue-event-calendar'
Vue.use(vueEventCalendar, {locale: 'en', weekStartOn: 1}) 
export default {
  props: ['header', 'allevents'],

  data () {
    return {
      /*events: [{
        date: '2018/11/12', // Required
        title: 'Foo' // Required
      }, {
        date: '2018/12/15',
        title: 'Bar',
        desc: 'description',
        customClass: 'disabled highlight' // Custom classes to an calendar cell
      }]*/
    }
  }
}

</script>

<style>
    div.cal-wrapper, div.events-wrapper {
        border: 1px solid #e1e1e1;
        border-radius: 10px;
        background: rgba(76, 135, 185, 0.15) !important;
    }
    div.cal-wrapper {
        padding: 0 !important;
    }
    div.cal-wrapper .cal-header {
        border-radius: 10px 10px 0 0;   
    }
    div.cal-wrapper .cal-body .weeks .item {
        font-size: 15px;
        color: #fff;
        font-weight: 900;
    }
    div.cal-wrapper .cal-body .dates .item .date-num {
        color: #e1e1e1 !important;
        font-size: 12px !important;
    }
    div.cal-events div.event-item p.desc {
      word-wrap: break-word;
    }
</style>