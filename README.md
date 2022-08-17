# sharing-vision-test
sharing vision test

Please clone git first with command below:
git clone https://github.com/nbmahsyar/sharing-vision-test.git

and install PHP dependecies with command below:
composer install

For the next step you must copy .env.example file to .env file.
After that, please setting this part below:
DB_DATABASE=YOUR_OWN_DATABAE
DB_USERNAME=YOUR_OWN_USER
DB_PASSWORD=YOUR_OWN_PASSWORD

Afterward, you must generate the key with command below:
php artisan key:generate

And than run:
php artisan migrate
npm install


## Microservices ##
- Membuat article baru
(POST): /api/article

-Menampilkan seluruh article di database dengan paging pada parameter limit & offset.
(GET): /article/<limit>/entries/<offset>

- Menampilkan article dengan id yang di-request
(GET): /api/article/<id>

- Merubah data article dengan id yang di-request
(POST): /api/article/<id>
param:
"id":"2"
body:
”title”: ””,
”content”: ””,
”category”:””,
”status”:””

- Menghapus data article dengan id yang di request
(DELETE): /api/article/<id>/delete
