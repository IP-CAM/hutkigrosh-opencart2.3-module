## Модуль интеграции с CMS OpenCart  2.3.x

Данный модуль обеспечивает взаимодействие между интернет-магазином на базе CMS Opencart версии 2.3.x и сервисом платежей hutkigrosh.by
  * Модуль интеграции для версии [OpenCart 1.5.x](https://github.com/esasby/hutkigrosh-opencart1.5-module)
  * Модуль интеграции для версии [OpenCart 2.1.x](https://github.com/esasby/hutkigrosh-opencart2.1-module)
  * Модуль интеграции для версии [OpenCart 2.2.x](https://github.com/esasby/hutkigrosh-opencart2.2-module)
  * Модуль интеграции для версии [OpenCart 3.0.x](https://github.com/esasby/hutkigrosh-opencart3.0-module)

### Требования ###
1. PHP 5.6 и выше 
1. Библиотека Curl 

### Инструкция по установке:
1. Создайте резервную копию вашего магазина и базы данных
1. Установите модуль [opencart23-hutkigrosh-payment-module.ocmod.zip](https://github.com/esasby/hutkigrosh-opencart2.3-module/blob/master/opencart23-hutkigrosh-payment-module.ocmod.zip) с помощью _Модули_ -> _Установка расширений_
1. Напротив модуля ХуткiГрош нажмите «Установить»

## Инструкция по настройке
1. Перейдите к настройке плагина через меню __Модули  -> Платежи__
1. Напротив модуля ХуткiГрош нажмите «Изменить».
1. Укажите обязательные параметры
    * Уникальный идентификатор услуги ЕРИП – ID ЕРИП услуги
    * Код услуги – код услуги в деревер ЕРИП. Используется при генерации QR-кода
    * Логин интернет-магазина – логин в системе ХуткiГрош.
    * Пароль интернет-магазина – пароль в системе ХуткiГрош.
    * Sandbox - перевод модуля в тестовый режим работы. В этом режиме счета выставляются в тестовую систему wwww.trial.hgrosh.by
    * Sms оповещение - включить информирование клиента по смс при успешном выставлении счета (выполняется шлюзом Хуткiгрош)
    * Email оповещение - включить информирование клиента по email при успешном выставлении счета (выполняется шлюзом Хуткiгрош)
    * Кнопка QR-code - если включена, то на итоговом экране клиенту будет доступна оплата счета по QR-коду
    * Кнопка Alfaclick - если включена, то на итоговом экране клиенту отобразится кнопка для выставления счета в Alfaclick
    * Кнопка Webpay - если включена, то на итоговом экране клиенту отобразится кнопка для оплаты счета картой (переход на Webpay)
    * Статус при выставлении счета  - какой статус выставить заказу при успешном выставлении счета в ЕРИП (идентификатор существующего статуса из Магазин > Настройки > Статусы)
    * Статус при успешной оплате счета - какой статус выставить заказу при успешной оплате выставленного счета (идентификатор существующего статуса)
    * Статус при отмене оплаты счета - какой статус выставить заказу при отмене оплаты счета (идентификатор существующего статуса)
    * Статус при ошибке оплаты счета - какой статус выставить заказу при ошибке выставленния счета (идентификатор существующего статуса)
    * Путь в дереве ЕРИП - путь для оплаты счета в дереве ЕРИП, который будет показан клиенту после оформления заказа (например, Платежи > Магазин > Заказы)
    * Срок действия счета - как долго счет, будет доступен в ЕРИП для оплаты
1. Сохраните изменения.

### Внимание!
* Для автоматического обновления статуса заказа (после оплаты клиентом выставленного в ЕРИП счета) необходимо сообщить в службу технической поддержки сервиса «Хуткi Грош» адрес обработчика:
    ```
    http://mydomen.my/index.php?route=extension/payment/hutkigrosh/notify
    ```
* Модуль ведет лог файл по пути _site_root/upload/system/library/esas/vendor/esas/hutkigrosh-api-php/logs/hutkigrosh.log_
Для обеспечения **безопасности** необходимо убедиться, что в настройках http-сервера включена директива _AllowOverride All_ для корневой папки.

### Тестовые данные
Для настрой оплаты в тестовом режиме
 * воспользуйтесь данными для подключения к тестовой системе, полученными при регистрации в ХуткiГрош
 * включите в настройках модуля режим "Песочницы" 
 * для эмуляции оплаты клиентом выставленного счета воспльзуйтесь личным кабинетом [тестовой системы](https://trial.hgrosh.by) (меню _Тест оплаты ЕРИП_)

_Разработано и протестировано с OpenCart v.2.3.0.2_

