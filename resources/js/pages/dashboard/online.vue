<template>
<Breadcrumbs main="Dashboard" title="online" />
<div class="container-fluid">
    <div class="row">
        <WelcomeCard />
        <TodayProgressCard />
        <DoYouWanttoGetCard />
        <DatePickerCard />
        <LearningOverviewCard />
        <ActivityHoursCard />
        <UpcomingEventsCard />
        <MyCourseCard />
        <UpcomingScheduleCard />
        <ActiveLessonsCard />
    </div>
</div>
</template>

<script>
import WelcomeCard from "./online/WelcomeCard.vue"
import TodayProgressCard from "./online/TodayProgressCard.vue"
import DoYouWanttoGetCard from "./online/DoYouWanttoGetCard.vue";
import DatePickerCard from "./online/DatePickerCard.vue";
import LearningOverviewCard from "./online/LearningOverviewCard.vue";
import ActivityHoursCard from "./online/ActivityHoursCard.vue";
import UpcomingEventsCard from "./online/UpcomingEventsCard.vue";
import MyCourseCard from "./online/MyCourseCard.vue";
import UpcomingScheduleCard from "./online/UpcomingScheduleCard.vue";
import ActiveLessonsCard from "./online/ActiveLessonsCard.vue";
export default {
    components: {
        WelcomeCard,
        TodayProgressCard,
        DoYouWanttoGetCard,
        DatePickerCard,
        LearningOverviewCard,
        ActivityHoursCard,
        UpcomingEventsCard,
        MyCourseCard,
        UpcomingScheduleCard,
        ActiveLessonsCard,
    },
};
</script>
