    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Haarlem Festival</title>
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css"/>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            
            <!-- <script src="https://cdn.tailwindcss.com"></script> -->
            <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"> -->
            
            <link rel="stylesheet" href="css/festival.css">
        <?php
        $currentPage = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $currentPage = pathinfo($currentPage, PATHINFO_FILENAME);

        // loadTime is way faster
        if (!str_starts_with($currentPage, 'api/')) {
            // Set default CSS file
            $defaultCssFile = 'festival.css';

            //Adjust CSS file based on the current page
            switch ($currentPage) {
                case '':
                    $cssFile = 'homeStyle.css';
                    break;
                    case 'manageuser':
                    $cssFile = 'manageuser.css';
                    break;
                    case 'DanceMain':
                        $cssFile = 'DanceMain.css';
                        break;
                    case 'HistoryMain':
                        $cssFile = 'HistoryMain.css';
                        break;
                default:
                    $cssFile = $defaultCssFile;
                    break;
            }
            echo '<link rel="stylesheet" href="css/' . $cssFile . '">';

        }
        ?>
        </head>

        <body>

