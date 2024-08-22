import RecyclerComponent from './components/RecyclerComponent.vue';
import RecyclerThemeComponent from './components/RecyclerThemeComponent.vue';
import RecyclerSolutionComponent from './components/RecyclerSolutionComponent.vue';
import RecyclerRequestComponent from './components/RecyclerRequestComponent.vue';

export const routes = [
    {
        path: '/recycler',
        component: RecyclerComponent
    },
    {
        path: '/recyclerTheme',
        component: RecyclerThemeComponent
    },
    {
        path: '/recyclerSolution',
        component: RecyclerSolutionComponent
    },
    {
        path: '/recyclerRequest',
        component: RecyclerRequestComponent
    },
];