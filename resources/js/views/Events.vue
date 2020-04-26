<template>
  <b-container>
    <b-row class="text-center">
      <b-col cols="4" class="pr-5">
        <EventForm :event="parentEvent" @eventsUpdated="fetchEvents" />
      </b-col>
      <b-col cols="8">
        <EventCalendar :events="events" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import EventCalendar from "../components/EventCalendar";
import EventForm from "../components/EventForm";

export default {
  components: {
    EventCalendar,
    EventForm
  },
  data() {
    return {
      parentEvent: null,
      events: [],
      showModal: false
    };
  },
  mounted() {
    this.fetchEvents();
  },
  methods: {
    /**
     * Fetch list of events from backend
     */
    fetchEvents() {
      this.axios.get("/api/v1/events").then(response => {
        if (response.status === 200) {
          let events = [];
          let eventDates = response.data.event.event_dates;

          //generate event object for calendar consumption
          eventDates.forEach((date, index) => {
            events.push({
              title: response.data.event.event_name,
              date: date
            });
          });

          //set new events
          this.events = events;
          this.parentEvent = response.data.event;
        }
      });
    }
  }
};
</script>

<style scoped>
@media (min-width: 1366px) {
  .container {
    max-width: 1250px;
  }
}

@media (min-width: 1600px) {
  .container {
    max-width: 1500px;
  }
}

@media (min-width: 1920px) {
  .container {
    max-width: 1800px;
  }
}
</style>
