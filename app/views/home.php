<?php 
  include __DIR__ . '/header.php'; 
  ?>
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="homeStyle.css"> -->
<header>
  <img src="img/homePhoto.png" alt="Haarlem Festival 2024" class="header-image">
</header>
<main>
  <section class="festival-intro">
    <h1>Welcome to the Haarlem Festival 2024!</h1>
    <p> Immerse yourself in the heart of Haarlem's vibrant social scene at the Grote Markt, surrounded by historic facades and lively cafes. The festival kicks off with "Yummy!" from July 25 to 28, where local restaurants showcase special Festival menus at reduced prices. Then, from July 26 to 28, join "DANCE!" – a dynamic addition featuring top DJs in Back2Back sessions and experimental club sessions. Don't miss "A Stroll through History" from July 26 to 28, offering guided tours through Haarlem's historic sites. Explore the rich tapestry of Haarlem's culinary, musical, and historical delights. Check the Festival Excel program for details on sessions, timetables, and prices. We invite you to make the most of your summer at the Haarlem Festival!</p>
  </section>
  <section class="festival-events">
  </section>
  <section class="event-highlights">
    <a href="somePage.php" class="event">
      <img src="img/TeylersEvent.png" alt="Teyler's app" class="event-image">
      <h2 class="event-title">Teyler's app</h2>
    </a>
    <a href="/DanceMain" class="event">
      <img src="img/DanceEvent.jpg" alt="Dance Event" class="event-image">
      <h2 class="event-title">Dance Event</h2>
    </a>
    <a href="somePage.php" class="event">
      <img src="img/YummyEvent.jpg" alt="Yummy Event" class="event-image">
      <h2 class="event-title">Yummy Event</h2>
    </a>
    <a href="/HistoryMain" class="event"> 
      <img src="img/HistoryEvent.jpg" alt="History Event" class="event-image">
      <h2 class="event-title">History Event</h2>
    </a>
  </section>
</main>

<?php
include __DIR__ . '/footer.php';
    ?>
