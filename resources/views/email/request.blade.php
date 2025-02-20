<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="ru">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <style type="">
        @font-face {
            font-family: 'Raleway';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap) format('woff2');
        }

        * {
            font-family: 'Raleway', Verdana, serif;
        }
    </style>
    <title></title>
</head>

<body style="margin:0 auto;padding:50px;color:#3E3E3E">

<table align="center" width="100%" border="0" cellPadding="0" cellSpacing="0" role="presentation"
       style="max-width:600px;width:100%">
    <tbody>
    <tr style="width:100%">
        <p>Компания: {{ $request->company }}</p>
    </tr >
    <tr style="width:100%">
        <p>Имя и Фамилия заказчика: {{ $request->name . ' ' . $request->surname }}</p>
    </tr>
    <tr>
        <p>Телефон заказчика: {{ $request->phone }}</p>
    </tr>
    <tr>
        <p>Email заказчика: {{ $request->email }}</p>
    </tr>
    <tr>
        <p>Приблизительный бюджет: {{ $request->budget }}</p>
    </tr>
    <tr>
        <p>Услуга: {{ $request->service }}</p>
    </tr>
    <tr style="width:100%">
        <p>Описание: {{ $request->description }}</p>
    </tr>
    </tbody>
</table>
</body>

</html>

