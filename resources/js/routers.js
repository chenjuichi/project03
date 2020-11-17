
// Define route components.
// These can be imported from other files
import VueRouter from 'vue-router';

import Hello1 from "./Hello1";
import Hello2 from "./Hello2";
import Hello11 from "./Hello11";
import Hello12 from "./Hello12";

import Welcome from "./Welcome";

// Define some routes, each route should map to a component.
const routes = [
    {path: '/hello1',    component: Hello1, name: "hello1",  
        children: [
            {path: 'hello11',   name: "hello1.hello11", component: Hello11}, 
            {path: 'hello12',   name: "hello1.hello12", component: Hello12}
        ]
    },
    {path: '/hello2',   component: Hello2,  name: "hello2"},
    {path: '/',         component: Welcome, name: "welcome"},
    {path: '*', redirect: '/' }
];

// Create the router instance and pass the `routes` option
const router = new VueRouter({
  routes,			// short for `routes: routes
  mode: 'history',
});

export default router;
