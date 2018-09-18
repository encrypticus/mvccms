// Основной js-файл админ-панели

var formNotification = new APP.Widget.Notification.CheckForm({//Объект уведомления проверки формы

    color: "yellow",//цвет текста уведомления

    fontSize: "larger",//размер шрифта уведомления

    boxShadow: "-5px 5px 10px gray",//тень

    duration: 1000,//время проказа уведомления

    borderRadius: "5px",//радиус скругления углов уведомления

    left: "100px",

    top: "10px"
  }),

  btnAddPage = $('#btnAddPage'),//кнопка отправки формы добавления страницы в БД

  btnUpdatePage = $('#btnUpdate'),//кнопка отправки формы обновления страницы в БД

  //Объект загрузчика контента создаваемой страницы на сервер
  formDataLoader = new APP.FormDataLoader({

    url: "/admin/page/add/",//url, куда следует отправить данные формы

    form_element: $("#add_content_form"),// jquery объект формы

    success: function (content) {//функция, которая выполнится в результате удачного ответа сервера
      /*formNotification.content(content);

      formNotification.hide();*/
      window.location = "/admin/page/edit/" + content;
    },

    beforeSend: function () {//функция, которая выполнится перед отправкой данных на сервер
      formNotification.show("Обработка данных...");
    }
  }),

  //Объект загрузчика контента обновляемой страницы на сервер
  formDataUpdater = new APP.FormDataLoader({

    url: "/admin/page/update/", //url, куда следует отправить данные формы

    form_element: $("#updateContentForm"),// jquery-объект формы

    success: function (content) {//функция, которая выполнится в результате удачного ответа сервера
      formNotification.content(content);

      formNotification.hide();
    },

    beforeSend: function () {//функция, которая выполнится перед отправкой данных на сервер
      formNotification.show("Обработка данных...");
    }
  });

formNotification.append();//добавление уведомления в DOM

//Обработка нажатия кнопки добавления страницы
btnAddPage.on('click', function () {
  formDataLoader.query();
});

//Обработка нажатия кнопки обновления страницы
btnUpdatePage.on('click', function () {
  formDataUpdater.query();
});

