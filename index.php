<html>
<head>
    <title>Test Comments</title>

    <link rel="stylesheet" href="/assets/css/style.css">
</head>


<body>
<h1 class="page-heading">Test Comments</h1>
<div class="preview-text">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
        laborum.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
        laborum.</p>
</div>

<div class="comments">
    <div class="new-comment">
        <div class="add-new-comment">
            <a href="#" id="add-new-comment-btn">Добавить комментарий</a>
        </div>
        <form id="add-new-comment-form" class="hidden" action="#" method="POST" enctype="multipart/form-data">
            <label for="name">Ваше имя</label>
            <input type="text" name="name" id="name" placeholder="Иван Иванов" min="3" max="40" required>
            <span id="error-name"></span>

            <label for="email">Ваш E-mail</label>
            <input type="email" name="email" id="email" placeholder="test@test.test" min="3" max="255" required>
            <span id="error-email"></span>

            <label for="title">Заголовок комментария</label>
            <input type="text" name="title" id="title" min="5" max="40" required>
            <span id="error-title"></span>

            <label for="title">Комментарий</label>
            <textarea name="comment" id="comment" rows="2" cols="2" min="10" max="255" required></textarea>
            <span id="error-comment"></span>

            <input type="submit" name="add-new-comment-form-sbm" value="Добавить">
        </form>
    </div>
    <div id="comments-list"></div>
</div>

<script src="/assets/js/core.js"></script>
</body>

</html>