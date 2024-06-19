-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 19, 2024 at 08:23 PM
-- Server version: 11.1.2-MariaDB-1:11.1.2+maria~ubu2204
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
                          `agendaId` int(11) NOT NULL,
                          `artistName` varchar(255) DEFAULT NULL,
                          `eventDay` varchar(255) DEFAULT NULL,
                          `eventDate` date DEFAULT NULL,
                          `eventTime` time DEFAULT NULL,
                          `durationMinutes` int(11) DEFAULT NULL,
                          `sessionPrice` decimal(10,2) DEFAULT NULL,
                          `sessionsAvailable` int(11) DEFAULT NULL,
                          `venueAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`agendaId`, `artistName`, `eventDay`, `eventDate`, `eventTime`, `durationMinutes`, `sessionPrice`, `sessionsAvailable`, `venueAddress`) VALUES
                                                                                                                                                                  (10, 'Afrojack, Tiësto, Nicky Romero', 'Saturday', '2024-07-27', '15:00:00', 520, 120.00, 2000, 'Caprera Openluchttheater, Hoge Duin en Daalseweg 2, 2061 AG Bloemendaal'),
                                                                                                                                                                  (13, 'Martin Garrix', 'Sunday', '2024-07-28', '18:00:00', 90, 60.00, 200, 'Club Stalker, Kromme Elleboogsteeg 20, 2011 TS Haarlem'),
                                                                                                                                                                  (27, 'Armin van Buuren', 'Sunday', '2024-07-28', '22:22:00', 90, 100.00, 100, 'Amsterdam'),
                                                                                                                                                                  (28, 'Nicky Romero/Afrojack', 'Friday', '2024-07-26', '20:00:00', 360, 75.00, 1500, 'Lichtfabriek, Minckelersweg 2, 2031 EM Haarlem'),
                                                                                                                                                                  (29, 'Tiësto', 'Friday', '2024-07-26', '22:00:00', 90, 60.00, 200, 'Club Stalker, Kromme Elleboogsteeg 20, 2011 TS Haarlem'),
                                                                                                                                                                  (30, 'Martin Garrix', 'Friday', '2024-07-26', '22:00:00', 90, 60.00, 200, 'Club Ruis, Smedestraat 31, 2011 RE Haarlem'),
                                                                                                                                                                  (31, 'Armin van Buuren', 'Friday', '2024-07-26', '22:00:00', 90, 60.00, 200, 'XO The Club, Grote Markt 8, 2011 RD Haarlem'),
                                                                                                                                                                  (32, 'Hardwell', 'Friday', '2024-07-26', '23:00:00', 90, 60.00, 300, 'Jopenkerk, Gedempte Voldersgracht 2, 2011 WD Haarlem'),
                                                                                                                                                                  (33, 'Hardwell, Martin Garrix, Armin van Buuren', 'Saturday', '2024-07-27', '14:00:00', 540, 110.00, 2000, 'Caprera Openluchttheater, Hoge Duin en Daalseweg 2, 2061 AG Bloemendaal'),
                                                                                                                                                                  (34, 'Tiësto', 'Saturday', '2024-07-27', '21:00:00', 240, 75.00, 1500, 'Lichtfabriek, Minckelersweg 2, 2031 EM Haarlem'),
                                                                                                                                                                  (35, 'Afrojack', 'Saturday', '2024-07-27', '21:00:00', 90, 75.00, 1500, 'Lichtfabriek, Minckelersweg 2, 2031 EM Haarlem'),
                                                                                                                                                                  (38, 'Nicky Romero', 'Saturday', '2024-07-27', '23:00:00', 90, 60.00, 200, 'Club Stalker, Kromme Elleboogsteeg 20, 2011 TS Haarlem'),
                                                                                                                                                                  (39, 'Hardwell', 'Sunday', '2024-07-28', '21:00:00', 90, 75.00, 1500, 'XO the Club,, Grote Markt 8, 2011 RD Haarlem');

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
                          `artistId` int(11) NOT NULL,
                          `artistName` varchar(255) DEFAULT NULL,
                          `style` varchar(255) DEFAULT NULL,
                          `description` varchar(1024) DEFAULT NULL,
                          `title` varchar(255) DEFAULT NULL,
                          `participationDate` date DEFAULT NULL,
                          `imageName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artistId`, `artistName`, `style`, `description`, `title`, `participationDate`, `imageName`) VALUES
                                                                                                                       (10, 'Martin Garrix', 'Dance / Electronic', 'Dive into the dynamic world of dance and electronic music with him. Experience his mesmerizing beats.', 'Electro Prodigy', '2024-07-27', '666c55c04aa61-wp1674223.jpg'),
                                                                                                                       (13, 'Nicky Romero', 'Electrohouse ', ' Step into the world of electrohouse and progressive house with Nicky Romero. Feel the electrifying beats.', 'Electro Luminary', '2024-07-28', '6615275f7314f-Nicky_Romero_Nofame2.jpg'),
                                                                                                                       (15, 'Hardwell', 'Dance and House', 'Elevate your night with electrifying dance and house beats, creating an experience in the vibrant setting of Jopenkerk.', 'Dance Dynamo', '2024-07-27', '65f7111e79ae1-dj-hardwell-wallpaper-preview.jpg'),
                                                                                                                       (16, 'Armin van Buuren', 'Trance and Techno', 'Experience the mesmerizing beats of Armin van Buuren in an intimate club setting at XO the Club.', 'Trance Titan', '2024-07-26', '66102497cf5da-maxresdefault.jpg'),
                                                                                                                       (49, 'Afrojack', 'House', 'Immerse yourself in the pulsating rhythms of Afrojack, delivering vibrant house beats in an intimate club atmosphere at XO the Club.', 'House Icon', '2024-07-27', '66152a39037cf-1.-Ultra-2019-7-kopieren.jpg'),
                                                                                                                       (57, 'Poliska', 'FreeStyle', 'I am the Real G in this World', 'Top G', '2024-07-27', '666c56640f865-martin-garrix-e1676543091971.png'),
                                                                                                                       (58, 'Tiësto', 'FreeStyle', 'Number One, yes that\'s me', 'Top T', '2024-07-27', '66705af03f0f2-66103e236b4b3-unnamed.jpg'),
                                                                                                                       (64, 'Poliska', 'pol pol', 'This is the G This is the G This is the G ', 'Top G', '2024-07-28', '66705daa3e2f3-6618d1595662e-5d711f7e-b535-40da-81b4-a1b72ecf9ca9 2.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE `custom_pages` (
                                `id` int(11) NOT NULL,
                                `title` varchar(255) NOT NULL,
                                `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danceOverview`
--

CREATE TABLE `danceOverview` (
                                 `id` int(11) NOT NULL,
                                 `header` varchar(255) DEFAULT NULL,
                                 `subHeader` varchar(255) DEFAULT NULL,
                                 `text` text NOT NULL,
                                 `imageName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danceOverview`
--

INSERT INTO `danceOverview` (`id`, `header`, `subHeader`, `text`, `imageName`) VALUES
                                                                                   (6, 'July 26-28, 2024', '     Unleash the Beat, Move join the Dance Celebration!', '(Unforgettable Dance Experience)', '65fb0ee6c8d2e-65f82aaececdd-wp5310238.jpg'),
                                                                                   (7, 'To Dance Festival !', 'July 26-28', 'Get ready to groove and have a blast with your family! We&#39;re counting down the days until the Family Dance Festival lights up Haarlem from July 26th to 28th. Don&#39;t miss the chance to join the fun – mark your calendars and get ready for a dance-filled family celebration', '66706f55e2377-65fb0ee6c8d2e-65f82aaececdd-wp5310238.jpg'),
                                                                                   (8, 'Back2Back', 'Saturday 27,2024  14:00 ', 'Experience a Saturday like never before at Caprera Openluchttheater, featuring the incredible beats of Hardwell, the dynamic melodies of Martin Garrix, and the transcendent tunes of Armin van Buuren. It&#39;s a back-to-back dance extravaganza, lasting 540 minutes! Limited tickets available, so secure your spot for a day of music and memories. Tickets: €110.00.', '660024107b8b7-Screenshot 2024-03-24 at 13.58.02.png'),
                                                                                   (9, 'Musical Marvel.', 'Friday 26,2024 20:00 ', 'Kick off your weekend with a bang at Lichtfabriek as Nicky Romero and Afrojack take the stage for a back-to-back musical journey! The beats will be non-stop for 360 minutes, creating a Friday night fever you won&#39;t want to miss. Limited tickets available – be part of the electrifying experience. Tickets: €75.00.', '66002881eca91-Together.jpeg'),
                                                                                   (10, 'Dynamic Trio.', 'Sunday 28,2024 14:00', 'Prepare for a revolutionary musical experience at Caprera Openluchttheater as Afrojack, Tiësto, and Nicky Romero unite for a back-to-back spectacle! Dive into 540 minutes of non-stop rhythms. Limited tickets available – join the revolution. Tickets: €110.00.', '66002b9f697a1-Screenshot 2024-03-24 at 13.58.49.png'),
                                                                                   (11, 'Armin van Buuren', 'Don&#39;t be a prisoner of your own style.', 'Armin van Buuren, often referred to as the &#34;King of Trance,&#34; is a Dutch DJ, record producer, and remixer. With his groundbreaking radio show &#34;A State of Trance&#34; and timeless tracks like &#34;This Is What It Feels Like,&#34; Armin has become synonymous with the trance genre. His unparalleled talent for crafting emotive melodies and captivating audiences with his mesmerizing performances has earned him a revered status in the electronic music community.', '660609166ad82-1690356818_gettyimages-1476895326-1.jpg'),
                                                                                   (12, 'Afrojack', 'Music is the universal language of mankind.&#34; - Afrojack', 'Afrojack, born Nick van de Wall, is a Dutch DJ, record producer, and remixer. He gained international fame with his breakout single &#34;Take Over Control&#34; featuring Eva Simons. Known for his energetic performances and innovative sound blending electro house, Dutch house, and EDM, Afrojack continues to influence the electronic music scene globally.', '6605fccb2a56a-Afrojack@2000x1500.jpg'),
                                                                                   (13, 'Hardwell', 'Go Hardwell or Go Home.', 'Hardwell, also known as Robbert van de Corput, is a Dutch DJ, record producer, and remixer. He rose to prominence with his hit tracks like \"Spaceman\" and \"Apollo,\" establishing himself as one of the leading figures in the EDM scene. With his dynamic performances and chart-topping releases, Hardwell has solidified his position as a powerhouse in electronic dance music.', '6605ff1184415-Hardwell-2022-002.jpg'),
                                                                                   (14, 'Tiësto', 'The energy from the crowd and my passion for music is what keeps me going.', 'Tiësto, born Tijs Michiel Verwest, is a Dutch DJ and record producer who has played a pivotal role in shaping the electronic dance music landscape. Renowned for his electrifying live sets and chart-topping hits like &#34;Adagio for Strings&#34; and &#34;Traffic,&#34; Tiësto has garnered widespread acclaim and earned a dedicated global following. His relentless pursuit of musical innovation and boundless energy on stage have made him a true icon in the EDM world.', '6610409baa128-tiesto2_autoOrient_i.jpg'),
                                                                                   (15, 'Martin Garrix', 'If you put everything in what you love to do, it&#39;s going to work out.', 'Martin Garrix, born Martijn Gerard Garritsen, is a Dutch DJ and record producer who shot to fame with his chart-topping single &#34;Animals&#34; at the age of 17. Since then, he has become one of the youngest and most successful artists in the electronic music industry. With his infectious energy and genre-defying sound, Martin continues to push boundaries and inspire a new generation of music enthusiasts worldwide.', '667062be67a34-6605ff6ecb352-1267480.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `festival_events`
--

CREATE TABLE `festival_events` (
                                   `id` int(11) NOT NULL,
                                   `event_name` varchar(255) DEFAULT NULL,
                                   `event_description` text DEFAULT NULL,
                                   `event_date` date DEFAULT NULL,
                                   `start_time` time DEFAULT NULL,
                                   `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `festival_events`
