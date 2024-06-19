<?php include __DIR__ . '/header.php';
  $dates = [
    '2024-07-04' => 'Thursday',
    '2024-07-05' => 'Friday',
    '2024-07-06' => 'Saturday',
    '2024-07-07' => 'Sunday'
  ];
    $headerImagePath = $service->getContent("Header Image");
?>

    <img src="<?= htmlspecialchars($headerImagePath) ?>" alt="Haarlem Festival 2024" class="header-image">
    
    <section class="festival-intro">
      <h1><?= $service->getContent('Intro Title'); ?></h1>
      <p><?= $service->getContent('Intro Text'); ?></p>
    </section>
    <section class="event-highlights">
      <a href="#" class="event">
        <img src="<?= $service->getContent('Teylers Event Image'); ?>" alt="Teyler's app" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Teylers Event Title'); ?></h2>
      </a>
      </a>
      <a href="/DanceEvent" class="event">
        <img src="<?= $service->getContent('Dance Event Image'); ?>" alt="Dance Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Dance Event Title'); ?></h2>
      </a>
      <a href="/yummy" class="event">
        <img src="<?= $service->getContent('Yummy Event Image'); ?>" alt="Yummy Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('Yummy Event Title'); ?></h2>
      </a>
      <a href="/HistoryMain" class="event">
        <img src="<?= $service->getContent('History Event Image'); ?>" alt="History Event" class="event-image">
        <h2 class="event-title"><?= $service->getContent('History Event Title'); ?></h2>
      </a>
    </section>

    <section class="festival-calendar">
        <?php foreach ($dates as $date => $dayName): ?>
            <div class="day-events">
                <h2><?= $dayName ?></h2>
                <?php $events = $service->getEventsByDate($date); ?>
                <?php if (count($events) > 0): ?>
                    <ul>
                        <?php foreach ($events as $event): ?>
                            <li>
                                <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                                <p><?= htmlspecialchars($event['event_description']) ?></p>
                                <span><?= $event['start_time'] ?> - <?= $event['end_time'] ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No events scheduled.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

  </main>

  <?php
  include __DIR__ . '/footer.php';

?>
