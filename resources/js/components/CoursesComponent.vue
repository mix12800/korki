<template>
    <div class="p-3">
        <button
            class="btn btn-dark"
            data-bs-toggle="modal"
            data-bs-target="#AddModal"
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
                <tr>
                    <th>
                        <!-- <span class="placeholder col-2"></span> -->
                        1
                    </th>
                    <td>
                        <!-- <a
                class="btn btn-dark disabled placeholder col-6"
                aria-disabled="true"
              ></a> -->
                        Шашки
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
                            >
                                Изменить <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#DelModal"
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

    <!-- Модальное окно Добавить курс -->
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
                        Удалить курс?
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-lg w-100">
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

    <!-- Модальное окно Добавить курс -->
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Добавить курс
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-body">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Назвение"
                    />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark w-100">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "CoursesComponent",
};
</script>
