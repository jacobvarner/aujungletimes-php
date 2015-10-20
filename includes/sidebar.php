<div id="sidebarSocial">
	<a href="https://twitter.com/TheJungleTimes" class="twitter-follow-button" data-size="large" data-dnt="true">Follow @TheJungleTimes</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<br/>
	<div class="fb-like" data-href="https://facebook.com/TheJungleTimes" data-width="300" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
</div>
<div class="sidebarAd">
	<!-- JT_Sidebar -->
	<center><ins class="adsbygoogle"
	     style="display:inline-block;width:300px;height:250px"
	     data-ad-client="ca-pub-8692643521715142"
	     data-ad-slot="4436837739"></ins></center>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>
<div id="sidebarRecentPosts">
	<h3>Recent Posts</h3>
	<ul class="list-group">
	<?php
$stmt5 = $db->query("SELECT postTitle, postSlug, postImage, postDate FROM blog_posts ORDER BY postDate DESC LIMIT 5");
while ($row = $stmt5->fetch()) {
	echo '<a href="' . $row['postSlug'] . '" class="list-group-item">';
	echo '<h4 class="list-group-item-heading">' . $row['postTitle'] . '</h4>';
	echo '<p class="list-group-item-text">' . date('F d, Y', strtotime($row['postDate'])) . '</p><br/>';
	echo '<img class="img-responsive center-block" src="../images/postImages/' . $row['postImage'] . '"></a>';
}
?>
	</ul>
</div>
<div class="sidebarAd">
	<!-- JT_Sidebar -->
	<center><ins class="adsbygoogle"
	     style="display:inline-block;width:300px;height:250px"
	     data-ad-client="ca-pub-8692643521715142"
	     data-ad-slot="4436837739"></ins></center>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>
<div id="sidebarArchive">
	<h3>Archives</h3>
	<div class="list-group">
	<?php
$stmt = $db->query("SELECT Month(postDate) as Month, Year(postDate) as Year FROM blog_posts GROUP BY Month(postDate), Year(postDate) ORDER BY postDate DESC");
while ($row = $stmt->fetch()) {
	$monthName = date("F Y", mktime(0, 0, 0, $row['Month'], 10));
	$slug = 'a-' . $row['Month'] . '-' . $row['Year'];

	//set from and to dates
	$from = date('Y-m-01 00:00:00', strtotime($row['Year'] - $row['Month']));
	$to = date('Y-m-31 23:59:59', strtotime($row['Year'] - $row['Month']));

	$stmt2 = $db->prepare("SELECT * FROM blog_posts WHERE postDate >= :from AND postDate <= :to");
	$stmt2->execute(array(
		':from' => $from,
		':to' => $to,
	));

	$NumberOfPosts = $stmt2->rowCount();
	echo '<a href=' . $slug . ' class="list-group-item">' . $monthName . ' <span class="badge">' . $NumberOfPosts . '</span></a>';
	$NumberOfPosts = 0;
}
?>
	</div>
</div>
<div id="sidebarCategory">
	<h3>Tags</h3>
	<div class="list-group">
	<?php
$stmt3 = $db->query('SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
while ($row = $stmt3->fetch()) {

	$stmt4 = $db->prepare("SELECT * FROM blog_cat_cats WHERE catID = :catID");
	$stmt4->execute(array(':catID' => $row['catID']));

	$NumberOfPosts2 = $stmt4->rowCount();
	echo '<a href="c-' . $row['catSlug'] . '" class="list-group-item">' . $row['catTitle'] . ' <span class="badge">' . $NumberOfPosts2 . '</span></a>';
}
?>
	</div>
</div>