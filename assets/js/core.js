/**
 * Форма добавления комментария
 * @type {HTMLElement}
 */
let newCommentForm = document.getElementById('add-new-comment-form');
/**
 * Кнопка показа формы добавления комментария
 * @type {HTMLElement}
 */
let newCommentBtn = document.getElementById('add-new-comment-btn');
/**
 * Блок списка комментариев
 * @type {HTMLElement}
 */
let commentsListDiv = document.getElementById('comments-list');
/**
 * Сабмит формы добавления комментария
 * @type {HTMLElement}
 */
let newCommentSubmitBtn = document.getElementsByName('add-new-comment-form-sbm')[0];
/**
 * Текущая страница
 * @type {number}
 */
let currentPage = 1;
/**
 * Маска для проверки e-mail
 * @type {RegExp}
 */
const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

/**
 * Метод загрузки комментариев
 * @returns {Promise<void>}
 */
async function loadComments() {
    let response;

    try {
        const request = await fetch("/core.php?controller=comments&method=index&page=" + currentPage);

        response = JSON.parse(await request.text());

        if(response.code === 200 && response.data.items.length) {
            commentsListDiv.innerHTML = response.data.items;
        }

        paginationButtons();
    } catch (e) {
        console.error(e);
    }
}

/**
 * Метод обработки события клика для перехода по страницам пагинации
 */
function paginationButtons() {
    let paginationLinks = document.getElementById('comments-pagination');

    if(paginationLinks !== null && paginationLinks.hasChildNodes()) {
        paginationLinks.childNodes.forEach(function(element) {
            element.addEventListener("click", function(e) {
                e.preventDefault();

                currentPage = this.getAttribute('data-page');

                loadComments();
            });
        });
    }
}

/**
 * Ивент, срабатывающий до загрузки страницы, когда все элементы уже есть
 * 1. событие клика на кнопку "добавить комментарий"
 * 2. загрузка комментариев
 */
window.addEventListener('DOMContentLoaded', () => {

    newCommentBtn.onclick = function (e) {
        e.preventDefault();

        if(newCommentForm.classList.contains('hidden')) {
            newCommentForm.removeAttribute('class');
        } else {
            newCommentForm.setAttribute("class", "hidden");
        }
    }

    loadComments();
});

/**
 * Событие при сабмите формы
 * @param e
 */
newCommentSubmitBtn.onclick = function (e) {
    e.preventDefault();

    insertComment();
};

/**
 * Метод отправки запроса для создания комментария
 * @returns {Promise<boolean>}
 */
async function insertComment() {
    let response;

    try {
        newCommentForm.querySelectorAll("span").forEach( e => {
            e.innerHTML = "";
        });

        newCommentForm.querySelectorAll("input, textarea").forEach( e => {
            e.classList.remove('error');
        });

        var formData = new FormData(newCommentForm);
        var formObject = {};

        formData.forEach((value, key) => formObject[key] = value);

        if(!validateForm(formObject)) {
            return false;
        }

        const request = await fetch("/core.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
                "Cache": "no-cache"
            },
            body: JSON.stringify({
                "controller": "comments",
                "method": "store",
                "item": formObject
            })
        });

        response = JSON.parse(await request.text());

        if(response.code === 200 && response.data.items.length) {
            alert('Ваш комментарий был добавлен!');
            commentsListDiv.innerHTML = response.data.items;
        } else if(response.code === 422 && Reflect.ownKeys(response.data.errors).length) {
            setValidationErrorsBackend(response.data.errors);
        }

        newCommentForm.reset();

        paginationButtons();
    } catch (e) {
        console.error(e);
    }
}

/**
 * Обработка ошибок валидации с бекенда
 * @param errors
 */
function setValidationErrorsBackend(errors) {
    Object.entries(errors).forEach(([key, value]) => {
        const input = document.getElementById(key);
        const span = document.getElementById('error-' + key);

        span.innerHTML = value;
        input.classList.add('error');
    });
}

/**
 * Валидация формы с данными
 * @param formData
 * @returns {boolean}
 */
function validateForm(formData) {
    let validated = true;
    Object.keys(formData).map(function (objectKey){
        let field = document.getElementById(objectKey);
        field.classList.remove('error');

        let isInvalid = false;
        const min = field.getAttribute('min') ?? 1;
        const max = field.max ?? 254;
        let span = document.getElementById("error-" +objectKey);
        span.innerHTML = "";

        switch (field.type) {
            default:
                isInvalid = field.value.length === 0 || min > field.value.length || max < field.value.length
                if(isInvalid) {
                    span.innerHTML = "Мин. кол-во символов " + min +". Макс. кол-во символов: " + max + "!";
                }
                break;
            case 'email':
                isInvalid = !emailRegExp.test(field.value);
                if(isInvalid) {
                    span.innerHTML = "Введите корректный e-mail!"
                }
                break;
        }

        if(isInvalid) {
            field.classList.add('error');
            validated = false;
        }
    });

    return validated;
}