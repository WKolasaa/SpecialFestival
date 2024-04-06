<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haarlem Festival</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/festival.css">

    <?php
    $currentPage = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $currentPage = trim($_SERVER["REQUEST_URI"], '/');
    // echo $currentPage;
    
    // loadTime is way faster
    if (!str_starts_with($currentPage, 'api/')) {
        //Adjust CSS file based on the current page
        switch ($currentPage) {
            case '':
                $cssFile = 'homeStyle.css';
                break;
                case 'adminView/orders':
                    $cssFile = 'admin/orders.css';
                    break;
            case 'adminView/manageUser':
                $cssFile = 'admin/manageuser.css';
                break;
            case 'danceevent':
                $cssFile = 'Dance/overview.css';
                break;
            case 'adminView/dance':
                $cssFile = 'admin/danceAdminEvent.css';

                break;
            case 'HistoryMain':
                $cssFile = 'HistoryMain.css';
                break;
            case 'danceevent/agenda':
                $cssFile = 'Dance/agenda.css';
                break;
            case 'danceevent/session':
                $cssFile = 'Dance/session.css';
                break;
            case 'danceevent/artist':
                $cssFile = 'Dance/artist.css';
                break;
            case 'YummyMain':
                $cssFile = 'YummyMain.css';
                break;
            case 'admin/yummyAdmin':
                $cssFile = 'admin/danceAdminEvent.css';
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