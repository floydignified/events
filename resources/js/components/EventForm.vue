<template>
  <div align="left">
    <h3>Calendar</h3>
    <hr />
    <div v-if="isError" align="right">
      <span class="text-danger">All fields are required.</span>
    </div>
    <b-form @click="clearErrors">
      <b-form-group label="Event name">
        <b-form-input
          v-model="formData.eventName"
          :class="{ error: isError }"
          placeholder="Event"
        ></b-form-input>
      </b-form-group>
      <b-row class="mb-4">
        <b-col>
          <label>From</label>
          <b-form-datepicker
            v-model="formData.startDate"
            :class="{ error: isError }"
            :max="formData.endDate"
          ></b-form-datepicker>
        </b-col>
        <b-col>
          <label>To</label>
          <b-form-datepicker
            v-model="formData.endDate"
            :class="{ error: isError }"
            :min="formData.startDate"
          ></b-form-datepicker>
        </b-col>
      </b-row>
      <b-form-group align="center">
        <b-form-checkbox-group
          v-model="formData.selectedDays"
          :class="{ error: isError }"
          :options="options"
        ></b-form-checkbox-group>
      </b-form-group>
    </b-form>

    <b-button variant="success" @click="submitEvent">Save</b-button>
  </div>
</template>

<script>
export default {
  props: {
    event: {
      default: null
    }
  },
  data() {
    return {
      isError: false,
      formData: {
        eventName: "",
        startDate: null,
        endDate: null,
        selectedDays: []
      },
      options: [
        { text: "Mon", value: "monday" },
        { text: "Tue", value: "tuesday" },
        { text: "Wed", value: "wednesday" },
        { text: "Thu", value: "thursday" },
        { text: "Fri", value: "friday" },
        { text: "Sat", value: "saturday" },
        { text: "Sun", value: "sunday" }
      ]
    };
  },
  watch: {
    //catch event prop changes and set to local formData
    event(newData) {
      this.formData = {
        eventName: newData.event_name,
        startDate: newData.start_date,
        endDate: newData.end_date,
        selectedDays: newData.selected_days
      };
    }
  },
  methods: {
    /**
     * Clear errors
     */
    clearErrors() {
      this.isError = false;
    },
    /**
     * Custom method for resetting form data
     */
    resetEvent() {
      this.formData = {
        eventName: "",
        startDate: null,
        endDate: null,
        selectedDays: []
      };
    },
    /**
     * Show notification
     */
    showNotification(data) {
      this.$bvToast.toast(data.message, {
        title: data.title,
        variant: data.type
      });
    },
    /**
     * Submit event data to backend
     */
    submitEvent() {
      //TODO: try better validation
      if (
        !this.formData.eventName ||
        !this.formData.startDate ||
        !this.formData.endDate ||
        this.formData.selectedDays.length <= 0
      ) {
        this.isError = true;
      }

      //post request to backend
      this.axios
        .post("/api/v1/events/create", {
          event_name: this.formData.eventName,
          start_date: this.formData.startDate,
          end_date: this.formData.endDate,
          days: this.formData.selectedDays
        })
        .then(response => {
          //refresh calendar data and show success notification
          if (response.status === 200) {
            this.$emit("eventsUpdated");
            this.showNotification({
              title: response.data.message,
              message: this.formData.eventName,
              type: "success"
            });
          }
        })
        .catch(error => {
          //show error notification
          this.showNotification({
            title: "Event creation failed",
            message: error.response.data.message,
            type: "danger"
          });
        });
    }
  }
};
</script>

<style scoped>
.error {
  border: 1px red solid;
}
</style>