--

INSERT INTO `festival_events` (`id`, `event_name`, `event_description`, `event_date`, `start_time`, `end_time`) VALUES
                                                                                                                    (1, 'A Stroll through History', 'Location: Bavo ChurchHui', '2024-07-04', '10:00:00', '12:30:13'),
                                                                                                                    (3, 'Jazz Concert', 'Location: City Park.', '2024-07-04', '16:00:00', '18:30:00'),
                                                                                                                    (4, 'Poetry Reading', 'Location: Local Library.', '2024-07-04', '19:00:00', '21:00:00'),
                                                                                                                    (5, 'Culinary Workshop', 'Location: Downtown Market.', '2024-07-05', '10:00:00', '12:30:00'),
                                                                                                                    (6, 'Theater Performance', 'Location: Community Theater.', '2024-07-05', '13:30:00', '15:30:00'),
                                                                                                                    (7, 'Film Screening', 'Location: Old Cinema.', '2024-07-05', '16:00:00', '18:00:00'),
                                                                                                                    (8, 'Classical Music Concert', 'Location: Concert Hall.', '2024-07-05', '19:30:00', '22:00:00'),
                                                                                                                    (9, 'Guided Nature Walk ))', 'Location: City Park.', '2024-07-06', '10:00:00', '12:00:00'),
                                                                                                                    (22, 'zalupa', 'zalupa', '2024-07-06', '12:12:00', '16:55:00'),
                                                                                                                    (26, 'monetochka', 'coin', '2024-07-06', '07:00:00', '08:00:00'),
                                                                                                                    (58, 'ioyg', 'goug', '2024-07-06', '04:02:00', '07:06:00'),
                                                                                                                    (68, 'sjrat', 'sjty', '2024-07-07', '02:07:00', '03:07:00'),
                                                                                                                    (85, 'aferg', 'aergerg', '2024-07-07', '02:08:00', '07:39:00'),
                                                                                                                    (86, 'zaebalsa', 'jaafeeraferfsfgrsaregar', '2024-07-07', '17:07:00', '08:09:00'),
                                                                                                                    (87, '524', '2342376747667', '2024-07-07', '03:04:00', '04:03:00'),
                                                                                                                    (88, 'abeme', 'man', '2024-07-07', '17:08:00', '07:06:00'),
                                                                                                                    (89, '1472', 'rgthy', '2024-07-07', '02:08:00', '03:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `history_contents`
--

CREATE TABLE `history_contents` (
                                    `id` int(11) NOT NULL,
                                    `page_name` varchar(100) NOT NULL,
                                    `entry_name` varchar(100) NOT NULL,
                                    `entry_type` varchar(100) NOT NULL,
                                    `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_contents`
--

INSERT INTO `history_contents` (`id`, `page_name`, `entry_name`, `entry_type`, `content`) VALUES
                                                                                              (11, 'History Main', 'Festival Description', 'TEXT', 'Embark on a fascinating journey through Haarlem\'s rich history with our guided walking tour, a 2.5-hour exploration available on Thursdays, Fridays, Saturdays and Sundays. Departing from the heart of Haarlem, near the \'Church of St. Bavo\' at \'Grote Markt,\' our expert guides will lead you to iconic landmarks, including the magnificent St. Bavo\'s Church and the vibrant Grote Markt. With a 15-minute refreshment break, this immersive experience unveils hidden gems and lesser-known treasures. Tickets, available on-site or online, promise an unforgettable stroll through Haarlem\'s captivating history.'),
                                                                                              (12, 'History Port', 'Title ', 'TEXT', 'Amsterdam Port'),
                                                                                              (16, 'History Main', 'Seventh Location Name', 'TEXT', 'Adriaan Windmill'),
                                                                                              (17, 'History Main', 'Eighth Location Name', 'TEXT', 'Amsterdam Port'),
                                                                                              (18, 'History Main', 'Seventh Location Description', 'TEXT', 'Molen De Adriaan, a picturesque windmill situated on the banks of the Spaarne River in Haarlem, stands as a testament to the city\'s rich industrial heritage. Originally built in 1779, the mill has undergone restoration to preserve its historic charm. Visitors can explore the interior, witness the working machinery, and enjoy panoramic views of Haarlem from its observation deck.'),
                                                                                              (19, 'History Main', 'Eighth Location Description', 'TEXT', 'Amsterdamse Poort, a magnificent gate that once formed part of Haarlem\'s medieval city walls, exudes a sense of grandeur and historical significance. Constructed in the 14th century, this imposing structure served as a defensive gateway and showcased the city\'s wealth and prominence. Today, the Amsterdamse Poort stands as a captivating relic, offering a glimpse into Haarlem\'s past.'),
                                                                                              (20, 'History Main', 'Start Location Address', 'TEXT', 'Grote Markt 22, 2011 RD Haarlem'),
                                                                                              (25, 'History Port', 'Festival Description', 'TEXT', 'As you approach Amsterdamse Poort, you stand before a gateway that has witnessed centuries of Haarlem\'s narrative. Our expert guides will lead you through the towering arches, unraveling the rich history and architectural brilliance that define this medieval masterpiece. Prepare to be immersed in the stories etched into the stones, as we unveil the role this magnificent gateway played in shaping Haarlem\'s destiny.'),
                                                                                              (26, 'History Port', 'Amsterdam Port First Title', 'TEXT', 'History and Significance'),
                                                                                              (27, 'History Port', 'Amsterdam Port First Description', 'TEXT', 'Constructed in the 14th century, Amsterdamse Poort served as a formidable defender of Haarlem, its walls standing tall against the backdrop of changing times. Explore the intricate details of this historic structure, from the sturdy battlements to the symbolic carvings, and learn about the pivotal moments that have unfolded within and beyond its arches.'),
                                                                                              (28, 'History Port', 'Amsterdam Port Second Title', 'TEXT', 'Industrial Heritage and Cultural Significance'),
                                                                                              (29, 'History Port', 'Amsterdam Port Second Description', 'TEXT', 'Much more than a mere entrance, Amsterdamse Poort is a symbol of Haarlem\'s industrial and cultural heritage. Discover the layers of significance embedded in its stones, reflecting a city that thrived on trade, resilience, and the fortitude to protect its people. The gateway is not just a physical barrier; it\'s a bridge connecting Haarlem\'s past to the present.'),
                                                                                              (30, 'History Port', 'Amsterdam Port Third Title', 'TEXT', 'Transformation'),
                                                                                              (31, 'History Port', 'Amsterdam Port Third Description', 'TEXT', 'Originally named Spaarnwouderpoort for land travelers, this gate underwent a transformation with the introduction of a new canal and towpath, making travel to Amsterdam more accessible. Renamed Amsterdamse Poort, the gate faced demolition in 1865 due to its deteriorating condition. Despite initial plans, a short-term renovation was undertaken to buy time until funds were available for a new bridge.'),
                                                                                              (32, 'History Port', 'Amsterdam Port Fourth Title', 'TEXT', 'Renovation and Recognition'),
                                                                                              (33, 'History Port', 'Amsterdam Port Fourth Description', 'TEXT', 'The Amsterdamse Poort, a historic landmark, underwent several phases of care and restoration. Back in 1889, the city\'s architect, J. Leijh, led a modest renovation to maintain its structure, followed by further adjustments over time. In the 1960s, it was officially recognized as a national monument. This recognition led to a major renovation in 1985, aimed at preserving the gate\'s rich history and ensuring its legacy for future generations.'),
                                                                                              (74, 'History Main', 'Title', 'TEXT', 'A Stroll through History'),
                                                                                              (77, 'History Port', 'Amsterdam Port Map First Place', 'TEXT', 'Church of St.Bavo'),
                                                                                              (78, 'History Port', 'Amsterdam Port Map Second Place', 'TEXT', 'Grote Markt'),
                                                                                              (79, 'History Port', 'Amsterdam Port Map Third Place', 'TEXT', 'De Hallen'),
                                                                                              (80, 'History Port', 'Amsterdam Port Map Fourth Place', 'TEXT', 'Proveniershof'),
                                                                                              (81, 'History Port', 'Amsterdam Port Map Fifth Place', 'TEXT', 'Jopenpark'),
                                                                                              (83, 'History Port', 'Amsterdam Port Map Sixth Place', 'TEXT', 'Wallse Kerk'),
                                                                                              (84, 'History Port', 'Amsterdam Port Map Seventh Place', 'TEXT', 'Molen de Adriaan'),
                                                                                              (85, 'History Port', 'Amsterdam Port Map Eighth Place', 'TEXT', 'Amsterdamse Poort'),
                                                                                              (87, 'History Port', 'Amsterdam Port Map Ninth Place', 'TEXT', 'Hof van Bakenes'),
                                                                                              (90, 'History Main', 'Start Location Image', 'IMAGE', '/img/History/img_662b6dbbf2416.jpg'),
                                                                                              (91, 'History Main', 'Route Image', 'IMAGE', '/img/History/img_66182a9a884f3.png'),
                                                                                              (92, 'History Port', 'Route Image', 'IMAGE', '/img/History/img_66069c48aec74.png'),
                                                                                              (93, 'History Port', 'Amsterdam Port Image 1', 'IMAGE', '/img/History/img_6611b1c62231a.jpg'),
                                                                                              (109, 'History Main', 'Adriaan Windmill Image', 'IMAGE', '/img/History/img_66182a458c3ef.png'),
                                                                                              (110, 'History Main', 'Amsterdam Port Image', 'IMAGE', '/img/History/img_66730930137b0.png'),
                                                                                              (111, 'History Port', 'Amsterdam Port Image 2', 'IMAGE', '/img/History/img_660832b3a4c24.jpg'),
                                                                                              (112, 'History Port', 'Amsterdam Port Image 3', 'IMAGE', '/img/History/img_6672f0a7d39fe.jpg'),
                                                                                              (113, 'History Port', 'Amsterdam Port Image 4', 'IMAGE', '/img/History/img_6608337cacfa8.jpg'),
                                                                                              (114, 'History Windmill', 'Title', 'TEXT', 'Adriaan Windmill'),
                                                                                              (115, 'History Windmill', 'Festival Description', 'TEXT', 'Our guided walking tour proudly includes a visit to the Adriaan Windmill. You will discover the history and significance of the Adriaan Windmill, its role in Haarlem\'s industrial heritage, and the stories embedded in its weathered blades and wooden beams. You\'ll get to see how the old windmill has helped shape what Haarlem is today.'),
                                                                                              (116, 'History Windmill', 'Adriaan Windmill First Title', 'TEXT', 'Construction and origins '),
                                                                                              (118, 'History Windmill', 'Adriaan Windmill First Description', 'TEXT', 'Molen De Adriaan was initially constructed in 1779, during a period when windmills played a vital role in the economic landscape of the Netherlands. Originally serving as a grain mill, De Adriaan harnessed the power of the wind to grind cereals. This process was crucial in producing the vital flour that fueled the energetic and growing city of Haarlem. The construction of De Adriaan not only reflects the architectural and engineering skills of the era but also marks an important phase in the economic development of Haarlem'),
                                                                                              (119, 'History Windmill', 'Adriaan Windmill Second Title', 'TEXT', 'Destruction and Reconstruction'),
                                                                                              (120, 'History Windmill', 'Adriaan Windmill Second Description', 'TEXT', 'Tragically, in 1932, De Adriaan was consumed by a catastrophic fire, leaving it in a state of ruin. In 2002, following a period marked by determined restoration initiatives, the windmill was triumphantly resurrected, reclaiming its place in the city\'s skyline. This meticulous reconstruction was more than just a restoration of a structure; it was carried out with a deep respect for the original design, effectively breathing life back into a significant emblem of Haarlem\'s heritage. The rebirth of De Adriaan stands as a testament to Haarlem\'s resilience and commitment to preserving its historical legacy, rekindling a vital piece of the city\'s cultural identity.'),
                                                                                              (121, 'History Windmill', 'Adriaan Windmill Third Title', 'TEXT', 'Importance to Haarlem'),
                                                                                              (123, 'History Windmill', 'Adriaan Windmill Third Description', 'TEXT', 'During the Dutch Golden Age, spanning the 17th century, Haarlem emerged as a vibrant economic hub. The Adriaan Windmill, constructed in 1778, became an integral part of this economic landscape. Its primary function was to grind grain into flour, a vital process in the production of staple foods. The windmill\'s grinding capabilities not only served local residents but also facilitated trade, as Haarlem became a key supplier of flour to nearby regions. The economic prosperity generated by the milling activities of windmills like Adriaan contributed significantly to the city\'s growth and affluence.'),
                                                                                              (124, 'History Windmill', 'Adriaan Windmill Fourth Title', 'TEXT', 'Industrial Innovation'),
                                                                                              (125, 'History Windmill', 'Adriaan Windmill Fourth Description', 'TEXT', 'The windmill represents a marvel of industrial innovation in its time. Using the power of the wind, it shows how clever the Dutch were at using what nature gave them. The windmill had special machinery inside that made grinding grain into flour much more efficient. This was a big step forward in technology back then, showing just how advanced they were at using natural forces for their needs.'),
                                                                                              (126, 'History Windmill', 'Adriaan Windmill Map First Place', 'TEXT', 'Church of St.Bavo'),
                                                                                              (127, 'History Windmill', 'Adriaan Windmill Map Second Place', 'TEXT', 'Grote Markt'),
                                                                                              (129, 'History Windmill', 'Adriaan Windmill Map Third Place', 'TEXT', 'De Hallen'),
                                                                                              (130, 'History Windmill', 'Adriaan Windmill Map Fourth Place', 'TEXT', 'Proveniershof'),
                                                                                              (131, 'History Windmill', 'Adriaan Windmill Map Fifth Place', 'TEXT', 'Jopenpark'),
                                                                                              (132, 'History Windmill', 'Adriaan Windmill Map Sixth Place', 'TEXT', 'Wallse Kerk'),
                                                                                              (133, 'History Windmill', 'Adriaan Windmill Map Seventh Place', 'TEXT', 'Molen de Adriaan'),
                                                                                              (134, 'History Windmill', 'Adriaan Windmill Map Eighth Place', 'TEXT', 'Amsterdamse Poort'),
                                                                                              (135, 'History Windmill', 'Adriaan Windmill Map Ninth Place', 'TEXT', 'Hof van Bakenes'),
                                                                                              (136, 'History Windmill', 'Route Image', 'IMAGE', '/img/History/img_66085cf56706b.png'),
                                                                                              (137, 'History Windmill', 'Adriaan Windmill Image 1', 'IMAGE', '/img/History/img_66085dc4707a4.jpg'),
                                                                                              (138, 'History Windmill', 'Adriaan Windmill Image 2', 'IMAGE', '/img/History/img_66085dcfee41a.jpg'),
                                                                                              (139, 'History Windmill', 'Adriaan Windmill Image 3', 'IMAGE', '/img/History/img_6611b1a8e4574.jpg'),
                                                                                              (141, 'History Windmill', 'Adriaan Windmill Image 4', 'IMAGE', '/img/History/img_6611b185c6f6b.jpg'),
                                                                                              (143, 'History Main', 'Family Ticket Price', 'TEXT', '60'),
                                                                                              (144, 'History Main', 'Regular Ticket Price', 'TEXT', '17,50'),
                                                                                              (145, 'History Windmill', 'Adriaan Windmill Intro Image', 'IMAGE', '/img/History/img_66723284d117e.png'),
                                                                                              (146, 'History Port', 'Amsterdam Port Intro Image', 'IMAGE', '/img/History/img_66722ecba3435.png'),
                                                                                              (147, 'History Main', 'History Intro Image', 'IMAGE', '/img/History/img_6672f08f1d64c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `history_timeslots`
--

CREATE TABLE `history_timeslots` (
                                     `id` int(11) NOT NULL,
                                     `day` date NOT NULL,
                                     `start_time` time NOT NULL,
                                     `end_time` time NOT NULL,
                                     `english_tour` int(11) NOT NULL DEFAULT 0,
                                     `dutch_tour` int(11) NOT NULL DEFAULT 0,
                                     `chinese_tour` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_timeslots`
--

INSERT INTO `history_timeslots` (`id`, `day`, `start_time`, `end_time`, `english_tour`, `dutch_tour`, `chinese_tour`) VALUES
                                                                                                                          (1, '2024-07-25', '10:00:00', '12:30:00', 5, 8, 1),
                                                                                                                          (2, '2024-07-25', '13:00:00', '15:30:00', 3, 2, 53),
                                                                                                                          (3, '2025-07-25', '16:00:00', '18:30:00', 3, 4, 0),
                                                                                                                          (4, '2024-07-26', '10:00:00', '12:30:00', 9, 3, 0),
                                                                                                                          (5, '2024-07-26', '13:00:00', '15:30:00', 5, 6, 2),
                                                                                                                          (6, '2024-07-26', '16:00:00', '18:30:00', 1, 1, 0),
                                                                                                                          (7, '2024-07-27', '10:00:00', '12:30:00', 2, 4, 0),
                                                                                                                          (8, '2024-07-27', '13:00:00', '15:30:00', 4, 4, 4),
                                                                                                                          (9, '2024-07-27', '16:00:00', '18:30:00', 5, 5, 5),
                                                                                                                          (10, '2024-07-28', '10:00:00', '12:30:00', 4, 4, 4),
                                                                                                                          (11, '2024-07-28', '13:00:00', '15:30:00', 4, 4, 459),
                                                                                                                          (24, '2024-04-11', '05:15:00', '16:55:00', 44, 4, 4),
                                                                                                                          (26, '2024-04-17', '12:02:00', '17:07:00', 75, 75, 5464),
                                                                                                                          (27, '2024-04-30', '12:45:00', '18:20:00', 69, 69, 69),
                                                                                                                          (31, '2024-05-02', '04:45:00', '16:54:00', 41545, 79, 79),
                                                                                                                          (32, '2024-04-16', '14:41:00', '04:24:00', 2, 2, 1111),
                                                                                                                          (35, '2024-04-16', '10:22:00', '16:24:00', 45, 45, 47),
                                                                                                                          (36, '2024-04-01', '04:44:00', '16:44:00', 4, 4, 4),
                                                                                                                          (37, '2024-04-10', '04:22:00', '04:01:00', 5, 5, 5),
                                                                                                                          (38, '2024-04-10', '04:52:00', '04:24:00', 6, 6, 6),
                                                                                                                          (39, '2024-04-18', '14:41:00', '16:52:00', 2, 2, 1),
                                                                                                                          (40, '2024-04-24', '12:02:00', '16:06:00', 1, 1, 1),
                                                                                                                          (44, '2024-05-08', '12:00:00', '18:00:00', 0, 0, 0),
                                                                                                                          (45, '2024-05-29', '05:00:00', '07:00:00', 7, 8, 9),
                                                                                                                          (46, '2024-05-30', '10:00:00', '11:01:00', 14, 14, 41),
                                                                                                                          (47, '2024-05-14', '04:45:00', '05:02:00', 0, 0, 1),
                                                                                                                          (50, '2024-05-28', '11:01:00', '11:30:00', 4, 1, 4),
                                                                                                                          (51, '2024-05-15', '13:03:00', '15:00:00', 18, 18, 18),
                                                                                                                          (52, '2024-06-05', '12:04:00', '14:06:00', 4, 4, 445),
                                                                                                                          (53, '2024-06-26', '12:47:00', '12:53:00', 47, 47, 47),
                                                                                                                          (54, '2424-02-04', '14:25:00', '02:24:00', 4, 4, 404),
                                                                                                                          (55, '2024-06-26', '14:01:00', '16:01:00', 450, 451, 457),
                                                                                                                          (56, '2024-06-12', '23:36:00', '12:05:00', 23, 23, 24),
                                                                                                                          (59, '2024-06-05', '02:05:00', '08:52:00', 28, 257, 725),
                                                                                                                          (60, '2024-06-13', '15:47:00', '07:53:00', 537, 573, 367),
                                                                                                                          (61, '2024-06-12', '02:43:00', '06:04:00', 63, 36, 36),
                                                                                                                          (64, '2024-06-12', '02:57:00', '07:06:00', 63, 36, 36),
                                                                                                                          (65, '2024-06-19', '08:07:00', '06:09:00', 444555, 45, 45);

-- --------------------------------------------------------

--
-- Table structure for table `home_contents`
--

CREATE TABLE `home_contents` (
                                 `id` int(11) NOT NULL,
                                 `content_name` varchar(255) NOT NULL,
                                 `content_type` enum('TEXT','IMAGE') NOT NULL,
                                 `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_contents`
--

INSERT INTO `home_contents` (`id`, `content_name`, `content_type`, `content`) VALUES
                                                                                  (8, 'Teylers Event Image', 'IMAGE', '/img/Home/img_66733dac132c6.png'),
                                                                                  (9, 'Header Image', 'IMAGE', '/img/Home/img_6670635e2a8db.png'),
                                                                                  (10, 'Dance Event Image', 'IMAGE', '/img/Home/img_66720379c898d.jpg'),
                                                                                  (11, 'Yummy Event Image', 'IMAGE', '/img/Home/img_667222d91a110.jpg'),
                                                                                  (12, 'History Event Image', 'IMAGE', '/img/Home/img_667209807bcb4.jpg'),
                                                                                  (13, 'Intro Title', 'TEXT', 'Welcome to the Haarlem Festival 2024 !'),
                                                                                  (14, 'Intro Text', 'TEXT', 'Immerse yourself in the heart of Haarlem\'s vibrant social scene at the Grote Markt, surrounded by historic facades and lively cafes. The festival kicks off with \"Yummy!\" from July 25 to 28, where local restaurants showcase special Festival menus at reduced prices. Then, from July 26 to 28, join \"DANCE!\" – a dynamic addition featuring top DJs in Back2Back sessions and experimental club sessions. Don\'t miss \"A Stroll through History\" from July 26 to 28, offering guided tours through Haarlem\'s historic sites. Explore the rich tapestry of Haarlem\'s culinary, musical, and historical delights. Check the Festival Excel program for details on sessions, timetables, and prices. We invite you to make the most of your summer at the Haarlem Festival!'),
                                                                                  (15, 'Teylers Event Title', 'TEXT', 'Teyler\'sEvent'),
                                                                                  (16, 'Dance Event Title', 'TEXT', 'Dance Event'),
                                                                                  (17, 'Yummy Event Title', 'TEXT', 'Yummy Event'),
                                                                                  (18, 'History Event Title', 'TEXT', 'History Event');

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
                          `imageId` int(11) NOT NULL,
                          `sectionId` int(11) NOT NULL,
                          `imageName` varchar(255) DEFAULT NULL,
                          `imagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
                         `id` int(11) NOT NULL,
                         `ticket_id` int(11) NOT NULL,
                         `ticket_name` varchar(255) NOT NULL,
                         `event_name` varchar(255) NOT NULL,
                         `paid` tinyint(1) NOT NULL,
                         `total_amount` decimal(10,0) NOT NULL,
                         `orderAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `ticket_id`, `ticket_name`, `event_name`, `paid`, `total_amount`, `orderAt`) VALUES
                                                                                                            (4, 125, 'DANCE EVENT', 'Armin van Buuren', 1, 135, '2024-04-11 20:39:00'),
                                                                                                            (7, 138, 'DANCE EVENT', 'Afrojack, Tiësto, Nicky Romero', 1, 110, '2024-04-11 21:09:25'),
                                                                                                            (8, 138, 'DANCE EVENT', 'Afrojack, Tiësto, Nicky Romero', 1, 110, '2024-04-11 21:09:25'),
                                                                                                            (16, 141, 'History Tour Ticket', 'History Event', 1, 60, '2024-04-20 10:42:22'),
                                                                                                            (18, 163, 'History Tour Ticket', 'History Event', 1, 60, '2024-04-20 10:48:57'),
                                                                                                            (21, 141, 'History Tour Ticket', 'History Event', 1, 60, '2024-04-25 20:47:13'),
                                                                                                            (23, 186, 'YUMMY EVENT', 'Restaurant ML', 1, 10, '2024-04-25 21:05:28'),
                                                                                                            (25, 188, 'DANCE EVENT', 'Armin van Buuren', 1, 60, '2024-04-26 09:30:33'),
                                                                                                            (26, 189, 'YUMMY EVENT', 'Ratatouille', 1, 20, '2024-04-26 09:30:33'),
                                                                                                            (27, 190, 'YUMMY EVENT', 'Ratatouille', 1, 120, '2024-04-26 09:30:33'),
                                                                                                            (29, 219, 'YUMMY EVENT', 'Ratatouille', 1, 20, '2024-05-30 10:25:04'),
                                                                                                            (30, 220, 'YUMMY EVENT', 'Ratatouille', 1, 10, '2024-06-11 16:48:27'),
                                                                                                            (32, 200, 'DANCE EVENT', 'Nicky Romero, Afrojack', 1, 75, '2024-06-11 17:05:34'),
                                                                                                            (75, 164, 'DANCE EVENT', 'Martin Garrix', 1, 60, '2024-06-17 07:23:55'),
                                                                                                            (76, 270, 'YUMMY EVENT', 'Ratatouille', 1, 10, '2024-06-19 15:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `Pages`
--

CREATE TABLE `Pages` (
                         `pageId` int(11) NOT NULL,
                         `pageTitle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Paragraph`
--

CREATE TABLE `Paragraph` (
                             `paragraphId` int(11) NOT NULL,
                             `sectionId` int(11) NOT NULL,
                             `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr`
--

CREATE TABLE `qr` (
                      `id` int(11) NOT NULL,
                      `user_ticket_id` int(11) NOT NULL,
                      `code` varchar(255) NOT NULL,
                      `scan` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr`
--

INSERT INTO `qr` (`id`, `user_ticket_id`, `code`, `scan`) VALUES
                                                              (31, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (41, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (52, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (63, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (74, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (76, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (86, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (88, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (99, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (101, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (109, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (111, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (114, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 1),
                                                              (116, 186, '126bac7560ef02bf672f6780e61d25798162bde158ad7eead917c3fe92d33dd4', 1),
                                                              (118, 188, '39bcbd9f3010bac651adcbda3b4ce93945f0be511c516b0a2f36df8d434ccebd', 1),
                                                              (119, 189, 'd69f8881498e7fb47c5fa5dc55b27b929b9aeee2b9a225c467b47e764acb6324', 1),
                                                              (120, 190, '7f14622adef72ba0c2d70fffc4201c8a446637647f55f40b75bc34f495841ae8', 0),
                                                              (124, 141, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0),
                                                              (125, 163, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0),
                                                              (127, 141, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0),
                                                              (128, 219, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0),
                                                              (131, 141, '187f63aec2789ee505279f0d817d068fc9bef073ebb18fb6b04c62044c84dfb0', 0),
                                                              (132, 163, '3a2d78361bc85bb1fd2c424108caf66eed532874f0e4b9b543952933beaae9c1', 0),
                                                              (134, 141, '02845d70c7f6871b0690ccdc1e4afa6748433a173b1197f0553e767628806f84', 0),
                                                              (135, 219, '17b068a585c46cf244581704e477f15796367aea124183c682c7b386c4fca46b', 0),
                                                              (136, 220, '4b6a04aa8d76e0e5761a3ce6dd5348446579c9669701e6dcbaf7d1008c2c0f36', 0),
                                                              (139, 141, 'fadb6b5994ce7c466d75f3f2e8700568403fb31d64df1215ae09e2ff4c0d3cc0', 0),
                                                              (140, 163, '81b65facc7243ffe1c32379fc75d931a04dd3f6c8475a221179d366cd40d2991', 0),
                                                              (142, 141, '52ffe75fc1930e8f6ec609964f50e7ee6d1bd9ebf6ebe55e6e60145009aea7a3', 0),
                                                              (143, 219, '9f5868be0e6e6bfa530be6d40dc90af1bdfd06b616838a50cb2939238ac01b93', 0),
                                                              (144, 220, '57424fc2be0ebbbfc956e8491ee27e3b375e7ef93211f903a6534f3d59b6f685', 0),
                                                              (148, 141, '5ada09eb6977d93a3535f9358925bb973f04b753d40aaa3771adad298960dabc', 0),
                                                              (149, 163, '515a38902a8dfa6a3ad4a7900a7cd3f5cc530890448a70b3a8c19722135bfa3d', 0),
                                                              (151, 141, '1d574865fc7563659817288efe51deb561ed8c3c828becdc6c9eeedddc4d4e0c', 0),
                                                              (152, 219, 'dd793d505a514a883dc73f59a1162a503fe12ba327fd42aaef9fa661faede6c7', 0),
                                                              (153, 220, '1a616ad1e0a3ff242674f0bb2c053c8720d4c89062d7e65b0065c8c78efe21d6', 0),
                                                              (155, 200, 'afdb05cc3204c964ab7462da3057fbc22e7d06f6c5da6f2534bd83e1ccd8c636', 0),
                                                              (157, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (158, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (160, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (161, 219, '45932499ddab54473f5ef92aea264ccf7dc8e4b5cf098dd553fe14ef10fbbf45', 0),
                                                              (162, 220, '2cc6308ad3fbfa6b2acf0a282feb776ac3d80b5a7bae1983afc728ee814d9cde', 0),
                                                              (164, 200, '92de9357905fd51aae020a621dba7e8fda7a218e2bdc23ab3af8454f52c60703', 0),
                                                              (166, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (167, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (169, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (170, 219, '45932499ddab54473f5ef92aea264ccf7dc8e4b5cf098dd553fe14ef10fbbf45', 0),
                                                              (171, 220, '2cc6308ad3fbfa6b2acf0a282feb776ac3d80b5a7bae1983afc728ee814d9cde', 0),
                                                              (173, 200, '92de9357905fd51aae020a621dba7e8fda7a218e2bdc23ab3af8454f52c60703', 0),
                                                              (175, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (176, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (178, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (179, 219, '45932499ddab54473f5ef92aea264ccf7dc8e4b5cf098dd553fe14ef10fbbf45', 0),
                                                              (180, 220, '2cc6308ad3fbfa6b2acf0a282feb776ac3d80b5a7bae1983afc728ee814d9cde', 0),
                                                              (182, 200, '92de9357905fd51aae020a621dba7e8fda7a218e2bdc23ab3af8454f52c60703', 0),
                                                              (184, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (185, 163, '286156c43a5a974a24d6e4262b569077eafffbe850d643b87eb2e264000f577d', 0),
                                                              (186, 141, '150f56f9faed160b2c51b4650e4347265505fcd9d01290c016edb3844793b73a', 0),
                                                              (187, 219, '45932499ddab54473f5ef92aea264ccf7dc8e4b5cf098dd553fe14ef10fbbf45', 0),
                                                              (188, 220, '2cc6308ad3fbfa6b2acf0a282feb776ac3d80b5a7bae1983afc728ee814d9cde', 0),
                                                              (190, 200, '92de9357905fd51aae020a621dba7e8fda7a218e2bdc23ab3af8454f52c60703', 0),
                                                              (191, 164, '5f045f1a91ae3dbb8b9fcdf15308dcba1032b4be707b08db28d1ecc9c1487ab8', 0),
                                                              (192, 141, '8e41986a48da2a6849b6fad57158290b0b58d4f65230293c2f09d56b78053057', 0),
                                                              (193, 163, 'cdd2ed7afd59f89836d07405d4ffa06e7783362a8d22af511c406a27f0708709', 0),
                                                              (194, 141, '4474d57d06a9b00cbcf8d855ff25c308b4ccaed41b6333ac03ec70fed79af3f1', 0),
                                                              (195, 219, 'f3a5cb27fae18ff94c8964401a97cb418df1287c61dc89c5cf400e2391197c43', 0),
                                                              (196, 220, '8a599232151102493dbe689eb74cdef7549c0886371051b7ac7fd30c4548d786', 0),
                                                              (197, 200, 'cf525eb207d4938aa088be2daa008e7e92f25df32fabefa47ce6c538a8245d8d', 0),
                                                              (198, 164, '5c5585a6207703cd27001afb84063810e59139da3103c46e882a3302eb6329fa', 0),
                                                              (199, 270, 'a4b0a2a0d0c7e4e26f748518552225b589b3d383ebfa9bf9790d99943ef94c3f', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reset_tokens`
--

CREATE TABLE `reset_tokens` (
                                `id` int(11) NOT NULL,
                                `user_email` varchar(255) NOT NULL,
                                `token` varchar(64) NOT NULL,
                                `created_at` timestamp NULL DEFAULT current_timestamp(),
                                `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_tokens`
--

INSERT INTO `reset_tokens` (`id`, `user_email`, `token`, `created_at`, `expires_at`) VALUES
    (5, 'wojtusk574@gmail.com', 'c01ece5b3269577ae5239ddb2a028e63', '2024-03-03 15:08:43', '2024-04-08 18:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
                               `id` int(11) NOT NULL,
                               `name` varchar(255) NOT NULL,
                               `address` varchar(255) NOT NULL,
                               `type` varchar(255) DEFAULT NULL,
                               `price` decimal(10,2) DEFAULT NULL,
                               `reduced` decimal(10,2) DEFAULT NULL,
                               `stars` int(11) DEFAULT NULL,
                               `phoneNumber` varchar(20) DEFAULT NULL,
                               `email` varchar(255) DEFAULT NULL,
                               `website` varchar(255) DEFAULT NULL,
                               `chef` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `type`, `price`, `reduced`, `stars`, `phoneNumber`, `email`, `website`, `chef`) VALUES
                                                                                                                                        (1, 'Ratatouille', 'Spaarne 96, 2011 CL Haarlem, Nederland', 'French, fish and seafood, European', 45.00, 22.00, 4, '123123123', 'reserveringen@ratatouillefoodandwine.nl', 'https://www.facebook.com/RatatouilleFoodandWine/', 'Jozua Jaring'),
                                                                                                                                        (7, 'Restaurant ML', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', 'Dutch, fish and seafood, European', 45.00, 22.50, 4, ' +31 23 512 3910', 'welkom@mlinhaarlem.nl', 'https://www.mlinhaarlem.nl/en/', 'Mark Gratama');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_events`
--

CREATE TABLE `restaurant_events` (
                                     `id` int(11) NOT NULL,
                                     `restaurant_id` int(11) DEFAULT NULL,
                                     `event_date` date DEFAULT NULL,
                                     `event_day` varchar(10) DEFAULT NULL,
                                     `event_time_start` time DEFAULT NULL,
                                     `event_time_end` time DEFAULT NULL,
                                     `seats_total` int(11) DEFAULT NULL,
                                     `seats_left` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_events`
--

INSERT INTO `restaurant_events` (`id`, `restaurant_id`, `event_date`, `event_day`, `event_time_start`, `event_time_end`, `seats_total`, `seats_left`) VALUES
                                                                                                                                                          (1, 1, '2024-07-25', 'Thursday', '17:00:00', '19:00:00', 45, 0),
                                                                                                                                                          (2, 1, '2024-07-25', 'Thursday', '19:00:00', '21:00:00', 20, 14),
                                                                                                                                                          (3, 1, '2024-07-25', 'Thursday', '21:00:00', '23:00:00', 50, 30),
                                                                                                                                                          (4, 1, '2024-07-26', 'Friday', '17:00:00', '19:00:00', 40, 0),
                                                                                                                                                          (5, 1, '2024-07-26', 'Friday', '19:00:00', '21:00:00', 20, 0),
                                                                                                                                                          (6, 1, '2024-07-26', 'Friday', '21:00:00', '23:00:00', 50, 24),
                                                                                                                                                          (7, 1, '2024-07-27', 'Saturday', '17:00:00', '19:00:00', 40, 0),
                                                                                                                                                          (8, 1, '2024-07-27', 'Saturday', '19:00:00', '21:00:00', 20, 14),
                                                                                                                                                          (9, 1, '2024-07-27', 'Saturday', '21:00:00', '23:00:00', 50, 30),
                                                                                                                                                          (15, 7, '2024-07-25', 'Thursday', '17:00:00', '19:00:00', 40, 39),
                                                                                                                                                          (16, 7, '2024-07-25', 'Thursday', '19:00:00', '21:00:00', 20, 20),
                                                                                                                                                          (17, 7, '2024-07-26', 'Friday', '17:00:00', '19:00:00', 40, 39),
                                                                                                                                                          (18, 7, '2024-07-26', 'Friday', '19:00:00', '21:00:00', 20, 20),
                                                                                                                                                          (19, 7, '2024-07-27', 'Saturday', '17:00:00', '19:00:00', 40, 40),
                                                                                                                                                          (20, 7, '2024-07-27', 'Saturday', '19:00:00', '21:00:00', 20, 20),
                                                                                                                                                          (21, 7, '2024-07-28', 'Sunday', '17:00:00', '19:00:00', 40, 40),
                                                                                                                                                          (22, 7, '2024-07-28', 'Sunday', '19:00:00', '21:00:00', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_images`
--

CREATE TABLE `restaurant_images` (
                                     `id` int(11) NOT NULL,
                                     `restaurant_id` int(11) DEFAULT NULL,
                                     `image_path` varchar(255) NOT NULL,
                                     `image_type` enum('map','chef','gallery') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_images`
--

INSERT INTO `restaurant_images` (`id`, `restaurant_id`, `image_path`, `image_type`) VALUES
                                                                                        (1, 1, 'img/Yummy/Logo_ratatouille.jpg', 'gallery'),
                                                                                        (2, 1, 'img/Yummy/Ratatouille_map.png', 'map'),
                                                                                        (3, 1, 'img/Yummy/Ratatouille_Jozua.png', 'chef'),
                                                                                        (4, 1, 'img/Yummy/ratatouille-12ws.jpg', 'gallery'),
                                                                                        (5, 1, 'img/Yummy/ratatouille-2764028102.jpg', 'gallery'),
                                                                                        (6, 1, 'img/Yummy/ratatouille-23212312.jpg', 'gallery'),
                                                                                        (7, 1, 'img/Yummy/ratatouille-12312321.jpg', 'gallery'),
                                                                                        (8, 7, 'img/Yummy/Restaurant-ML-Haarlem.jpg\r\n', 'gallery'),
                                                                                        (9, 7, 'img/Yummy/ML-chef.jpeg', 'chef'),
                                                                                        (10, 7, 'img/Yummy/ML_ map.png', 'map'),
                                                                                        (11, 7, 'img/Yummy/ML-1231231.jpeg', 'gallery'),
                                                                                        (12, 7, 'img/Yummy/ML-12312312312.jpg', 'gallery'),
                                                                                        (13, 7, 'img/Yummy/ML-123123123122132.jpeg', 'gallery'),
                                                                                        (14, 7, 'img/Yummy/Ml-512412.jpg', 'gallery');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_reservations`
--

CREATE TABLE `restaurant_reservations` (
                                           `id` int(11) NOT NULL,
                                           `restaurantId` int(11) DEFAULT NULL,
                                           `eventID` int(11) DEFAULT NULL,
                                           `regularTickets` int(11) DEFAULT NULL,
                                           `reducedTickets` int(11) DEFAULT NULL,
                                           `specialRequests` text DEFAULT NULL,
                                           `enabled` tinyint(1) DEFAULT 1,
                                           `created_at` timestamp NULL DEFAULT current_timestamp(),
                                           `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_reservations`
--

INSERT INTO `restaurant_reservations` (`id`, `restaurantId`, `eventID`, `regularTickets`, `reducedTickets`, `specialRequests`, `enabled`, `created_at`, `updated_at`) VALUES
                                                                                                                                                                          (1, 1, 1, 1, 0, 'Test Test Test', 1, '2024-04-05 20:09:47', '2024-04-06 00:47:16'),
                                                                                                                                                                          (2, 1, 1, 1, 0, NULL, 1, '2024-04-05 20:10:37', '2024-04-06 00:45:29'),
                                                                                                                                                                          (3, 1, 1, 1, 0, 'Test Test', 1, '2024-04-05 20:14:31', '2024-04-06 00:45:32'),
                                                                                                                                                                          (4, 1, 1, 1, 0, '', 1, '2024-04-05 20:15:10', '2024-04-05 20:15:10'),
                                                                                                                                                                          (5, 1, 1, 1, 0, '', 1, '2024-04-05 20:17:09', '2024-04-05 20:17:09'),
                                                                                                                                                                          (6, 1, 1, 1, 0, 'TEST TEST', 1, '2024-04-05 20:17:34', '2024-04-05 20:17:34'),
                                                                                                                                                                          (8, 1, 1, 1, 0, 'awd', 1, '2024-04-09 18:18:31', '2024-04-09 18:18:31'),
                                                                                                                                                                          (9, 1, 4, 1, 0, 'awd', 1, '2024-04-09 18:18:51', '2024-04-09 18:18:51'),
                                                                                                                                                                          (10, 1, 4, 1, 0, 'awd', 1, '2024-04-09 18:19:29', '2024-04-09 18:19:29'),
                                                                                                                                                                          (11, 1, 4, 1, 0, 'awd', 1, '2024-04-09 18:20:42', '2024-04-09 18:20:42'),
                                                                                                                                                                          (12, 1, 4, 1, 0, 'awd', 1, '2024-04-09 18:21:03', '2024-04-09 18:21:03'),
                                                                                                                                                                          (13, 1, 4, 1, 0, 'awd', 1, '2024-04-09 18:22:51', '2024-04-09 18:22:51'),
                                                                                                                                                                          (14, 1, 4, 3, 2, 'awd', 1, '2024-04-09 18:23:39', '2024-04-09 18:23:39'),
                                                                                                                                                                          (15, 1, 4, 4, 2, 'awd', 1, '2024-04-09 18:23:57', '2024-04-09 18:23:57'),
                                                                                                                                                                          (16, 1, 4, 3, 2, 'awda', 1, '2024-04-09 18:24:51', '2024-04-09 18:24:51'),
                                                                                                                                                                          (17, 1, 4, 3, 2, 'awd', 1, '2024-04-09 18:25:45', '2024-04-09 18:25:45'),
                                                                                                                                                                          (18, 1, 4, 2, 1, 'awd', 1, '2024-04-10 14:18:55', '2024-04-10 14:18:55'),
                                                                                                                                                                          (19, 1, 4, 1, 1, 'awd', 1, '2024-04-10 14:19:46', '2024-04-10 14:19:46'),
                                                                                                                                                                          (20, 1, 4, 1, 1, 'awd', 1, '2024-04-10 14:20:57', '2024-04-10 14:20:57'),
                                                                                                                                                                          (21, 1, 4, 1, 1, 'awd', 1, '2024-04-10 14:28:15', '2024-04-10 14:28:15'),
                                                                                                                                                                          (22, 1, 4, 1, 1, 'awd', 1, '2024-04-10 14:31:25', '2024-04-10 14:31:25'),
                                                                                                                                                                          (23, 1, 4, 1, 1, 'awd', 1, '2024-04-10 14:33:07', '2024-04-10 14:33:07'),
                                                                                                                                                                          (24, 1, 4, 1, 0, 'awd', 1, '2024-04-10 14:34:20', '2024-04-10 14:34:20'),
                                                                                                                                                                          (25, 1, 5, 1, 0, 'awd', 1, '2024-04-10 14:35:44', '2024-04-10 14:35:44'),
                                                                                                                                                                          (26, 1, 5, 1, 0, 'awd', 1, '2024-04-10 14:40:56', '2024-04-10 14:40:56'),
                                                                                                                                                                          (27, 1, 5, 1, 1, 'awd', 1, '2024-04-10 14:41:35', '2024-04-10 14:41:35'),
                                                                                                                                                                          (28, 1, 5, 1, 1, 'awd', 1, '2024-04-10 15:18:19', '2024-04-10 15:18:19'),
                                                                                                                                                                          (29, 1, 5, 1, 2, 'awd', 1, '2024-04-10 15:23:33', '2024-04-10 15:23:33'),
                                                                                                                                                                          (30, 1, 5, 1, 2, 'awd', 1, '2024-04-10 15:24:09', '2024-04-10 15:24:09'),
                                                                                                                                                                          (31, 1, 5, 1, 2, 'awd', 1, '2024-04-10 15:25:04', '2024-04-10 15:25:04'),
                                                                                                                                                                          (32, 1, 5, 1, 0, 'asdasd', 1, '2024-04-10 15:25:54', '2024-04-10 15:25:54'),
                                                                                                                                                                          (33, 1, 7, 1, 2, 'dawdwadadwa', 1, '2024-04-10 15:27:19', '2024-04-10 15:27:19'),
                                                                                                                                                                          (34, 1, 7, 1, 3, 'awdadaw', 1, '2024-04-10 15:27:53', '2024-04-10 15:27:53'),
                                                                                                                                                                          (35, 1, 7, 1, 2, 'awdawd', 1, '2024-04-11 18:56:19', '2024-04-11 18:56:19'),
                                                                                                                                                                          (36, 1, 7, 1, 2, 'awdawd', 1, '2024-04-11 18:56:23', '2024-04-11 18:56:23'),
                                                                                                                                                                          (37, 1, 7, 1, 2, 'awdawd', 1, '2024-04-11 18:56:31', '2024-04-11 18:56:31'),
                                                                                                                                                                          (38, 1, 7, 1, 2, 'awdawd', 1, '2024-04-11 18:56:39', '2024-04-11 18:56:39'),
                                                                                                                                                                          (39, 1, 7, 1, 0, 'awdawd', 1, '2024-04-11 18:59:04', '2024-04-11 18:59:04'),
                                                                                                                                                                          (40, 1, 7, 1, 1, 'adawdawd', 1, '2024-04-11 19:02:20', '2024-04-11 19:02:20'),
                                                                                                                                                                          (41, 1, 7, 1, 1, 'awdawdawd', 1, '2024-04-11 19:03:42', '2024-04-11 19:03:42'),
                                                                                                                                                                          (42, 1, 5, 1, 1, 'awdadaw', 1, '2024-04-11 19:04:01', '2024-04-11 19:04:01'),
                                                                                                                                                                          (43, 1, 2, -1, -1, 'awd', 1, '2024-04-12 09:31:18', '2024-04-12 09:31:18'),
                                                                                                                                                                          (44, 1, 2, 1, 1, 'can I have the best shawrma wrap ', 1, '2024-04-20 11:05:41', '2024-04-20 11:05:41'),
                                                                                                                                                                          (45, 1, 5, 1, 1, 'can I have the best shawerma wrap ', 1, '2024-04-20 11:07:22', '2024-04-20 11:07:22'),
                                                                                                                                                                          (46, 1, 7, 2, 0, 'Test is the best', 1, '2024-04-20 11:37:38', '2024-04-20 11:37:38'),
                                                                                                                                                                          (47, 1, 6, 1, 0, 'best in the west', 1, '2024-04-25 20:45:19', '2024-04-25 20:45:19'),
                                                                                                                                                                          (48, 1, 6, 1, 0, '', 1, '2024-04-25 20:58:03', '2024-04-25 20:58:03'),
                                                                                                                                                                          (49, 1, 6, 1, 0, '', 1, '2024-04-25 21:01:04', '2024-04-25 21:01:04'),
                                                                                                                                                                          (50, 1, 6, 1, 0, '', 1, '2024-04-25 21:01:59', '2024-04-25 21:01:59'),
                                                                                                                                                                          (51, 7, 15, 1, 0, '', 1, '2024-04-25 21:04:52', '2024-04-25 21:04:52'),
                                                                                                                                                                          (52, 1, 7, 2, 0, '', 1, '2024-04-26 09:20:18', '2024-04-26 09:20:18'),
                                                                                                                                                                          (53, 1, 7, 12, 0, '', 1, '2024-04-26 09:23:43', '2024-04-26 09:23:43'),
                                                                                                                                                                          (54, 1, 8, 2, 0, 'Dupa', 1, '2024-05-30 10:24:11', '2024-05-30 10:24:11'),
                                                                                                                                                                          (55, 1, 8, 2, 0, '', 1, '2024-05-30 10:24:43', '2024-05-30 10:24:43'),
                                                                                                                                                                          (56, 1, 8, 1, 0, '', 1, '2024-06-11 16:48:19', '2024-06-11 16:48:19'),
                                                                                                                                                                          (57, 7, 17, 1, 0, 'Best service please', 1, '2024-06-17 07:23:01', '2024-06-17 07:23:01'),
                                                                                                                                                                          (58, 1, 2, 1, 0, '', 1, '2024-06-17 15:32:17', '2024-06-17 15:32:17'),
                                                                                                                                                                          (59, 1, 2, 1, 0, 'bober', 1, '2024-06-17 18:36:38', '2024-06-17 18:36:38'),
                                                                                                                                                                          (60, 1, 8, 1, 0, '', 1, '2024-06-17 18:40:40', '2024-06-17 18:40:40'),
                                                                                                                                                                          (61, 1, 6, 1, 0, '', 1, '2024-06-17 18:41:03', '2024-06-17 18:41:03'),
                                                                                                                                                                          (62, 1, 6, 1, 0, '', 1, '2024-06-17 18:41:36', '2024-06-17 18:41:36'),
                                                                                                                                                                          (63, 1, 2, 1, 0, '', 1, '2024-06-19 15:13:10', '2024-06-19 15:13:10'),
                                                                                                                                                                          (64, 1, 2, 1, 0, '', 1, '2024-06-19 15:14:02', '2024-06-19 15:14:02'),
                                                                                                                                                                          (65, 1, 2, 1, 0, '', 1, '2024-06-19 19:18:57', '2024-06-19 19:18:57'),
                                                                                                                                                                          (66, 1, 2, 1, 0, '', 1, '2024-06-19 19:55:57', '2024-06-19 19:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `Sections`
--

CREATE TABLE `Sections` (
                            `sectionId` int(11) NOT NULL,
                            `pageId` int(11) NOT NULL,
                            `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
                           `sessionId` int(11) NOT NULL,
                           `artistName` varchar(255) DEFAULT NULL,
                           `startSession` time DEFAULT NULL,
                           `sessionDate` date DEFAULT NULL,
                           `venue` varchar(255) DEFAULT NULL,
                           `sessionPrice` decimal(10,2) DEFAULT NULL,
                           `sessionType` varchar(1024) DEFAULT NULL,
                           `endSession` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sessionId`, `artistName`, `startSession`, `sessionDate`, `venue`, `sessionPrice`, `sessionType`, `endSession`) VALUES
                                                                                                                                           (6, 'Nicky Romero, Afrojack', '20:00:00', '2024-07-26', 'Lichtfabriek', 75.00, 'Back2Back', '02:00:00'),
                                                                                                                                           (7, 'Afrojack', '22:00:00', '2024-07-27', 'Jopenkerk', 60.00, 'Club', '23:30:00'),
                                                                                                                                           (8, 'Tiësto', '21:00:00', '2024-07-27', 'Lichtfabriek', 75.00, 'TiëstoWorld', '22:30:00'),
                                                                                                                                           (9, 'Nicky Romero', '23:00:00', '2024-07-27', 'Club Stalker', 60.00, 'Club', '00:30:00'),
                                                                                                                                           (12, 'Hardwell,Martin Garrix, Armin van Burren', '21:00:00', '2024-07-28', 'XO the Club', 90.00, 'Club', '23:30:00'),
                                                                                                                                           (13, 'Martin Garrix', '18:00:00', '2024-07-28', 'Club Stalker', 60.00, 'Club', '23:30:00'),
                                                                                                                                           (27, 'All-Day Pass', '00:00:00', '2024-07-26', 'Unlock a day-long musical odyssey with our all-encompassing All-Day Pass', 125.00, ' Immerse Yourself in Every Note!', '23:59:59'),
                                                                                                                                           (28, 'All-Day Pass', '00:00:00', '2024-07-27', 'Unlock a day-long musical odyssey with our all-encompassing All-Day Pass', 150.00, ' Immerse Yourself in Every Note!', '23:59:59'),
                                                                                                                                           (29, 'All-Day Pass', '00:00:00', '2024-07-28', 'Unlock a day-long musical odyssey with our all-encompassing All-Day Pass', 150.00, ' Immerse Yourself in Every Note!', '23:59:59'),
                                                                                                                                           (30, 'Golden Ticket', '00:00:00', '2024-07-26', 'Embark on a three-day musical odyssey with our All-Access Pass! ', 260.00, '.', '23:59:20'),
                                                                                                                                           (37, 'Hardwell', '14:00:00', '2024-07-27', 'Caprera Openluchttheater', 110.00, 'Back2Back', '23:00:00'),
                                                                                                                                           (40, 'Poliska', '09:12:00', '2024-07-28', 'Club Ruis', 100.00, 'Technoo', '12:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `share_personal_program`
--

CREATE TABLE `share_personal_program` (
                                          `user_id` int(11) NOT NULL,
                                          `share_token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `share_personal_program`
--

INSERT INTO `share_personal_program` (`user_id`, `share_token`) VALUES
    (56, 'eccd4');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
                          `id` int(11) NOT NULL,
                          `ticketId` int(11) NOT NULL,
                          `event_name` varchar(255) NOT NULL,
                          `ticket_type` int(11) NOT NULL,
                          `ticket_name` varchar(255) NOT NULL,
                          `location` varchar(255) NOT NULL,
                          `description` varchar(255) DEFAULT NULL,
                          `price` int(11) NOT NULL,
                          `start_date` datetime NOT NULL,
                          `end_date` datetime NOT NULL,
                          `available` int(11) NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `ticketId`, `event_name`, `ticket_type`, `ticket_name`, `location`, `description`, `price`, `start_date`, `end_date`, `available`) VALUES
                                                                                                                                                                   (20, 0, 'Golden Ticket', 1, 'DANCE EVENT', 'Embark on a three-day musical odyssey with our All-Access Pass! ', '', 250, '2024-07-26 00:00:00', '2024-07-28 23:59:59', 20),
                                                                                                                                                                   (22, 0, 'Martin Garrix, Armin van Buuren', 1, 'DANCE EVENT', 'Caprera Openluchttheater', '', 110, '2024-07-26 14:00:00', '2024-07-26 16:00:00', 20),
                                                                                                                                                                   (39, 0, 'Martin Garrix, Armin van Buuren', 1, 'DANCE EVENT', 'Caprera Openluchttheater', '', 110, '2024-07-26 14:00:00', '2024-07-26 16:00:00', 20),
                                                                                                                                                                   (80, 28, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/1/awd', 20, '2024-07-26 19:00:00', '2024-07-26 21:00:00', 20),
                                                                                                                                                                   (82, 30, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/2/awd', 30, '2024-07-26 19:00:00', '2024-07-26 21:00:00', 20),
                                                                                                                                                                   (107, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 10),
                                                                                                                                                                   (113, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (120, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (121, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (122, 26, 'ghonim', 1, 'DANCE EVENT', 'pyramids', '', 124, '2024-07-26 11:11:00', '2024-07-26 02:02:00', 20),
                                                                                                                                                                   (123, 6, 'Martin Garrix, Armin van Buuren', 1, 'DANCE EVENT', 'Caprera Openluchttheater', '', 110, '2024-07-26 14:00:00', '2024-07-26 16:00:00', 20),
                                                                                                                                                                   (124, 12, 'Hardwell', 1, 'DANCE EVENT', 'XO the Club', '', 90, '2024-07-28 21:00:00', '2024-07-28 23:30:00', 20),
                                                                                                                                                                   (125, 11, 'Armin van Buuren', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-26 19:00:00', '2024-07-26 23:30:00', 20),
                                                                                                                                                                   (126, 35, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/2/awdawd', 30, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (127, 36, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/2/awdawd', 30, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (128, 37, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/2/awdawd', 30, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (129, 38, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/2/awdawd', 30, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (130, 39, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/awdawd', 10, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (131, 40, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/1/adawdawd', 20, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (132, 41, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/1/awdawdawd', 20, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 20),
                                                                                                                                                                   (134, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (135, 11, 'Armin van Buuren', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-26 19:00:00', '2024-07-26 23:30:00', 20),
                                                                                                                                                                   (136, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (137, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (138, 10, 'Afrojack, Tiësto, Nicky Romero', 1, 'DANCE EVENT', 'Caprera Openluchttheater', '', 110, '2024-07-27 14:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (139, 10, 'Afrojack, Tiësto, Nicky Romero', 1, 'DANCE EVENT', 'Caprera Openluchttheater', '', 110, '2024-07-27 14:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (140, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English Family', 60, '2024-06-17 10:00:00', '2024-06-17 12:30:00', 91),
                                                                                                                                                                   (141, 4, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch Family', 60, '2024-07-26 10:00:00', '2024-07-26 12:30:00', 18),
                                                                                                                                                                   (142, 8, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, regular ticket', 17, '2024-07-27 13:00:00', '2024-07-27 15:30:00', 20),
                                                                                                                                                                   (143, 10, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-28 10:00:00', '2024-07-28 12:30:00', 20),
                                                                                                                                                                   (144, 20, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch Family', 60, '2024-07-28 16:00:00', '2024-07-28 18:30:00', 20),
                                                                                                                                                                   (145, 11, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese regular', 17, '2024-07-28 13:00:00', '2024-07-28 15:30:00', 20),
                                                                                                                                                                   (146, 11, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English adult', 17, '2024-07-28 13:00:00', '2024-07-28 15:30:00', 20),
                                                                                                                                                                   (147, 10, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-28 10:00:00', '2024-07-28 12:30:00', 20),
                                                                                                                                                                   (148, 8, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-27 13:00:00', '2024-07-27 15:30:00', 20),
                                                                                                                                                                   (149, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English adult', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (151, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (153, 43, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '-1/-1/awd', -20, '2024-07-25 19:00:00', '2024-07-25 21:00:00', 20),
                                                                                                                                                                   (155, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (157, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (158, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (159, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (161, 4, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-26 10:00:00', '2024-07-26 12:30:00', 20),
                                                                                                                                                                   (163, 5, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-26 13:00:00', '2024-07-26 15:30:00', 19),
                                                                                                                                                                   (164, 13, 'Martin Garrix', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-28 18:00:00', '2024-07-28 23:30:00', 19),
                                                                                                                                                                   (166, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (167, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (168, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (169, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (171, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (173, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (174, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (177, 4, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-26 10:00:00', '2024-07-26 12:30:00', 20),
                                                                                                                                                                   (178, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (179, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (180, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (181, 48, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-26 21:00:00', '2024-07-26 23:00:00', 20),
                                                                                                                                                                   (182, 49, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-26 21:00:00', '2024-07-26 23:00:00', 20),
                                                                                                                                                                   (183, 50, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-26 21:00:00', '2024-07-26 23:00:00', 20),
                                                                                                                                                                   (184, 28, 'All-Day Pass', 1, 'DANCE EVENT', 'Unlock a day-long musical odyssey with our all-encompassing All-Day Pass', '', 150, '2024-07-27 00:00:00', '2024-07-27 23:59:59', 20),
                                                                                                                                                                   (185, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (186, 51, 'Restaurant ML', 2, 'YUMMY EVENT', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', '1/0/', 10, '2024-07-25 17:00:00', '2024-07-25 19:00:00', 19),
                                                                                                                                                                   (187, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (188, 4, 'Armin van Buuren', 1, 'DANCE EVENT', 'XO the Club', '', 60, '2024-07-28 22:00:00', '2024-07-28 01:00:00', 19),
                                                                                                                                                                   (189, 52, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '2/0/', 20, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 19),
                                                                                                                                                                   (190, 53, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '12/0/', 120, '2024-07-27 17:00:00', '2024-07-27 19:00:00', 19),
                                                                                                                                                                   (191, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (192, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (193, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (194, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (195, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (196, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (198, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (199, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (200, 6, 'Nicky Romero, Afrojack', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-26 20:00:00', '2024-07-26 02:00:00', 19),
                                                                                                                                                                   (201, 13, 'Martin Garrix', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-28 18:00:00', '2024-07-28 23:30:00', 20),
                                                                                                                                                                   (202, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (203, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (205, 9, 'Nicky Romero', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-27 23:00:00', '2024-07-27 00:30:00', 20),
                                                                                                                                                                   (206, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (207, 6, 'Nicky Romero, Afrojack', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-26 20:00:00', '2024-07-26 02:00:00', 20),
                                                                                                                                                                   (208, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (209, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (210, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (211, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (212, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (213, 9, 'Nicky Romero', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-27 23:00:00', '2024-07-27 00:30:00', 20),
                                                                                                                                                                   (214, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (215, 46, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-05-30 10:00:00', '2024-05-30 11:01:00', 20),
                                                                                                                                                                   (216, 6, 'Nicky Romero, Afrojack', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-26 20:00:00', '2024-07-26 02:00:00', 20),
                                                                                                                                                                   (217, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (218, 54, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '2/0/Dupa', 20, '2024-07-27 19:00:00', '2024-07-27 21:00:00', 20),
                                                                                                                                                                   (219, 55, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '2/0/', 20, '2024-07-27 19:00:00', '2024-07-27 21:00:00', 19),
                                                                                                                                                                   (220, 56, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-27 19:00:00', '2024-07-27 21:00:00', 18),
                                                                                                                                                                   (221, 9, 'Nicky Romero', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-27 23:00:00', '2024-07-27 00:30:00', 20),
                                                                                                                                                                   (222, 6, 'Nicky Romero, Afrojack', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-26 20:00:00', '2024-07-26 02:00:00', 20),
                                                                                                                                                                   (223, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (224, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (225, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (227, 8, 'Tiësto', 1, 'DANCE EVENT', 'Lichtfabriek', '', 75, '2024-07-27 21:00:00', '2024-07-27 22:30:00', 20),
                                                                                                                                                                   (228, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (229, 13, 'Martin Garrix', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-28 18:00:00', '2024-07-28 23:30:00', 20),
                                                                                                                                                                   (230, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (232, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (234, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (235, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (236, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (237, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (238, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Family ticket', 60, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (242, 60, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-27 19:00:00', '2024-07-27 21:00:00', 20),
                                                                                                                                                                   (243, 61, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-26 21:00:00', '2024-07-26 23:00:00', 20),
                                                                                                                                                                   (245, 9, 'Nicky Romero', 1, 'DANCE EVENT', 'Club Stalker', '', 60, '2024-07-27 23:00:00', '2024-07-27 00:30:00', 20),
                                                                                                                                                                   (247, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Chinese, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (248, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (249, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (250, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (251, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (252, 2, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (265, 1, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (266, 1, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (268, 6, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-26 16:00:00', '2024-07-26 18:30:00', 20),
                                                                                                                                                                   (269, 63, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-25 19:00:00', '2024-07-25 21:00:00', 20),
                                                                                                                                                                   (270, 64, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-25 19:00:00', '2024-07-25 21:00:00', 19),
                                                                                                                                                                   (271, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (272, 1, 'History Event', 3, 'History Tour Ticket', 'Grote Markt 22, 2011 RD Haarlem', 'Dutch, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (273, 1, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (274, 1, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 10:00:00', '2024-07-25 12:30:00', 20),
                                                                                                                                                                   (275, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (276, 7, 'Afrojack', 1, 'DANCE EVENT', 'Jopenkerk', '', 60, '2024-07-27 22:00:00', '2024-07-27 23:30:00', 20),
                                                                                                                                                                   (277, 2, 'HISTORY EVENT', 3, 'Haarlem Tour', 'Grote Markt 22, 2011 RD Haarlem', 'English, Regular ticket', 17, '2024-07-25 13:00:00', '2024-07-25 15:30:00', 20),
                                                                                                                                                                   (278, 65, 'Ratatouille', 2, 'YUMMY EVENT', 'Spaarne 96, 2011 CL Haarlem, Nederland', '1/0/', 10, '2024-07-25 19:00:00', '2024-07-25 21:00:00', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `userName` varchar(255) NOT NULL,
                        `password` varchar(1024) NOT NULL,
                        `userRole` enum('CUSTOMER','EMPLOYEE','ADMINISTRATOR') NOT NULL,
                        `registrationDate` datetime NOT NULL DEFAULT current_timestamp(),
                        `email` varchar(255) DEFAULT NULL,
                        `firstName` varchar(255) DEFAULT NULL,
                        `lastName` varchar(255) DEFAULT NULL,
                        `photo` varchar(255) DEFAULT NULL,
                        `phoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `userRole`, `registrationDate`, `email`, `firstName`, `lastName`, `photo`, `phoneNumber`) VALUES
                                                                                                                                                (11, 'Wojteck', 'test1234', 'ADMINISTRATOR', '2024-02-27 14:16:36', 'Test@gmail.com', 'Abdelrahman', 'Ghonim', NULL, NULL),
                                                                                                                                                (17, 'Ghonim2222', '$2y$10$VC/t8GGbduhIdOaRYbPONepYCtcB83/TB.GZA0H4aDXVWQujNYW1.', 'EMPLOYEE', '2024-02-29 20:06:23', 'ghonim22@ghon.com', 'Abdelrahman', 'Ghonim', '', NULL),
                                                                                                                                                (21, 'Test123', '$2y$10$uruK5SOot0eR8JYHA1kMyekQfjnRYphQSp1KFk3JNE0xZW6ievevW', 'EMPLOYEE', '2024-03-02 18:31:54', 'wojtusk574@gmail.com', 'Test', 'Test', '', NULL),
                                                                                                                                                (23, 'Test2', '$2y$10$eDLtrHtfpjeFtzy6oLm/k.cYT5evY0DD.vRLEkA6nM4ktbebko8t.', 'EMPLOYEE', '2024-03-07 09:35:17', 'Test2@Test.Test', 'Test2', 'Test2', '', NULL),
                                                                                                                                                (25, 'admin', '$2y$10$mXwK890X3FXgOOcPOa7F/.4LUOI8SpY/loPgVoTqkuGTvbEFIdjk2', 'ADMINISTRATOR', '2024-03-10 10:42:55', 'admin@gmail.com', 'abc', 'def', '', NULL),
                                                                                                                                                (27, 'Login', '$2y$10$10W0lMNR3ytZYr37CH/1ne2L0YqwhqGUS.9KjNsBcECgojZyiqkSi', 'EMPLOYEE', '2024-03-10 12:56:14', 'Login@login.com', 'Login', 'Login', '', NULL),
                                                                                                                                                (29, 'LoginTest', '$2y$10$/EP6n1Z6HKUwKdO0u2LF9OtmkQ951wgzSQzk.7CrHDUAiLlOJYCUa', 'EMPLOYEE', '2024-03-11 08:54:34', 'Login@test.com', 'Login', 'Login', '', NULL),
                                                                                                                                                (31, 'Ghonim', '$2y$10$l.k81nwKCwmjfKVh2K58DuXipOKJFNCBg/eCbQzO8Q/Y0KYX5kECK', 'EMPLOYEE', '2024-03-19 10:06:50', 'abdelrahamgna@gmail.com', 'Abdel', 'rahman', '', NULL),
                                                                                                                                                (42, 'test', '$2y$10$.nFxFVIVkUp58D0FRbrpI.xU7Kcgn.r037sU2g6Pk10tYMBroYNZS', 'EMPLOYEE', '2024-04-06 16:48:52', 'teset@testing.com', 'test1', 'test2', '', '0123123123'),
                                                                                                                                                (43, 'sherif', '$2y$10$FAO4T2VUmuhE.YgL7ZKseOE/vZBXESGU5vde89kS96JSj/aDsGI7G', 'EMPLOYEE', '2024-04-06 16:52:25', 'testststit@s.com', 'tesssssssst', 'tessssssstt3', '', '0123123123123'),
                                                                                                                                                (44, 'Amr', '$2y$10$CKUduafeqhWeXz4VboIiOeJ2jsGfufGL.Lcz9TGtYgHXdryWkzJWG', 'EMPLOYEE', '2024-04-06 16:53:33', 'Amr@amr.com', 'Amr', 'Essam', '', '0123123123123'),
                                                                                                                                                (47, 'peter', '$2y$10$Pp73LGv/wUNRJVugm6kXuuptE679pZ2i0ItztpSIlRFANk7r48glK', 'EMPLOYEE', '2024-04-06 17:09:44', 'peter@gmail.com', 'peeteeeeer', 'ter', NULL, '345123123'),
                                                                                                                                                (49, 'poliska', '$2y$10$kccCkrRpA/Psx7EWvRsE5eKu.7kDVQrNm2XH6EpnknSRp3MIdXN2m', 'ADMINISTRATOR', '2024-04-07 13:54:52', 'poliska@gmail.com', 'pol', 'iska', NULL, '212343456'),
                                                                                                                                                (55, 'employee', '$2y$10$ccskazHgSZgQUod2zryo9Oxo.xY6NHMEBZHKsbV8.Rf5ThduHF4oG', 'EMPLOYEE', '2024-04-08 20:51:27', 'employee@employee.employee', 'employee', 'employee', '', '123123'),
                                                                                                                                                (56, 'customer', '$2y$10$HDiIYc5oiYdNTQGmdMKbke5eXfHbNjqaF4Dh8it768nrHeAHULoqK', 'CUSTOMER', '2024-04-08 20:51:57', 'fort.joris@gmail.com', 'customer', 'customer', '', '123123'),
                                                                                                                                                (62, 'Test2Test', '$2y$10$FMsfdb9qQgIWA1NoMTxXUus3AixfwOzJYe4YpeRbrMfZbOti8zXBa', 'CUSTOMER', '2024-04-16 11:14:19', 'test2test@gmail.com', 'Test', 'Test', '', '0123123123'),
                                                                                                                                                (63, 'Ghonim', '$2y$10$gsauhqIxhmjjgd05mW5qi.mVX5sEloz6AYQhLa8/teIyjEaueUW2y', 'CUSTOMER', '2024-04-25 20:50:52', 'ghonim123@gmail.com', 'test', 'test', '', '111111111111111'),
                                                                                                                                                (65, 'The Rock', '$2y$10$KHwGsX/jd9L0rhcS69CY6uHT.Y56xjri1IengEI3XPb7cXNHmq3rS', 'CUSTOMER', '2024-04-26 09:18:32', 'Rock@gmail.com', 'The', 'Rock', '', '9456456323'),
                                                                                                                                                (66, 'adw', '$2y$10$iIQ5VRPT/4/ubWxaEj72..jobcCwQW9vkELkBZDH9kPSBvgmDio8C', 'CUSTOMER', '2024-06-12 17:42:49', '123@123.com', 'adw', 'adw', '', 'awd'),
                                                                                                                                                (67, 'abdoo', '$2y$10$XBFbsZL.dZHPclxf29lcm.1JSLZO5uUufJcMqNipCz6wPOsU09M8u', 'CUSTOMER', '2024-06-14 14:53:33', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tickets`
--

CREATE TABLE `user_tickets` (
                                `user_id` int(11) NOT NULL,
                                `ticket_id` int(11) NOT NULL,
                                `quantity` int(11) NOT NULL,
                                `paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tickets`
--

INSERT INTO `user_tickets` (`user_id`, `ticket_id`, `quantity`, `paid`) VALUES
                                                                            (4, 39, 1, 0),
                                                                            (60, 124, 1, 1),
                                                                            (60, 125, 1, 1),
                                                                            (60, 113, 1, 1),
                                                                            (60, 125, 1, 1),
                                                                            (60, 107, 1, 1),
                                                                            (60, 113, 1, 1),
                                                                            (60, 138, 1, 1),
                                                                            (60, 138, 1, 1),
                                                                            (25, 140, 1, 0),
                                                                            (25, 141, 1, 0),
                                                                            (25, 113, 1, 0),
                                                                            (25, 138, 1, 0),
                                                                            (25, 144, 1, 0),
                                                                            (25, 125, 1, 0),
                                                                            (25, 125, 1, 0),
                                                                            (25, 138, 1, 0),
                                                                            (25, 113, 1, 0),
                                                                            (25, 140, 1, 0),
                                                                            (56, 141, 1, 1),
                                                                            (56, 163, 1, 1),
                                                                            (25, 140, 1, 0),
                                                                            (25, 159, 1, 0),
                                                                            (56, 141, 1, 1),
                                                                            (64, 107, 1, 1),
                                                                            (64, 186, 1, 1),
                                                                            (64, 140, 1, 1),
                                                                            (65, 188, 1, 1),
                                                                            (65, 189, 1, 1),
                                                                            (65, 190, 1, 1),
                                                                            (65, 140, 1, 1),
                                                                            (25, 140, 1, 0),
                                                                            (25, 140, 1, 0),
                                                                            (25, 140, 1, 0),
                                                                            (25, 149, 1, 0),
                                                                            (25, 159, 1, 0),
                                                                            (42, 215, 1, 0),
                                                                            (56, 219, 1, 1),
                                                                            (56, 220, 1, 1),
                                                                            (56, 200, 1, 1),
                                                                            (25, 149, 1, 0),
                                                                            (25, 149, 1, 0),
                                                                            (25, 149, 1, 0),
                                                                            (56, 164, 1, 1),
                                                                            (25, 140, 1, 0),
                                                                            (25, 265, 1, 0),
                                                                            (56, 270, 1, 1),
                                                                            (56, 107, 1, 0),
                                                                            (56, 107, 1, 0),
                                                                            (56, 277, 1, 0);

--
-- Triggers `user_tickets`
--
DELIMITER $$
CREATE TRIGGER `update_paid_order_after_update` AFTER UPDATE ON `user_tickets` FOR EACH ROW BEGIN
    UPDATE `order`
    SET `paid` = NEW.paid
    WHERE `ticket_id` = NEW.ticket_id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
    ADD PRIMARY KEY (`agendaId`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
    ADD PRIMARY KEY (`artistId`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danceOverview`
--
ALTER TABLE `danceOverview`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `festival_events`
--
ALTER TABLE `festival_events`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_contents`
--
ALTER TABLE `history_contents`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `page_name` (`page_name`,`entry_name`);

--
-- Indexes for table `history_timeslots`
--
ALTER TABLE `history_timeslots`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `day` (`day`,`start_time`,`end_time`);

--
-- Indexes for table `home_contents`
--
ALTER TABLE `home_contents`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `content_name` (`content_name`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
    ADD PRIMARY KEY (`imageId`),
    ADD KEY `sectionId` (`sectionId`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_order_ticket_id` (`ticket_id`);

--
-- Indexes for table `Pages`
--
ALTER TABLE `Pages`
    ADD PRIMARY KEY (`pageId`);

--
-- Indexes for table `Paragraph`
--
ALTER TABLE `Paragraph`
    ADD PRIMARY KEY (`paragraphId`),
    ADD KEY `sectionId` (`sectionId`);

--
-- Indexes for table `qr`
--
ALTER TABLE `qr`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_ticket_id` (`user_ticket_id`);

--
-- Indexes for table `reset_tokens`
--
ALTER TABLE `reset_tokens`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique_user_email` (`user_email`),
    ADD KEY `index_expires_at` (`expires_at`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_events`
--
ALTER TABLE `restaurant_events`
    ADD PRIMARY KEY (`id`),
    ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant_images`
--
ALTER TABLE `restaurant_images`
    ADD PRIMARY KEY (`id`),
    ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant_reservations`
--
ALTER TABLE `restaurant_reservations`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Sections`
--
ALTER TABLE `Sections`
    ADD PRIMARY KEY (`sectionId`),
    ADD KEY `pageId` (`pageId`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
    ADD PRIMARY KEY (`sessionId`);

--
-- Indexes for table `share_personal_program`
--
ALTER TABLE `share_personal_program`
    ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tickets`
--
ALTER TABLE `user_tickets`
    ADD KEY `ticket_id` (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
    MODIFY `agendaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
    MODIFY `artistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danceOverview`
--
ALTER TABLE `danceOverview`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `festival_events`
--
ALTER TABLE `festival_events`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `history_contents`
--
ALTER TABLE `history_contents`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `history_timeslots`
--
ALTER TABLE `history_timeslots`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `home_contents`
--
ALTER TABLE `home_contents`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
    MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `Pages`
--
ALTER TABLE `Pages`
    MODIFY `pageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `Paragraph`
--
ALTER TABLE `Paragraph`
    MODIFY `paragraphId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `qr`
--
ALTER TABLE `qr`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `reset_tokens`
--
ALTER TABLE `reset_tokens`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `restaurant_events`
--
ALTER TABLE `restaurant_events`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `restaurant_images`
--
ALTER TABLE `restaurant_images`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `restaurant_reservations`
--
ALTER TABLE `restaurant_reservations`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `Sections`
--
ALTER TABLE `Sections`
    MODIFY `sectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
    MODIFY `sessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Images`
--
ALTER TABLE `Images`
    ADD CONSTRAINT `Images_ibfk_1` FOREIGN KEY (`sectionId`) REFERENCES `Sections` (`sectionId`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
    ADD CONSTRAINT `fk_order_ticket_id` FOREIGN KEY (`ticket_id`) REFERENCES `user_tickets` (`ticket_id`);

--
-- Constraints for table `Paragraph`
--
ALTER TABLE `Paragraph`
    ADD CONSTRAINT `Paragraph_ibfk_1` FOREIGN KEY (`sectionId`) REFERENCES `Sections` (`sectionId`);

--
-- Constraints for table `qr`
--
ALTER TABLE `qr`
    ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`user_ticket_id`) REFERENCES `user_tickets` (`ticket_id`);

--
-- Constraints for table `restaurant_events`
--
ALTER TABLE `restaurant_events`
    ADD CONSTRAINT `restaurant_events_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_images`
--
ALTER TABLE `restaurant_images`
    ADD CONSTRAINT `restaurant_images_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Sections`
--
ALTER TABLE `Sections`
    ADD CONSTRAINT `Sections_ibfk_1` FOREIGN KEY (`pageId`) REFERENCES `Pages` (`pageId`);

--
-- Constraints for table `share_personal_program`
--
ALTER TABLE `share_personal_program`
    ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_tickets`
--
ALTER TABLE `user_tickets`
    ADD CONSTRAINT `user_tickets_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
