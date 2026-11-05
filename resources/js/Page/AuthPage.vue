<template>
    <div class="form">
        <div class="mb-3 form-title">
            <h2>Авторизация</h2>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.login }"
                id="login"
                v-model="login"
                placeholder="login"
                :disabled="isLoading"
            />
            <label for="login">Логин</label>
            <div v-if="errors.login" class="invalid-feedback">
                {{ errors.login.join(". ") }}
            </div>
        </div>
        <div class="form-floating mb-3">
            <input
                type="password"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.password }"
                id="password"
                v-model="password"
                placeholder="password"
                :disabled="isLoading"
            />
            <label for="password">Пароль</label>
            <div v-if="errors.password" class="invalid-feedback">
                {{ errors.password.join(". ") }}
            </div>
        </div>

        <button
            class="btn btn-dark btn-lg w-100 mb-3"
            @click="BtnAuth"
            :disabled="isLoading"
        >
            Войти
        </button>

        <div class="link-form mb-1">
            Ещё не зарегистрированы?
            <a
                href="Registration.html"
                @click.prevent="ChangePage('RegistrationPage')"
                >Регистрация</a
            >
        </div>
    </div>
</template>
<script>
export default {
    name: "AuthPage",
    props: ["ChangePage", "AuthUser", "server"],

    data() {
        return {
            isLoading: false,
            login: "",
            password: "",
            errors: {},
        };
    },

    methods: {
        BtnAuth() {
            this.isLoading = true;
            let formdata = new FormData();
            formdata.append("login", this.login);
            formdata.append("password", this.password);
            this.server("auth", "POST", formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.AuthUser(result);
                    }
                    this.isLoading = false;
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
