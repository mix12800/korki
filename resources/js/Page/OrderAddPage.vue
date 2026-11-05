<template>
    <div class="form">
        <div class="mb-3 form-title"><h2>Формирование заявки</h2></div>
        <div class="form-floating mb-3">
            <input
                type="date"
                class="form-control focus-ring focus-ring-dark border"
                id="date"
                v-model="date"
                placeholder="date"
                :class="{ 'is-invalid': errors.date }"
                :disabled="isLoading"
            />
            <label for="date">Желаемая дата начала обучения</label>
            <div v-if="errors.date" class="invalid-feedback">
                {{ errors.date.join(". ") }}
            </div>
        </div>
        <div class="mb-3">
            <select
                class="form-select form-select-lg"
                aria-label=".form-select-lg пример"
                :disabled="isLoading"
                :class="{ 'is-invalid': errors.course_id }"
                v-model="course_id"
            >
                <option value="">Наименование курса</option>
                <template v-for="Course in Courses">
                    <option :value="Course.id">
                        {{ Course.name }}
                    </option>
                </template>
            </select>
            <div v-if="errors.course_id" class="invalid-feedback">
                {{ errors.course_id.join(". ") }}
            </div>
        </div>

        <div class="mb-3">
            <p>Удобный способ оплаты</p>
            <input
                type="radio"
                class="btn-check"
                name="options-outlined"
                id="success-outlined"
                value="cash"
                v-model="pay"
                autocomplete="off"
                :disabled="isLoading"
            />
            <label class="btn btn-outline-dark m-1" for="success-outlined"
                >наличными</label
            >
            <input
                type="radio"
                class="btn-check"
                name="options-outlined"
                id="danger-outlined"
                value="translation"
                v-model="pay"
                autocomplete="off"
                :disabled="isLoading"
            />
            <label class="btn btn-outline-dark m-1" for="danger-outlined"
                >переводом по номеру телефона</label
            >
        </div>
        <button
            @click="OrderAdd()"
            class="btn btn-dark btn-lg w-100"
            :disabled="isLoading"
        >
            Отправить
        </button>
    </div>
</template>
<script>
export default {
    name: "OrderAddPage",
    props: ["server", "ChangePage"],

    data() {
        return {
            pay: "cash",
            date: "",
            course_id: "",
            isLoading: false,
            errors: {},
            Courses: [],
        };
    },

    mounted() {
        this.CoursesGet();
    },

    methods: {
        CoursesGet() {
            this.server("course")
                .then((result) => {
                    this.Courses = result.courses;
                })
                .catch((error) => console.error(error));
        },

        OrderAdd() {
            this.isLoading = true;
            let formdata = new FormData();
            formdata.append("pay", this.pay);
            formdata.append("date", this.date);
            formdata.append("course_id", this.course_id);
            this.server("order", "POST", formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.ChangePage("MyOrdersPage");
                    }
                    this.isLoading = false;
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
