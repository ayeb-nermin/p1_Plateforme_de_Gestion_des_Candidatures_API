<!doctype html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,shrink-to-fit=no">
    <style>
        .content {
            margin-bottom: 5%;
        }

        .table_taux td {
            border: 0.5px solid #000;
            font-size: 14px;
            padding: 5px;
        }

        .table_taux2 {
            border: 0.5px solid #000;
            font-size: 14px;
            padding: 5px;
        }

        .text-uppercase {
            text-transform: uppercase
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .width-100 {
            width: 100%
        }

        .table_taux td.border-none {
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
            border-bottom: none !important;
        }

        .table-client {
            border: 1px solid #000
        }
    </style>
</head>

<body>
    <div class="content">
        {!! $template !!}
    </div>
</body>

</html>
