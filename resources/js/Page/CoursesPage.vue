<template>
    <div class="p-3">
        <button
            class="btn btn-dark"
            data-bs-toggle="modal"
            data-bs-target="#AddModal"
            @click="Clear"
        >
            Добавить курс
        </button>
    </div>

    <div class="p-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Назвение</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(Course, key) in Courses" :key="key">
                    <th>
                        <!-- <span class="placeholder col-2"></span> -->
                        {{ key + 1 }}
                    </th>
                    <td>
                        <!-- <a
                class="btn btn-dark disabled placeholder col-6"
                aria-disabled="true"
              ></a> -->
                        {{ Course.name }}
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button
                                type="button"
                                class="btn btn-dark"
                                data-bs-toggle="modal"
                                data-bs-target="#AddModal"
                                @click="CourseGet(key)"
                            >
                                Изменить <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#DelModal"
                                @click="CourseGet(key)"
                            >
                                Удалить <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <!-- <a
                class="btn btn-dark disabled placeholder col-6"
                aria-disabled="true"
              ></a> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно Удалить курс -->
    <div
        class="modal fade"
        id="DelModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Удалить курс: {{ Course.name }} ?
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        id="closeDelModal"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        @click="CourseDelete(Course.id)"
                        class="btn btn-danger btn-lg w-100"
                    >
                        Удалить
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary btn-lg w-100"
                        data-bs-dismiss="modal"
                    >
                        Отмена
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Добавить/Удалить курс -->
    <div
        class="modal fade"
        id="AddModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1
                        class="modal-title fs-5"
                        v-if="Course.id"
                        id="exampleModalLabel"
                    >
                        Редактировать курс: {{ Course.name }}
                    </h1>
                    <h1 v-else class="modal-title fs-5" id="exampleModalLabel">
                        Добавить курс
                    </h1>

                    <button
                        type="button"
                        class="btn-close"
                        id="closeAddModal"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-body">
                    <input
                        type="text"
                        class="form-control focus-ring focus-ring-dark"
                        :class="{ 'is-invalid': errors.name }"
                        :disabled="isLoading"
                        placeholder="Назвение"
                        v-model="name"
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name.join(". ") }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        @click="CourseAdd"
                        :disabled="isLoading"
                        class="btn btn-dark w-100"
                    >
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "CoursesPage",
    props: ["server"],

    data() {
        return {
            name: "",
            errors: {},
            isLoading: false,
            Course: {},
            Courses: [],
        };
    },

    mounted() {
        this.CoursesGet();
    },

    methods: {
        CourseGet(key) {
            this.Course = this.Courses[key];
            this.name = this.Course.name;
        },

        Clear() {
            this.Course = {};
            this.name = "";
        },

        CourseDelete(id) {
            this.server(`course/${id}`, "DELETE")
                .then((result) => {
                    this.CoursesGet();
                    this.Course = {};
                    document.querySelector("#closeDelModal").click();
                })
                .catch((error) => console.error(error));
        },

        CourseAdd() {
            this.isLoading = true;
            let formdata = new FormData();
            formdata.append("name", this.name);
            this.server(
                this.Course.id ? `course/${this.Course.id}` : "course",
                this.Course.id ? "PATCH" : "POST",
                formdata,
            )
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.CoursesGet();
                        document.querySelector("#closeAddModal").click();
                        this.errors = {};
                        this.name = "";
                    }
                    this.isLoading = false;
                })
                .catch((error) => console.error(error));
        },

        CoursesGet() {
            this.server("course")
                .then((result) => {
                    this.Courses = result.courses;
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
