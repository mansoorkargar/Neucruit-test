<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Neucruit</title>

    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <style>
        .modal-backdrop {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-wrapper {
            width: 100%;
            max-width: 562px;
            padding: 35px;
            background-color: white;
            border: 1px solid #DEE2E6;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.12), 0 20px 20px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            position: fixed;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            z-index: 999999;
        }

        h2 {
            font-weight: 600;
            font-size: 20px;
            line-height: 25px;
        }

        .message {
            font-size: 14px;
            line-height: 22px;
            color: rgba(84, 89, 94, 0.6);
        }

        .img {
            width: 56px!important;
            margin-right: 24px;
        }
    </style>
</head>

<body>
    @if(Session::has('error'))
        <div class="modal-backdrop">
            <div id="modal" class="modal-wrapper">
                <div class="d-flex align-items-center">
                    <img class="img" src="/images/check-img.png" alt="">
                    <div>
                        <h2>We’ve received your registration form!</h2>
                        <p class="message">Hold tight, your study page will be generated soon. We
                            will send you an email once set-up has complete</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="app"></div>

    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
