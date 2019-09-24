Приложение позоляет вывести список пользователей а так же добавить юзера.

Базовые роуты: 
GET:/api/users
POST:/api/user/save

Пример POST запроса:

{
"first_name" : "Name",
"last_name" : "Last Name",
"mid_name" : "Mid Name",
"city_id" : "6",
"address" : "Nur-Sultan, Respublika st. 5",
"email" : "qwerty@email.com",
"phone_number" : "87774563214"
}

application/json
