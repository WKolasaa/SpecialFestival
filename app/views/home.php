  <?php 
    include __DIR__ . '/header.php'; 
    $headerImagePath = $service->getContent("Header Image");
    ?>
      
  <header>
    <img src="<?= htmlspecialchars($headerImagePath) ?>" alt="Haarlem Festival 2024" class="header-image">
  </header>
    <section class="festival-intro">
      <h1><?= $service->getContent('Intro Title'); ?></h1>
      <p><?= $service->getContent('Intro Text'); ?></p>
    </section>
    <section class="event-highlights">
      <a href="somePage.php" class="event">
        <img src="<?= $service->getContent('Teylers Event Image'); ?>" alt="Teyler's app" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Teylers Event Title'); ?></h2>
      </a>
      </a>
      <a href="/danceevent" class="event">
        <img src="<?= $service->getContent('Dance Event Image'); ?>" alt="Dance Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Dance Event Title'); ?></h2>
      </a>
      <a href="somePage.php" class="event">
        <img src="<?= $service->getContent('Yummy Event Image'); ?>" alt="Yummy Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Yummy Event Title'); ?></h2>
      </a>
      <a href="/HistoryMain" class="event"> 
        <img src="<?= $service->getContent('History Event Image'); ?>" alt="History Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('History Event Title'); ?></h2>
      </a>
    </section>
  </main>

    <?php
    include __DIR__ . '/footer.php';

  ?>
