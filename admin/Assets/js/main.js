// Основной js-файл админ-панели
var formNotification = new APP.Widget.Notification.CheckForm({//Объект уведомления проверки формы

    color: "yellow",//цвет текста уведомления

    fontSize: "larger",//размер шрифта уведомления

    boxShadow: "-5px 5px 10px gray",//тень

    duration: 2000,//время проказа уведомления

    borderRadius: "5px",//радиус скругления углов уведомления

    left: "10px",

    top: "10px"
  }),

  btnAddBook = $('#btnAddBook'),//кнопка отправки формы добавления книги в БД

  btnUpdateBook = $('#btnUpdateBook'),//кнопка отправки формы обновления книги в БД

  //Объект загрузчика контента создаваемой книги на сервер
  formDataLoader = new APP.FormDataLoader({

    url: "/admin/books/addBookData/",//url, куда следует отправить данные формы

    form_element: $("#addBookForm"),// jquery объект формы

    success: function (content) {//функция, которая выполнится в результате удачного ответа сервера
      formNotification.content(content);
      console.log(content);
      formNotification.hide();
      /*  jQuery.get('/admin/Config/settings.php', function (data) {
       var settings = $.parseJSON(data);
       console.log(settings);
       //if(settings.clearForm == 'on') formDataLoader.reset();
       });*/
      //formDataLoader.reset();
      //window.location = "/admin/page/edit/" + content;
    },

    beforeSend: function () {//функция, которая выполнится перед отправкой данных на сервер
      formNotification.show("Обработка данных...");
    }
  }),

  //Объект загрузчика контента обновляемой книги на сервер
  formDataUpdater = new APP.FormDataLoader({

    url: "/admin/books/editBookData/", //url, куда следует отправить данные формы

    form_element: $("#updateBookForm"),// jquery-объект формы

    success: function (content) {//функция, которая выполнится в результате удачного ответа сервера
      try {
        //парсинг json в объект
        content = JSON.parse(content);

        //сообщение как свойства распарсенного объекта
        formNotification.content(content.message);

        //если объект содержит указанное свойство - вставить изображение обложки в указанный элемент
        if (content.hasOwnProperty('coverUrl')) $('#coverContainer')[0].src = content.coverUrl;

        //если объект содержит указанное свойство - вставить строковое значение пути до файла книги в указанный элемент
        if (content.hasOwnProperty('bookFileName'))  $('#urlContainer').text(content.bookFileName);

      } catch (e) {//если ответ сервера не является валидной json-строкой - отобразить его как сообщение
        formNotification.content(content);

      } finally {//скрыть сообщение
        formNotification.hide();
      }
    },

    beforeSend: function () {//функция, которая выполнится перед отправкой данных на сервер
      formNotification.show("Обработка данных...");
    }
  });

formNotification.append();//добавление уведомления в DOM

//Обработка нажатия кнопки добавления книги
btnAddBook.on('click', function () {
  formDataLoader.query();
});

//Обработка нажатия кнопки обновления книги
btnUpdateBook.on('click', function () {
  formDataUpdater.query();
});
