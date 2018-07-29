<template>
    <div>
        <home></home>
        <about :header="titles.about_us" :content="texts.about_us_body"></about>
        <home-calendar :header="titles.calendar" :allevents="events"></home-calendar>
        <home-projects :header="titles.projects"></home-projects>
        <home-activities :header="titles.activities"></home-activities>
        <home-subscribe :header="titles.members" :content="texts.subscribe_body"></home-subscribe>
        <contact :header="titles.contact"></contact>
    </div>
</template>

<script>
    Vue.component('home', require('./Home.vue'));
    Vue.component('about', require('./About.vue'));
    Vue.component('home-projects',require('./Projects.vue'));
    Vue.component('home-activities',require('./Activities.vue'));
    Vue.component('home-calendar',require('./Calendar.vue'));
    Vue.component('home-subscribe',require('./Subscribe.vue'));
    Vue.component('contact', require('./Contact.vue'));
    export default {
        data() {
            return {
                titles: {
                    about_us: 'Hakkımızda',
                    calendar: 'Takvim',
                    projects: 'Projelerimiz',
                    activities: 'Etkinliklerimiz',
                    members: 'Üyelik',
                    contact: 'İletişim',
                },
                texts: {
                    about_us_body: 'Hakkımızda içerik',
                    subscribe_body: 'Üye ol içerik',
                },
                activities: null,
                projects: null,
                events: [],
                last_events: []
            }
        },

        created() {
            axios.get('api/home').then(response =>{
                this.titles = response.data[0];
                this.texts = response.data[1];
                this.activities = response.data[2];
                this.last_events = this.activities.slice(Math.max(this.activities.length - 3, 1))
                this.projects = response.data[3];
                for(var i=0; i<this.activities.length; i++){
                    var el = this;
                    this.events.push({
                        date: el.activities[i].date.split('/').reverse().join('/'),
                        title: el.activities[i].activity_title,
                        desc: el.activities[i].description,
                    });
                }
            });
        }
    }
</script>