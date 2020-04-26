<template>
  <div class="w-100">
    <FullCalendar
      ref="calendar"
      defaultView="dayGridMonth"
      :plugins="calendarPlugins"
      :events="events"
      :displayEventTime="false"
      eventColor="#28A745"
      eventTextColor="#FFFF"
      :buttonText="{ today: 'Today' }"
    />
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";

export default {
  props: {
    events: {
      type: Array,
      default: []
    }
  },
  components: {
    FullCalendar
  },
  data() {
    return {
      calendarPlugins: [dayGridPlugin]
    };
  }
};
</script>

<style lang="scss" scoped>
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
</style>
