<template>
    <HeaderComponent
        v-if="isAuth"
        :user="user"
        :logout="logout"
        :page="page"
        :ChangePage="ChangePage"
    />

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

    <CoursesPage v-if="page == 'CoursesPage'" :server="server" />

    <OrderAddPage
        v-if="page == 'OrderAddPage'"
        :server="server"
        :ChangePage="ChangePage"
    />

    <MyOrdersPage v-if="page == 'MyOrdersPage'" :server="server" />
</template>
<script>
import HeaderComponent from "./components/HeaderComponent.vue";
import AuthPage from "./Page/AuthPage.vue";
import CoursesPage from "./Page/CoursesPage.vue";
import MyOrdersPage from "./Page/MyOrdersPage.vue";
import OrderAddPage from "./Page/OrderAddPage.vue";
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
        } else {
            this.ChangePage("AuthPage");
        }
    },

    methods: {
        logout() {
            this.isAuth = false;
            this.user = {};
            this.ChangePage("AuthPage");
            this.server("logout")
                .then((result) => {})
                .catch((error) => console.error(error));
            localStorage.removeItem("token");
        },

        AuthUser(result) {
            this.user = result.user;
            localStorage.setItem("token", result.token);
            if (result.user.role == "admin") {
                this.ChangePage("CoursesPage");
            } else {
                this.ChangePage("OrderAddPage");
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
                    if (response.status == "401") {
                        this.logout();
                    }
                    return response.json();
                },
            );
        },
    },

    components: {
        AuthPage,
        RegistrationPage,
        CoursesPage,
        HeaderComponent,
        OrderAddPage,
        MyOrdersPage,
    },
};
</script>
