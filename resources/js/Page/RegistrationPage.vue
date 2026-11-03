<template>
    <div class="form">
        <div class="mb-3 form-title">
            <h2>Регистрация</h2>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.fio }"
                id="fio"
                v-model="fio"
                placeholder="fio"
            />
            <label for="fio">ФИО</label>
            <div v-if="errors.fio" class="invalid-feedback">
                {{ errors.fio.join(". ") }}
            </div>
            <div v-else class="form-text">Символы кириллицы и пробелы</div>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.phone }"
                id="phone"
                v-model="phone"
                placeholder="phone"
            />

            <label for="phone">Телефон</label>
            <div v-if="errors.phone" class="invalid-feedback">
                {{ errors.phone.join(". ") }}
            </div>
            <div v-else class="form-text">Формат: 8(XXX)XXX-XX-XX</div>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.email }"
                id="email"
                v-model="email"
                placeholder="email"
            />
            <label for="email">Адрес электронной почты</label>

            <div v-if="errors.email" class="invalid-feedback">
                {{ errors.email.join(". ") }}
            </div>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark"
                :class="{ 'is-invalid': errors.login }"
                id="login"
                v-model="login"
                placeholder="login"
            />
            <label for="login">Логин</label>
            <div v-if="errors.login" class="invalid-feedback">
                {{ errors.login.join(". ") }}
            </div>
            <div v-else class="form-text">
                Латиница и цифры, не менее 6 символов
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
            />
            <label for="password">Пароль</label>
            <div v-if="errors.password" class="invalid-feedback">
                {{ errors.password.join(". ") }}
            </div>
            <div v-else class="form-text">Минимум 8 символов</div>
        </div>

        <button @click="BtnRegistration" class="btn btn-dark btn-lg w-100 mb-3">
            Создать пользователя
        </button>

        <div class="link-form mb-1">
            Уже зарегистрированы?
            <a href="Auth.html" @click.prevent="page('AuthPage')"
                >Авторизация</a
            >
        </div>
    </div>
</template>
<script>
export default {
    name: "RegistrationPage",
    props: ["page", "server"],

    data() {
        return {
            fio: "",
            phone: "",
            email: "",
            login: "",
            password: "",
            errors: {},
        };
    },

    methods: {
        BtnRegistration() {
            const formdata = new FormData();
            formdata.append("fio", this.fio);
            formdata.append("phone", this.phone);
            formdata.append("email", this.email);
            formdata.append("login", this.login);
            formdata.append("password", this.password);
            this.server("registration", "POST", formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
