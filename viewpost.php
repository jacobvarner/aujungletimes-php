<?php require 'includes/config.php';

$stmt = $db->prepare('SELECT postID, postImage, postAuthor, postTitle, postSlug, postDescription, postContent, postDate FROM blog_posts WHERE postSlug = :postSlug');
$stmt->execute(array(':postSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if ($row['postID'] == '') {
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $row['postDescription'];?>">
    <meta name="author" content="Jacob Varner">
    <!-- favicon and other features -->
	<link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="images/favicons/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="images/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="images/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="images/favicons/manifest.json">
	<meta name="apple-mobile-web-app-title" content="The Jungle Times">
	<meta name="application-name" content="The Jungle Times">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="images/favicons/mstile-144x144.png">
	<meta name="theme-color" content="#f0f0f0">
	<!-- / end favicon -->
    <title><?php echo $row['postTitle'];?> | The Jungle Times - The official news for "The Jungle", Auburn Basektball's official student section</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700|Roboto:700,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

	<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="images/the_jungle_times-banner-transparent.png" height="40px"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="issues.php">Issues</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div id="wrapper" class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- jt_header -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-8692643521715142"
				     data-ad-slot="9318022538"
				     data-ad-format="auto"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
		<br/>
		<div id="main" class="row">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div id="postContainer">
	        <a role="button" class="btn btn-warning btn-sm" href="index.php"><span class="glyphicon glyphicon-chevron-left"></span> <strong>Return to Main Page</strong></a>


	        <?php
echo '<div id="postHeading">';
echo '<img class="img-responsive center-block" src="images/postImages/' . $row['postImage'].'" alt="'.$row['postSlug'].'-image"/>';
echo '<h1 id="postTitle">' . $row['postTitle'] . '</h1>';
echo '<h4 id="postInfo">By <strong>' . $row['postAuthor'] . '</strong> | ' . date('F d, Y', strtotime($row['postDate'])) . ' ';
$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_cat_cats WHERE blog_cats.catID = blog_cat_cats.catID AND blog_cat_cats.postID = :postID');
$stmt2->execute(array(':postID' => $row['postID']));
$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$links = array();
if (!empty($catRow)) {
	echo '<br/>Tags: ';
}
foreach ($catRow as $cat) {
	$links[] = "<a href='c-" . $cat['catSlug'] . "'><span class='badge'>" . $cat['catTitle'] . "</span></a>";
}
echo implode(", ", $links);
echo '</h4>';
echo '<div class=sharingButtons><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.aujungletimes.com/' . $row['postSlug'] . '" data-via="TheJungleTimes" data-related="TheJungleTimes" data-dnt="true">Tweet</a>
<div class="fb-share-button" data-href="http://www.aujungletimes.com/' . $row['postSlug'] . '" data-layout="button_count"></div></div>';
echo '</div>';
echo '<div id="postAd" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- jt_header -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-8692643521715142"
					     data-ad-slot="9318022538"
					     data-ad-format="auto"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';
echo '<div id="postContent">' . $row['postContent'] . '</div>';

echo '<div id="postAd" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- jt_header -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-8692643521715142"
					     data-ad-slot="9318022538"
					     data-ad-format="auto"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>';

$postAuthor = $row['postAuthor'];
$stmt = $db->prepare('SELECT username, userImage, about, twitter FROM blog_members WHERE username = :postAuthor');
$stmt->execute(array(
	':postAuthor' => $postAuthor,
));
$row2 = $stmt->fetch();

echo '<div id="aboutAuthor" class="panel panel-default"><div class="panel-heading">';
echo '<h4 class="panel-title">About <strong>' . $row2['username'] . '</strong></h4></div>';
echo '<div class="panel-body"><img src="images/userImages/' . $row2['userImage'] . '" width="100px" alt="' . $row2['username'] . '">';
echo '<p>' . $row2['about'] . '</p>';
echo '<a href="https://twitter.com/' . $row2['twitter'] . '" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @' . $row2['twitter'] . '</a>';
echo '</div></div>';
?>
				<div id="disqusComments" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- Disqus comments -->
					<div id="disqus_thread"></div>
					<script type="text/javascript">
					    /* * * CONFIGURATION VARIABLES * * */
					    var disqus_shortname = 'theaujungletimes';

					    /* * * DON'T EDIT BELOW THIS LINE * * */
					    (function() {
					        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					    })();
					</script>
					<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
				</div>
			</div>
			</div>

			<div id="sidebar" class="col-lg-4 col-md-4 hidden-xs hidden-sm">
				<?php require 'includes/sidebar.php';?>
			</div>
		</div>
	</div>

    <footer class="footer">
      <div class="container">
        <a href="index.php"><img id="footer-image" src="images/the_jungle_times-square-transparent.png"></a>
        <div id="footer-text">
        	<p align="right" class="text-muted"><a href="http://www.twitter.com/TheJungleTimes" target="_blank">Twitter</a> | <a href="http://www.facebook.com/TheJungleTimes" target="_blank">Facebook</a></p>
        	<p align="right" class="text-muted">&copy; 2015 <strong>The Jungle Times</strong></p>
        	<p align="right" class="text-muted">Site by <a href="http://www.jacobvarner.com" target="_blank">Jacob Varner</a></p>
      	</div>
      </div>
    </footer>

	<?php require_once 'includes/javascript.php';?>

</body>
</html>