<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haarlem Festival</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="/css/festival.css">

    <?php
    $currentPage = explode('?', $_SERVER["REQUEST_URI"], 2)[0];
    $currentPage = trim($currentPage, '/');

    // loadTime is way faster
    if (!str_starts_with($currentPage, 'api/')) {
        //Adjust CSS file based on the current page
        switch ($currentPage) {
            case '':
                $cssFile = 'homeStyle.css';
                break;
            case 'AdminView/orders':
                $cssFile = 'admin/orders.css';
                break;
            case 'AdminView/manageUser':
                $cssFile = 'admin/manageuser.css';
                break;
            case 'DanceEvent':
                $cssFile = 'Dance/overview.css';
                break;
            case 'AdminView/dance':
                $cssFile = 'admin/danceAdminEvent.css';
                break;
            case 'HistoryMain':
                $cssFile = 'History/HistoryMain.css';
                break;
            case 'HistoryMain/port':
                $cssFile = 'History/HistoryPort.css';
                break;
            case 'HistoryMain/windmill':
                $cssFile = 'History/HistoryWindmill.css';
                break;
            case 'AdminView/history':
                $cssFile = 'admin/HistoryAdmin.css';
                break;
            case 'AdminView':
                $cssFile = 'admin/HomeAdmin.css';
                break;
            case 'HistoryMain/cart':
                $cssFile = 'History/HistoryAddingToCart.css';
                break;
            case 'DanceEvent/agenda':
                $cssFile = 'Dance/agenda.css';
                break;
            case 'DanceEvent/session':
                $cssFile = 'Dance/session.css';
                break;
            case 'DanceEvent/artist':
                $cssFile = 'Dance/artist.css';
                break;
            case 'yummy':
            case 'restaurants':
                $cssFile = 'YummyMain.css';
                break;
            case 'AdminView/yummy':
                $cssFile = 'admin/danceAdminEvent.css';
                break;
            case 'FestPlan':
                $cssFile = 'festplan.css';
                break;
            case 'PageManagement/showPage':
                $cssFile = 'customPages.css';
                break;
            default:
                $defaultCssFile = 'festival.css';
                $cssFile = $defaultCssFile;
                break;
        }
        echo '<link rel="stylesheet" href="/css/' . $cssFile . '">';

    }
    ?>
</head>

<body>