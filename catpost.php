<?php require 'includes/config.php';

$stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if ($row['catID'] == '') {
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
    <meta name="description" content="Posts filtered by a category on The Jungle Times to help users find various posts about Auburn Basketball sorted into certain categories and tags.">
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
    <title>Posts in <?php echo $row['catTitle'];?> | The Jungle Times - The official news for "The Jungle", Auburn Basektball's official student section</title>
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

    <div id="wrapper" class="container-fluid">
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
<h1 id="blogheader">The Jungle Times Blog <small>Posts in "<?php echo $row['catTitle'];?>"</small></h1>
		<div id="main" class="row">
			<div id="posts" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
            <?php
try {

	$pages = new Paginator('12', 'p');

	$stmt = $db->prepare('SELECT blog_posts.postID FROM blog_posts, blog_cat_cats WHERE blog_posts.postID = blog_cat_cats.postID AND blog_cat_cats.catID = :catID');
	$stmt->execute(array(':catID' => $row['catID']));

	//pass number of records to
	$pages->set_total($stmt->rowCount());

	$stmt = $db->prepare('SELECT blog_posts.postID, blog_posts.postTitle, blog_posts.postAuthor, blog_posts.postSlug, blog_posts.postImage, blog_posts.postDescription, blog_posts.postDate FROM blog_posts, blog_cat_cats WHERE blog_posts.postID = blog_cat_cats.postID AND blog_cat_cats.catID = :catID ORDER BY postID DESC ' . $pages->get_limit());

	$stmt->execute(array(':catID' => $row['catID']));
	$adCount = 3;
	while ($row = $stmt->fetch()) {

		echo '<div class="postsOuter col-lg-3 col-md-6 col-sm-6 col-xs-12">';
		echo '<div class="posts">';
		echo '<h2><a href="' . $row['postSlug'] . '">' . $row['postTitle'] . '</a></h2>';
		echo '<h4>By <strong>' . $row['postAuthor'] . '</strong> | ' . date('F d, Y', strtotime($row['postDate'])) . ' <br/>';
		$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_cat_cats WHERE blog_cats.catID = blog_cat_cats.catID AND blog_cat_cats.postID = :postID');
		$stmt2->execute(array(':postID' => $row['postID']));
		$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		$links = array();
		if (!empty($catRow)) {
			echo 'Tags: ';
		} else {
			echo '&nbsp;';
		}
		foreach ($catRow as $cat) {
			$links[] = "<a href='c-" . $cat['catSlug'] . "'><span class='badge'>" . $cat['catTitle'] . "</span></a>";
		}
		echo implode(" ", $links);
		echo '</h4>';
		echo '<a href="' . $row['postSlug'] . '"><img class="img-responsive center-block" src="images/postImages/' . $row['postImage'] . '" alt="' . $row['postSlug'] . '-image"></a>';
		//echo '' . $row['postDescription'] . '';
		echo '<div class=sharingButtons><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.aujungletimes.com/' . $row['postSlug'] . '" data-via="TheJungleTimes" data-related="TheJungleTimes" data-dnt="true">Tweet</a>
<div class="fb-share-button" data-href="http://www.aujungletimes.com/' . $row['postSlug'] . '" data-layout="button_count"></div></div>';
		echo '</div>';
		echo '</div>';
		$adCount++;
		if ($adCount % 4 == 0) {
			echo '<div class="postsOuter col-lg-3 col-md-6 col-sm-6 col-xs-12">';
			echo '<div class="postsAd">';
			echo '<!-- JT_Desktop_Feed -->
					<center><ins class="adsbygoogle"
		     			style="display:inline-block;width:336px;height:280px"
		     			data-ad-client="ca-pub-8692643521715142"
		     			data-ad-slot="9006638131"></ins></center>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>';
			echo '</div>';
			echo '</div>';
		}

	}

} catch (PDOException $e) {
	echo $e->getMessage();
}

?>
			</div>
			<div class="pagination col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php echo $pages->page_links('c-' . $_GET['id'] . '&');?>
			</div>
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