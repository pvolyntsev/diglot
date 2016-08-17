<?php

$this->title = 'Руководство по импорту статей с github';
?>
<style>
    .c-page-header {
    }

    .c-person {
        margin-top: 3em;
    }
    .c-person .c-info .c-img {
        width: 100%;
        max-height: 400px;
        overflow: hidden;
        margin: 0 auto;
    }

    .c-person .c-info .c-img > img {
        width: 100%;
        display: block;
        transition: opacity 0.15s;
        opacity: 0.8;
    }

    .c-person .c-info .c-img:hover > img {
        opacity: 1;
    }

    .c-person .c-name {
        display: inline-block;
        float: left;
        font-size: 20px;
        color: #3f444a;
        font-weight: 600 !important;
        text-transform: uppercase;
        margin-top: 10px;
    }
    .c-person .c-socials {
        display: inline-block;
        float: right;
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }
    .c-person .c-socials > li {
        padding: 0;
        margin: 0;
        display: inline-block;
    }
    .c-person .c-socials > li a {
        font-size: 24px;
        color: #7a838e;
        text-decoration: none;
    }

    .c-person .c-position {
        clear: both;
        margin-top: 0;
        display: inline-block;
        float: left;
        font-size: 14px;
        font-weight: 400;
        text-transform: uppercase;
        color: #7a838e;
    }

    .c-person .c-bio {
        clear: both;
        padding-top: 20px;
    }

</style>

<h2 class="c-page-header align center"><?=$this->title?></h2>

<h3>Запуск импорта статей с github</h3>
<ol>
    <li>Необходимо авторизоваться через <strong>github-аккаунт</strong> или добавить его к своему существующему профилю</li>
    <li>После этого на странице профиля появится ссылка <strong>запуска импорта с github</strong></li>
    <li>Через некоторое время статья появится в <strong>черновиках страницы профиля</strong></li>
</ol>

<h3>Оформление репозитория для импорта статей с github</h3>
<ol>
    <li>Пример правильно оформленного репозитория - <a href="https://github.com/poymanov/diglottest">https://github.com/poymanov/diglottest</a></li>
    <li>В корне репозитория должен быть создан файл <strong><a href="https://github.com/poymanov/diglottest/blob/master/diglot.ini">diglot.ini</a></strong>
        <ul>
            <li>В параметре <strong>[branch]</strong> нужно указать название активной ветки проекта. Именно в ней будет происходить поиск материалов для импорта</li>
            <li>В параметре <strong>[article]</strong> указываются папки (в структуре репозитория), в которых будет происходить поиск материалов</li>
        </ul>
    </li>
    <li>
        В папке со статьей находятся файлы, обязательные для осуществления импорта:
        <ul>
            <li>
                <a href="https://github.com/poymanov/diglottest/blob/master/test-article-number-one/meta.ini">
                    meta.ini
                </a>
                <p>Содержит служебную информацию импортируемой статьи:</p>
                <ul>
                    <li>
                        <strong>page-mode</strong> - содержит значение по умолчанию. Просто перенести в свой файл.
                    </li>
                    <li>
                        <strong>orig-language</strong> - оригинальный язык статьи. Должен содержать значение языка, который поддерживается diglot
                    </li>
                    <li>
                        <strong>translate-language</strong> - язык перевода статьи. Должен содержать значение языка, который поддерживается diglot
                    </li>
                    <li>
                        <strong>orig-title</strong> - оригинальное название статьи
                    </li>
                    <li>
                        <strong>orig-url</strong> - url оригинальной статьи (источник)
                    </li>
                    <li>
                        <strong>orig-author-url</strong> - url страницы автора оригинальной статьи
                    </li>
                    <li>
                        <strong>orig-author-title</strong> - имя/псевдоним автора оригинальной статьи
                    </li>
                    <li>
                        <strong>orig-tags</strong> - тэги оригинальной статьи. Обязательно через запятую
                    </li>
                    <li>
                        <strong>trans-title</strong> - название перевода статьи
                    </li>
                    <li>
                        <strong>trans-url</strong> - url перевода статьи
                    </li>
                    <li>
                        <strong>trans-author-url</strong> - url страницы переводчика статьи
                    </li>
                    <li>
                        <strong>trans-author-title</strong> - имя/псевдоним автора перевода
                    </li>
                    <lil>
                        <strong>trans-tags</strong> - тэги переведенной статьи. Обязательно через запятую
                    </lil>
                </ul>
            </li>
            <li>
                <a href="https://github.com/poymanov/diglottest/blob/master/test-article-number-one/original.md">
                    original.md
                </a>
                <p>Содержит контент в исходном языке</p>
            </li>
            <li>
                <a href="https://github.com/poymanov/diglottest/blob/master/test-article-number-one/translate.md">
                    translate.md
                </a>
                <p>Содержит контент в переведенном виде</p>
            </li>
        </ul>
    </li>
    <li>
        Контент статьи должен быть оформлен на языке разметки <strong>markdown</strong>
    </li>
    <li>
        Блоки текста в файлах original.md/translate.md должны быть отделены друг от друга разделителем <strong>---</strong>
    </li>
</ol>