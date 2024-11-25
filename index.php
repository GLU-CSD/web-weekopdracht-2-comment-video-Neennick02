<?php
include("config.php");
include("reactions.php");

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postArray = [
        'naam' => $_POST['naam'],
        'email' => $_POST['email'],
        'comment' => $_POST['comment']
    ];

    $result = Reactions::setReaction($postArray);
    if (isset($result['error'])) {
        $message = '<div class="error">' . htmlspecialchars($result['error']) . '</div>';
    } else {
        $message = '<div class="success">Comment posted successfully!</div>';
    }
}

$getReactions = Reactions::getReactions();
//uncomment de volgende regel om te kijken hoe de array van je reactions eruit ziet
 echo "<pre>".var_dump($getReactions)."</pre>";

if(!empty($_POST)){

    //dit is een voorbeeld array.  Deze waardes moeten erin staan.
    $postArray = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message']

    ];

    $setReaction = Reactions::setReaction($postArray);

    if(isset($setReaction['error']) && $setReaction['error'] != ''){
        prettyDump($setReaction['error']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Youtube remake</title>
</head>
<body>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=twI61ZGDECBr4ums" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

    <h2>Hieronder komen reacties</h2>

    <p>Maak hier je eigen pagina van aan de hand van de opdracht</p>


    <form action="index.php" method="POST">
    <div id="naam">  
       naam: <input type="text" name="naam" value="" placeholder="Username">
    </div>
    <div id="email">
       email: <input type="email" name="email" value="" placeholder="Email">
    </div>
    <div id="textarea">
        <textarea name="comments"></textarea>
    </div>
    <input type="submit" value="send">
    </form>

    <div class="comments-section">
        <?php foreach($getReactions as $comment): ?>
            <div class="comment">
                <div class="comment-header">
                    <?php echo htmlspecialchars($comment['name']); ?>
                    <span class="comment-date">
                        <?php echo htmlspecialchars($comment['email']); ?>
                    </span>
                    <span class="comment-date">
                        <?php echo date('F j, Y', strtotime($comment['date_added'])); ?>
                    </span>
                </div>
                <div class="comment-content">
                    <?php echo htmlspecialchars($comment['message']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>


<?php 
$sql = "SELECT * FROM `reactions`;";
$result = $con->query($sql);

$con->close();
?>