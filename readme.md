yii2-advanced + vue.js 

## Установка

1. клонируем проект с github

```
git clone https://github.com/disasterovich/test-yii2-advanced-vue.git
```

2. Создаем БД, прописываем свои логин, пароль, имя бд. (в файле /path/to/yii-application/common/config/main-local.php или в /path/to/yii-application/common/config/main.php). 

3. Переходим в корень проекта и устанавливаем composer и npm пакеты

```
composer install
npm install
```

4. Выполняем миграции:

```
yii migrate
```

5. Настраиваем отображение бэкенда и фронтенда как описано в документации - https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md

Заходим на фронтенд (например http://test-yii2-advanced-vue-frontend.localhost/index.php?r=site%2Fsignup) и регистрируем пользователя

Переходим в бекэнд (например http://test-yii2-advanced-vue-backend.localhost/site/login) и авторизуемся.

Далее в браузере переходим на индексную страницу бэкенда (например http://test-yii2-advanced-vue-backend.localhost/)

Нажимаем кнопку генерации. Проверяем уходят ли ajax запросы на сервер.

