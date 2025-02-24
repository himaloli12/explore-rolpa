<?php
require_once 'config.php';

// Fetch places for the homepage
$sql = "SELECT * FROM places ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$places = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Rolpa</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>

        <div class="logo">Explore Rolpa</div>

        <div class="box">
            <ul>
            <marquee behavior="" direction=""> यस website बाट रोल्पाको सम्पूर्ण जानकारी र नयाँ नयाँ सुचना पाउन सकिन्छ । </marquee>
            </ul>
            </div> 


        <nav>
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">ABOUT US </a></li>
                <li><a href="#">PLACES TO VISIT</a></li>
                <li><a href="#">GALLERY</a></li>
                <li><a href="#">CONTACT US</a></li>
                <li><a href="http://localhost/exploreRolpa/manage_places.php">ADD PLACES</a></li>
                
            </ul>
        </nav>
    </header>
    <main>
    
        <section class="hero">
            <h1>Welcome to Rolpa</h1>
            
        </section>
        <!-- <section class="features" > 
            <div class="feature">
                <img src="./image/jalajala.jpg" alt="" width="200px" height="200px">
                <h2>jalajala</h2>
                <p>रोल्पा जिल्ला सदरमुकाम लिबाङबाट पैदल १ घण्टा दूरीको प्रसिद्ध जलजला धार्मिक पर्यकीय गन्तव्य बनेको छ  । 
                    जलजला पहाडमा लोपोन्मुख सेतो लालीगुराँसको फूल पाइन्छ ।</p>
                
            </div>
            <div class="feature">
                <img src="./image/view tawar rolpa.jpg" alt="" width="200px" height="200px">
                <h2>जनयुद्ध स्मृति भिउ टावर सातदोबाटो, रोल्पा ।</h2>
                <p> रोल्पाले ऐतिहासिक १० वर्षे जनयुद्धको सम्झना लाइकको यो टावर ठडायो ।</p>
            </div>
            <div class="feature">
                <img src="./image/Rolpa Thabang.jpg" alt="" width="200px" height="200px">
                <h2>Thabang Rolpa</h2>
                <p>रोल्पा जिल्लाको सदरमुकाम लिवाङबाट ३५ कि.मी. टाढा रहेको छ।
                     यो हाल थवाङ गाउँपालिकामा पर्दछ। नेपालमा चलेको १० वर्षको माओवादी गृहयुद्धको सुरूवात यहिबाट भयको थियो।  </p>
            </div>
            <div class="feature">
                <img src="./image/Liwang Rolpa.jpg" alt="" width="200px" height="200px">
                <h2>Rolpa Liwang</h2>
                <p> रोल्पा नगरपालिका रोल्पा जिल्लाको एक मात्र नगरपालिका हो । पहाडी जिल्लामा पर्ने यो नगरपालिका नेपालको लुम्बिनी प्रदेश अन्तर्गत पर्दछ ।
                     यस नगरपालिकामा १० वटा वडा रहेका छन् । सडक सञ्जाल , शिक्षा ,पर्यटन जस्ता विविध पक्षहरुमा विकास उन्मुख रुपमा रहेको यो नगरपालिका
                      प्राकृतिक रुपमा अति लोभलाग्दो छ ।</p>
            </div>
            
        </section> -->

        <!-- Replace your static features section with this -->
<!-- Replace your features section with this -->
<section class="features">
    <div class="features-grid">
        <?php 
        $count = 0;
        foreach ($places as $place): 
            if ($count % 4 == 0 && $count != 0) {
                echo '</div><div class="features-grid">';
            }
        ?>
            <div class="feature">
                <img src="<?php echo htmlspecialchars($place['image_path']); ?>" alt="<?php echo htmlspecialchars($place['title']); ?>" width="200px" height="200px">
                <h2><?php echo htmlspecialchars($place['title']); ?></h2>
                <p><?php echo htmlspecialchars($place['description']); ?></p>
            </div>
        <?php 
            $count++;
        endforeach; 
        ?>
    </div>
</section>


    </main>
    <footer>

    </div> 
    <div class="content">
        <h1>रोल्पाको बारेमा  <br><span> सम्पूर्ण </span> <br> जानकारी</h1>
        <p class="par">रोल्पा नेपालको एक पहाडी जिल्ला हो। रोल्पा जिल्लाको क्षेत्रफल एक हजार आठ सय ७९ बर्ग किलोमिटर रहेको छ। <br>
            नेपालको पहाडमा अवस्थित रोल्पा पश्चिम नेपालको लुकेको रत्न हो। ठुला पहाड, घना जङ्गल, धनी संस्कृति र <br>मानिसहरूको परम्परा, धार्मिक 
            स्थल र फराकिलो उपत्यका भएको रोप्लामा यो ठाउँबाट बाहिर निस्कन खोज्ने सबै कुरा छन्। <br>
            यससँग जोडिएका जिल्लाहरू दक्षिणमा दाङ, पूर्वमा प्युठान, पश्चिममा सल्यान र उत्तरमा पूर्वी रुकुम जिल्ला पर्दछन्।</p>

            <button class="cn"><a href="#"> PLEASE JOIN US</a></button>

            <div class="form">
                <h2>Login Here</h2>
                <input type="email" name="email" placeholder="Enter Your Email ">
                <input type="password" name="" placeholder="Enter Your Password ">
                <button class="btnn"><a href="#">Login</a></button>

                <p class="link">Don't have an account<br>
                <a href="#">Sign up </a> here</a></p>
                <p class="liw">Log in with</p>

                <div class="icons">
                    <a href="https://www.facebook.com" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="https://www.instagram.com"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="https://www.twitter.com"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="https://www.google.com/"><ion-icon name="logo-google"></ion-icon></a>
                    <a href="https://www.skype.com"><ion-icon name="logo-skype"></ion-icon></a>
                </div>

            </div>
                </div>
            </div>
    </div>
</div>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
        <p>&copy; 2025 Explore Rolpa. please visite our place.</p>
        <section class="rolpa">
        <p>Discover the cultural heritage and natural beauty of Rolpa.</p>
            <a href="#" class="cta">Learn More</a>
        </section>
    </footer>
    
</body>

</html>