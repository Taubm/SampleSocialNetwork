SampleSocialNetwork
===============

jquery+php+mysql 

Написать мини-социальную сеть. 
Функционал:
1. Регистрация пользователя. ФИО, email, пол, пароль. Проверка обязательности полей. 
2. "Стена" пользователя, где пользователь может оставлять сообщения. На странице помещается 20 сообщений, далее постраничная разбивка.
3. Другие зарегистрированные пользователи могут оставлять комментарии к сообщениям пользователя на его стене. Отображается только последний комментарий, остальные комментарии могут подгружаются с помощью AJAX.
4. Профиль пользователя - информация о пользователе, количество сообщений, комментариев и т.п.
5. Список популярных пользователей - 10 пользователей с максимальным количеством комментариев к их записям за последнюю неделю.
    
Настройки - в файле conf.php
Дамп БД - snetwork.sql

Тестовые пользователи:
ivan@mail.ru - 178500
anna@mail.ru - test