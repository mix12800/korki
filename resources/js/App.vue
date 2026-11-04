<template>
    <HeaderComponent v-if="isAuth" :logout="logout" />

    <AuthPage
        v-if="page == 'AuthPage'"
        :ChangePage="ChangePage"
        :server="server"
        :AuthUser="AuthUser"
    />
    <RegistrationPage
        v-if="page == 'RegistrationPage'"
        :ChangePage="ChangePage"
        :server="server"
        :AuthUser="AuthUser"
    />

    <CoursesComponent v-if="page == 'CoursesComponent'" />
    {{ user }}
</template>
<script>
import CoursesComponent from "./components/CoursesComponent.vue";
import HeaderComponent from "./components/HeaderComponent.vue";
import AuthPage from "./Page/AuthPage.vue";
import RegistrationPage from "./Page/RegistrationPage.vue";

export default {
    name: "App",

    data() {
        return {
            page: localStorage.getItem("page") || "AuthPage",
            server_URL: "http://127.0.0.1:8000/api/",
            user: {},
            isAuth: false,
        };
    },

    mounted() {
        if (localStorage.getItem("token")) {
            this.server("user")
                .then((result) => {
                    this.user = result.user;
                    this.isAuth = true;
                })
                .catch((error) => console.error(error));
        }
    },

    methods: {
        logout() {
            this.isAuth = false;
            this.page("authPage");
            localStorage.removeItem("token");
        },

        AuthUser(result) {
            this.user = result.user;
            localStorage.setItem("token", result.token);
            if (result.user.role == "admin") {
                this.ChangePage("CoursesComponent");
            }
            this.isAuth = true;
        },

        ChangePage(page) {
            this.page = page;
            localStorage.setItem("page", page);
        },

        async server(route, method = "GET", formdata = null) {
            let myHeaders = new Headers();
            myHeaders.append("Accept", "accept/json");
            myHeaders.append(
                "Authorization",
                `Bearer ${localStorage.getItem("token")}`,
            );

            let requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: "follow",
            };

            if (method != "GET" && method != "DELETE") {
                requestOptions.body = formdata;
            }

            return await fetch(this.server_URL + route, requestOptions).then(
                (response) => {
                    return response.json();
                },
            );
        },
    },

    components: {
        AuthPage,
        RegistrationPage,
        CoursesComponent,
        HeaderComponent,
    },
};
</script>
